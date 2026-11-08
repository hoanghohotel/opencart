<?php
namespace Mail;
class Mail extends \stdClass {
	public function send() {
		if (is_array($this->to)) {
			$to = implode(',', $this->to);
		} else {
			$to = $this->to;
		}

		if (version_compare(phpversion(), '8.0', '>=') || substr(PHP_OS, 0, 3) == 'WIN') {
			$eol = "\r\n";
		} else {
			$eol = PHP_EOL;
		}

		$boundary = '----=_NextPart_' . md5(time());

		$header  = 'MIME-Version: 1.0' . $eol;
		$header .= 'Date: ' . date('D, d M Y H:i:s O') . $eol;
		$header .= 'From: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . $eol;
		
		if (!$this->reply_to) {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . $eol;
		} else {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->reply_to) . '?= <' . $this->reply_to . '>' . $eol;
		}
		
		$header .= 'Return-Path: ' . $this->from . $eol;
		$header .= 'X-Mailer: PHP/' . phpversion() . $eol;
		$header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $eol . $eol;

		if (!$this->html) {
			$message  = '--' . $boundary . $eol;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $eol;
			$message .= 'Content-Transfer-Encoding: base64' . $eol . $eol;
			$message .= chunk_split(base64_encode($this->text)) . $eol;
		} else {
			$html_body = (string)$this->html;
			$inline_images = array();
			$root_dir = defined('DIR_SYSTEM') ? dirname(rtrim(DIR_SYSTEM, '/\\')) . '/' : '';

			if ($root_dir) {
				$html_body = preg_replace_callback('/(\bsrc=["\'])([^"\']+)(["\'])/i', function($m) use ($root_dir, &$inline_images) {
					$src = trim($m[2]);
					if (stripos($src, 'cid:') === 0 || stripos($src, 'data:') === 0) {
						return $m[0];
					}
					$rel = $src;
					foreach (array('HTTPS_CATALOG', 'HTTP_CATALOG', 'HTTPS_SERVER', 'HTTP_SERVER') as $srv_const) {
						if (defined($srv_const) && constant($srv_const) !== '' && stripos($rel, constant($srv_const)) === 0) {
							$rel = substr($rel, strlen(constant($srv_const)));
							break;
						}
					}
					$rel = preg_replace('#^(?:https?://[^/]+)?(?:/[^/]+)*?/(?=(?:image|application|admin)/)#i', '', $rel);
					$rel = ltrim(rawurldecode(preg_replace('/\?.*$/', '', $rel)), '/');

					if (!$rel || stripos($rel, 'http://') === 0 || stripos($rel, 'https://') === 0) {
						return $m[0];
					}

					$candidate = $root_dir . $rel;
					if (!is_file($candidate)) {
						return $m[0];
					}

					$ext = strtolower(pathinfo($candidate, PATHINFO_EXTENSION));
					$mime_map = array(
						'png'  => 'image/png',
						'jpg'  => 'image/jpeg',
						'jpeg' => 'image/jpeg',
						'gif'  => 'image/gif',
						'webp' => 'image/webp',
						'svg'  => 'image/svg+xml'
					);
					$mime = isset($mime_map[$ext]) ? $mime_map[$ext] : 'application/octet-stream';
					$cid = 'ocimg_' . md5($candidate) . '@opencart.com';

					$inline_images[$cid] = array(
						'path' => $candidate,
						'name' => basename($candidate),
						'mime' => $mime
					);

					return $m[1] . 'cid:' . $cid . $m[3];
				}, $html_body);
			}

			$message  = '--' . $boundary . $eol;
			$message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . $eol . $eol;
			$message .= '--' . $boundary . '_alt' . $eol;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $eol;
			$message .= 'Content-Transfer-Encoding: base64' . $eol . $eol;

			if ($this->text) {
				$message .= chunk_split(base64_encode($this->text)) . $eol;
			} else {
				$message .= chunk_split(base64_encode('This is a HTML email and your email client software does not support HTML email!')) . $eol;
			}

			if (empty($inline_images)) {
				$message .= '--' . $boundary . '_alt' . $eol;
				$message .= 'Content-Type: text/html; charset="utf-8"' . $eol;
				$message .= 'Content-Transfer-Encoding: base64' . $eol . $eol;
				$message .= chunk_split(base64_encode($html_body)) . $eol;
			} else {
				$message .= '--' . $boundary . '_alt' . $eol;
				$message .= 'Content-Type: multipart/related; boundary="' . $boundary . '_rel"' . $eol . $eol;
				$message .= '--' . $boundary . '_rel' . $eol;
				$message .= 'Content-Type: text/html; charset="utf-8"' . $eol;
				$message .= 'Content-Transfer-Encoding: base64' . $eol . $eol;
				$message .= chunk_split(base64_encode($html_body)) . $eol;

				foreach ($inline_images as $cid => $img_info) {
					$img_bytes = @file_get_contents($img_info['path']);
					if ($img_bytes !== false) {
						$message .= '--' . $boundary . '_rel' . $eol;
						$message .= 'Content-Type: ' . $img_info['mime'] . '; name="' . $img_info['name'] . '"' . $eol;
						$message .= 'Content-Transfer-Encoding: base64' . $eol;
						$message .= 'Content-ID: <' . $cid . '>' . $eol;
						$message .= 'Content-Disposition: inline; filename="' . $img_info['name'] . '"' . $eol . $eol;
						$message .= chunk_split(base64_encode($img_bytes)) . $eol;
					}
				}

				$message .= '--' . $boundary . '_rel--' . $eol;
			}

			$message .= '--' . $boundary . '_alt--' . $eol;
		}

		foreach ($this->attachments as $attachment) {
			if (file_exists($attachment)) {
				$handle = fopen($attachment, 'r');

				$content = fread($handle, filesize($attachment));

				fclose($handle);

				$message .= '--' . $boundary . $eol;
				$message .= 'Content-Type: application/octet-stream; name="' . basename($attachment) . '"' . $eol;
				$message .= 'Content-Transfer-Encoding: base64' . $eol;
				$message .= 'Content-Disposition: attachment; filename="' . basename($attachment) . '"' . $eol;
				$message .= 'Content-ID: <' . urlencode(basename($attachment)) . '>' . $eol;
				$message .= 'X-Attachment-Id: ' . urlencode(basename($attachment)) . $eol . $eol;
				$message .= chunk_split(base64_encode($content));
			}
		}

		$message .= '--' . $boundary . '--' . $eol;

		@ini_set('sendmail_from', $this->from);

		if ($this->parameter) {
			@mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header, $this->parameter);
		} else {
			@mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header);
		}
	}
}

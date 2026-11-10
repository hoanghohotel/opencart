<?php
namespace Mail;
class Mail extends \stdClass {
	public $to;
	public $from;
	public $sender;
	public $reply_to;
	public $subject;
	public $text;
	public $html;
	public $attachments = array();
	public $parameter;

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

		$boundary = '----=_NextPart_' . md5((string)time());
		$has_attachments = !empty($this->attachments) && is_array($this->attachments);

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

		if (!$this->html && !$has_attachments) {
			$header .= 'Content-Type: text/plain; charset="utf-8"' . $eol;
			$header .= 'Content-Transfer-Encoding: base64' . $eol . $eol;
			$message = chunk_split(base64_encode((string)$this->text)) . $eol;
		} elseif (!$this->html) {
			$header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $eol . $eol;
			$message  = '--' . $boundary . $eol;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $eol;
			$message .= 'Content-Transfer-Encoding: base64' . $eol . $eol;
			$message .= chunk_split(base64_encode((string)$this->text)) . $eol;
		} else {
			$html_body = (string)$this->html;
			$inline_images = array();
			$root_dir = defined('DIR_SYSTEM') ? rtrim(str_replace('\\', '/', dirname(rtrim(DIR_SYSTEM, '/\\'))), '/') . '/' : '';
			$cid_domain = !empty($_SERVER['SERVER_NAME']) ? preg_replace('/[^a-zA-Z0-9.-]/', '', $_SERVER['SERVER_NAME']) : 'localhost';

			if ($root_dir) {
				$allowed_dirs = array(
					realpath($root_dir . 'image'),
					realpath($root_dir . 'application/view/image')
				);

				$html_body = preg_replace_callback('/(<img\b[^>]*?\bsrc=["\'])([^"\']+)(["\'])/i', function($m) use ($root_dir, $allowed_dirs, $cid_domain, &$inline_images) {
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
					$rel = preg_replace('#^(?:https?://[^/]+)?(?:/[^/]+)*?/(?=(?:image|application/view/image)/)#i', '', $rel);
					$rel = ltrim(rawurldecode(preg_replace('/\?.*$/', '', $rel)), '/');

					if (!$rel || stripos($rel, 'http://') === 0 || stripos($rel, 'https://') === 0) {
						return $m[0];
					}

					$ext = strtolower(pathinfo($rel, PATHINFO_EXTENSION));
					$mime_map = array(
						'png'  => 'image/png',
						'jpg'  => 'image/jpeg',
						'jpeg' => 'image/jpeg',
						'gif'  => 'image/gif',
						'webp' => 'image/webp',
						'svg'  => 'image/svg+xml'
					);
					if (!isset($mime_map[$ext])) {
						return $m[0];
					}

					$real_candidate = realpath($root_dir . $rel);
					if (!$real_candidate || !is_file($real_candidate)) {
						return $m[0];
					}

					$in_allowed_dir = false;
					foreach ($allowed_dirs as $allowed_dir) {
						if ($allowed_dir && strpos($real_candidate, $allowed_dir . DIRECTORY_SEPARATOR) === 0) {
							$in_allowed_dir = true;
							break;
						}
					}
					if (!$in_allowed_dir) {
						return $m[0];
					}

					$cid = 'img_' . md5($real_candidate) . '@' . $cid_domain;

					$inline_images[$cid] = array(
						'path' => $real_candidate,
						'name' => basename($real_candidate),
						'mime' => $mime_map[$ext]
					);

					return $m[1] . 'cid:' . $cid . $m[3];
				}, $html_body);
			}

			$alt_boundary = $has_attachments ? ($boundary . '_alt') : $boundary;
			if ($has_attachments) {
				$header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $eol . $eol;
				$message  = '--' . $boundary . $eol;
				$message .= 'Content-Type: multipart/alternative; boundary="' . $alt_boundary . '"' . $eol . $eol;
			} else {
				$header .= 'Content-Type: multipart/alternative; boundary="' . $alt_boundary . '"' . $eol . $eol;
				$message = '';
			}

			$message .= '--' . $alt_boundary . $eol;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $eol;
			$message .= 'Content-Transfer-Encoding: base64' . $eol . $eol;

			if ($this->text) {
				$message .= chunk_split(base64_encode((string)$this->text)) . $eol;
			} else {
				$message .= chunk_split(base64_encode('This is a HTML email and your email client software does not support HTML email!')) . $eol;
			}

			if (empty($inline_images)) {
				$message .= '--' . $alt_boundary . $eol;
				$message .= 'Content-Type: text/html; charset="utf-8"' . $eol;
				$message .= 'Content-Transfer-Encoding: base64' . $eol . $eol;
				$message .= chunk_split(base64_encode($html_body)) . $eol;
			} else {
				$message .= '--' . $alt_boundary . $eol;
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

			$message .= '--' . $alt_boundary . '--' . $eol;
		}

		if ($has_attachments) {
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
					$message .= 'X-Attachment-Id: ' . urlencode(basename($attachment)) . '>' . $eol . $eol;
					$message .= chunk_split(base64_encode($content));
				}
			}

			$message .= '--' . $boundary . '--' . $eol;
		}

		@ini_set('sendmail_from', $this->from);

		if ($this->parameter) {
			@mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header, $this->parameter);
		} else {
			@mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header);
		}
	}
}

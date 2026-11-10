<?php
namespace Mail;
class Smtp extends \stdClass {
	public $to;
	public $from;
	public $sender;
	public $reply_to;
	public $subject;
	public $text;
	public $html;
	public $attachments = array();
	public $parameter;
	public $smtp_hostname;
	public $smtp_username;
	public $smtp_password;
	public $smtp_port = 25;
	public $smtp_timeout = 10;
	public $max_attempts = 3;
	public $verp = false;

	protected function parseHostAndTls() {
		$raw_host = trim((string)$this->smtp_hostname);
		$port = (int)$this->smtp_port ?: 25;
		$use_starttls = false;
		$remote_host = $raw_host;

		if (stripos($raw_host, 'tls://') === 0) {
			$remote_host = substr($raw_host, 6);
			$use_starttls = true;
		} elseif (stripos($raw_host, 'ssl://') === 0) {
			$remote_host = 'ssl://' . substr($raw_host, 6);
		} elseif ($port === 465) {
			$remote_host = 'ssl://' . $raw_host;
		} elseif ($port === 587) {
			$use_starttls = true;
		}

		return array($remote_host, $port, $use_starttls);
	}

	protected function getServerName() {
		$server_name = getenv('SERVER_NAME');
		if (!$server_name && !empty($_SERVER['SERVER_NAME'])) {
			$server_name = $_SERVER['SERVER_NAME'];
		}
		if (!$server_name) {
			$server_name = 'localhost';
		}
		return $server_name;
	}

	public function testConnection() {
		list($hostname, $port, $use_starttls) = $this->parseHostAndTls();
		$timeout = (int)$this->smtp_timeout ?: 10;
		$server_name = $this->getServerName();

		$context = stream_context_create(array(
			'ssl' => array(
				'verify_peer'       => false,
				'verify_peer_name'  => false,
				'allow_self_signed' => true
			)
		));

		$errno = 0;
		$errstr = '';
		$handle = @stream_socket_client($hostname . ':' . $port, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);

		if (!$handle) {
			throw new \Exception('Could not connect to SMTP host "' . $this->smtp_hostname . ':' . $port . '" - ' . $errstr . ' (' . $errno . ')');
		}

		stream_set_timeout($handle, $timeout);

		$banner = '';
		while ($line = fgets($handle, 515)) {
			$banner .= $line;
			if (substr($line, 3, 1) == ' ') {
				break;
			}
		}

		fputs($handle, 'EHLO ' . $server_name . "\r\n");

		$reply = '';
		while ($line = fgets($handle, 515)) {
			$reply .= $line;
			if (substr($reply, 0, 3) == 220 && substr($line, 3, 1) == ' ') {
				$reply = '';
				continue;
			} elseif (substr($line, 3, 1) == ' ') {
				break;
			}
		}

		if (substr($reply, 0, 3) != 250) {
			fclose($handle);
			throw new \Exception('EHLO not accepted from server: ' . trim($reply));
		}

		$tls_established = (stripos($hostname, 'ssl://') === 0);

		if ($use_starttls || (stripos($reply, 'STARTTLS') !== false && !$tls_established && $port == 587)) {
			fputs($handle, 'STARTTLS' . "\r\n");
			$this->handleReply($handle, 220, 'Error: STARTTLS not accepted from server!');

			$crypto_method = STREAM_CRYPTO_METHOD_TLS_CLIENT;
			if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
				$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
			}
			if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
				$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
			}

			if (@stream_socket_enable_crypto($handle, true, $crypto_method) !== true) {
				fclose($handle);
				throw new \Exception('Error: TLS encryption could not be established!');
			}

			$tls_established = true;

			fputs($handle, 'EHLO ' . $server_name . "\r\n");
			$this->handleReply($handle, 250, 'Error: EHLO after STARTTLS not accepted from server!');
		}

		$authenticated = false;
		if (!empty($this->smtp_username) && !empty($this->smtp_password)) {
			fputs($handle, 'AUTH LOGIN' . "\r\n");
			$this->handleReply($handle, 334, 'Error: AUTH LOGIN not accepted from server!');

			fputs($handle, base64_encode($this->smtp_username) . "\r\n");
			$this->handleReply($handle, 334, 'Error: SMTP Username not accepted from server!');

			fputs($handle, base64_encode($this->smtp_password) . "\r\n");
			$this->handleReply($handle, 235, 'Error: SMTP Password not accepted from server!');
			$authenticated = true;
		}

		fputs($handle, 'QUIT' . "\r\n");
		@fclose($handle);

		return array(
			'banner'        => trim($banner),
			'ehlo'          => trim($reply),
			'tls'           => $tls_established,
			'authenticated' => $authenticated
		);
	}

	protected function buildMimeMessage() {
		if (is_array($this->to)) {
			$to = implode(',', $this->to);
		} else {
			$to = $this->to;
		}

		$eol = "\r\n";
		$boundary = '----=_NextPart_' . md5(uniqid((string)time(), true));
		$has_attachments = !empty($this->attachments) && is_array($this->attachments);

		$header  = 'MIME-Version: 1.0' . $eol;
		$header .= 'To: <' . $to . '>' . $eol;
		$header .= 'Subject: =?UTF-8?B?' . base64_encode($this->subject) . '?=' . $eol;
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
			$cid_domain = preg_replace('/[^a-zA-Z0-9.-]/', '', $this->getServerName()) ?: 'localhost';

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
				$message .= chunk_split(base64_encode(trim(strip_tags((string)$this->html)))) . $eol;
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

		return array('header' => $header, 'message' => $message);
	}

	public function send() {
		$built = $this->buildMimeMessage();
		$header = $built['header'];
		$message = $built['message'];

		list($hostname, $port, $use_starttls) = $this->parseHostAndTls();
		$timeout = (int)$this->smtp_timeout ?: 10;
		$server_name = $this->getServerName();

		$context = stream_context_create(array(
			'ssl' => array(
				'verify_peer'       => false,
				'verify_peer_name'  => false,
				'allow_self_signed' => true
			)
		));

		$errno = 0;
		$errstr = '';
		$handle = @stream_socket_client($hostname . ':' . $port, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);

		if (!$handle) {
			throw new \Exception('Error: ' . $errstr . ' (' . $errno . ')');
		} else {
			stream_set_timeout($handle, $timeout);

			while ($line = fgets($handle, 515)) {
				if (substr($line, 3, 1) == ' ') {
					break;
				}
			}

			fputs($handle, 'EHLO ' . $server_name . "\r\n");

			$reply = '';

			while ($line = fgets($handle, 515)) {
				$reply .= $line;

				if (substr($reply, 0, 3) == 220 && substr($line, 3, 1) == ' ') {
					$reply = '';
					continue;
				} else if (substr($line, 3, 1) == ' ') {
					break;
				}
			}

			if (substr($reply, 0, 3) != 250) {
				fclose($handle);
				throw new \Exception('Error: EHLO not accepted from server! (' . trim($reply) . ')');
			}

			if ($use_starttls) {
				fputs($handle, 'STARTTLS' . "\r\n");

				$this->handleReply($handle, 220, 'Error: STARTTLS not accepted from server!');

				$crypto_method = STREAM_CRYPTO_METHOD_TLS_CLIENT;
				if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
					$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
				}
				if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
					$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
				}

				if (@stream_socket_enable_crypto($handle, true, $crypto_method) !== true) {
					fclose($handle);
					throw new \Exception('Error: TLS could not be established!');
				}

				fputs($handle, 'EHLO ' . $server_name . "\r\n");

				$this->handleReply($handle, 250, 'Error: EHLO not accepted from server!');
			}

			if (!empty($this->smtp_username) && !empty($this->smtp_password)) {
				fputs($handle, 'AUTH LOGIN' . "\r\n");

				$this->handleReply($handle, 334, 'Error: AUTH LOGIN not accepted from server!');

				fputs($handle, base64_encode($this->smtp_username) . "\r\n");

				$this->handleReply($handle, 334, 'Error: Username not accepted from server!');

				fputs($handle, base64_encode($this->smtp_password) . "\r\n");

				$this->handleReply($handle, 235, 'Error: Password not accepted from server!');
			}

			if ($this->verp) {
				fputs($handle, 'MAIL FROM: <' . $this->from . '>XVERP' . "\r\n");
			} else {
				fputs($handle, 'MAIL FROM: <' . $this->from . '>' . "\r\n");
			}

			$this->handleReply($handle, 250, 'Error: MAIL FROM not accepted from server!');

			if (!is_array($this->to)) {
				fputs($handle, 'RCPT TO: <' . $this->to . '>' . "\r\n");

				$reply = $this->handleReply($handle, false, 'RCPT TO [!array]');

				if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
					throw new \Exception('Error: RCPT TO not accepted from server! (' . trim($reply) . ')');
				}
			} else {
				foreach ($this->to as $recipient) {
					fputs($handle, 'RCPT TO: <' . $recipient . '>' . "\r\n");

					$reply = $this->handleReply($handle, false, 'RCPT TO [array]');

					if ((substr($reply, 0, 3) != 250) && (substr($reply, 0, 3) != 251)) {
						throw new \Exception('Error: RCPT TO not accepted from server! (' . trim($reply) . ')');
					}
				}
			}

			fputs($handle, 'DATA' . "\r\n");

			$this->handleReply($handle, 354, 'Error: DATA not accepted from server!');

			$message = str_replace("\r\n", "\n", $header . $message);
			$message = str_replace("\r", "\n", $message);

			$lines = explode("\n", $message);

			foreach ($lines as $line) {
				$results = ($line === '') ? [''] : str_split($line, 998);

				foreach ($results as $result) {
					if (substr($result, 0, 1) == '.') {
						$result = '.' . $result;
					}
					fputs($handle, $result . "\r\n");
				}
			}

			fputs($handle, '.' . "\r\n");

			$this->handleReply($handle, 250, 'Error: DATA not accepted from server!');

			fputs($handle, 'QUIT' . "\r\n");

			$this->handleReply($handle, 221, 'Error: QUIT not accepted from server!');

			fclose($handle);
		}
	}

	private function handleReply($handle, $status_code = false, $error_text = false, $counter = 0) {
		$reply = '';

		while (($line = fgets($handle, 515)) !== false) {
			$reply .= $line;

			if (substr($line, 3, 1) == ' ') {
				break;
			}
		}

		if (!$line && empty($reply) && $counter < $this->max_attempts) {
			sleep(1);

			$counter++;

			return $this->handleReply($handle, $status_code, $error_text, $counter);
		}

		if ($status_code) {
			if (substr($reply, 0, 3) != $status_code) {
				throw new \Exception($error_text . ($reply ? ' [' . trim($reply) . ']' : ''));
			}
		}

		return $reply;
	}
}

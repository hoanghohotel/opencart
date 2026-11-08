<?php
class ControllerMailPin extends Controller {
	public function index($args = array()) {
		$this->load->language('mail/pin');

		if (empty($args['email'])) {
			return;
		}

		$username = !empty($args['username']) ? $args['username'] : (!empty($args['firstname']) ? $args['firstname'] : $this->language->get('text_default_member'));
		$new_pin  = !empty($args['new_pin']) ? $args['new_pin'] : sprintf('%04d', mt_rand(0, 9999));
		$code     = !empty($args['code']) ? $args['code'] : '';
		$ip       = isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '127.0.0.1';

		$confirm_link = $code ? $this->url->link('account/security/confirm', 'code=' . urlencode($code), true) : $this->url->link('account/security', '', true);
		$store_name   = html_entity_decode($this->config->get('config_name') ?: 'Store', ENT_QUOTES, 'UTF-8');

		$data['username'] = $username;
		$data['reset']    = sprintf($this->language->get('text_new_pin_info'), $new_pin, $confirm_link);
		$data['ip']       = $ip;
		$data['store']    = $store_name;
		$data['text_greeting_formatted'] = sprintf($this->language->get('text_greeting'), $username);
		$data['text_ip_formatted'] = sprintf($this->language->get('text_ip'), $ip);

		$text = $this->load->view('mail/pin_reset', $data);

		$header = $this->load->controller('mail/header');
		$footer = $this->load->controller('mail/footer');

		$html  = $header;
		$html .= '<div style="padding:30px;font-family:\'Open Sans\',Arial,sans-serif;color:#333;line-height:1.6;">';
		$html .= '<h2 style="color:#1e91cf;margin-top:0;">' . $this->language->get('text_heading') . '</h2>';
		$html .= '<p>' . sprintf($this->language->get('text_greeting_html'), htmlspecialchars($username, ENT_QUOTES, 'UTF-8')) . '</p>';
		$html .= '<p>' . sprintf($this->language->get('text_html_requested'), htmlspecialchars($store_name, ENT_QUOTES, 'UTF-8')) . '</p>';
		$html .= '<div style="background:#f5f9fc;border:1px solid #bce8f1;border-radius:4px;padding:18px;text-align:center;margin:20px 0;">';
		$html .= '<div style="font-size:13px;color:#666;margin-bottom:6px;">' . $this->language->get('text_html_pin_label') . '</div>';
		$html .= '<div style="font-size:28px;font-weight:bold;letter-spacing:6px;color:#0287d0;">' . htmlspecialchars($new_pin, ENT_QUOTES, 'UTF-8') . '</div>';
		$html .= '</div>';
		$html .= '<p>' . $this->language->get('text_html_instruction') . '</p>';
		$html .= '<p><a href="' . $confirm_link . '" style="color:#0287d0;">' . $confirm_link . '</a></p>';
		$html .= '<p style="font-size:12px;color:#888;">' . sprintf($this->language->get('text_html_ip'), htmlspecialchars($ip, ENT_QUOTES, 'UTF-8')) . '</p>';
		$html .= '</div>';
		$html .= $footer;

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($args['email']);
			$mail->setFrom($this->config->get('config_email') ?: ('noreply@' . (parse_url($this->config->get('config_url'), PHP_URL_HOST) ?: 'localhost')));
			$mail->setSender($store_name);
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_subject'), $store_name, $new_pin), ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}
	}
}

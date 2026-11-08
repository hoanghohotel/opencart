<?php
class ControllerMailPin extends Controller {
	public function index($args = array()) {
		if (empty($args['email'])) {
			return;
		}

		$username = !empty($args['username']) ? $args['username'] : (!empty($args['firstname']) ? $args['firstname'] : 'Member');
		$new_pin  = !empty($args['new_pin']) ? $args['new_pin'] : sprintf('%04d', mt_rand(0, 9999));
		$code     = !empty($args['code']) ? $args['code'] : '';
		$ip       = isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '127.0.0.1';

		$confirm_link = $code ? $this->url->link('account/security/confirm', 'code=' . urlencode($code), true) : $this->url->link('account/security', '', true);
		$store_name   = html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8');

		$data['username'] = $username;
		$data['reset']    = "Your new 4-digit PIN is: " . $new_pin . "\n\nOr click the link below to set a custom PIN:\n" . $confirm_link;
		$data['ip']       = $ip;
		$data['store']    = $store_name;

		$text = $this->load->view('mail/pin_reset', $data);

		$header = $this->load->controller('mail/header');
		$footer = $this->load->controller('mail/footer');

		$html  = $header;
		$html .= '<div style="padding:30px;font-family:\'Open Sans\',Arial,sans-serif;color:#333;line-height:1.6;">';
		$html .= '<h2 style="color:#1e91cf;margin-top:0;">Security PIN Reset</h2>';
		$html .= '<p>Hi <strong>' . htmlspecialchars($username) . '</strong>,</p>';
		$html .= '<p>A new 4-digit security PIN was requested for your OpenCart account.</p>';
		$html .= '<div style="background:#f5f9fc;border:1px solid #bce8f1;border-radius:4px;padding:18px;text-align:center;margin:20px 0;">';
		$html .= '<div style="font-size:13px;color:#666;margin-bottom:6px;">Your New 4-Digit Security PIN</div>';
		$html .= '<div style="font-size:28px;font-weight:bold;letter-spacing:6px;color:#0287d0;">' . htmlspecialchars($new_pin) . '</div>';
		$html .= '</div>';
		$html .= '<p>You can enter this 4-digit PIN directly on the Security PIN Check page, or click the link below if you would like to choose a custom PIN:</p>';
		$html .= '<p><a href="' . $confirm_link . '" style="color:#0287d0;">' . $confirm_link . '</a></p>';
		$html .= '<p style="font-size:12px;color:#888;">The IP used to make this request was: ' . htmlspecialchars($ip) . '</p>';
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
			$mail->setFrom($this->config->get('config_email') ?: 'noreply@opencart.com');
			$mail->setSender(html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(($this->config->get('config_name') ?: 'OpenCart') . ' - New Security PIN (' . $new_pin . ')', ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}
	}
}

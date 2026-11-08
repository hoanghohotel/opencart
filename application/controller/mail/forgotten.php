<?php
class ControllerMailForgotten extends Controller {
	public function index($member_info = array()) {
		if (empty($member_info['email']) || empty($member_info['code'])) {
			return;
		}

		$store_name = html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8');

		$data['header'] = $this->load->controller('mail/header');
		$data['footer'] = $this->load->controller('mail/footer');
		$data['ip'] = isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '127.0.0.1';
		$data['store'] = $store_name;
		$data['store_url'] = $this->url->link('common/home', '', true);
		$data['reset'] = $this->url->link('account/reset', 'code=' . urlencode($member_info['code']), true);

		$html = $this->load->view('mail/forgotten', $data);
		$text = "A new password was requested for your OpenCart account.\n\nTo reset your password click on the link below:\n" . $data['reset'] . "\n\nIP: " . $data['ip'];

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($member_info['email']);
			$mail->setFrom($this->config->get('config_email') ?: 'noreply@opencart.com');
			$mail->setSender(html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(($this->config->get('config_name') ?: 'OpenCart') . ' - Password Reset Request', ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}
	}
}

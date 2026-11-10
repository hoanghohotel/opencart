<?php
class ControllerMailPayment extends Controller {
	public function index($args = array()) {
		$this->load->language('mail/payment');

		$email = !empty($args['email']) ? $args['email'] : ($this->member->isLogged() ? $this->member->getEmail() : '');
		if (!$email) {
			return;
		}

		$store_name = html_entity_decode($this->config->get('config_name') ?: 'Store', ENT_QUOTES, 'UTF-8');

		$data['header'] = $this->load->controller('mail/header');
		$data['footer'] = $this->load->controller('mail/footer');
		$data['ip'] = isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '127.0.0.1';
		$data['text'] = !empty($args['text']) ? $args['text'] : $this->language->get('text_default_message');
		$data['mail_link'] = !empty($args['mail_link']) ? $args['mail_link'] : $this->url->link('account/payment', '', true);
		$data['store'] = $store_name;
		$data['store_url'] = rtrim((string)$this->config->get('config_url'), '/') . '/';
		$data['text_team_formatted'] = sprintf($this->language->get('text_team'), $store_name);

		$html = $this->load->view('mail/payment', $data);
		$text = $data['text'] . "\n\n" . sprintf($this->language->get('text_view_details'), $data['mail_link']) . "\n" . sprintf($this->language->get('text_ip'), $data['ip']);

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($email);
			$mail->setFrom($this->config->get('config_email') ?: ('noreply@' . (parse_url($this->config->get('config_url'), PHP_URL_HOST) ?: 'localhost')));
			$mail->setSender($store_name);
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_subject'), $store_name), ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}
	}
}

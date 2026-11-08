<?php
class ControllerMailCloudStore extends Controller {
	public function index($args = array()) {
		$email = !empty($args['email']) ? $args['email'] : ($this->member->isLogged() ? $this->member->getEmail() : '');
		if (!$email) {
			return;
		}

		$store_name = html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8');

		$data['header'] = $this->load->controller('mail/header');
		$data['footer'] = $this->load->controller('mail/footer');
		$data['ip'] = isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '127.0.0.1';
		$data['name'] = !empty($args['name']) ? $args['name'] : 'OpenCart Cloud Store';
		$data['url'] = !empty($args['url']) ? $args['url'] : $this->url->link('account/subscription', '', true);
		$data['text'] = !empty($args['text']) ? $args['text'] : 'Your OpenCart Cloud store "' . $data['name'] . '" has been provisioned and is ready!';
		$data['store'] = $store_name;
		$data['store_url'] = $this->url->link('common/home', '', true);

		$html = $this->load->view('mail/cloud_store', $data);
		$text = $data['text'] . "\n\nStore Name: " . $data['name'] . "\nStore URL: " . $data['url'] . "\nIP: " . $data['ip'];

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($email);
			$mail->setFrom($this->config->get('config_email') ?: 'noreply@opencart.com');
			$mail->setSender(html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(($this->config->get('config_name') ?: 'OpenCart') . ' - Cloud Store: ' . $data['name'], ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}
	}
}

<?php
class ControllerMailComment extends Controller {
	public function index($args = array()) {
		$extension_id = isset($args['extension_id']) ? (int)$args['extension_id'] : 0;
		$comment_text = isset($args['comment']) ? trim($args['comment']) : '';

		if (!$extension_id || !$comment_text) {
			return;
		}

		$this->load->model('marketplace/extension');
		$this->load->model('account/member');

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);
		if (!$extension_info || empty($extension_info['member_id'])) {
			return;
		}

		$seller_info = $this->model_account_member->getMember($extension_info['member_id']);
		$recipient_email = !empty($args['email']) ? $args['email'] : ($seller_info ? $seller_info['email'] : '');
		if (!$recipient_email) {
			return;
		}

		$store_name = html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8');

		$data['firstname'] = !empty($args['firstname']) ? $args['firstname'] : ($seller_info ? $seller_info['firstname'] : 'Developer');
		$data['username'] = !empty($args['username']) ? $args['username'] : ($this->member->isLogged() ? $this->member->getUsername() : 'Member');
		$data['extension'] = $extension_info['name'];
		$data['comment'] = $comment_text;
		$data['marketplace'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true);
		$data['store'] = $store_name;

		$text = $this->load->view('mail/comment', $data);

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($recipient_email);
			$mail->setFrom($this->config->get('config_email') ?: 'noreply@opencart.com');
			$mail->setSender(html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(($this->config->get('config_name') ?: 'OpenCart') . ' - New Comment on ' . $extension_info['name'], ENT_QUOTES, 'UTF-8'));
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}
	}
}

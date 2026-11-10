<?php
class ControllerMailRegister extends Controller {
	public function index($member_info = array()) {
		$this->load->language('mail/register');

		if (is_numeric($member_info)) {
			$this->load->model('account/member');
			$member_info = $this->model_account_member->getMember((int)$member_info);
		}

		if (empty($member_info['email'])) {
			return;
		}

		$code = !empty($member_info['code']) ? $member_info['code'] : token(40);
		$store_name = html_entity_decode($this->config->get('config_name') ?: 'Store', ENT_QUOTES, 'UTF-8');

		$data['header'] = $this->load->controller('mail/header');
		$data['footer'] = $this->load->controller('mail/footer');
		$data['verification_link'] = $this->url->link('account/verify', 'code=' . urlencode($code), true);
		$data['store'] = $store_name;
		$data['store_url'] = rtrim((string)$this->config->get('config_url'), '/') . '/';
		$data['text_team_formatted'] = sprintf($this->language->get('text_team'), $store_name);
		$data['extension'] = array(
			'link' => $this->url->link('marketplace/extension', '', true),
			'href' => $this->url->link('marketplace/extension', '', true)
		);

		$this->load->model('marketplace/extension');
		$this->load->model('tool/image');

		$data['promotions'] = array();
		$data['extensions'] = array();

		$results = $this->model_marketplace_extension->getExtensions(array('sort' => 'rating', 'order' => 'DESC', 'start' => 0, 'limit' => 6));

		$i = 0;
		foreach ($results as $result) {
			if (!empty($result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 160, 93);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 160, 93);
			}

			$ext_link = $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id'], true);

			$item = array(
				'image'       => $image,
				'name'        => $result['name'],
				'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 80) . '...',
				'price'       => ($result['price'] > 0) ? $this->currency->format($result['price'], $this->config->get('config_currency')) : $this->language->get('text_free'),
				'link'        => $ext_link,
				'href'        => $ext_link
			);

			if ($i < 3) {
				$data['promotions'][] = $item;
			} else {
				$data['extensions'][] = $item;
			}
			$i++;
		}

		$html = $this->load->view('mail/register', $data);
		$text = sprintf($this->language->get('text_plain_welcome'), $store_name, $data['verification_link']);

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($member_info['email']);
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

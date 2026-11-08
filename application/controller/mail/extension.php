<?php
class ControllerMailExtension extends Controller {
	public function index($args = array()) {
		$extension_id = isset($args['extension_id']) ? (int)$args['extension_id'] : 0;
		if (!$extension_id) {
			return;
		}

		$this->load->model('marketplace/extension');
		$this->load->model('tool/image');

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);
		if (!$extension_info) {
			return;
		}

		$store_name = html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8');

		$data['header'] = $this->load->controller('mail/header');
		$data['footer'] = $this->load->controller('mail/footer');
		$data['comment'] = !empty($args['comment']) ? $args['comment'] : 'A new version of ' . $extension_info['name'] . ' is now available for download.';
		$data['store'] = $store_name;
		$data['store_url'] = $this->url->link('common/home', '', true);
		$data['extension'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true);

		if (!empty($extension_info['image'])) {
			$data['image'] = $this->model_tool_image->resize($extension_info['image'], 160, 93);
		} else {
			$data['image'] = $this->model_tool_image->resize('no_image.png', 160, 93);
		}

		$data['name'] = $extension_info['name'];
		$data['description'] = utf8_substr(trim(strip_tags(html_entity_decode($extension_info['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '...';
		$data['download'] = $this->url->link('account/download', 'extension_id=' . $extension_id, true);

		$data['extensions'] = array();
		$results = $this->model_marketplace_extension->getExtensions(array('sort' => 'rating', 'order' => 'DESC', 'start' => 0, 'limit' => 3));

		foreach ($results as $result) {
			if (!empty($result['image'])) {
				$img = $this->model_tool_image->resize($result['image'], 160, 93);
			} else {
				$img = $this->model_tool_image->resize('no_image.png', 160, 93);
			}

			$ext_link = $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id'], true);

			$data['extensions'][] = array(
				'image'       => $img,
				'name'        => $result['name'],
				'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 80) . '...',
				'price'       => ($result['price'] > 0) ? $this->currency->format($result['price'], $this->config->get('config_currency')) : 'FREE',
				'link'        => $ext_link,
				'href'        => $ext_link
			);
		}

		$html = $this->load->view('mail/extension', $data);
		$text = "Extension Updated: " . $extension_info['name'] . "\n\n" . $data['comment'] . "\n\nDownload: " . $data['download'];

		// Determine recipients (explicit email or buyers who purchased this extension)
		$recipients = array();
		if (!empty($args['email'])) {
			$recipients[] = $args['email'];
		} else {
			$query = $this->db->query("SELECT DISTINCT m.email FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "member` m ON (o.member_id = m.member_id) WHERE o.extension_id = '" . (int)$extension_id . "' AND o.order_status_id > '0' AND m.email != ''");
			foreach ($query->rows as $row) {
				$recipients[] = $row['email'];
			}
		}

		foreach ($recipients as $email) {
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
				$mail->setSubject(html_entity_decode(($this->config->get('config_name') ?: 'OpenCart') . ' - Extension Update: ' . $extension_info['name'], ENT_QUOTES, 'UTF-8'));
				$mail->setHtml($html);
				$mail->setText($text);
				$mail->send();
			} catch (\Exception $e) {
				// Logged in Mail::send()
			}
		}
	}
}

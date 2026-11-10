<?php
class ControllerMailOrder extends Controller {
	public function index($args = array()) {
		$this->load->language('mail/order');
		$this->load->language('mail/seller');

		if (is_numeric($args)) {
			$order_id = (int)$args;
			$is_new = true;
		} else {
			$order_id = isset($args['order_id']) ? (int)$args['order_id'] : 0;
			$is_new = isset($args['status']) ? (bool)$args['status'] : true;
		}

		if (!$order_id) {
			return;
		}

		$this->load->model('account/order');
		$this->load->model('marketplace/extension');
		$this->load->model('account/member');
		$this->load->model('tool/image');

		$order_info = $this->model_account_order->getOrder($order_id);

		if (!$order_info) {
			return;
		}

		$buyer_info = array();
		if (!empty($order_info['member_id'])) {
			$buyer_info = $this->model_account_member->getMember($order_info['member_id']);
		}

		$buyer_email = !empty($order_info['buyer_email']) ? $order_info['buyer_email'] : (!empty($order_info['email']) ? $order_info['email'] : '');
		if (!$buyer_email && !empty($buyer_info['email'])) {
			$buyer_email = $buyer_info['email'];
		}

		if (!$buyer_email) {
			return;
		}

		$store_name = html_entity_decode($this->config->get('config_name') ?: 'Store', ENT_QUOTES, 'UTF-8');
		$order_status_name = !empty($order_info['status']) ? $order_info['status'] : (!empty($order_info['order_status']) ? $order_info['order_status'] : $this->language->get('text_status_complete'));

		if (is_array($args) && isset($args['status']) && is_string($args['status'])) {
			$status_code = strtolower(trim($args['status']));
		} elseif (stripos($order_status_name, 'complete') !== false) {
			$status_code = 'complete';
		} elseif (stripos($order_status_name, 'pending') !== false || stripos($order_status_name, 'process') !== false) {
			$status_code = 'pending';
		} else {
			$status_code = $is_new ? 'complete' : strtolower($order_status_name);
		}

		$data['header'] = $this->load->controller('mail/header');
		$data['footer'] = $this->load->controller('mail/footer');
		$data['status'] = $status_code;
		$data['order_status'] = $order_status_name;
		$data['download'] = $this->url->link('account/download', '', true);
		$data['order_id'] = $order_info['order_id'];
		$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
		$data['store'] = $store_name;
		$data['store_url'] = rtrim((string)$this->config->get('config_url'), '/') . '/';
		$data['text_team_formatted'] = sprintf($this->language->get('text_team'), $store_name);

		$data['extensions'] = array();

		$ext_info = !empty($order_info['extension_id']) ? $this->model_marketplace_extension->getExtension($order_info['extension_id']) : array();

		if ($ext_info && !empty($ext_info['image'])) {
			$image = $this->model_tool_image->resize($ext_info['image'], 160, 93);
		} else {
			$image = $this->model_tool_image->resize('no_image.png', 160, 93);
		}

		$currency_code = $this->config->get('config_currency') ?: 'USD';
		$ext_url = $this->url->link('marketplace/extension/info', 'extension_id=' . $order_info['extension_id'], true);

		$data['extensions'][] = array(
			'extension'   => $ext_url,
			'link'        => $ext_url,
			'href'        => $ext_url,
			'image'       => $image,
			'name'        => $order_info['extension'],
			'description' => $ext_info ? utf8_substr(trim(strip_tags(html_entity_decode($ext_info['description'], ENT_QUOTES, 'UTF-8'))), 0, 80) . '...' : '',
			'license'     => !empty($order_info['license_period']) ? $order_info['license_period'] : $this->language->get('text_default_license'),
			'price'       => $this->currency->format((float)$order_info['price'], $currency_code),
			'quantity'    => isset($order_info['quantity']) ? (int)$order_info['quantity'] : 1,
			'total'       => $this->currency->format((float)$order_info['total'], $currency_code)
		);

		$featured_results = $this->model_marketplace_extension->getExtensions(array('sort' => 'rating', 'order' => 'DESC', 'start' => 0, 'limit' => 3));
		foreach ($featured_results as $f_res) {
			if ((int)$f_res['extension_id'] === (int)$order_info['extension_id']) {
				continue;
			}
			if (!empty($f_res['image'])) {
				$f_img = $this->model_tool_image->resize($f_res['image'], 160, 93);
			} else {
				$f_img = $this->model_tool_image->resize('no_image.png', 160, 93);
			}
			$f_url = $this->url->link('marketplace/extension/info', 'extension_id=' . $f_res['extension_id'], true);
			$data['extensions'][] = array(
				'extension'   => $f_url,
				'link'        => $f_url,
				'href'        => $f_url,
				'image'       => $f_img,
				'name'        => $f_res['name'],
				'description' => utf8_substr(trim(strip_tags(html_entity_decode($f_res['description'], ENT_QUOTES, 'UTF-8'))), 0, 80) . '...'
			);
			if (count($data['extensions']) >= 3) {
				break;
			}
		}

		$from_email = $this->config->get('config_email') ?: ('noreply@' . (parse_url($this->config->get('config_url'), PHP_URL_HOST) ?: 'localhost'));

		// Also notify the extension seller using mail/seller.twig
		$seller_id = !empty($order_info['seller_id']) ? (int)$order_info['seller_id'] : (!empty($ext_info['member_id']) ? (int)$ext_info['member_id'] : 0);
		if ($seller_id) {
			$seller_info = $this->model_account_member->getMember($seller_id);
			if ($seller_info && !empty($seller_info['email'])) {
				$buyer_firstname = !empty($order_info['firstname']) ? $order_info['firstname'] : (!empty($buyer_info['firstname']) ? $buyer_info['firstname'] : (!empty($buyer_info['username']) ? $buyer_info['username'] : $this->language->get('text_default_customer')));
				$seller_username = !empty($seller_info['username']) ? $seller_info['username'] : $seller_info['firstname'];
				$transaction_url = $this->url->link('account/transaction', '', true);

				$seller_data = array(
					'username'                  => $seller_username,
					'extension'                 => $order_info['extension'],
					'extension_id'              => $order_info['extension_id'],
					'transaction'               => $transaction_url,
					'order_id'                  => $order_info['order_id'],
					'firstname'                 => $buyer_firstname,
					'email'                     => $buyer_email,
					'order_status'              => $data['order_status'],
					'store'                     => $store_name,
					'text_greeting_formatted'   => sprintf($this->language->get('text_greeting'), $seller_username),
					'text_sale_intro_formatted' => sprintf($this->language->get('text_sale_intro'), $order_info['extension'], $order_info['extension_id']),
					'text_sale_tx_formatted'    => sprintf($this->language->get('text_sale_transaction'), $transaction_url),
					'text_sale_order_formatted' => sprintf($this->language->get('text_sale_order_id'), $order_info['order_id']),
					'text_sale_fname_formatted' => sprintf($this->language->get('text_sale_firstname'), $buyer_firstname),
					'text_sale_email_formatted' => sprintf($this->language->get('text_sale_email'), $buyer_email),
					'text_sale_status_formatted'=> sprintf($this->language->get('text_sale_status'), $data['order_status'])
				);

				$seller_text = $this->load->view('mail/seller', $seller_data);

				try {
					$smail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
					$smail->parameter = $this->config->get('config_mail_parameter');
					$smail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$smail->smtp_username = $this->config->get('config_mail_smtp_username');
					$smail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$smail->smtp_port = $this->config->get('config_mail_smtp_port');
					$smail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$smail->setTo($seller_info['email']);
					$smail->setFrom($from_email);
					$smail->setSender($store_name);
					$smail->setSubject(html_entity_decode(sprintf($this->language->get('text_seller_subject'), $store_name, $order_info['order_id']), ENT_QUOTES, 'UTF-8'));
					$smail->setText($seller_text);
					$smail->send();
				} catch (\Exception $e) {
					// Logged in Mail::send()
				}
			}
		}

		// Reload mail/order language keys after mail/seller so mail/order keys take precedence
		$this->load->language('mail/order');

		$html = $this->load->view('mail/order', $data);
		$text = sprintf($this->language->get('text_plain_thank_you'), $store_name, $order_info['order_id']) . "\n" . sprintf($this->language->get('text_plain_extension'), $order_info['extension']) . "\n" . sprintf($this->language->get('text_plain_status'), $data['order_status']) . "\n" . sprintf($this->language->get('text_plain_downloads'), $data['download']);

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($buyer_email);
			$mail->setFrom($from_email);
			$mail->setSender($store_name);
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_subject'), $store_name, $order_info['order_id']), ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}
	}
}

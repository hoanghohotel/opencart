<?php
class ControllerSettingSetting extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('config', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('setting/setting', 'user_token=' . $this->session->data['user_token'], true));
		}

		$error_keys = array(
			'warning',
			'name',
			'owner',
			'address',
			'email',
			'telephone',
			'meta_title',
			'limit_admin',
			'log'
		);

		foreach ($error_keys as $key) {
			if (isset($this->error[$key])) {
				$data['error_' . $key] = $this->error[$key];
			} else {
				$data['error_' . $key] = '';
			}
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/setting', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('setting/setting', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true);

		$data['user_token'] = $this->session->data['user_token'];

		$config_fields = array(
			'config_meta_title',
			'config_meta_description',
			'config_meta_keyword',
			'config_name',
			'config_owner',
			'config_address',
			'config_email',
			'config_telephone',
			'config_contact_support',
			'config_contact_partner',
			'config_contact_marketing',
			'config_forum_url',
			'config_docs_url',
			'config_book_url',
			'config_developer_url',
			'config_dedicated_support_url',
			'config_demo_store_url',
			'config_demo_admin_url',
			'config_country_id',
			'config_zone_id',
			'config_language',
			'config_admin_language',
			'config_currency',
			'config_limit_admin',
			'config_order_status_id',
			'config_download_status_id',
			'config_logo',
			'config_icon',
			'config_mail_engine',
			'config_mail_parameter',
			'config_mail_smtp_hostname',
			'config_mail_smtp_username',
			'config_mail_smtp_password',
			'config_mail_smtp_port',
			'config_mail_smtp_timeout',
			'config_maintenance',
			'config_seo_url',
			'config_encryption',
			'config_error_display',
			'config_error_log',
			'config_error_filename',
			'config_storage_driver',
			'config_storage_bucket',
			'config_storage_region',
			'config_storage_endpoint',
			'config_storage_access_key',
			'config_storage_secret_key',
			'config_storage_gcs_json',
			'config_storage_prefix',
			'config_storage_public_url',
			'config_storage_acl',
			'config_storage_keep_local'
		);

		foreach ($config_fields as $field) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} else {
				$data[$field] = $this->config->get($field);
			}
		}

		if (empty($data['config_storage_driver'])) {
			$data['config_storage_driver'] = 'local';
		}
		if (empty($data['config_storage_region'])) {
			$data['config_storage_region'] = 'us-east-1';
		}
		if (empty($data['config_storage_acl'])) {
			$data['config_storage_acl'] = 'private';
		}
		if ($data['config_storage_keep_local'] === null || $data['config_storage_keep_local'] === '') {
			$data['config_storage_keep_local'] = '1';
		}

		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('tool/image');

		if (isset($this->request->post['config_logo']) && is_file(DIR_IMAGE . $this->request->post['config_logo'])) {
			$data['logo'] = $this->model_tool_image->resize($this->request->post['config_logo'], 100, 100);
		} elseif ($this->config->get('config_logo') && is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $this->model_tool_image->resize($this->config->get('config_logo'), 100, 100);
		} else {
			$data['logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['config_icon']) && is_file(DIR_IMAGE . $this->request->post['config_icon'])) {
			$data['icon'] = $this->model_tool_image->resize($this->request->post['config_icon'], 100, 100);
		} elseif ($this->config->get('config_icon') && is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $this->model_tool_image->resize($this->config->get('config_icon'), 100, 100);
		} else {
			$data['icon'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/setting', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['config_meta_title'])) {
			$this->error['meta_title'] = $this->language->get('error_meta_title');
		}

		if (empty($this->request->post['config_name'])) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['config_owner']) < 3) || (utf8_strlen($this->request->post['config_owner']) > 64)) {
			$this->error['owner'] = $this->language->get('error_owner');
		}

		if ((utf8_strlen($this->request->post['config_address']) < 3) || (utf8_strlen($this->request->post['config_address']) > 256)) {
			$this->error['address'] = $this->language->get('error_address');
		}

		if ((utf8_strlen($this->request->post['config_email']) > 96) || !filter_var($this->request->post['config_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['config_telephone']) < 3) || (utf8_strlen($this->request->post['config_telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if (empty($this->request->post['config_limit_admin'])) {
			$this->error['limit_admin'] = $this->language->get('error_limit');
		}

		if (empty($this->request->post['config_error_filename'])) {
			$this->error['log'] = $this->language->get('error_log_required');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function testSmtp() {
		$this->load->language('setting/setting');

		$json = array();

		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$json['error'] = $this->language->get('error_permission');
		}

		$engine        = isset($this->request->post['config_mail_engine']) ? trim($this->request->post['config_mail_engine']) : 'smtp';
		$smtp_hostname = isset($this->request->post['config_mail_smtp_hostname']) ? trim($this->request->post['config_mail_smtp_hostname']) : '';
		$smtp_username = isset($this->request->post['config_mail_smtp_username']) ? trim($this->request->post['config_mail_smtp_username']) : '';
		$smtp_password = isset($this->request->post['config_mail_smtp_password']) ? html_entity_decode($this->request->post['config_mail_smtp_password'], ENT_QUOTES, 'UTF-8') : '';
		$smtp_port     = isset($this->request->post['config_mail_smtp_port']) && (int)$this->request->post['config_mail_smtp_port'] > 0 ? (int)$this->request->post['config_mail_smtp_port'] : 25;
		$smtp_timeout  = isset($this->request->post['config_mail_smtp_timeout']) && (int)$this->request->post['config_mail_smtp_timeout'] > 0 ? (int)$this->request->post['config_mail_smtp_timeout'] : 10;
		$from_email    = !empty($this->request->post['config_email']) ? trim($this->request->post['config_email']) : $this->config->get('config_email');
		$sender_name   = !empty($this->request->post['config_name']) ? trim($this->request->post['config_name']) : $this->config->get('config_name');
		$test_email    = !empty($this->request->post['test_email']) ? trim($this->request->post['test_email']) : $from_email;

		if (!$json) {
			if ($engine == 'smtp' && empty($smtp_hostname)) {
				$json['error'] = 'Error: SMTP Hostname is required to test SMTP connection!';
			} elseif (!empty($test_email) && !filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
				$json['error'] = 'Error: Please enter a valid Test Recipient E-Mail address!';
			}
		}

		if (!$json) {
			try {
				$adaptor = (!empty($smtp_hostname) || $engine === 'smtp') ? 'smtp' : 'mail';
				$mail = new Mail($adaptor);
				$mail->parameter     = isset($this->request->post['config_mail_parameter']) ? $this->request->post['config_mail_parameter'] : '';
				$mail->smtp_hostname = $smtp_hostname;
				$mail->smtp_username = $smtp_username;
				$mail->smtp_password = $smtp_password;
				$mail->smtp_port     = $smtp_port;
				$mail->smtp_timeout  = $smtp_timeout;

				$diag = $mail->testConnection();

				if (!empty($test_email)) {
					$default_host = parse_url(defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER, PHP_URL_HOST) ?: 'localhost';
					$mail->setTo($test_email);
					$mail->setFrom($from_email ?: ($smtp_username ?: ('noreply@' . $default_host)));
					$mail->setSender(html_entity_decode($sender_name ?: 'OpenCart', ENT_QUOTES, 'UTF-8'));
					$mail->setSubject(html_entity_decode(($sender_name ?: 'OpenCart') . ' - SMTP Configuration Test', ENT_QUOTES, 'UTF-8'));

					$html  = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;border:1px solid #e5e5e5;border-radius:4px;">';
					$html .= '<h2 style="color:#1e91cf;margin-top:0;">OpenCart SMTP Test Successful</h2>';
					$html .= '<p>Your SMTP settings have been verified successfully before saving.</p>';
					$html .= '<table style="width:100%;border-collapse:collapse;margin:15px 0;font-size:13px;">';
					$html .= '<tr><td style="padding:6px;border-bottom:1px solid #eee;"><strong>Engine:</strong></td><td style="padding:6px;border-bottom:1px solid #eee;">' . htmlspecialchars(strtoupper($adaptor)) . '</td></tr>';
					$html .= '<tr><td style="padding:6px;border-bottom:1px solid #eee;"><strong>SMTP Host:</strong></td><td style="padding:6px;border-bottom:1px solid #eee;">' . htmlspecialchars($smtp_hostname ?: 'localhost') . ':' . (int)$smtp_port . '</td></tr>';
					$html .= '<tr><td style="padding:6px;border-bottom:1px solid #eee;"><strong>TLS Encrypted:</strong></td><td style="padding:6px;border-bottom:1px solid #eee;">' . (!empty($diag['tls']) ? 'Yes' : 'No') . '</td></tr>';
					$html .= '<tr><td style="padding:6px;border-bottom:1px solid #eee;"><strong>Authenticated:</strong></td><td style="padding:6px;border-bottom:1px solid #eee;">' . (!empty($diag['authenticated']) ? 'Yes' : 'No') . '</td></tr>';
					$html .= '<tr><td style="padding:6px;border-bottom:1px solid #eee;"><strong>Timestamp:</strong></td><td style="padding:6px;border-bottom:1px solid #eee;">' . date('Y-m-d H:i:s') . '</td></tr>';
					$html .= '</table>';
					$html .= '</div>';

					$text = "OpenCart SMTP Test Successful\n\nHost: " . ($smtp_hostname ?: 'localhost') . ":" . $smtp_port . "\nTLS: " . (!empty($diag['tls']) ? 'Yes' : 'No') . "\nAuthenticated: " . (!empty($diag['authenticated']) ? 'Yes' : 'No') . "\nTime: " . date('Y-m-d H:i:s');

					$mail->setHtml($html);
					$mail->setText($text);
					$mail->send();
				}

				$tls_label  = !empty($diag['tls']) ? 'TLS/SSL Active' : 'Plaintext';
				$auth_label = !empty($diag['authenticated']) ? 'Authenticated' : 'No Auth';
				$json['success'] = 'Success: Connected to ' . ($smtp_hostname ?: 'local mail engine') . ':' . $smtp_port . ' (' . $tls_label . ', ' . $auth_label . ') and sent test email to ' . $test_email . '! You can now click Save.';
				$json['diagnostics'] = $diag;
			} catch (\Exception $e) {
				$json['error'] = $e->getMessage();
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function testStorage() {
		$this->load->language('setting/setting');

		$json = array();

		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			require_once(DIR_SYSTEM . 'library/cloud_storage.php');
			$storage = new CloudStorage($this->registry, $this->request->post);
			$res = $storage->testConnection();

			if (!empty($res['success'])) {
				$json['success'] = $res['message'];
				$json['details'] = $res;
			} else {
				$json['error'] = !empty($res['error']) ? $res['error'] : 'Cloud storage connection test failed.';
				$json['details'] = $res;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

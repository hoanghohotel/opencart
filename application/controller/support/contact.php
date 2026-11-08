<?php
class ControllerSupportContact extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Contact Us');

		if ($this->member->isLogged()) {
			$data['name'] = trim($this->member->getFirstName() . ' ' . $this->member->getLastName());
			if (!$data['name']) {
				$data['name'] = $this->member->getUsername();
			}
			$data['email'] = $this->member->getEmail();
		} else {
			$data['name'] = '';
			$data['email'] = '';
		}

		$data['contact_support'] = 'info@opencart.com';
		$data['contact_telephone'] = '+852 2499 0996';
		$data['contact_partner'] = 'partners@opencart.com';
		$data['contact_marketing'] = 'media@opencart.com';

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/contact', $data));
	}

	public function reason() {
		$reason = isset($this->request->get['reason']) ? $this->request->get['reason'] : '';

		$this->load->model('localisation/country');
		$this->load->model('cms/download');

		$data['countries'] = $this->model_localisation_country->getCountries();
		$data['country_id'] = $this->member->isLogged() ? $this->member->getCountryId() : $this->config->get('config_country_id');
		$data['downloads'] = $this->model_cms_download->getDownloads();

		$allowed = array('order', 'partner', 'fraud', 'support', 'other');

		if (in_array($reason, $allowed)) {
			$this->response->setOutput($this->load->view('support/contact_' . $reason, $data));
		} else {
			$this->response->setOutput('');
		}
	}

	public function send() {
		$json = array();

		$this->load->model('support/enquiry');

		$type = isset($this->request->post['reason']) ? $this->request->post['reason'] : (isset($this->request->post['type']) ? $this->request->post['type'] : '');

		if (!$type) {
			$json['error']['warning'] = 'Please select what you would like to contact us about!';
		} else {
			if (!isset($this->request->post['name']) || (utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 64)) {
				$json['error']['name'] = 'Name must be between 3 and 64 characters!';
			}

			if (!isset($this->request->post['email']) || (utf8_strlen(trim($this->request->post['email'])) > 96) || !filter_var(trim($this->request->post['email']), FILTER_VALIDATE_EMAIL)) {
				$json['error']['email'] = 'E-Mail Address does not appear to be valid!';
			}

			if (!isset($this->request->post['enquiry']) || (utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
				$json['error']['enquiry'] = 'Message must be between 10 and 3000 characters!';
			}

			if ($type == 'partner') {
				if (empty($this->request->post['company'])) {
					$json['error']['company'] = 'Company Name required!';
				}

				if (empty($this->request->post['website'])) {
					$json['error']['website'] = 'Company Website required!';
				}

				if (empty($this->request->post['country_id'])) {
					$json['error']['country'] = 'Please select a country!';
				}
			}

			if ($json && !isset($json['error']['warning'])) {
				$json['error']['warning'] = 'Please check the form carefully for errors!';
			}
		}

		if (!$json) {
			$enquiry_data = $this->request->post;
			$enquiry_data['type'] = $type;

			$this->model_support_enquiry->addEnquiry($enquiry_data);

			$admin_email = $this->config->get('config_email');
			if ($admin_email && filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
				$store_name = html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8');
				$sender_name = trim($this->request->post['name']);
				$sender_email = trim($this->request->post['email']);
				$message_body = trim($this->request->post['enquiry']);

				$text  = "New Contact Us Enquiry (" . ucfirst($type) . ")\n\n";
				$text .= "From: " . $sender_name . " (" . $sender_email . ")\n";
				if (!empty($this->request->post['company'])) {
					$text .= "Company: " . trim($this->request->post['company']) . "\n";
				}
				if (!empty($this->request->post['website'])) {
					$text .= "Website: " . trim($this->request->post['website']) . "\n";
				}
				if (!empty($this->request->post['order_id'])) {
					$text .= "Order ID: #" . trim($this->request->post['order_id']) . "\n";
				}
				$text .= "\nMessage:\n----------------------------------------\n" . $message_body . "\n----------------------------------------\n";

				try {
					$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$mail->setTo($admin_email);
					$mail->setFrom($admin_email);
					$mail->setSender(html_entity_decode($store_name . ' (' . $sender_name . ')', ENT_QUOTES, 'UTF-8'));
					$mail->setReplyTo($sender_email);
					$mail->setSubject(html_entity_decode($store_name . ' - Contact Enquiry [' . ucfirst($type) . '] from ' . $sender_name, ENT_QUOTES, 'UTF-8'));
					$mail->setText($text);
					$mail->send();
				} catch (\Exception $e) {
					// Logged in Mail::send()
				}
			}

			unset($this->session->data['captcha']);

			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('support/contact/success'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function success() {
		$this->document->setTitle('OpenCart - Contact Us');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/contact_success', $data));
	}
}

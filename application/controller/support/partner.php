<?php
class ControllerSupportPartner extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Partners');

		$this->load->model('account/partner');
		$this->load->model('tool/image');

		if (isset($this->request->get['filter_country_id'])) {
			$filter_country_id = (int)$this->request->get['filter_country_id'];
		} else {
			$filter_country_id = 0;
		}

		if (isset($this->request->get['filter_type_id'])) {
			$filter_type_id = (string)$this->request->get['filter_type_id'];
		} elseif (isset($this->request->get['filter_partner_type_id'])) {
			$filter_type_id = (string)$this->request->get['filter_partner_type_id'];
		} else {
			$filter_type_id = '';
		}

		if (isset($this->request->get['filter_status_id'])) {
			$filter_status_id = (string)$this->request->get['filter_status_id'];
		} elseif (isset($this->request->get['filter_partner_status_id'])) {
			$filter_status_id = (string)$this->request->get['filter_partner_status_id'];
		} else {
			$filter_status_id = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 5;

		$buildUrl = function($overrides = array()) use ($filter_country_id, $filter_type_id, $filter_status_id) {
			$params = array(
				'filter_country_id' => $filter_country_id ? $filter_country_id : '',
				'filter_type_id'    => $filter_type_id,
				'filter_status_id'  => $filter_status_id
			);

			foreach ($overrides as $k => $v) {
				$params[$k] = $v;
			}

			$url = '';
			foreach ($params as $k => $v) {
				if ($v !== '' && $v !== null) {
					$url .= '&' . $k . '=' . urlencode((string)$v);
				}
			}

			return ltrim($url, '&');
		};

		$data['country'] = '';
		$data['countries'] = array();

		$data['countries'][] = array(
			'country_id' => 0,
			'name'       => 'All',
			'total'      => 0,
			'href'       => $this->url->link('support/partner', $buildUrl(array('filter_country_id' => '')))
		);

		$partner_countries = $this->model_account_partner->getPartnerCountries();

		foreach ($partner_countries as $country) {
			if ((int)$country['country_id'] === $filter_country_id) {
				$data['country'] = $country['name'];
			}

			$data['countries'][] = array(
				'country_id' => $country['country_id'],
				'name'       => $country['name'] . ' (' . $country['total'] . ')',
				'total'      => $country['total'],
				'href'       => $this->url->link('support/partner', $buildUrl(array('filter_country_id' => $country['country_id'])))
			);
		}

		$data['partner_types'] = array();

		$data['partner_types'][] = array(
			'member_partner_type_id' => '',
			'name'                   => 'All',
			'href'                   => $this->url->link('support/partner', $buildUrl(array('filter_type_id' => '')))
		);

		$types = $this->model_account_partner->getPartnerTypes();

		foreach ($types as $type) {
			$data['partner_types'][] = array(
				'member_partner_type_id' => (string)$type['member_partner_type_id'],
				'name'                   => $type['name'],
				'href'                   => $this->url->link('support/partner', $buildUrl(array('filter_type_id' => $type['member_partner_type_id'])))
			);
		}

		$data['partner_statuses'] = array();

		$data['partner_statuses'][] = array(
			'member_partner_status_id' => '',
			'name'                     => 'All',
			'href'                     => $this->url->link('support/partner', $buildUrl(array('filter_status_id' => '')))
		);

		$statuses = $this->model_account_partner->getPartnerStatuses();

		foreach ($statuses as $status) {
			$data['partner_statuses'][] = array(
				'member_partner_status_id' => (string)$status['member_partner_status_id'],
				'name'                     => $status['name'],
				'href'                     => $this->url->link('support/partner', $buildUrl(array('filter_status_id' => $status['member_partner_status_id'])))
			);
		}

		$filter_data = array(
			'filter_country_id'        => $filter_country_id,
			'filter_partner_type_id'   => $filter_type_id,
			'filter_partner_status_id' => $filter_status_id,
			'start'                    => ($page - 1) * $limit,
			'limit'                    => $limit
		);

		$partner_total = $this->model_account_partner->getTotalPartners($filter_data);
		$results = $this->model_account_partner->getPartners($filter_data);

		$base_url = $buildUrl();

		$data['partners'] = array();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 110, 40);
			} else {
				$image = '';
			}

			if ($result['status_image']) {
				$status_image = (strpos($result['status_image'], 'image/') === 0 || strpos($result['status_image'], 'application/') === 0 || strpos($result['status_image'], 'http') === 0) ? $result['status_image'] : 'image/' . ltrim($result['status_image'], '/');
			} else {
				$status_image = 'image/original/58267ff292cfd.jpg';
			}

			$data['partners'][] = array(
				'member_partner_id' => $result['member_partner_id'],
				'company'           => $result['company'],
				'image'             => $image,
				'description'       => trim(strip_tags(html_entity_decode($result['description_short'], ENT_QUOTES, 'UTF-8'))),
				'country'           => $result['country'],
				'status_image'      => $status_image,
				'status_name'       => $result['status_name'],
				'website'           => $result['website'],
				'href'              => $this->url->link('support/partner/info', 'partner_id=' . $result['member_partner_id'] . ($base_url ? '&' . $base_url : ''))
			);
		}

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $partner_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('support/partner', ($base_url ? $base_url . '&' : '') . 'page={page}')
		));

		$data['filter_country_id'] = $filter_country_id;
		$data['filter_type_id'] = $filter_type_id;
		$data['filter_status_id'] = $filter_status_id;
		$data['add'] = $this->url->link('account/partner/add', '', true);

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/partner_list', $data));
	}

	public function info() {
		$this->load->model('account/partner');
		$this->load->model('cms/showcase');
		$this->load->model('tool/image');

		$partner_id = isset($this->request->get['partner_id']) ? (int)$this->request->get['partner_id'] : (isset($this->request->get['member_partner_id']) ? (int)$this->request->get['member_partner_id'] : 0);

		$partner_info = $this->model_account_partner->getPartner($partner_id);

		if ($partner_info) {
			$this->document->setTitle('OpenCart - Partner ' . $partner_info['company']);

			$data['partner_id'] = $partner_info['member_partner_id'];
			$data['company'] = $partner_info['company'];

			if ($partner_info['image']) {
				$data['image'] = $this->model_tool_image->resize($partner_info['image'], 110, 40);
			} else {
				$data['image'] = '';
			}

			if ($partner_info['status_image']) {
				$data['status_image'] = (strpos($partner_info['status_image'], 'image/') === 0 || strpos($partner_info['status_image'], 'application/') === 0 || strpos($partner_info['status_image'], 'http') === 0) ? $partner_info['status_image'] : 'image/' . ltrim($partner_info['status_image'], '/');
			} else {
				$data['status_image'] = 'image/original/58267ff292cfd.jpg';
			}

			$data['status_name'] = $partner_info['status_name'];
			$data['filter_status'] = $this->url->link('support/partner', 'filter_status_id=' . $partner_info['member_partner_status_id']);
			$data['date_added'] = date('m/Y', strtotime($partner_info['date_added']));
			$data['description'] = html_entity_decode($partner_info['description_long'] ? $partner_info['description_long'] : $partner_info['description_short'], ENT_QUOTES, 'UTF-8');

			$address_parts = array_filter(array(
				$partner_info['address_1'],
				$partner_info['address_2'],
				trim($partner_info['city'] . ($partner_info['postcode'] ? ' ' . $partner_info['postcode'] : '')),
				$partner_info['zone'],
				$partner_info['country']
			));

			$data['address'] = implode('<br />', $address_parts);
			$data['country'] = $partner_info['country'];
			$data['telephone'] = $partner_info['telephone'];
			$data['website'] = $partner_info['website'];
			$data['facebook'] = $partner_info['facebook'];
			$data['twitter'] = $partner_info['twitter'];
			$data['linkedin'] = $partner_info['linkedin'];
			$data['contact'] = $this->url->link('support/partner/contact', 'partner_id=' . $partner_info['member_partner_id']);

			$data['showcases'] = array();

			$showcase_results = $this->model_cms_showcase->getShowcases(array(
				'filter_member_id' => $partner_info['member_id'],
				'start'            => 0,
				'limit'            => 3
			));

			if (!$showcase_results) {
				$showcase_results = $this->model_cms_showcase->getShowcases(array(
					'start' => 0,
					'limit' => 3
				));
			}

			foreach ($showcase_results as $result) {
				if ($result['image']) {
					$sc_image = $this->model_tool_image->resize($result['image'], 360, 200);
				} else {
					$sc_image = $this->model_tool_image->resize('no_image.png', 360, 200);
				}

				$data['showcases'][] = array(
					'showcase_id' => $result['showcase_id'],
					'name'        => $result['name'],
					'category'    => isset($result['category']) ? $result['category'] : '',
					'image'       => $sc_image,
					'link'        => $result['link']
				);
			}

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('support/partner_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function contact() {
		$this->load->model('account/partner');
		$this->load->model('tool/image');

		$partner_id = isset($this->request->get['partner_id']) ? (int)$this->request->get['partner_id'] : 0;

		$partner_info = $this->model_account_partner->getPartner($partner_id);

		if ($partner_info) {
			$this->document->setTitle('Contact Partner - ' . $partner_info['company']);

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

			$data['partner_id'] = $partner_info['member_partner_id'];
			$data['member_token'] = isset($this->session->data['member_token']) ? $this->session->data['member_token'] : '';

			if (!empty($partner_info['member_image'])) {
				$data['partner_image'] = $this->model_tool_image->resize($partner_info['member_image'], 65, 65);
			} else {
				$data['partner_image'] = $this->model_tool_image->resize('profile.png', 65, 65);
			}

			$data['partner_username'] = $partner_info['company'];
			$data['partner_date_added'] = date('M Y', strtotime($partner_info['date_added']));
			$data['partner_telephone'] = $partner_info['telephone'];

			$address_parts = array_filter(array(
				$partner_info['address_1'],
				$partner_info['address_2'],
				$partner_info['city'],
				$partner_info['zone'],
				$partner_info['postcode'],
				$partner_info['country']
			));

			$data['partner_address'] = implode(', ', $address_parts);
			$data['status_name'] = $partner_info['status_name'];
			$data['partner_facebook'] = $partner_info['facebook'];
			$data['partner_twitter'] = $partner_info['twitter'];
			$data['partner_linkedin'] = $partner_info['linkedin'];

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('support/partner_contact', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function send() {
		$json = array();

		$this->load->model('support/enquiry');

		if (!isset($this->request->post['name']) || (utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 64)) {
			$json['error']['name'] = 'Name must be between 3 and 64 characters!';
		}

		if (!isset($this->request->post['email']) || (utf8_strlen(trim($this->request->post['email'])) > 96) || !filter_var(trim($this->request->post['email']), FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = 'E-Mail Address does not appear to be valid!';
		}

		if (!isset($this->request->post['subject']) || (utf8_strlen(trim($this->request->post['subject'])) < 3) || (utf8_strlen(trim($this->request->post['subject'])) > 128)) {
			$json['error']['subject'] = 'Subject must be between 3 and 128 characters!';
		}

		if (!isset($this->request->post['enquiry']) || (utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
			$json['error']['enquiry'] = 'Message must be between 10 and 3000 characters!';
		}

		if ($json && !isset($json['error']['warning'])) {
			$json['error']['warning'] = 'Please check the form carefully for errors!';
		}

		if (!$json) {
			$enquiry_data = $this->request->post;
			$enquiry_data['type'] = 'partner';
			$enquiry_data['partner_id'] = isset($this->request->get['partner_id']) ? (int)$this->request->get['partner_id'] : 0;

			$this->model_support_enquiry->addEnquiry($enquiry_data);

			$this->load->model('account/partner');
			$partner_info = $this->model_account_partner->getPartner($enquiry_data['partner_id']);
			$partner_email = ($partner_info && !empty($partner_info['email']) && filter_var($partner_info['email'], FILTER_VALIDATE_EMAIL)) ? $partner_info['email'] : $this->config->get('config_email');

			if ($partner_email) {
				$store_name = html_entity_decode($this->config->get('config_name') ?: 'OpenCart', ENT_QUOTES, 'UTF-8');
				$sender_name = trim($this->request->post['name']);
				$sender_email = trim($this->request->post['email']);
				$subject_line = trim($this->request->post['subject']);
				$message_body = trim($this->request->post['enquiry']);

				$text  = "Hi " . ($partner_info ? $partner_info['company'] : 'Partner') . ",\n\n";
				$text .= "You have received a new partner enquiry on " . $store_name . ".\n\n";
				$text .= "From: " . $sender_name . " (" . $sender_email . ")\n";
				$text .= "Subject: " . $subject_line . "\n\n";
				$text .= "Message:\n----------------------------------------\n" . $message_body . "\n----------------------------------------\n";

				try {
					$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$mail->setTo($partner_email);
					$mail->setFrom($this->config->get('config_email') ?: 'noreply@opencart.com');
					$mail->setSender(html_entity_decode($store_name . ' (' . $sender_name . ')', ENT_QUOTES, 'UTF-8'));
					$mail->setReplyTo($sender_email);
					$mail->setSubject(html_entity_decode($store_name . ' - Partner Enquiry: ' . $subject_line, ENT_QUOTES, 'UTF-8'));
					$mail->setText($text);
					$mail->send();
				} catch (\Exception $e) {
					// Logged in Mail::send()
				}
			}

			unset($this->session->data['captcha']);

			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('support/partner/success'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function success() {
		$this->document->setTitle('OpenCart - Contact Partner');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/partner_success', $data));
	}
}

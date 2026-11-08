<?php
class ControllerAccountPartner extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/partner', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->model('account/partner');

		$partner_info = $this->getPartnerByMember($this->member->getId());

		if ($partner_info || $this->member->isPartner()) {
			return $this->edit();
		} else {
			return $this->add();
		}
	}

	public function add() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/partner/add', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/partner');

		$this->document->setTitle($this->language->get('heading_add'));

		$this->load->model('account/partner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm('add')) {
			$this->savePartnerData($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->getForm('account/partner/add');
	}

	public function edit() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/partner/edit', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/partner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm('edit')) {
			$this->savePartnerData($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_edit');

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->getForm('account/partner/edit');
	}

	protected function getPartnerByMember($member_id) {
		if (isset($this->model_account_partner->getPartnerByMemberId)) {
			return $this->model_account_partner->getPartnerByMemberId($member_id);
		}

		return $this->model_account_partner->getPartner($member_id);
	}

	protected function savePartnerData($post_data) {
		if (isset($this->model_account_partner->addPartner) && !$this->getPartnerByMember($this->member->getId())) {
			$ref = new ReflectionMethod('ModelAccountPartner', 'addPartner');
			if ($ref->getNumberOfParameters() >= 2) {
				$this->model_account_partner->addPartner($this->member->getId(), $post_data);
			} else {
				$this->model_account_partner->addPartner($post_data);
			}
		} else {
			$ref = new ReflectionMethod('ModelAccountPartner', 'editPartner');
			if ($ref->getNumberOfParameters() >= 2) {
				$this->model_account_partner->editPartner($this->member->getId(), $post_data);
			} else {
				$this->model_account_partner->editPartner($post_data);
			}
		}
	}

	protected function getForm($route) {
		$error_keys = array(
			'warning',
			'firstname',
			'lastname',
			'company',
			'website',
			'email',
			'telephone',
			'partner_type',
			'description_short',
			'description_long',
			'address_1',
			'city',
			'postcode',
			'country',
			'zone'
		);

		foreach ($error_keys as $key) {
			if (isset($this->error[$key])) {
				$data['error_' . $key] = $this->error[$key];
			} else {
				$data['error_' . $key] = '';
			}
		}

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['route'] = $route;
		$data['partner_status'] = $this->member->isPartner();
		$data['member_token'] = $this->session->data['member_token'];
		$data['action'] = $this->url->link($route, $token, true);
		$data['cancel'] = $this->url->link('account/account', $token, true);

		$partner_info = array();

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$partner_info = $this->getPartnerByMember($this->member->getId());
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($partner_info['firstname'])) {
			$data['firstname'] = $partner_info['firstname'];
		} else {
			$data['firstname'] = $this->member->getFirstName();
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($partner_info['lastname'])) {
			$data['lastname'] = $partner_info['lastname'];
		} else {
			$data['lastname'] = $this->member->getLastName();
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (!empty($partner_info['company'])) {
			$data['company'] = $partner_info['company'];
		} else {
			$data['company'] = $this->member->getCompany();
		}

		if (isset($this->request->post['website'])) {
			$data['website'] = $this->request->post['website'];
		} elseif (!empty($partner_info['website'])) {
			$data['website'] = $partner_info['website'];
		} else {
			$data['website'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($partner_info['email'])) {
			$data['email'] = $partner_info['email'];
		} else {
			$data['email'] = $this->member->getEmail();
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($partner_info['telephone'])) {
			$data['telephone'] = $partner_info['telephone'];
		} else {
			$data['telephone'] = $this->member->getTelephone();
		}

		if (isset($this->request->post['member_partner_type_id'])) {
			$data['member_partner_type_id'] = (int)$this->request->post['member_partner_type_id'];
		} elseif (!empty($partner_info['member_partner_type_id'])) {
			$data['member_partner_type_id'] = (int)$partner_info['member_partner_type_id'];
		} else {
			$data['member_partner_type_id'] = 0;
		}

		$data['partner_types'] = $this->model_account_partner->getPartnerTypes();

		if (isset($this->request->post['description_short'])) {
			$data['description_short'] = $this->request->post['description_short'];
		} elseif (!empty($partner_info['description_short'])) {
			$data['description_short'] = $partner_info['description_short'];
		} else {
			$data['description_short'] = '';
		}

		if (isset($this->request->post['description_long'])) {
			$data['description_long'] = $this->request->post['description_long'];
		} elseif (!empty($partner_info['description_long'])) {
			$data['description_long'] = $partner_info['description_long'];
		} else {
			$data['description_long'] = '';
		}

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (!empty($partner_info['address_1'])) {
			$data['address_1'] = $partner_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (!empty($partner_info['address_2'])) {
			$data['address_2'] = $partner_info['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($partner_info['city'])) {
			$data['city'] = $partner_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($partner_info['postcode'])) {
			$data['postcode'] = $partner_info['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		} elseif (!empty($partner_info['country_id'])) {
			$data['country_id'] = (int)$partner_info['country_id'];
		} else {
			$data['country_id'] = (int)$this->member->getCountryId();
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = (int)$this->request->post['zone_id'];
		} elseif (!empty($partner_info['zone_id'])) {
			$data['zone_id'] = (int)$partner_info['zone_id'];
		} else {
			$data['zone_id'] = 0;
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($partner_info['image'])) {
			$data['image'] = $partner_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if ($data['image'] && $this->model_tool_image->resize($data['image'], 100, 100)) {
			$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['facebook'])) {
			$data['facebook'] = $this->request->post['facebook'];
		} elseif (!empty($partner_info['facebook'])) {
			$data['facebook'] = $partner_info['facebook'];
		} else {
			$data['facebook'] = '';
		}

		if (isset($this->request->post['twitter'])) {
			$data['twitter'] = $this->request->post['twitter'];
		} elseif (!empty($partner_info['twitter'])) {
			$data['twitter'] = $partner_info['twitter'];
		} else {
			$data['twitter'] = '';
		}

		if (isset($this->request->post['linkedin'])) {
			$data['linkedin'] = $this->request->post['linkedin'];
		} elseif (!empty($partner_info['linkedin'])) {
			$data['linkedin'] = $partner_info['linkedin'];
		} else {
			$data['linkedin'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/partner', $data));
	}

	protected function validateForm($mode = 'edit') {
		if (!isset($this->request->post['firstname']) || (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if (!isset($this->request->post['lastname']) || (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if (empty($this->request->post['company'])) {
			$this->error['company'] = $this->language->get('error_company');
		}

		if (empty($this->request->post['website'])) {
			$this->error['website'] = $this->language->get('error_website');
		}

		if (!isset($this->request->post['email']) || (utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!isset($this->request->post['telephone']) || (utf8_strlen(trim($this->request->post['telephone'])) < 3) || (utf8_strlen(trim($this->request->post['telephone'])) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if (empty($this->request->post['member_partner_type_id'])) {
			$this->error['partner_type'] = $this->language->get('error_partner_type');
		}

		if (empty($this->request->post['description_short'])) {
			$this->error['description_short'] = $this->language->get('error_description_short');
		}

		if (empty($this->request->post['description_long'])) {
			$this->error['description_long'] = $this->language->get('error_description_long');
		}

		if (!isset($this->request->post['address_1']) || (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if (!isset($this->request->post['city']) || (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		if (empty($this->request->post['country_id'])) {
			$this->error['country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] === '') {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		if ($mode === 'add' && empty($this->request->post['agree'])) {
			$this->error['warning'] = $this->language->get('error_agree');
		}

		return !$this->error;
	}
}

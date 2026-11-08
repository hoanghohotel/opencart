<?php
class ControllerAccountSeller extends Controller {
	private $error = array();

	public function index() {
		$this->edit();
	}

	public function add() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/seller/add', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/seller');

		$this->document->setTitle($this->language->get('heading_add'));

		$this->load->model('account/seller');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate(true)) {
			$this->model_account_seller->addSeller($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->getForm('account/seller/add');
	}

	public function edit() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/seller/edit', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/seller');

		$this->load->model('account/seller');

		$seller_info = $this->model_account_seller->getSeller($this->member->getId());

		if (!$this->member->isSeller() && !$seller_info) {
			$this->response->redirect($this->url->link('account/seller/add', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate(false)) {
			$this->model_account_seller->editSeller($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_edit');

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->getForm('account/seller/edit');
	}

	protected function getForm($route = 'account/seller/edit') {
		$data['route'] = $route;

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['support_email'])) {
			$data['error_support_email'] = $this->error['support_email'];
		} else {
			$data['error_support_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['payment_email'])) {
			$data['error_payment_email'] = $this->error['payment_email'];
		} else {
			$data['error_payment_email'] = '';
		}

		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		if (isset($this->error['api_url'])) {
			$data['error_api_url'] = $this->error['api_url'];
		} else {
			$data['error_api_url'] = '';
		}

		$data['action'] = $this->url->link($route, 'member_token=' . $this->session->data['member_token'], true);
		$data['cancel'] = $this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true);

		$seller_info = $this->model_account_seller->getSeller($this->member->getId());

		if (!$seller_info) {
			$this->load->model('account/member');
			$member_info = $this->model_account_member->getMember($this->member->getId());
		} else {
			$member_info = array();
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($seller_info['firstname'])) {
			$data['firstname'] = $seller_info['firstname'];
		} elseif (isset($member_info['firstname'])) {
			$data['firstname'] = $member_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($seller_info['lastname'])) {
			$data['lastname'] = $seller_info['lastname'];
		} elseif (isset($member_info['lastname'])) {
			$data['lastname'] = $member_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (isset($seller_info['email'])) {
			$data['email'] = $seller_info['email'];
		} elseif (isset($member_info['email'])) {
			$data['email'] = $member_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['support_email'])) {
			$data['support_email'] = $this->request->post['support_email'];
		} elseif (isset($seller_info['support_email'])) {
			$data['support_email'] = $seller_info['support_email'];
		} elseif (isset($member_info['email'])) {
			$data['support_email'] = $member_info['email'];
		} else {
			$data['support_email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($seller_info['telephone'])) {
			$data['telephone'] = $seller_info['telephone'];
		} elseif (isset($member_info['telephone'])) {
			$data['telephone'] = $member_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['website'])) {
			$data['website'] = $this->request->post['website'];
		} elseif (isset($seller_info['website'])) {
			$data['website'] = $seller_info['website'];
		} elseif (isset($member_info['website'])) {
			$data['website'] = $member_info['website'];
		} else {
			$data['website'] = '';
		}

		if (isset($this->request->post['payment_method'])) {
			$data['payment_method'] = $this->request->post['payment_method'];
		} elseif (isset($seller_info['payment_method']) && $seller_info['payment_method'] !== '') {
			$data['payment_method'] = $seller_info['payment_method'];
		} else {
			$data['payment_method'] = 'paypal';
		}

		$data['payoneer'] = 'https://www.payoneer.com';

		if (!empty($seller_info['payoneer_token'])) {
			$data['payoneer_token'] = $seller_info['payoneer_token'];
		} else {
			$data['payoneer_token'] = '';
		}

		if (isset($this->request->post['payment_email'])) {
			$data['payment_email'] = $this->request->post['payment_email'];
		} elseif (isset($seller_info['payment_email'])) {
			$data['payment_email'] = $seller_info['payment_email'];
		} else {
			$data['payment_email'] = '';
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (isset($seller_info['company'])) {
			$data['company'] = $seller_info['company'];
		} elseif (isset($member_info['company'])) {
			$data['company'] = $member_info['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (isset($seller_info['address_1'])) {
			$data['address_1'] = $seller_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (isset($seller_info['address_2'])) {
			$data['address_2'] = $seller_info['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (isset($seller_info['city'])) {
			$data['city'] = $seller_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($seller_info['postcode'])) {
			$data['postcode'] = $seller_info['postcode'];
		} else {
			$data['postcode'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($seller_info['country_id'])) {
			$data['country_id'] = $seller_info['country_id'];
		} elseif (isset($member_info['country_id'])) {
			$data['country_id'] = $member_info['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = $this->request->post['zone_id'];
		} elseif (isset($seller_info['zone_id'])) {
			$data['zone_id'] = $seller_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		if (isset($this->request->post['notify'])) {
			$data['notify'] = $this->request->post['notify'];
		} elseif (isset($seller_info['notify'])) {
			$data['notify'] = $seller_info['notify'];
		} else {
			$data['notify'] = 1;
		}

		if (isset($this->request->post['api_status'])) {
			$data['api_status'] = $this->request->post['api_status'];
		} elseif (isset($seller_info['api_status'])) {
			$data['api_status'] = $seller_info['api_status'];
		} else {
			$data['api_status'] = 0;
		}

		if (isset($this->request->post['api_url'])) {
			$data['api_url'] = $this->request->post['api_url'];
		} elseif (isset($seller_info['api_url'])) {
			$data['api_url'] = $seller_info['api_url'];
		} else {
			$data['api_url'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/seller', $data));
	}

	protected function validate($require_agree = false) {
		if (!isset($this->request->post['firstname']) || (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if (!isset($this->request->post['lastname']) || (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if (!isset($this->request->post['email']) || (utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!isset($this->request->post['support_email']) || (utf8_strlen($this->request->post['support_email']) > 96) || !filter_var($this->request->post['support_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['support_email'] = $this->language->get('error_support_email');
		}

		if (!isset($this->request->post['telephone']) || (utf8_strlen(trim($this->request->post['telephone'])) < 3) || (utf8_strlen(trim($this->request->post['telephone'])) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if (!isset($this->request->post['payment_email']) || (utf8_strlen($this->request->post['payment_email']) > 96) || !filter_var($this->request->post['payment_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['payment_email'] = $this->language->get('error_payment_email');
		}

		if (!isset($this->request->post['address_1']) || (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if (!isset($this->request->post['city']) || (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		$this->load->model('localisation/country');

		if (!empty($this->request->post['country_id'])) {
			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

			if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
				$this->error['postcode'] = $this->language->get('error_postcode');
			}
		} else {
			$this->error['country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] === '') {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		if (!empty($this->request->post['api_status']) && empty($this->request->post['api_url'])) {
			$this->error['api_url'] = $this->language->get('error_api_url');
		}

		if ($require_agree && empty($this->request->post['agree'])) {
			$this->error['warning'] = $this->language->get('error_agree');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
}

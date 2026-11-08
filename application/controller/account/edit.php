<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/edit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/member');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_account_member->editMember($this->member->getId(), $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
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

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		$data['action'] = $this->url->link('account/edit', 'member_token=' . $this->session->data['member_token'], true);

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$member_info = $this->model_account_member->getMember($this->member->getId());
		}

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} elseif (!empty($member_info)) {
			$data['username'] = $member_info['username'];
		} else {
			$data['username'] = $this->member->getUsername();
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($member_info)) {
			$data['firstname'] = $member_info['firstname'];
		} else {
			$data['firstname'] = $this->member->getFirstName();
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($member_info)) {
			$data['lastname'] = $member_info['lastname'];
		} else {
			$data['lastname'] = $this->member->getLastName();
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (!empty($member_info)) {
			$data['company'] = $member_info['company'];
		} else {
			$data['company'] = $this->member->getCompany();
		}

		if (isset($this->request->post['tax_id'])) {
			$data['tax_id'] = $this->request->post['tax_id'];
		} elseif (!empty($member_info)) {
			$data['tax_id'] = $member_info['tax_id'];
		} else {
			$data['tax_id'] = $this->member->getTaxId();
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($member_info)) {
			$data['email'] = $member_info['email'];
		} else {
			$data['email'] = $this->member->getEmail();
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		} elseif (!empty($member_info)) {
			$data['country_id'] = (int)$member_info['country_id'];
		} else {
			$data['country_id'] = (int)$this->member->getCountryId();
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($member_info)) {
			$data['image'] = $member_info['image'];
		} else {
			$data['image'] = $this->member->getImage();
		}

		$this->load->model('tool/image');

		if ($data['image'] && $this->model_tool_image->resize($data['image'], 100, 100)) {
			$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['notify'])) {
			$data['notify'] = (int)$this->request->post['notify'];
		} elseif (!empty($member_info)) {
			$data['notify'] = (int)$member_info['notify'];
		} else {
			$data['notify'] = (int)$this->member->getNotify();
		}

		$data['cancel'] = $this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/edit', $data));
	}

	protected function validate() {
		if (!isset($this->request->post['username']) || (utf8_strlen(trim($this->request->post['username'])) < 3) || (utf8_strlen(trim($this->request->post['username'])) > 64)) {
			$this->error['username'] = $this->language->get('error_username');
		} elseif ((utf8_strtolower($this->member->getUsername()) != utf8_strtolower(trim($this->request->post['username']))) && $this->model_account_member->getTotalMembersByUsername($this->request->post['username'])) {
			$this->error['username'] = $this->language->get('error_username_exists');
		}

		if (!isset($this->request->post['firstname']) || (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if (!isset($this->request->post['lastname']) || (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if (!isset($this->request->post['email']) || (utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		} elseif ((utf8_strtolower($this->member->getEmail()) != utf8_strtolower(trim($this->request->post['email']))) && $this->model_account_member->getTotalMembersByEmail($this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email_exists');
		}

		if (empty($this->request->post['country_id'])) {
			$this->error['country'] = $this->language->get('error_country');
		}

		return !$this->error;
	}
}

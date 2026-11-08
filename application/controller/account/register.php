<?php
class ControllerAccountRegister extends Controller {
	private $error = array();

	public function index() {
		if ($this->member->isLogged()) {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->document->setTitle('Register for OpenCart account');

		$this->load->model('account/member');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$member_id = $this->model_account_member->addMember($this->request->post);

			$member_info = $this->model_account_member->getMember($member_id);

			if ($member_info) {
				$this->load->controller('mail/register', $member_info);
			}

			$this->response->redirect($this->url->link('account/success', '', true));
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

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		$data['action'] = $this->url->link('account/register', '', true);

		if (isset($this->request->post['username'])) {
			$data['username'] = $this->request->post['username'];
		} else {
			$data['username'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		} else {
			$data['country_id'] = (int)$this->config->get('config_country_id');
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['redirect'])) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];
		} else {
			$data['redirect'] = '';
		}

		$data['extension'] = $this->url->link('marketplace/extension', '', true);
		$data['seller'] = $this->url->link('account/seller', '', true);

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/register', $data));
	}

	protected function validate() {
		if (!isset($this->request->post['username']) || (utf8_strlen(trim($this->request->post['username'])) < 3) || (utf8_strlen(trim($this->request->post['username'])) > 64)) {
			$this->error['username'] = 'Username must be between 3 and 64 characters!';
		} elseif ($this->model_account_member->getTotalMembersByUsername($this->request->post['username'])) {
			$this->error['username'] = 'Warning: Username is already registered!';
		}

		if (!isset($this->request->post['firstname']) || (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = 'First Name must be between 1 and 32 characters!';
		}

		if (!isset($this->request->post['lastname']) || (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = 'Last Name must be between 1 and 32 characters!';
		}

		if (!isset($this->request->post['email']) || (utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = 'E-Mail Address does not appear to be valid!';
		} elseif ($this->model_account_member->getTotalMembersByEmail($this->request->post['email'])) {
			$this->error['email'] = 'Warning: E-Mail Address is already registered!';
		}

		if (empty($this->request->post['country_id'])) {
			$this->error['country'] = 'Please select a country!';
		}

		if (!isset($this->request->post['password']) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
			$this->error['password'] = 'Password must be between 4 and 40 characters!';
		}

		return !$this->error;
	}
}

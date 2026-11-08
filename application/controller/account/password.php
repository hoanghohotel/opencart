<?php
class ControllerAccountPassword extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/password', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->document->setTitle('Change My Password');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('account/member');

			$this->model_account_member->editPassword($this->member->getEmail(), $this->request->post['password']);

			$this->session->data['success'] = 'Success: Your password has been successfully updated.';

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		if (isset($this->error['current'])) {
			$data['error_current'] = $this->error['current'];
		} else {
			$data['error_current'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		$data['action'] = $this->url->link('account/password', 'member_token=' . $this->session->data['member_token'], true);

		if (isset($this->request->post['current'])) {
			$data['current'] = $this->request->post['current'];
		} else {
			$data['current'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$data['cancel'] = $this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/password', $data));
	}

	protected function validate() {
		if (!isset($this->request->post['current']) || !$this->member->login($this->member->getEmail(), html_entity_decode($this->request->post['current'], ENT_QUOTES, 'UTF-8'))) {
			$this->error['current'] = 'Your old password is incorrect!';
		}

		if (!isset($this->request->post['password']) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
			$this->error['password'] = 'Password must be between 4 and 40 characters!';
		}

		if (!isset($this->request->post['confirm']) || ($this->request->post['confirm'] != $this->request->post['password'])) {
			$this->error['confirm'] = 'Password confirmation does not match password!';
		}

		return !$this->error;
	}
}

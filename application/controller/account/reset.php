<?php
class ControllerAccountReset extends Controller {
	private $error = array();

	public function index() {
		if ($this->member->isLogged()) {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		if (isset($this->request->get['code'])) {
			$code = $this->request->get['code'];
		} else {
			$code = '';
		}

		$this->load->language('account/reset');

		$this->load->model('account/member');

		$member_info = $this->model_account_member->getMemberByCode($code);

		if ($member_info) {
			$this->document->setTitle($this->language->get('heading_title'));

			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				$this->model_account_member->editPassword($member_info['email'], $this->request->post['password']);

				$this->session->data['success'] = $this->language->get('text_success');

				$this->response->redirect($this->url->link('account/login', '', true));
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

			$data['action'] = $this->url->link('account/reset', 'code=' . $code, true);

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

			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('account/reset', $data));
		} else {
			$this->session->data['error'] = $this->language->get('error_code');

			$this->response->redirect($this->url->link('account/login', '', true));
		}
	}

	protected function validate() {
		if (!isset($this->request->post['password']) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!isset($this->request->post['confirm']) || ($this->request->post['confirm'] != $this->request->post['password'])) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}

		return !$this->error;
	}
}

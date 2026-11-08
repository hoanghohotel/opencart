<?php
class ControllerAccountForgotten extends Controller {
	private $error = array();

	public function index() {
		if ($this->member->isLogged()) {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->load->language('account/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/member');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$code = token(40);

			$this->model_account_member->editCode($this->request->post['email'], $code);

			$member_info = $this->model_account_member->getMemberByEmail($this->request->post['email']);
			if ($member_info) {
				$member_info['code'] = $code;
				$this->load->controller('mail/forgotten', $member_info);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		$data['action'] = $this->url->link('account/forgotten', '', true);
		$data['login'] = $this->url->link('account/login', '', true);

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/forgotten', $data));
	}

	protected function validate() {
		if (!isset($this->request->post['email']) || empty($this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		} elseif (!$this->model_account_member->getTotalMembersByEmail($this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		return !$this->error;
	}
}

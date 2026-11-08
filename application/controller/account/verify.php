<?php
class ControllerAccountVerify extends Controller {
	public function index() {
		$this->load->language('account/verify');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/member');

		if (isset($this->request->get['code'])) {
			$code = $this->request->get['code'];
		} else {
			$code = '';
		}

		$data['verified'] = false;

		if ($code) {
			$member_info = $this->model_account_member->getMemberByCode($code);

			if ($member_info) {
				$this->model_account_member->verifyMember($code);

				$data['verified'] = true;
			}
		}

		$data['download'] = $this->url->link('cms/download', '', true);
		$data['cloud'] = $this->url->link('cloud/landing', '', true);
		$data['login'] = $this->url->link('account/login', '', true);

		if (is_file(DIR_APPLICATION . 'controller/cms/banner.php')) {
			$data['banner'] = $this->load->controller('cms/banner');
		} else {
			$data['banner'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/verify', $data));
	}
}

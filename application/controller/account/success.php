<?php
class ControllerAccountSuccess extends Controller {
	public function index() {
		$this->document->setTitle('Your Account Has Been Created!');

		if ($this->member->isLogged()) {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$data['continue'] = $this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true);
		} else {
			$data['continue'] = $this->url->link('account/login', '', true);
		}

		if (is_file(DIR_APPLICATION . 'controller/cms/banner.php')) {
			$data['banner'] = $this->load->controller('cms/banner');
		} else {
			$data['banner'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/success', $data));
	}
}

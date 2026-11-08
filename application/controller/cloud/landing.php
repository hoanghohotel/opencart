<?php
class ControllerCloudLanding extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart Cloud - Start Your Free Trial');

		if ($this->member->isLogged() && isset($this->session->data['member_token'])) {
			$data['create'] = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true);
		} else {
			$data['create'] = $this->url->link('account/login', '', true);
		}

		$data['trial'] = $data['create'];

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cloud/landing', $data));
	}
}

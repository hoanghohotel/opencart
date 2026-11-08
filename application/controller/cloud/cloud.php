<?php
class ControllerCloudCloud extends Controller {
	public function index() {
		$this->load->language('cloud/cloud');
		$this->load->language('cloud/landing');

		$store_name = $this->config->get('config_name') ?: 'Store';

		$this->document->setTitle(str_replace('{store_name}', $store_name, $this->language->get('heading_title')));

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

	public function terms() {
		$this->load->language('cloud/terms');

		$store_name = $this->config->get('config_name') ?: 'Store';

		$this->document->setTitle(str_replace('{store_name}', $store_name, $this->language->get('heading_title')));

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cloud/terms', $data));
	}
}

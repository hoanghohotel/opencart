<?php
class ControllerCmsCompany extends Controller {
	public function index() {
		$this->load->language('cms/company');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/company', $data));
	}
}

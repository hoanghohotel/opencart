<?php
class ControllerCmsCompany extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - About Us');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/company', $data));
	}
}

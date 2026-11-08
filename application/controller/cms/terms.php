<?php
class ControllerCmsTerms extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Terms & Conditions');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/terms', $data));
	}
}

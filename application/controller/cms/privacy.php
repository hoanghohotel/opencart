<?php
class ControllerCmsPrivacy extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Privacy Policy');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/privacy', $data));
	}
}

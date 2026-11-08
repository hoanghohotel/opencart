<?php
class ControllerCmsGdpr extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - GDPR Compliance');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/gdpr', $data));
	}
}

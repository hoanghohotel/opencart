<?php
class ControllerCmsDemo extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Demo');

		$data['extension'] = $this->url->link('marketplace/extension');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/demo', $data));
	}
}

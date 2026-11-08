<?php
class ControllerCmsTerms extends Controller {
	public function index() {
		$this->load->language('cms/terms');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/terms', $data));
	}
}

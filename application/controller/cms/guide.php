<?php
class ControllerCmsGuide extends Controller {
	public function index() {
		$this->load->language('cms/guide');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['home'] = $this->url->link('common/home');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/guide', $data));
	}
}

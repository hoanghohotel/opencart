<?php
class ControllerSupportSupport extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Support');

		$data['support'] = $this->url->link('support/contact');
		$data['partner'] = $this->url->link('support/partner');
		$data['marketplace'] = $this->url->link('marketplace/extension');
		$data['forum'] = 'https://forum.opencart.com';

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/support', $data));
	}
}

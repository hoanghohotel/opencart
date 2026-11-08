<?php
class ControllerCmsFeature extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Features');

		$data['download'] = $this->url->link('cms/download');
		$data['demo'] = $this->url->link('cms/demo');
		$data['marketplace'] = $this->url->link('marketplace/extension');
		$data['extension'] = $this->url->link('marketplace/extension');
		$data['partner'] = $this->url->link('support/partner');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/feature', $data));
	}
}

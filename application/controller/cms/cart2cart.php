<?php
class ControllerCmsCart2cart extends Controller {
	public function index() {
		$this->load->language('cms/cart2cart');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/cart2cart', $data));
	}
}

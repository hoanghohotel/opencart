<?php
class ControllerCmsCart2cart extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Cart2Cart Migration');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/cart2cart', $data));
	}
}

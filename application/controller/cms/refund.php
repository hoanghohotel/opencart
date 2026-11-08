<?php
class ControllerCmsRefund extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Refund Policy');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/refund', $data));
	}
}

<?php
class ControllerCommonMaintenance extends Controller {
	public function index() {
		$this->document->setTitle('Maintenance');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => 'Maintenance',
			'href' => $this->url->link('common/maintenance')
		);

		$data['message'] = '<h1 style="text-align:center;">We are currently performing some scheduled maintenance. <br/>We will be back as soon as possible. Please check back soon.</h1>';

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/maintenance', $data));
	}
}

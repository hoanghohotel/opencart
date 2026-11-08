<?php
class ControllerMailHeader extends Controller {
	public function index() {
		$this->load->language('mail/header');

		$data = array();

		return $this->load->view('mail/header', $data);
	}
}

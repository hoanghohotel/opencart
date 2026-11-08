<?php
class ControllerMailHeader extends Controller {
	public function index() {
		$data = array();

		return $this->load->view('mail/header', $data);
	}
}

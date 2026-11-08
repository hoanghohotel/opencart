<?php
class ControllerMailFooter extends Controller {
	public function index() {
		$data['marketplace'] = $this->url->link('marketplace/extension', '', true);

		return $this->load->view('mail/footer', $data);
	}
}

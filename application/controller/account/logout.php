<?php
class ControllerAccountLogout extends Controller {
	public function index() {
		if ($this->member->isLogged()) {
			$this->member->logout();

			unset($this->session->data['member_token']);
		}

		$this->response->redirect($this->url->link('account/login', '', true));
	}
}

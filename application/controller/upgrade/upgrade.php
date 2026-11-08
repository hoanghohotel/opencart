<?php
class ControllerUpgradeUpgrade extends Controller {
	public function index() {
		$this->response->redirect(HTTP_SERVER . 'install/index.php?route=upgrade/upgrade');
	}

	public function next() {
		$step = isset($this->request->get['step']) ? (int)$this->request->get['step'] : 1;
		$this->response->redirect(HTTP_SERVER . 'install/index.php?route=upgrade/upgrade/next&step=' . $step);
	}
}

<?php
class ControllerEventLanguage extends Controller {
	public function index(&$route, &$args) {
		foreach ($this->language->all() as $key => $value) {
			if (!isset($args[$key])) {
				$args[$key] = $value;
			}
		}
	}

	public function before(&$route, &$output) {
		$this->language->set('backup', $this->language->all());
	}

	public function after(&$route, &$args, &$output) {
		$data = $this->language->get('backup');

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$this->language->set($key, $value);
			}
		}
	}
}

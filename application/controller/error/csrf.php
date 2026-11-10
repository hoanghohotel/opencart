<?php
class ControllerErrorCsrf extends Controller {
	public function index() {
		if ($this->registry->has('load') && method_exists($this->load, 'language')) {
			$this->load->language('error/csrf');
		}

		$has_lang = $this->registry->has('language');

		if ($this->registry->get('csrf_status') === 405) {
			$this->response->addHeader('HTTP/1.1 405 Method Not Allowed');
			$this->response->addHeader('Allow: POST');
			$error = ($has_lang && $this->language->get('error_method_not_allowed') !== 'error_method_not_allowed')
				? $this->language->get('error_method_not_allowed')
				: 'This action requires a POST request.';
		} else {
			$this->response->addHeader('HTTP/1.1 403 Forbidden');
			$error = ($has_lang && $this->language->get('error_invalid_token') !== 'error_invalid_token')
				? $this->language->get('error_invalid_token')
				: 'Invalid or missing request token. Reload the page before submitting again.';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->addHeader('Cache-Control: no-store');
		$this->response->setOutput(json_encode(array('error' => $error)));
	}
}

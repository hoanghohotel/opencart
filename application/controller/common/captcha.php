<?php
class ControllerCommonCaptcha extends Controller {
	public function index() {
		$this->load->language('common/captcha');

		$json = array();

		$this->session->data['captcha'] = false;
		$this->session->data['captcha_tries'] = 3;

		$icons = array(
			'lock' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#25a9e0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
			'star' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#25a9e0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
			'heart' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#25a9e0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>',
			'home' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#25a9e0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
			'bell' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#25a9e0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>'
		);

		$icon_labels = array(
			'lock'  => $this->language->get('text_lock'),
			'star'  => $this->language->get('text_star'),
			'heart' => $this->language->get('text_heart'),
			'home'  => $this->language->get('text_home_icon'),
			'bell'  => $this->language->get('text_bell')
		);

		$keys = array_keys($icons);
		$target_key = $keys[array_rand($keys)];
		shuffle($keys);

		$target_label = isset($icon_labels[$target_key]) ? $icon_labels[$target_key] : ucfirst($target_key);
		$json['message'] = sprintf($this->language->get('text_instruction'), $target_label);
		$json['image'] = array();

		foreach ($keys as $key) {
			$code = token(16);

			if ($key == $target_key) {
				$this->session->data['captcha_code'] = $code;
			}

			$json['image'][] = array(
				'href'  => str_replace('&amp;', '&', $this->url->link('common/captcha/check', 'code=' . $code, true)),
				'image' => 'data:image/svg+xml;base64,' . base64_encode($icons[$key])
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function check() {
		$this->load->language('common/captcha');

		$json = array();

		if (isset($this->request->get['code']) && isset($this->session->data['captcha_code']) && $this->request->get['code'] === $this->session->data['captcha_code']) {
			$this->session->data['captcha'] = true;
			$json['success'] = $this->language->get('text_success');
		} else {
			if (!isset($this->session->data['captcha_tries'])) {
				$this->session->data['captcha_tries'] = 3;
			}

			$this->session->data['captcha_tries']--;

			$json['error'] = $this->language->get('error_captcha');
			$json['total'] = max(0, (int)$this->session->data['captcha_tries']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

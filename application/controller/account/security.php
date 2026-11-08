<?php
class ControllerAccountSecurity extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/security', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('account/member');

		$member_info = $this->model_account_member->getMember($this->member->getId());

		if (empty($member_info['pin'])) {
			$this->response->redirect($this->url->link('account/pin', '', true));
		}

		$this->load->language('account/security');

		$this->document->setTitle($this->language->get('heading_title'));

		$pin_total = isset($member_info['pin_attempts']) ? (int)$member_info['pin_attempts'] : 0;

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ($pin_total >= 3) {
				$this->error['warning'] = $this->language->get('error_attempts');
			} else {
				$submitted_pin = isset($this->request->post['pin']) ? trim($this->request->post['pin']) : '';

				if ($submitted_pin !== '' && $submitted_pin === (string)$member_info['pin']) {
					$this->model_account_member->resetPinAttempts($this->member->getId());
					$this->member->trustCurrentIp();

					if (empty($this->session->data['member_token'])) {
						$this->session->data['member_token'] = token(32);
					}

					if (!empty($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], HTTP_SERVER) !== false || strpos($this->request->post['redirect'], HTTPS_SERVER) !== false)) {
						$redirect = str_replace('&amp;', '&', $this->request->post['redirect']);

						if (strpos($redirect, 'member_token=') === false) {
							if (preg_match('/([?&]route=[^&]+)/', $redirect, $m)) {
								$redirect = str_replace($m[1], $m[1] . '&member_token=' . $this->session->data['member_token'], $redirect);
							} else {
								$redirect .= (strpos($redirect, '?') !== false ? '&' : '?') . 'member_token=' . $this->session->data['member_token'];
							}
						}

						$this->response->redirect($redirect);
					} else {
						$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
					}
				} else {
					$this->model_account_member->incrementPinAttempts($this->member->getId());
					$pin_total++;

					if ($pin_total < 3) {
						$remaining = 3 - $pin_total;
						$this->error['warning'] = sprintf($this->language->get('error_pin_remaining'), $remaining);
					}
				}
			}
		}

		$data['pin_total'] = $pin_total;
		$data['contact'] = $this->url->link('support/contact', '', true);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action'] = $this->url->link('account/security', '', true);

		if (isset($this->request->post['pin'])) {
			$data['pin'] = $this->request->post['pin'];
		} else {
			$data['pin'] = '';
		}

		if (isset($this->request->post['redirect'])) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];
			unset($this->session->data['redirect']);
		} else {
			$data['redirect'] = '';
		}

		if (is_file(DIR_APPLICATION . 'controller/cms/banner.php')) {
			$data['banner'] = $this->load->controller('cms/banner');
		} else {
			$data['banner'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/security', $data));
	}

	public function reset() {
		$this->load->language('account/security');

		$json = array();

		if (!$this->member->isLogged()) {
			$json['error'] = $this->language->get('error_session');
		} else {
			$this->load->model('account/member');

			$member_info = $this->model_account_member->getMember($this->member->getId());

			if ($member_info) {
				$new_pin = sprintf('%04d', mt_rand(0, 9999));
				$code = token(40);

				$this->model_account_member->resetMemberPin($member_info['member_id'], $new_pin, $code);

				$this->load->controller('mail/pin', array(
					'member_id' => $member_info['member_id'],
					'username'  => $member_info['username'],
					'firstname' => $member_info['firstname'],
					'email'     => $member_info['email'],
					'new_pin'   => $new_pin,
					'code'      => $code
				));

				$json['success'] = sprintf($this->language->get('text_reset_success'), $member_info['email']);
			} else {
				$json['error'] = $this->language->get('error_not_found');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function confirm() {
		$code = isset($this->request->get['code']) ? trim($this->request->get['code']) : '';

		if ($code) {
			$this->load->model('account/member');

			$member_info = $this->model_account_member->getMemberByCode($code);

			if ($member_info) {
				$this->model_account_member->resetMemberPin($member_info['member_id'], '', '');

				if (!$this->member->isLogged()) {
					$this->member->login($member_info['email'], '', true);
				}

				$this->session->data['force_pin_setup'] = true;

				$this->response->redirect($this->url->link('account/pin', '', true));
			}
		}

		$this->response->redirect($this->url->link('account/login', '', true));
	}
}

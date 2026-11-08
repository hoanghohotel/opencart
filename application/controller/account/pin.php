<?php
class ControllerAccountPin extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/pin', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('account/member');

		$member_info = $this->model_account_member->getMember($this->member->getId());

		if (!empty($member_info['pin']) && empty($this->session->data['force_pin_setup'])) {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			if (!$this->member->isIpVerified()) {
				$this->response->redirect($this->url->link('account/security', '', true));
			} else {
				$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
			}
		}

		$this->document->setTitle('Setup PIN for your account');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$pin = trim($this->request->post['pin']);

			$this->model_account_member->editPin($this->member->getId(), $pin);

			$this->member->trustCurrentIp();

			unset($this->session->data['force_pin_setup']);

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
		}

		if (isset($this->error['pin'])) {
			$data['error_pin'] = $this->error['pin'];
		} else {
			$data['error_pin'] = '';
		}

		$data['action'] = $this->url->link('account/pin', '', true);

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

		$this->response->setOutput($this->load->view('account/pin', $data));
	}

	protected function validate() {
		$pin = isset($this->request->post['pin']) ? trim($this->request->post['pin']) : '';

		if (!preg_match('/^\d{4}$/', $pin)) {
			$this->error['pin'] = 'PIN must be exactly 4 digits (0-9)!';
		}

		return !$this->error;
	}
}

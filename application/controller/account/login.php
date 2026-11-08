<?php
class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/member');

		// Login override for admin users or magic links
		if (!empty($this->request->get['email']) && !empty($this->request->get['code'])) {
			$this->member->logout();

			$member_info = $this->model_account_member->getMemberByCode($this->request->get['code']);

			if ($member_info && $member_info['email'] === $this->request->get['email']) {
				$this->member->login($member_info['email'], '', true);

				$this->model_account_member->editCode($member_info['email'], '');

				if (empty($this->session->data['member_token'])) {
					$this->session->data['member_token'] = token(32);
				}

				$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
			}
		}

		if ($this->member->isLogged()) {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$this->response->redirect($this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->load->language('account/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			if (isset($this->request->post['redirect']) && $this->request->post['redirect'] != $this->url->link('account/logout', '', true) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], HTTP_SERVER) !== false || strpos($this->request->post['redirect'], HTTPS_SERVER) !== false)) {
				$this->session->data['redirect'] = str_replace('&amp;', '&', $this->request->post['redirect']);
			}

			if (!$this->member->hasPin()) {
				$this->response->redirect($this->url->link('account/pin', '', true));
			}

			if (!$this->member->isIpVerified()) {
				$this->response->redirect($this->url->link('account/security', '', true));
			}

			// Added strpos check to pass McAfee PCI compliance test
			if (!empty($this->session->data['redirect'])) {
				$redirect = $this->session->data['redirect'];
				unset($this->session->data['redirect']);

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

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('account/login', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['forgotten'] = $this->url->link('account/forgotten', '', true);

		if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], HTTP_SERVER) !== false || strpos($this->request->post['redirect'], HTTPS_SERVER) !== false)) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];

			unset($this->session->data['redirect']);
		} else {
			$data['redirect'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/login', $data));
	}

	protected function validate() {
		$email = isset($this->request->post['email']) ? trim($this->request->post['email']) : '';
		$password = isset($this->request->post['password']) ? html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8') : '';

		if (!$email || !$password) {
			$this->error['warning'] = $this->language->get('error_login');
		}

		if (!$this->error) {
			$member_info = $this->model_account_member->getMemberByLogin($email);

			if ($member_info && !$member_info['status']) {
				$this->error['warning'] = $this->language->get('error_disabled');
			} elseif ($member_info && !$member_info['verified']) {
				if (empty($member_info['code'])) {
					$code = token(40);
					$this->model_account_member->editCode($member_info['member_id'], $code);
					$member_info['code'] = $code;
				}

				$this->load->controller('mail/register', $member_info);

				$this->error['warning'] = sprintf($this->language->get('error_unverified'), $member_info['email']);
			} elseif (!$this->member->login($email, $password)) {
				$this->model_account_member->addLoginAttempt($email);
				$this->error['warning'] = $this->language->get('error_login');
			} else {
				$this->model_account_member->deleteLoginAttempts($email);
			}
		}

		return !$this->error;
	}
}

<?php
class ControllerAccountPayment extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/payment', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->document->setTitle('Registered Payment Methods');

		$this->load->model('account/payment');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} elseif (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 10;

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['payment_methods'] = array();

		$payment_total = $this->model_account_payment->getTotalPayments($this->member->getId());

		$results = $this->model_account_payment->getPayments($this->member->getId(), ($page - 1) * $limit, $limit);

		foreach ($results as $result) {
			$payment_id = isset($result['member_payment_id']) ? (int)$result['member_payment_id'] : (isset($result['payment_id']) ? (int)$result['payment_id'] : 0);

			$image = !empty($result['image']) ? $result['image'] : '';
			if (!$image || $image === 'application/view/image/cloud/cloud_credit_card.svg') {
				if ($result['type'] === 'paypal') {
					$image = 'application/view/image/account/paypal-logo.png';
				} elseif (stripos($result['name'], 'MasterCard') !== false) {
					$image = 'application/view/image/payment/mastercard.png';
				} elseif (stripos($result['name'], 'American Express') !== false) {
					$image = 'application/view/image/payment/american_express.png';
				} elseif (stripos($result['name'], 'Discover') !== false) {
					$image = 'application/view/image/payment/discover.png';
				} elseif (stripos($result['name'], 'JCB') !== false) {
					$image = 'application/view/image/payment/jcb.png';
				} elseif (stripos($result['name'], 'Maestro') !== false) {
					$image = 'application/view/image/payment/maestro.png';
				} else {
					$image = 'application/view/image/payment/visa.png';
				}
			}

			$data['payment_methods'][] = array(
				'member_payment_id' => $payment_id,
				'type'              => $result['type'],
				'name'              => $result['name'],
				'image'             => $image,
				'date_expire'       => $result['date_expire'],
				'default'           => (int)$result['default'],
				'make_default'      => $this->url->link('account/payment/makedefault', $token . '&member_payment_id=' . $payment_id, true),
				'delete'            => $this->url->link('account/payment/delete', $token . '&member_payment_id=' . $payment_id, true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $payment_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/payment', $token . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['cancel'] = $this->url->link('account/account', $token, true);
		$data['create_card'] = $this->url->link('account/payment/card', $token, true);
		$data['create_paypal'] = $this->url->link('account/payment/paypal', $token, true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/payment_list', $data));
	}

	public function stripe() {
		$this->request->get['gateway'] = 'stripe';
		return $this->card();
	}

	public function braintree() {
		$this->request->get['gateway'] = 'braintree';
		return $this->card();
	}

	public function card() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/payment/card', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		$payment_gateway = new PaymentGateway($this->registry);

		$gateway_override = isset($this->request->get['gateway']) ? $this->request->get['gateway'] : '';
		$active_gateway = $payment_gateway->getActiveCardGateway($gateway_override);
		$this->session->data['active_card_gateway'] = $active_gateway;

		if ($active_gateway === 'stripe') {
			$this->document->setTitle('Register New Credit Card (Stripe)');
		} else {
			$this->document->setTitle('Register New Credit Card');
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['member_token'] = $this->session->data['member_token'];
		$data['client_token'] = $payment_gateway->getClientToken($active_gateway);
		$data['cancel'] = $this->url->link('account/payment', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/credit_card_form', $data));
	}

	public function paypal() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/payment/paypal', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		$payment_gateway = new PaymentGateway($this->registry);
		$pp_cfg = $payment_gateway->getPayPalConfig();

		$this->document->setTitle('Register PayPal Account');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['member_token'] = $this->session->data['member_token'];
		$data['client_token'] = 'paypal|' . $pp_cfg['environment'] . '|' . $pp_cfg['client_id'];
		$data['cancel'] = $this->url->link('account/payment', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/paypal_form', $data));
	}

	public function add() {
		$json = array();

		if (!$this->member->isLogged()) {
			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/login', '', true));
		} else {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$type = isset($this->request->get['type']) ? $this->request->get['type'] : 'card';
			$nonce = isset($this->request->post['nonce']) ? trim($this->request->post['nonce']) : '';

			if (!$nonce && empty($this->request->post['name'])) {
				$json['error']['warning'] = 'Payment token is missing!';
				$json['error']['merchant_errors'] = array();
			} else {
				require_once(DIR_SYSTEM . 'library/payment_gateway.php');
				$payment_gateway = new PaymentGateway($this->registry);

				$this->load->model('account/payment');

				if ($type === 'paypal') {
					$payment_data = array(
						'type'        => 'paypal',
						'name'        => isset($this->request->post['name']) ? $this->request->post['name'] : $this->member->getEmail(),
						'token'       => $nonce ? $nonce : 'bt_tok_' . token(12),
						'image'       => 'application/view/image/account/paypal-logo.png',
						'date_expire' => 'Unlimited',
						'default'     => 0
					);
				} else {
					$active_gateway = isset($this->session->data['active_card_gateway'])
						? $this->session->data['active_card_gateway']
						: $payment_gateway->getActiveCardGateway();

					if (strpos($nonce, 'stripe_pm|') === 0 || strpos($nonce, 'pm_') === 0 || strpos($nonce, 'tok_') === 0) {
						$active_gateway = 'stripe';
					}

					if ($active_gateway === 'stripe') {
						$vault_res = $payment_gateway->vaultStripeCard(
							$nonce,
							$this->member->getEmail(),
							trim($this->member->getFirstName() . ' ' . $this->member->getLastName()),
							$this->member->getId()
						);
					} else {
						$vault_res = $payment_gateway->vaultBraintreeCard($nonce);
					}

					if (!empty($vault_res['error'])) {
						$json['error']['warning'] = $vault_res['error'];
						$json['error']['merchant_errors'] = array();
						$this->response->addHeader('Content-Type: application/json');
						$this->response->setOutput(json_encode($json));
						return;
					}

					$payment_data = array(
						'type'        => isset($vault_res['type']) ? $vault_res['type'] : 'card',
						'name'        => isset($this->request->post['name']) ? $this->request->post['name'] : $vault_res['name'],
						'token'       => $vault_res['token'],
						'image'       => $vault_res['image'],
						'date_expire' => $vault_res['date_expire'],
						'default'     => 0
					);
				}

				$ref = new ReflectionMethod('ModelAccountPayment', 'addPayment');
				if ($ref->getNumberOfParameters() >= 2) {
					$this->model_account_payment->addPayment($this->member->getId(), $payment_data);
				} else {
					$this->model_account_payment->addPayment($payment_data);
				}

				$this->load->controller('mail/payment', array(
					'email'     => $this->member->getEmail(),
					'text'      => 'A new payment method (' . $payment_data['name'] . ') has been added to your OpenCart account.',
					'mail_link' => $this->url->link('account/payment', 'member_token=' . $this->session->data['member_token'], true)
				));

				$this->session->data['success'] = 'Success: You have added a new payment method!';

				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/payment', 'member_token=' . $this->session->data['member_token'], true));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function makedefault() {
		$json = array();

		if (!$this->member->isLogged()) {
			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/login', '', true));
		} else {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$member_payment_id = isset($this->request->get['member_payment_id']) ? (int)$this->request->get['member_payment_id'] : 0;

			$this->load->model('account/payment');

			$payment_info = $this->model_account_payment->getPayment($member_payment_id);

			if (!$payment_info || (isset($payment_info['member_id']) && (int)$payment_info['member_id'] !== (int)$this->member->getId())) {
				$json['error'] = 'Warning: Payment method could not be found!';
			} else {
				$ref = new ReflectionMethod('ModelAccountPayment', 'setDefaultPayment');
				if ($ref->getNumberOfParameters() >= 2) {
					$this->model_account_payment->setDefaultPayment($this->member->getId(), $member_payment_id);
				} else {
					$this->model_account_payment->setDefaultPayment($member_payment_id);
				}

				$this->session->data['success'] = 'Success: Default payment method has been updated!';

				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/payment', 'member_token=' . $this->session->data['member_token'], true));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$json = array();

		if (!$this->member->isLogged()) {
			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/login', '', true));
		} else {
			if (empty($this->session->data['member_token'])) {
				$this->session->data['member_token'] = token(32);
			}

			$member_payment_id = isset($this->request->get['member_payment_id']) ? (int)$this->request->get['member_payment_id'] : 0;

			$this->load->model('account/payment');

			$payment_info = $this->model_account_payment->getPayment($member_payment_id);

			if (!$payment_info || (isset($payment_info['member_id']) && (int)$payment_info['member_id'] !== (int)$this->member->getId())) {
				$json['error'] = 'Warning: Payment method could not be found!';
			} else {
				$ref = new ReflectionMethod('ModelAccountPayment', 'deletePayment');
				if ($ref->getNumberOfParameters() >= 2) {
					$this->model_account_payment->deletePayment($this->member->getId(), $member_payment_id);
				} else {
					$this->model_account_payment->deletePayment($member_payment_id);
				}

				$this->session->data['success'] = 'Success: Payment method has been deleted!';

				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/payment', 'member_token=' . $this->session->data['member_token'], true));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

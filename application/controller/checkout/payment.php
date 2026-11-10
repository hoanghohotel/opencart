<?php
class ControllerCheckoutPayment extends Controller {
	private function lang($key, $fallback) {
		if ($this->registry->has('language')) {
			$val = $this->language->get($key);
			if ($val !== $key) {
				return $val;
			}
		}
		return $fallback;
	}

	public function index() {
		$this->card();
	}

	public function card() {
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/card');
		}

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;
		$order_id = isset($this->request->get['order_id']) ? (int)$this->request->get['order_id'] : 0;

		if (!$this->member->isLogged() || !isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token'])) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true));
			$this->response->addHeader('Location: ' . str_replace('&amp;', '&', $this->url->link('account/login', '', true)));
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 401 Unauthorized');
			return;
		}

		$payment_gateway = $this->paymentGateway();

		$gateway_override = isset($this->request->get['gateway']) ? $this->request->get['gateway'] : '';
		$active_gateway = $payment_gateway->getActiveCardGateway($gateway_override);
		$this->session->data['checkout_card_gateway'] = $active_gateway;

		$data['extension_id'] = $extension_id;
		$data['quantity'] = $quantity;
		$data['order_id'] = $order_id;
		$data['member_token'] = isset($this->session->data['member_token']) ? $this->session->data['member_token'] : '';
		$data['terms'] = $this->url->link('checkout/checkout/terms');
		$data['client_token'] = $payment_gateway->getClientToken($active_gateway);

		$this->response->setOutput($this->load->view('checkout/card', $data));
	}

	public function paypal() {
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/paypal');
		}

		$extension_id = (int)($this->request->get['extension_id'] ?? 0);
		if (!$this->member->isLogged() || !isset($this->request->get['member_token'], $this->session->data['member_token'])
			|| $this->request->get['member_token'] !== $this->session->data['member_token']) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true));
			$this->response->addHeader('Location: ' . str_replace('&amp;', '&', $this->url->link('account/login', '', true)));
			$this->response->addHeader(($this->request->server['SERVER_PROTOCOL'] ?? 'HTTP/1.1') . ' 401 Unauthorized');
			return;
		}

		// Preserve the endpoint, but do not invite a browser-side payment that
		// this legacy integration cannot verify/capture on the server.
		$this->response->setOutput($this->load->view('checkout/paypal', array(
			'error_warning' => $this->lang('error_paypal_unavailable', 'PayPal checkout is unavailable until server-side capture verification is configured. Please select a card payment method.')
		)));
	}

	public function prepare() {
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/confirm');
		}

		$this->load->model('marketplace/extension');
		$this->load->model('account/payment');

		$payment_gateway = $this->paymentGateway();

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;
		$member_payment_id = isset($this->request->get['member_payment_id']) ? (int)$this->request->get['member_payment_id'] : 0;
		$order_id = isset($this->request->get['order_id']) ? (int)$this->request->get['order_id'] : 0;

		if (!$this->member->isLogged() || !isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token'])) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true));
			$this->response->addHeader('Location: ' . str_replace('&amp;', '&', $this->url->link('account/login', '', true)));
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 401 Unauthorized');
			return;
		}

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		$payment_name = '';
		$payment_image = 'application/view/image/payment/visa.png';
		$nonce = isset($this->request->post['nonce']) ? trim($this->request->post['nonce']) : '';
		$active_gateway = isset($this->session->data['checkout_card_gateway'])
			? $this->session->data['checkout_card_gateway']
			: $payment_gateway->getActiveCardGateway();

		if (strpos($nonce, 'stripe_pm|') === 0 || strpos($nonce, 'pm_') === 0 || strpos($nonce, 'tok_') === 0) {
			$active_gateway = 'stripe';
		}

		$payment_token = $nonce;

		if ($member_payment_id) {
			$payment_info = $this->model_account_payment->getPayment($member_payment_id);
			if ($payment_info) {
				$payment_name = $payment_info['name'];
				$payment_image = ($payment_info['image'] && $payment_info['image'] !== 'application/view/image/cloud/cloud_credit_card.svg') ? $payment_info['image'] : 'application/view/image/payment/visa.png';
				$payment_token = $payment_info['token'];
				if ($payment_info['type'] === 'stripe' || strpos($payment_token, 'stripe|') === 0) {
					$active_gateway = 'stripe';
				}
			}
		} elseif ($nonce) {
			if ($active_gateway === 'stripe') {
				$vault_res = $payment_gateway->vaultStripeCard(
					$nonce,
					$this->member->getEmail(),
					trim($this->member->getFirstName() . ' ' . $this->member->getLastName()),
					$this->member->getId()
				);
				if (empty($vault_res['error'])) {
					$payment_name = $vault_res['name'];
					$payment_image = $vault_res['image'];
					$payment_token = $vault_res['token'];
					if (!empty($this->request->post['vault']) && $this->member->isLogged()) {
						$member_payment_id = $this->model_account_payment->addPayment(array(
							'type'        => 'stripe',
							'name'        => $vault_res['name'],
							'token'       => $vault_res['token'],
							'image'       => $vault_res['image'],
							'date_expire' => $vault_res['date_expire'],
							'default'     => 0
						));
					}
				}
			} else {
				$vault_res = $payment_gateway->vaultBraintreeCard($nonce);
				if (empty($vault_res['error'])) {
					$payment_name = $vault_res['name'];
					$payment_image = $vault_res['image'];
					$payment_token = $vault_res['token'];
					if (!empty($this->request->post['vault']) && $this->member->isLogged()) {
						$member_payment_id = $this->model_account_payment->addPayment(array(
							'type'        => 'card',
							'name'        => $vault_res['name'],
							'token'       => $vault_res['token'],
							'image'       => $vault_res['image'],
							'date_expire' => $vault_res['date_expire'],
							'default'     => 0
						));
					}
				}
			}
		}

		if ($payment_name === '') {
			return $this->card();
		}

		if ($extension_info) {
			$this->session->data['pending_extension_order'] = array(
				'member_id'       => $this->member->getId(),
				'seller_id'       => $extension_info['member_id'],
				'extension_id'    => $extension_id,
				'extension'       => $extension_info['name'],
				'quantity'        => $quantity,
				'price'           => $extension_info['price'],
				'total'           => (float)$extension_info['price'] * $quantity,
				'currency'        => strtoupper((string)$this->config->get('config_currency')),
				'payment_method'  => ($active_gateway === 'stripe' ? 'Stripe (' . $payment_name . ')' : 'Credit Card (' . $payment_name . ')'),
				'payment_gateway' => $active_gateway,
				'payment_token'   => $payment_token,
				'transaction_id'  => ($active_gateway === 'stripe' ? 'pi_' : 'CC-') . strtoupper(token(10)),
				'order_status_id' => 5
			);
		}

		$data['extension_id'] = $extension_id;
		$data['extension'] = $extension_info ? $extension_info['name'] : '';
		$data['quantity'] = $quantity;
		$data['total'] = $extension_info ? $this->currency->format((float)$extension_info['price'] * $quantity, $this->config->get('config_currency')) : '$0.00';
		$data['payment_name'] = $payment_name;
		$data['payment_image'] = $payment_image;
		$data['payment_nonce'] = $payment_token ? $payment_token : token(24);
		$data['payment_bin'] = '411111';
		$data['member_email'] = $this->member->getEmail();
		$data['member_firstname'] = $this->member->getFirstName();
		$data['member_lastname'] = $this->member->getLastName();
		$data['member_payment_id'] = $member_payment_id;
		$data['order_id'] = $order_id;
		$data['member_token'] = isset($this->session->data['member_token']) ? $this->session->data['member_token'] : '';
		$data['three_d_secure'] = false;
		$data['client_token'] = $payment_gateway->getClientToken($active_gateway);

		$this->response->setOutput($this->load->view('checkout/confirm', $data));
	}

	protected function paymentGateway() {
		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		return new PaymentGateway($this->registry);
	}

	public function confirm() {
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/payment');
		}

		$json = array();
		$pending = $this->session->data['pending_extension_order'] ?? array();
		$currency = strtoupper((string)$this->config->get('config_currency'));
		$quantity = $pending['quantity'] ?? 0;
		$price = $pending['price'] ?? null;
		$total = $pending['total'] ?? null;

		if (($this->request->server['REQUEST_METHOD'] ?? '') !== 'POST' || !$this->member->isLogged()
			|| empty($this->request->get['member_token']) || empty($this->session->data['member_token'])
			|| !is_string($this->request->get['member_token']) || !is_string($this->session->data['member_token'])
			|| !hash_equals((string)$this->session->data['member_token'], (string)$this->request->get['member_token'])) {
			$json['error'] = $this->lang('error_login', 'Please sign in and submit the payment confirmation again.');
		} elseif (!$pending || (int)($pending['member_id'] ?? 0) !== (int)$this->member->getId()
			|| (int)($pending['extension_id'] ?? 0) !== (int)($this->request->get['extension_id'] ?? 0)
			|| empty($pending['extension_id']) || empty($pending['currency']) || $pending['currency'] !== $currency
			|| !is_numeric($quantity) || (int)$quantity != $quantity || (int)$quantity < 1
			|| !is_numeric($price) || !is_numeric($total) || !is_finite((float)$total) || (float)$total <= 0
			|| (float)$price <= 0 || abs(round((float)$price * (int)$quantity, 2) - (float)$total) > 0.00001
			|| empty($pending['payment_token']) || !in_array($pending['payment_gateway'] ?? '', array('stripe', 'braintree'), true)) {
			$json['error'] = $this->lang('error_prepared_required', 'A supported, prepared checkout is required. Restart checkout; no order has been created.');
		} else {
			try {
				$gateway = $this->paymentGateway();
				if ($pending['payment_gateway'] === 'stripe') {
					$store_name = $this->config->get('config_name') ?: 'Store';
					$stripe_desc_tpl = $this->lang('text_stripe_description', '{store_name} Extension: %s');
					$stripe_desc = sprintf(str_replace('{store_name}', $store_name, $stripe_desc_tpl), $pending['extension']);

					$charge = $gateway->chargeStripe(
						$pending['payment_token'],
						$total,
						$currency,
						$stripe_desc,
						$this->member->getEmail(),
						trim($this->member->getFirstName() . ' ' . $this->member->getLastName()),
						$this->member->getId()
					);
				} else {
					$charge = $gateway->chargeBraintree($pending['payment_token'], $total, $currency);
				}

				if (empty($charge['success']) || ($charge['verified'] ?? false) !== true || empty($charge['transaction_id']) || !empty($charge['error'])) {
					$json['error'] = $charge['error'] ?? $this->lang('error_payment_unverified', 'Payment has not been verified. Check payment status before retrying.');
				} else {
					$pending['transaction_id'] = $charge['transaction_id'];
					$pending['order_status_id'] = 5;
					$this->load->model('account/order');
					$order_id = $this->model_account_order->addOrder($pending);
					if ((int)$order_id <= 0) {
						throw new \RuntimeException('Order persistence did not return an ID.');
					}
					unset($this->session->data['pending_extension_order']);
					$json['order_id'] = $order_id;
					$json['success'] = $this->lang('text_success', 'Your order has been completed!');
				}
			} catch (\Throwable $e) {
				// Do not disclose provider tokens/credentials or exception payloads.
				if ($this->registry->has('log')) {
					$this->log->write('Checkout confirmation exception; payment/order outcome requires reconciliation.');
				}
				$json['error'] = $this->lang('error_reconciliation', 'Payment or order confirmation could not be completed. Contact support before retrying.');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

<?php
class ControllerCheckoutPayment extends Controller {
	public function index() {
		$this->card();
	}

	public function card() {
		$this->load->language('checkout/card');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;
		$order_id = isset($this->request->get['order_id']) ? (int)$this->request->get['order_id'] : 0;

		if (!$this->member->isLogged() || !isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token'])) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true));
			$this->response->addHeader('Location: ' . str_replace('&amp;', '&', $this->url->link('account/login', '', true)));
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 401 Unauthorized');
			return;
		}

		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		$payment_gateway = new PaymentGateway($this->registry);

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
		$this->load->language('checkout/paypal');

		$this->load->model('marketplace/extension');

		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		$payment_gateway = new PaymentGateway($this->registry);
		$pp_cfg = $payment_gateway->getPayPalConfig();

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;
		$order_id = isset($this->request->get['order_id']) ? (int)$this->request->get['order_id'] : 0;

		if (!$this->member->isLogged() || !isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token'])) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true));
			$this->response->addHeader('Location: ' . str_replace('&amp;', '&', $this->url->link('account/login', '', true)));
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 401 Unauthorized');
			return;
		}

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		$member_token = isset($this->session->data['member_token']) ? $this->session->data['member_token'] : '';

		if ($extension_info) {
			$this->session->data['pending_extension_order'] = array(
				'member_id'       => $this->member->getId(),
				'seller_id'       => $extension_info['member_id'],
				'extension_id'    => $extension_id,
				'extension'       => $extension_info['name'],
				'quantity'        => $quantity,
				'price'           => $extension_info['price'],
				'total'           => (float)$extension_info['price'] * $quantity,
				'payment_method'  => 'PayPal (' . strtoupper($pp_cfg['environment']) . ')',
				'transaction_id'  => 'PP-' . strtoupper(token(10)),
				'order_status_id' => 5
			);
		}

		$data['extension_id'] = $extension_id;
		$data['extension'] = $extension_info ? $extension_info['name'] : '';
		$data['extension_url'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id);
		$data['quantity'] = $quantity;
		$data['price'] = $extension_info ? number_format((float)$extension_info['price'], 2, '.', '') : '0.00';
		$data['total'] = $extension_info ? $this->currency->format((float)$extension_info['price'] * $quantity, $this->config->get('config_currency')) : '$0.00';
		$data['order_id'] = $order_id;
		$data['member_token'] = $member_token;
		$data['stored_paypal'] = true;
		$data['new_paypal'] = false;
		$data['store_url'] = $this->url->link('checkout/payment/paypal', 'member_token=' . $member_token . '&extension_id=' . $extension_id . '&quantity=' . $quantity, true);
		$data['client_token'] = 'paypal|' . $pp_cfg['environment'] . '|' . $pp_cfg['client_id'];

		$this->response->setOutput($this->load->view('checkout/paypal', $data));
	}

	public function prepare() {
		$this->load->language('checkout/confirm');

		$this->load->model('marketplace/extension');
		$this->load->model('account/payment');

		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		$payment_gateway = new PaymentGateway($this->registry);

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

	public function confirm() {
		$this->load->language('checkout/payment');

		$json = array();

		$this->load->model('marketplace/extension');
		$this->load->model('account/order');

		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		$payment_gateway = new PaymentGateway($this->registry);

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;

		if (!$this->member->isLogged()) {
			$json['error'] = $this->language->get('error_login');
		}

		if (!$json) {
			if (!empty($this->session->data['pending_extension_order'])) {
				$order_data = $this->session->data['pending_extension_order'];
				$payment_token = !empty($order_data['payment_token'])
					? $order_data['payment_token']
					: (isset($this->request->post['nonce']) ? $this->request->post['nonce'] : '');
				$gateway_used = !empty($order_data['payment_gateway']) ? $order_data['payment_gateway'] : '';

				if ($gateway_used === 'stripe' || strpos($payment_token, 'stripe') === 0) {
					$store_name = $this->config->get('config_name') ?: 'Store';
					$stripe_desc = sprintf(str_replace('{store_name}', $store_name, $this->language->get('text_stripe_description')), $order_data['extension']);

					$charge = $payment_gateway->chargeStripe(
						$payment_token,
						$order_data['total'],
						$this->config->get('config_currency'),
						$stripe_desc,
						$this->member->getEmail(),
						trim($this->member->getFirstName() . ' ' . $this->member->getLastName()),
						$this->member->getId()
					);
					if (!empty($charge['error'])) {
						$json['error'] = $charge['error'];
					} elseif (!empty($charge['transaction_id'])) {
						$order_data['transaction_id'] = $charge['transaction_id'];
					}
				} elseif ($gateway_used === 'braintree') {
					$charge = $payment_gateway->chargeBraintree($payment_token, $order_data['total']);
					if (!empty($charge['error'])) {
						$json['error'] = $charge['error'];
					} elseif (!empty($charge['transaction_id'])) {
						$order_data['transaction_id'] = $charge['transaction_id'];
					}
				}

				if (empty($json['error'])) {
					unset($this->session->data['pending_extension_order']);
					$order_id = $this->model_account_order->addOrder($order_data);
					$json['order_id'] = $order_id;
					$json['success'] = $this->language->get('text_success');
				}
			} else {
				$extension_info = $this->model_marketplace_extension->getExtension($extension_id);
				if ($extension_info) {
					$order_id = $this->model_account_order->addOrder(array(
						'member_id'       => $this->member->getId(),
						'seller_id'       => $extension_info['member_id'],
						'extension_id'    => $extension_id,
						'extension'       => $extension_info['name'],
						'quantity'        => $quantity,
						'price'           => $extension_info['price'],
						'total'           => (float)$extension_info['price'] * $quantity,
						'payment_method'  => isset($this->request->get['type']) && $this->request->get['type'] == 'paypal' ? 'PayPal' : 'Credit Card',
						'transaction_id'  => strtoupper(token(12)),
						'order_status_id' => 5
					));
					$json['order_id'] = $order_id;
					$json['success'] = $this->language->get('text_success');
				} else {
					$json['error'] = $this->language->get('error_extension');
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

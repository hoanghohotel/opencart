<?php
class ControllerCheckoutCheckout extends Controller {
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
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/checkout');
		}

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;

		if (!$this->member->isLogged() || !isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token'])) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true));
			$this->response->addHeader('Location: ' . str_replace('&amp;', '&', $this->url->link('account/login', '', true)));
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 401 Unauthorized');
			return;
		}

		$this->load->model('marketplace/extension');
		$this->load->model('account/payment');

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		if ($extension_info) {
			$member_token = $this->session->data['member_token'];

			$data['extension_id'] = $extension_id;
			$data['extension'] = $extension_info['name'];
			$data['quantity'] = $quantity;
			$data['quantities'] = range(1, 10);
			$data['total'] = $this->currency->format((float)$extension_info['price'] * $quantity, $this->config->get('config_currency'));
			$data['member_token'] = $member_token;

			$data['vaulted'] = array();

			$payments = $this->model_account_payment->getPayments($this->member->getId());

			foreach ($payments as $payment) {
				$data['vaulted'][] = array(
					'value' => $this->url->link('checkout/payment/prepare', 'member_token=' . $member_token . '&extension_id=' . $extension_id . '&quantity=' . $quantity . '&member_payment_id=' . $payment['member_payment_id'], true),
					'text'  => strtoupper($payment['type']) . ' - ' . $payment['name']
				);
			}

			require_once(DIR_SYSTEM . 'library/payment_gateway.php');
			$payment_gateway = new PaymentGateway($this->registry);

			$data['payment_methods'] = array();

			if ($payment_gateway->isStripeEnabled()) {
				$stripe_cfg = $payment_gateway->getStripeConfig();
				$mode_label = $stripe_cfg['environment'] === 'live' ? $this->language->get('text_live') : $this->language->get('text_test_mode');
				$data['payment_methods'][] = array(
					'value' => $this->url->link('checkout/payment/card', 'member_token=' . $member_token . '&extension_id=' . $extension_id . '&quantity=' . $quantity . '&gateway=stripe', true),
					'text'  => sprintf($this->language->get('text_stripe_card'), $mode_label)
				);
			}

			if ($payment_gateway->isBraintreeEnabled()) {
				$bt_cfg = $payment_gateway->getBraintreeConfig();
				$mode_label = $bt_cfg['environment'] === 'production' ? $this->language->get('text_live') : $this->language->get('text_sandbox');
				$data['payment_methods'][] = array(
					'value' => $this->url->link('checkout/payment/card', 'member_token=' . $member_token . '&extension_id=' . $extension_id . '&quantity=' . $quantity . '&gateway=braintree', true),
					'text'  => sprintf($this->language->get('text_braintree_card'), $mode_label)
				);
			}

			if ($payment_gateway->isPayPalEnabled()) {
				$pp_cfg = $payment_gateway->getPayPalConfig();
				$mode_label = $pp_cfg['environment'] === 'live' ? $this->language->get('text_live') : $this->language->get('text_sandbox');
				$data['payment_methods'][] = array(
					'value' => $this->url->link('checkout/payment/paypal', 'member_token=' . $member_token . '&extension_id=' . $extension_id . '&quantity=' . $quantity, true),
					'text'  => sprintf($this->language->get('text_paypal_method'), $mode_label)
				);
			}

			if (empty($data['payment_methods'])) {
				$data['payment_methods'][] = array(
					'value' => $this->url->link('checkout/payment/card', 'member_token=' . $member_token . '&extension_id=' . $extension_id . '&quantity=' . $quantity, true),
					'text'  => $this->language->get('text_credit_debit_card')
				);
			}

			$this->response->setOutput($this->load->view('checkout/checkout', $data));
		}
	}

	public function success() {
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/success');
		}

		$this->document->setTitle($this->lang('heading_title', 'Extension Purchase Success'));

		// A result page is not payment confirmation. Order creation belongs to
		// the payment flow; visiting or refreshing this page must not consume
		// a pending checkout or grant a purchase without gateway verification.

		$member_token = isset($this->session->data['member_token']) ? 'member_token=' . $this->session->data['member_token'] : '';

		$data['account'] = $this->url->link('account/account', $member_token, true);
		$data['history'] = $this->url->link('account/order', $member_token, true);
		$data['contact'] = $this->url->link('support/contact');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/success', $data));
	}

	public function failure() {
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/failure');
		}

		$this->document->setTitle($this->lang('heading_title', 'Extension Purchase Failure'));

		$data['contact'] = $this->url->link('support/contact');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/failure', $data));
	}

	public function terms() {
		if (method_exists($this->load, 'language')) {
			$this->load->language('checkout/terms');
		}

		$this->document->setTitle($this->lang('heading_title', 'Extension Purchase Terms'));

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/terms', $data));
	}
}

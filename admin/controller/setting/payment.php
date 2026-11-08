<?php
class ControllerSettingPayment extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('setting/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('setting/payment', 'user_token=' . $this->session->data['user_token'], true));
		}

		if (isset($this->error['warning'])) {
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/payment', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('setting/payment', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true);
		$data['user_token'] = $this->session->data['user_token'];

		$defaults = array(
			'payment_card_gateway'                        => 'stripe',
			// Stripe
			'payment_stripe_status'                       => '1',
			'payment_stripe_environment'                  => 'test',
			'payment_stripe_test_publishable_key'         => '',
			'payment_stripe_test_secret_key'              => '',
			'payment_stripe_test_webhook_secret'          => '',
			'payment_stripe_live_publishable_key'         => '',
			'payment_stripe_live_secret_key'              => '',
			'payment_stripe_live_webhook_secret'          => '',
			'payment_stripe_currency'                     => 'USD',
			'payment_stripe_capture_method'               => 'automatic',
			'payment_stripe_three_d_secure'               => '0',
			// Braintree
			'payment_braintree_status'                    => '1',
			'payment_braintree_environment'               => 'sandbox',
			'payment_braintree_sandbox_merchant_id'       => '',
			'payment_braintree_sandbox_public_key'        => '',
			'payment_braintree_sandbox_private_key'       => '',
			'payment_braintree_sandbox_merchant_account_id' => '',
			'payment_braintree_production_merchant_id'    => '',
			'payment_braintree_production_public_key'     => '',
			'payment_braintree_production_private_key'    => '',
			'payment_braintree_production_merchant_account_id' => '',
			'payment_braintree_three_d_secure'            => '0',
			'payment_braintree_paypal_status'             => '1',
			// PayPal REST API
			'payment_paypal_status'                       => '1',
			'payment_paypal_environment'                  => 'sandbox',
			'payment_paypal_sandbox_client_id'            => '',
			'payment_paypal_sandbox_secret'               => '',
			'payment_paypal_live_client_id'               => '',
			'payment_paypal_live_secret'                  => '',
			'payment_paypal_currency'                     => 'USD'
		);

		foreach ($defaults as $field => $default_value) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif ($this->config->get($field) !== null) {
				$data[$field] = $this->config->get($field);
			} else {
				$data[$field] = $default_value;
			}
		}

		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/payment', $data));
	}

	public function testStripe() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'setting/payment')) {
			$json['error'] = 'Permission denied!';
		} else {
			require_once(DIR_SYSTEM . 'library/payment_gateway.php');
			$gateway = new PaymentGateway($this->registry);

			$environment = isset($this->request->post['environment']) ? $this->request->post['environment'] : 'test';
			$secret_key = isset($this->request->post['secret_key']) ? $this->request->post['secret_key'] : '';

			$result = $gateway->testStripeConnection($secret_key, $environment);
			if (!empty($result['error'])) {
				$json['error'] = $result['error'];
			} else {
				$json['success'] = $result['message'];
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function testBraintree() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'setting/payment')) {
			$json['error'] = 'Permission denied!';
		} else {
			require_once(DIR_SYSTEM . 'library/payment_gateway.php');
			$gateway = new PaymentGateway($this->registry);

			$environment = isset($this->request->post['environment']) ? $this->request->post['environment'] : 'sandbox';
			$merchant_id = isset($this->request->post['merchant_id']) ? $this->request->post['merchant_id'] : '';
			$public_key = isset($this->request->post['public_key']) ? $this->request->post['public_key'] : '';
			$private_key = isset($this->request->post['private_key']) ? $this->request->post['private_key'] : '';

			$result = $gateway->testBraintreeConnection($environment, $merchant_id, $public_key, $private_key);
			if (!empty($result['error'])) {
				$json['error'] = $result['error'];
			} else {
				$json['success'] = $result['message'];
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function testPaypal() {
		$json = array();

		if (!$this->user->hasPermission('modify', 'setting/payment')) {
			$json['error'] = 'Permission denied!';
		} else {
			require_once(DIR_SYSTEM . 'library/payment_gateway.php');
			$gateway = new PaymentGateway($this->registry);

			$environment = isset($this->request->post['environment']) ? $this->request->post['environment'] : 'sandbox';
			$client_id = isset($this->request->post['client_id']) ? $this->request->post['client_id'] : '';
			$secret = isset($this->request->post['secret']) ? $this->request->post['secret'] : '';

			$result = $gateway->getPayPalAccessToken($environment, $client_id, $secret);
			if (!empty($result['error'])) {
				$json['error'] = $result['error'];
			} else {
				$json['success'] = $result['message'];
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'setting/payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

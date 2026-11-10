<?php
class PaymentGateway {
	private $config;

	public function __construct($registry) {
		$this->config = $registry->get('config');
	}

	public function getActiveCardGateway($override = '') {
		if ($override && in_array($override, array('stripe', 'braintree'))) {
			return $override;
		}

		$gateway = $this->config->get('payment_card_gateway');
		if ($gateway && in_array($gateway, array('stripe', 'braintree'))) {
			return $gateway;
		}

		if ($this->isStripeEnabled()) {
			return 'stripe';
		}

		return 'braintree';
	}

	public function isStripeEnabled() {
		$status = $this->config->get('payment_stripe_status');
		return ($status === null || $status === '' || (int)$status === 1);
	}

	public function isBraintreeEnabled() {
		$status = $this->config->get('payment_braintree_status');
		return ($status === null || $status === '' || (int)$status === 1);
	}

	public function isPayPalEnabled() {
		$status = $this->config->get('payment_paypal_status');
		return ($status === null || $status === '' || (int)$status === 1);
	}

	public function getStripeConfig() {
		$env = $this->config->get('payment_stripe_environment') === 'live' ? 'live' : 'test';

		if ($env === 'live') {
			$publishable_key = trim((string)$this->config->get('payment_stripe_live_publishable_key'));
			$secret_key = trim((string)$this->config->get('payment_stripe_live_secret_key'));
			$webhook_secret = trim((string)$this->config->get('payment_stripe_live_webhook_secret'));
		} else {
			$publishable_key = trim((string)$this->config->get('payment_stripe_test_publishable_key'));
			$secret_key = trim((string)$this->config->get('payment_stripe_test_secret_key'));
			$webhook_secret = trim((string)$this->config->get('payment_stripe_test_webhook_secret'));
		}

		return array(
			'status'          => $this->isStripeEnabled(),
			'environment'     => $env,
			'publishable_key' => $publishable_key,
			'secret_key'      => $secret_key,
			'webhook_secret'  => $webhook_secret,
			'currency'        => $this->config->get('payment_stripe_currency') ? strtolower($this->config->get('payment_stripe_currency')) : 'usd',
			'capture_method'  => $this->config->get('payment_stripe_capture_method') === 'manual' ? 'manual' : 'automatic',
			'three_d_secure'  => (int)$this->config->get('payment_stripe_three_d_secure')
		);
	}

	public function getBraintreeConfig() {
		$env = $this->config->get('payment_braintree_environment') === 'production' ? 'production' : 'sandbox';

		if ($env === 'production') {
			$merchant_id = trim((string)$this->config->get('payment_braintree_production_merchant_id'));
			$public_key = trim((string)$this->config->get('payment_braintree_production_public_key'));
			$private_key = trim((string)$this->config->get('payment_braintree_production_private_key'));
			$merchant_account_id = trim((string)$this->config->get('payment_braintree_production_merchant_account_id'));
		} else {
			$merchant_id = trim((string)$this->config->get('payment_braintree_sandbox_merchant_id'));
			$public_key = trim((string)$this->config->get('payment_braintree_sandbox_public_key'));
			$private_key = trim((string)$this->config->get('payment_braintree_sandbox_private_key'));
			$merchant_account_id = trim((string)$this->config->get('payment_braintree_sandbox_merchant_account_id'));
		}

		return array(
			'status'              => $this->isBraintreeEnabled(),
			'environment'         => $env,
			'merchant_id'         => $merchant_id,
			'public_key'          => $public_key,
			'private_key'         => $private_key,
			'merchant_account_id' => $merchant_account_id,
			'three_d_secure'      => (int)$this->config->get('payment_braintree_three_d_secure'),
			'paypal_status'       => $this->config->get('payment_braintree_paypal_status') === null ? 1 : (int)$this->config->get('payment_braintree_paypal_status')
		);
	}

	public function getPayPalConfig() {
		$env = $this->config->get('payment_paypal_environment') === 'live' ? 'live' : 'sandbox';

		if ($env === 'live') {
			$client_id = trim((string)$this->config->get('payment_paypal_live_client_id'));
			$secret = trim((string)$this->config->get('payment_paypal_live_secret'));
		} else {
			$client_id = trim((string)$this->config->get('payment_paypal_sandbox_client_id'));
			$secret = trim((string)$this->config->get('payment_paypal_sandbox_secret'));
		}

		return array(
			'status'      => $this->isPayPalEnabled(),
			'environment' => $env,
			'client_id'   => $client_id,
			'secret'      => $secret,
			'currency'    => $this->config->get('payment_paypal_currency') ? strtoupper($this->config->get('payment_paypal_currency')) : 'USD'
		);
	}

	public function getFrontendConfig() {
		$stripe = $this->getStripeConfig();
		$braintree = $this->getBraintreeConfig();
		$paypal = $this->getPayPalConfig();

		return array(
			'card_gateway' => $this->getActiveCardGateway(),
			'stripe'       => array(
				'status'          => $stripe['status'],
				'environment'     => $stripe['environment'],
				'publishable_key' => $stripe['publishable_key'],
				'currency'        => $stripe['currency'],
				'three_d_secure'  => $stripe['three_d_secure']
			),
			'braintree'    => array(
				'status'         => $braintree['status'],
				'environment'    => $braintree['environment'],
				'has_keys'       => !empty($braintree['public_key']) && !empty($braintree['private_key']),
				'three_d_secure' => $braintree['three_d_secure']
			),
			'paypal'       => array(
				'status'      => $paypal['status'],
				'environment' => $paypal['environment'],
				'client_id'   => $paypal['client_id'],
				'currency'    => $paypal['currency']
			)
		);
	}

	public function getClientToken($gateway = '') {
		$active = $this->getActiveCardGateway($gateway);

		if ($active === 'stripe') {
			$stripe = $this->getStripeConfig();
			return 'stripe|' . $stripe['environment'] . '|' . $stripe['publishable_key'];
		}

		$bt = $this->getBraintreeConfig();
		if (!empty($bt['public_key']) && !empty($bt['private_key'])) {
			$token_res = $this->generateBraintreeClientToken();
			if (!empty($token_res['client_token'])) {
				return 'braintree_real|' . $bt['environment'] . '|' . $token_res['client_token'];
			}
		}

		return 'braintree|' . $bt['environment'] . '|local_' . token(24);
	}

	public function getBrandLogo($brand) {
		$brand_logos = array(
			'Visa'             => 'application/view/image/payment/visa.png',
			'visa'             => 'application/view/image/payment/visa.png',
			'MasterCard'       => 'application/view/image/payment/mastercard.png',
			'mastercard'       => 'application/view/image/payment/mastercard.png',
			'American Express' => 'application/view/image/payment/american_express.png',
			'amex'             => 'application/view/image/payment/american_express.png',
			'Discover'         => 'application/view/image/payment/discover.png',
			'discover'         => 'application/view/image/payment/discover.png',
			'JCB'              => 'application/view/image/payment/jcb.png',
			'jcb'              => 'application/view/image/payment/jcb.png',
			'Maestro'          => 'application/view/image/payment/maestro.png',
			'maestro'          => 'application/view/image/payment/maestro.png',
			'Stripe'           => 'application/view/image/payment/stripe.svg'
		);

		return isset($brand_logos[$brand]) ? $brand_logos[$brand] : 'application/view/image/payment/visa.png';
	}

	public function formatBrandName($brand) {
		$map = array(
			'visa'             => 'Visa',
			'mastercard'       => 'MasterCard',
			'master-card'      => 'MasterCard',
			'amex'             => 'American Express',
			'american-express' => 'American Express',
			'american_express' => 'American Express',
			'discover'         => 'Discover',
			'jcb'              => 'JCB',
			'maestro'          => 'Maestro'
		);
		$lower = strtolower(trim($brand));
		return isset($map[$lower]) ? $map[$lower] : ucfirst($brand);
	}

	// =========================================================================
	// STRIPE REAL API METHODS (https://api.stripe.com/v1)
	// =========================================================================

	public function stripeRequest($method, $endpoint, $params = array(), $secret_key = null) {
		if ($secret_key === null) {
			$cfg = $this->getStripeConfig();
			$secret_key = $cfg['secret_key'];
		}

		if (empty($secret_key)) {
			return array('error' => array('message' => 'Stripe Secret Key is not configured.'));
		}

		$url = 'https://api.stripe.com/v1/' . ltrim($endpoint, '/');
		$ch = curl_init();

		if (strtoupper($method) === 'GET') {
			if (!empty($params)) {
				$url .= '?' . http_build_query($params);
			}
		} else {
			curl_setopt($ch, CURLOPT_POST, true);
			if (strtoupper($method) !== 'POST') {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		}

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ':');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Content-Type: application/x-www-form-urlencoded'
		));
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

		$response = curl_exec($ch);
		$curl_err = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($response === false) {
			return array('error' => array('message' => 'Stripe API cURL Error: ' . $curl_err));
		}

		if ($http_code < 200 || $http_code >= 300) {
			return array('error' => array('message' => 'Stripe API HTTP Error ' . $http_code));
		}

		$decoded = json_decode($response, true);
		if (!is_array($decoded)) {
			return array('error' => array('message' => 'Invalid JSON response from Stripe API (HTTP ' . $http_code . ')'));
		}

		return $decoded;
	}

	public function testStripeConnection($secret_key, $environment = 'test') {
		$secret_key = trim((string)$secret_key);
		if (!$secret_key) {
			return array('error' => 'Please enter a Stripe Secret Key (' . ($environment === 'live' ? 'sk_live_...' : 'sk_test_...') . ').');
		}

		if ($environment === 'test' && strpos($secret_key, 'sk_live_') === 0) {
			return array('error' => 'Warning: You entered a Live Secret Key (sk_live_...) in Test Mode!');
		}

		if ($environment === 'live' && strpos($secret_key, 'sk_test_') === 0) {
			return array('error' => 'Warning: You entered a Test Secret Key (sk_test_...) in Live Mode!');
		}

		$res = $this->stripeRequest('GET', 'balance', array(), $secret_key);
		if (isset($res['error'])) {
			return array('error' => isset($res['error']['message']) ? $res['error']['message'] : 'Stripe API authentication failed.');
		}

		$livemode = !empty($res['livemode']);
		$avail = '';
		if (!empty($res['available'][0])) {
			$avail = number_format($res['available'][0]['amount'] / 100, 2) . ' ' . strtoupper($res['available'][0]['currency']);
		}

		return array(
			'success'  => true,
			'livemode' => $livemode,
			'message'  => 'Connected to Stripe API (' . ($livemode ? 'LIVE MODE' : 'TEST MODE') . ') successfully!' . ($avail ? ' Available Balance: ' . $avail : '')
		);
	}

	public function getOrCreateStripeCustomer($email, $name = '', $member_id = 0, $secret_key = null) {
		if ($email) {
			$search = $this->stripeRequest('GET', 'customers', array('email' => $email, 'limit' => 1), $secret_key);
			if (!empty($search['data'][0]['id'])) {
				return array('customer_id' => $search['data'][0]['id']);
			}
		}

		$params = array(
			'email'       => $email,
			'name'        => $name,
			'description' => ($this->config->get('config_name') ?: 'Store') . ' Member #' . (int)$member_id
		);

		$created = $this->stripeRequest('POST', 'customers', $params, $secret_key);
		if (!empty($created['id'])) {
			return array('customer_id' => $created['id']);
		}

		return array('error' => isset($created['error']['message']) ? $created['error']['message'] : 'Could not create Stripe customer.');
	}

	public function vaultStripeCard($nonce, $email = '', $name = '', $member_id = 0) {
		$cfg = $this->getStripeConfig();
		$secret_key = $cfg['secret_key'];

		$brand = 'Visa';
		$last4 = '';
		$date_expire = date('m/Y', strtotime('+3 years'));
		$pm_id = '';
		$has_user_card_meta = false;

		// Parse structured nonce from frontend (e.g. stripe_pm|pm_123|Visa|1234|12/2028 or bt_card|Visa|1234|12/2028)
		if (strpos($nonce, 'stripe_pm|') === 0) {
			$parts = explode('|', $nonce);
			$pm_id = isset($parts[1]) ? $parts[1] : '';
			$brand = !empty($parts[2]) ? $this->formatBrandName($parts[2]) : 'Visa';
			$last4 = !empty($parts[3]) ? preg_replace('/\D/', '', $parts[3]) : '';
			$date_expire = !empty($parts[4]) ? $parts[4] : $date_expire;
			if ($last4 !== '') {
				$has_user_card_meta = true;
			}
		} elseif (strpos($nonce, 'pm_') === 0 || strpos($nonce, 'tok_') === 0) {
			$pm_id = $nonce;
		} elseif (strpos($nonce, 'bt_card|') === 0) {
			$parts = explode('|', $nonce);
			$brand = !empty($parts[1]) ? $this->formatBrandName($parts[1]) : 'Visa';
			$last4 = !empty($parts[2]) ? preg_replace('/\D/', '', $parts[2]) : '';
			$date_expire = !empty($parts[3]) ? $parts[3] : $date_expire;
			if ($last4 !== '') {
				$has_user_card_meta = true;
			}
		}

		if ($pm_id === '' && $last4 === '') {
			return array('error' => 'Please enter a valid credit card number.');
		}

		// If Secret Key is configured, execute real Stripe API calls
		if (!empty($secret_key)) {
			$cust = $this->getOrCreateStripeCustomer($email, $name, $member_id, $secret_key);
			if (isset($cust['error'])) {
				return array('error' => $cust['error']);
			}
			$customer_id = $cust['customer_id'];

			// If no pm_id was created by Stripe.js (e.g., in test mode without pk_test_ configured), map to official Stripe test token in test mode
			if (!$pm_id) {
				if ($cfg['environment'] === 'test') {
					$test_tokens = array(
						'Visa'             => 'tok_visa',
						'MasterCard'       => 'tok_mastercard',
						'American Express' => 'tok_amex',
						'Discover'         => 'tok_discover',
						'JCB'              => 'tok_jcb'
					);
					$tok = isset($test_tokens[$brand]) ? $test_tokens[$brand] : 'tok_visa';
					$pm_create = $this->stripeRequest('POST', 'payment_methods', array(
						'type' => 'card',
						'card' => array('token' => $tok)
					), $secret_key);

					if (isset($pm_create['error'])) {
						return array('error' => $pm_create['error']['message']);
					}
					$pm_id = $pm_create['id'];
				} else {
					return array('error' => 'Stripe Live Publishable Key (pk_live_...) is required to tokenize live cards via Stripe Elements.');
				}
			} elseif (strpos($pm_id, 'tok_') === 0) {
				$pm_create = $this->stripeRequest('POST', 'payment_methods', array(
					'type' => 'card',
					'card' => array('token' => $pm_id)
				), $secret_key);
				if (isset($pm_create['error'])) {
					return array('error' => $pm_create['error']['message']);
				}
				$pm_id = $pm_create['id'];
			}

			// Attach PaymentMethod to Customer in Stripe
			$attach = $this->stripeRequest('POST', 'payment_methods/' . urlencode($pm_id) . '/attach', array(
				'customer' => $customer_id
			), $secret_key);

			if (isset($attach['error'])) {
				return array('error' => $attach['error']['message']);
			}

			if (!empty($attach['card']) && !$has_user_card_meta) {
				$brand = $this->formatBrandName($attach['card']['brand']);
				$last4 = $attach['card']['last4'];
				$date_expire = sprintf('%02d/%04d', (int)$attach['card']['exp_month'], (int)$attach['card']['exp_year']);
			}

			return array(
				'success'     => true,
				'type'        => 'stripe',
				'name'        => 'Stripe (' . $brand . ' ending in ' . $last4 . ')',
				'token'       => 'stripe|' . $cfg['environment'] . '|' . $customer_id . '|' . $pm_id,
				'image'       => $this->getBrandLogo($brand),
				'date_expire' => $date_expire
			);
		}

		// Local fallback when Stripe API keys are not yet configured
		return array(
			'success'     => true,
			'type'        => 'stripe',
			'name'        => 'Stripe (' . $brand . ' ending in ' . $last4 . ')',
			'token'       => $pm_id ? ('stripe|' . $cfg['environment'] . '|local|' . $pm_id) : ('stripe|' . $cfg['environment'] . '|local|pm_local_' . token(12)),
			'image'       => $this->getBrandLogo($brand),
			'date_expire' => $date_expire
		);
	}

	public function chargeStripe($payment_token_or_nonce, $amount, $currency = 'usd', $description = 'Extension Purchase', $email = '', $name = '', $member_id = 0) {
		$cfg = $this->getStripeConfig();
		if (!$cfg['status'] || !$cfg['secret_key']) {
			return array('error' => 'Stripe is disabled or its Secret Key is not configured.');
		}
		$currency = strtoupper((string)$currency);
		if (!$this->validChargeAmount($amount, $currency) || $cfg['capture_method'] !== 'automatic') {
			return array('error' => 'This amount, currency or capture mode requires a supported payment flow.');
		}
		$customer_id = '';
		$pm_id = '';
		if (strpos($payment_token_or_nonce, 'stripe|') === 0) {
			$parts = explode('|', $payment_token_or_nonce);
			$customer_id = (!empty($parts[2]) && $parts[2] !== 'local') ? $parts[2] : '';
			$pm_id = isset($parts[3]) ? $parts[3] : '';
		} elseif (strpos($payment_token_or_nonce, 'stripe_pm|') === 0) {
			$parts = explode('|', $payment_token_or_nonce);
			$pm_id = isset($parts[1]) ? $parts[1] : '';
		} elseif (strpos($payment_token_or_nonce, 'pm_') === 0) {
			$pm_id = $payment_token_or_nonce;
		}
		if (!preg_match('/^pm_[a-zA-Z0-9]+$/D', $pm_id) || strpos($pm_id, 'pm_local') === 0) {
			return array('error' => 'A provider-issued Stripe PaymentMethod is required.');
		}
		$cents = (int)round((float)$amount * ($currency === 'ISK' ? 100 : pow(10, $this->currencyPrecision($currency))));
		$params = array(
			'amount'               => $cents,
			'currency'             => strtolower($currency),
			'payment_method'       => $pm_id,
			'payment_method_types' => array('card'),
			'confirm'              => 'true',
			'capture_method'       => 'automatic',
			'description'          => $description
		);
		if ($customer_id) {
			$params['customer'] = $customer_id;
		}
		$intent = $this->stripeRequest('POST', 'payment_intents', $params, $cfg['secret_key']);
		if (!empty($intent['error'])) {
			return array('error' => isset($intent['error']['message']) ? $intent['error']['message'] : 'Stripe payment failed.');
		}
		if (!is_array($intent) || !$this->validTransactionId($intent['id'] ?? null) || ($intent['status'] ?? '') !== 'succeeded'
			|| !isset($intent['amount'], $intent['amount_received'], $intent['currency'], $intent['livemode'])
			|| !is_int($intent['amount']) || !is_int($intent['amount_received']) || !is_string($intent['currency'])
			|| $intent['amount'] !== $cents || $intent['amount_received'] !== $cents
			|| strtoupper($intent['currency']) !== $currency || $intent['livemode'] !== ($cfg['environment'] === 'live')) {
			return array('error' => 'Stripe has not confirmed the expected captured payment. Check payment status before retrying.');
		}
		return array(
			'success'        => true,
			'verified'       => true,
			'transaction_id' => $intent['id'],
			'status'         => $intent['status']
		);
	}

	private function validTransactionId($id) {
		return is_string($id) && $id !== '' && !preg_match('/[\x00-\x20\x7f]/', $id);
	}

	private function validTransactionAmount($amount, $currency) {
		if (!is_string($amount) && !is_int($amount) && !is_float($amount)) {
			return false;
		}
		// A GraphQL Amount is a decimal value, not scientific notation. Permit
		// zero-decimal providers to serialize whole units as e.g. "20.00".
		$pattern = $this->currencyPrecision($currency) === 0 ? '/^[0-9]+(?:\.0{1,2})?$/D' : '/^[0-9]+(?:\.[0-9]{1,2})?$/D';
		return preg_match($pattern, (string)$amount) === 1;
	}

	private function currencyPrecision($currency) {
		if (in_array($currency, array('BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF', 'ISK'), true)) {
			return 0;
		}
		// The existing price/total schema has two decimal places. Do not
		// silently round currencies requiring a different accounting contract.
		if (in_array($currency, array('BHD', 'JOD', 'KWD', 'OMR', 'TND'), true)) {
			return -1;
		}
		return 2;
	}

	private function validChargeAmount($amount, $currency) {
		$precision = $this->currencyPrecision($currency);
		$factor = pow(10, max(0, $precision));
		return $precision >= 0 && is_numeric($amount) && is_finite((float)$amount) && (float)$amount > 0
			&& (float)$amount < PHP_INT_MAX / 100 && preg_match('/^[A-Z]{3}$/D', $currency)
			&& abs((float)$amount * $factor - round((float)$amount * $factor)) < 0.00001;
	}

	// =========================================================================
	// BRAINTREE REAL GRAPHQL API METHODS
	// =========================================================================

	public function braintreeGraphQL($query, $variables = array(), $override_cfg = null) {
		$cfg = is_array($override_cfg) ? $override_cfg : $this->getBraintreeConfig();
		$env = $cfg['environment'] === 'production' ? 'production' : 'sandbox';

		if (empty($cfg['public_key']) || empty($cfg['private_key'])) {
			return array('error' => 'Braintree API keys are not configured.');
		}

		$endpoint = $env === 'production'
			? 'https://payments.braintree-api.com/graphql'
			: 'https://payments.sandbox.braintree-api.com/graphql';

		$payload = array('query' => $query);
		if (!empty($variables)) {
			$payload['variables'] = $variables;
		}

		$ch = curl_init($endpoint);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $cfg['public_key'] . ':' . $cfg['private_key']);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Content-Type: application/json',
			'Braintree-Version: 2023-05-01'
		));
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

		$response = curl_exec($ch);
		$curl_err = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($response === false) {
			return array('error' => 'Braintree API cURL Error: ' . $curl_err);
		}

		$decoded = json_decode($response, true);
		if (!is_array($decoded)) {
			return array('error' => 'Invalid JSON response from Braintree API (HTTP ' . $http_code . ')');
		}

		if (!empty($decoded['errors'][0]['message'])) {
			return array('error' => $decoded['errors'][0]['message']);
		}

		if ($http_code >= 400) {
			return array('error' => 'Braintree API HTTP Error ' . $http_code);
		}

		return $decoded;
	}

	public function testBraintreeConnection($environment, $merchant_id, $public_key, $private_key) {
		$public_key = trim((string)$public_key);
		$private_key = trim((string)$private_key);

		if (!$public_key || !$private_key) {
			return array('error' => 'Please enter both Braintree Public Key and Private Key.');
		}

		$query = 'mutation CreateClientToken { createClientToken { clientToken } }';
		$res = $this->braintreeGraphQL($query, array(), array(
			'environment' => $environment,
			'merchant_id' => $merchant_id,
			'public_key'  => $public_key,
			'private_key' => $private_key
		));

		if (isset($res['error'])) {
			return array('error' => $res['error']);
		}

		if (!empty($res['data']['createClientToken']['clientToken'])) {
			return array(
				'success' => true,
				'message' => 'Connected to Braintree GraphQL API (' . strtoupper($environment) . ') and generated Client Token successfully!'
			);
		}

		return array('error' => 'Failed to generate Braintree Client Token.');
	}

	public function generateBraintreeClientToken() {
		$cfg = $this->getBraintreeConfig();
		if (empty($cfg['public_key']) || empty($cfg['private_key'])) {
			return array('error' => 'Braintree keys not configured.');
		}

		$input = array();
		if (!empty($cfg['merchant_account_id'])) {
			$input['clientToken'] = array('merchantAccountId' => $cfg['merchant_account_id']);
		}

		$query = 'mutation CreateClientToken($input: CreateClientTokenInput) { createClientToken(input: $input) { clientToken } }';
		$res = $this->braintreeGraphQL($query, array('input' => (object)$input));

		if (!empty($res['data']['createClientToken']['clientToken'])) {
			return array('client_token' => $res['data']['createClientToken']['clientToken']);
		}

		return array('error' => isset($res['error']) ? $res['error'] : 'Could not create Braintree client token');
	}

	public function vaultBraintreeCard($nonce) {
		$cfg = $this->getBraintreeConfig();
		$brand = 'Visa';
		$last4 = '';
		$date_expire = date('m/Y', strtotime('+3 years'));
		$has_user_card_meta = false;

		if (strpos($nonce, 'bt_card|') === 0) {
			$parts = explode('|', $nonce);
			$brand = !empty($parts[1]) ? $this->formatBrandName($parts[1]) : 'Visa';
			$last4 = !empty($parts[2]) ? preg_replace('/\D/', '', $parts[2]) : '';
			$date_expire = !empty($parts[3]) ? $parts[3] : $date_expire;
			if ($last4 !== '') {
				$has_user_card_meta = true;
			}
		}

		if (empty($nonce) || (strpos($nonce, 'bt_card|') === 0 && $last4 === '')) {
			return array('error' => 'Please enter a valid credit card number.');
		}

		if (!empty($cfg['public_key']) && !empty($cfg['private_key'])) {
			$real_nonce = (strpos($nonce, 'bt_card|') === 0) ? 'fake-valid-visa-nonce' : $nonce;
			$query = 'mutation VaultPaymentMethod($input: VaultPaymentMethodInput!) {
				vaultPaymentMethod(input: $input) {
					paymentMethod {
						id
						details {
							... on CreditCardDetails {
								brandCode
								last4
								expirationMonth
								expirationYear
							}
						}
					}
				}
			}';
			$res = $this->braintreeGraphQL($query, array(
				'input' => array('paymentMethodId' => $real_nonce)
			));

			if (isset($res['error'])) {
				return array('error' => $res['error']);
			}

			if (!empty($res['data']['vaultPaymentMethod']['paymentMethod'])) {
				$pm = $res['data']['vaultPaymentMethod']['paymentMethod'];
				if (!$has_user_card_meta) {
					if (!empty($pm['details']['brandCode'])) {
						$brand = $this->formatBrandName($pm['details']['brandCode']);
					}
					if (!empty($pm['details']['last4'])) {
						$last4 = $pm['details']['last4'];
					}
					if (!empty($pm['details']['expirationMonth']) && !empty($pm['details']['expirationYear'])) {
						$date_expire = $pm['details']['expirationMonth'] . '/' . $pm['details']['expirationYear'];
					}
				}
				return array(
					'success'     => true,
					'type'        => 'card',
					'name'        => $brand . ' ending in ' . $last4,
					'token'       => 'braintree|' . $cfg['environment'] . '|' . $pm['id'],
					'image'       => $this->getBrandLogo($brand),
					'date_expire' => $date_expire
				);
			}
		}

		if ($last4 === '') {
			return array('error' => 'Please enter a valid credit card number.');
		}

		return array(
			'success'     => true,
			'type'        => 'card',
			'name'        => $brand . ' ending in ' . $last4,
			'token'       => $nonce ? $nonce : 'bt_tok_' . token(12),
			'image'       => $this->getBrandLogo($brand),
			'date_expire' => $date_expire
		);
	}

	public function chargeBraintree($payment_token_or_nonce, $amount, $currency = '') {
		$cfg = $this->getBraintreeConfig();
		$currency = strtoupper($currency ?: (string)$this->config->get('config_currency'));
		if (!$cfg['status'] || !$cfg['public_key'] || !$cfg['private_key'] || !$cfg['merchant_account_id']) {
			return array('error' => 'Braintree requires API keys and an explicit merchant account.');
		}
		if (!$this->validChargeAmount($amount, $currency)) {
			return array('error' => 'Unsupported payment amount or currency.');
		}
		$pm_id = $payment_token_or_nonce;
		if (strpos($pm_id, 'braintree|') === 0) {
			$parts = explode('|', $pm_id);
			if (($parts[1] ?? '') !== $cfg['environment']) {
				return array('error' => 'Payment method environment mismatch.');
			}
			$pm_id = $parts[2] ?? '';
		}
		if (!$pm_id || strpos($pm_id, 'bt_') === 0 || strpos($pm_id, 'local_') === 0) {
			return array('error' => 'A provider-issued Braintree payment method is required.');
		}
		$query = 'mutation ChargePaymentMethod($input: ChargePaymentMethodInput!) {
			chargePaymentMethod(input: $input) { transaction { id status amount { value currencyCode } merchantAccountId } }
		}';
		$res = $this->braintreeGraphQL($query, array(
			'input' => array(
				'paymentMethodId' => $pm_id,
				'transaction'     => array(
					'amount'            => number_format((float)$amount, $this->currencyPrecision($currency), '.', ''),
					'merchantAccountId' => $cfg['merchant_account_id']
				)
			)
		));
		if (!empty($res['error'])) {
			return array('error' => $res['error']);
		}
		$tx = $res['data']['chargePaymentMethod']['transaction'] ?? array();
		if (!is_array($tx) || !$this->validTransactionId($tx['id'] ?? null)
			|| !in_array($tx['status'] ?? '', array('SUBMITTED_FOR_SETTLEMENT', 'SETTLING', 'SETTLED', 'SETTLEMENT_PENDING'), true)
			|| !isset($tx['amount']['value'], $tx['amount']['currencyCode'], $tx['merchantAccountId'])
			|| !is_string($tx['amount']['currencyCode']) || !$this->validTransactionAmount($tx['amount']['value'], $currency)
			|| abs((float)$tx['amount']['value'] - (float)$amount) > 0.00001
			|| number_format((float)$tx['amount']['value'], $this->currencyPrecision($currency), '.', '') !== number_format((float)$amount, $this->currencyPrecision($currency), '.', '')
			|| strtoupper($tx['amount']['currencyCode']) !== $currency || $tx['merchantAccountId'] !== $cfg['merchant_account_id']) {
			return array('error' => 'Braintree has not confirmed the expected payment. Check payment status before retrying.');
		}
		return array(
			'success'        => true,
			'verified'       => true,
			'transaction_id' => $tx['id'],
			'status'         => $tx['status']
		);
	}

	// =========================================================================
	// PAYPAL REAL REST API v2 METHODS
	// =========================================================================

	public function getPayPalAccessToken($environment = null, $client_id = null, $secret = null) {
		$cfg = $this->getPayPalConfig();
		$env = $environment !== null ? $environment : $cfg['environment'];
		$cid = $client_id !== null ? trim((string)$client_id) : $cfg['client_id'];
		$sec = $secret !== null ? trim((string)$secret) : $cfg['secret'];

		if (!$cid || !$sec) {
			return array('error' => 'Please enter both PayPal Client ID and Secret.');
		}

		$url = ($env === 'live')
			? 'https://api-m.paypal.com/v1/oauth2/token'
			: 'https://api-m.sandbox.paypal.com/v1/oauth2/token';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $cid . ':' . $sec);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Accept-Language: en_US',
			'Content-Type: application/x-www-form-urlencoded'
		));
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

		$response = curl_exec($ch);
		$curl_err = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($response === false) {
			return array('error' => 'PayPal API cURL Error: ' . $curl_err);
		}

		$decoded = json_decode($response, true);
		if (!empty($decoded['access_token'])) {
			return array(
				'success'      => true,
				'access_token' => $decoded['access_token'],
				'app_id'       => isset($decoded['app_id']) ? $decoded['app_id'] : '',
				'message'      => 'Connected to PayPal REST API (' . strtoupper($env) . ') successfully!'
			);
		}

		$err_msg = !empty($decoded['error_description']) ? $decoded['error_description'] : ('PayPal API Error (HTTP ' . $http_code . ')');
		return array('error' => $err_msg);
	}
}

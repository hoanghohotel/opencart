<?php
class ControllerAccountPromotion extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/promotion', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/promotion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/promotion');

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

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['config_download_status_id'] = (int)$this->config->get('config_download_status_id') ? (int)$this->config->get('config_download_status_id') : ((int)$this->config->get('config_complete_status_id') ? (int)$this->config->get('config_complete_status_id') : 5);
		$data['config_order_status_id'] = (int)$this->config->get('config_order_status_id') ? (int)$this->config->get('config_order_status_id') : 1;

		$data['promotions'] = array();

		$filter_data = array(
			'member_id' => $this->member->getId(),
			'start'     => ($page - 1) * 10,
			'limit'     => 10
		);

		$promotion_total = $this->model_account_promotion->getTotalPromotions($filter_data);

		$results = $this->model_account_promotion->getPromotions($filter_data);

		foreach ($results as $result) {
			$is_paid = ((int)$result['status'] === 1 && (int)$result['order_status_id'] === $data['config_download_status_id']);

			$data['promotions'][] = array(
				'promotion_id'    => $result['promotion_id'],
				'extension'       => $result['extension'],
				'days'            => $result['days'],
				'total'           => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'date_start'      => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'        => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'order_status_id' => $result['order_status_id'],
				'is_paid'         => $is_paid,
				'order_status'    => $is_paid ? $this->language->get('text_paid_active') : ($result['order_status'] ? $result['order_status'] : $this->language->get('text_pending_payment')),
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'pay'             => !$is_paid ? $this->url->link('account/promotion/pay', 'member_token=' . $this->session->data['member_token'] . '&promotion_id=' . $result['promotion_id'], true) : '',
				'href'            => $this->url->link('account/promotion/info', 'member_token=' . $this->session->data['member_token'] . '&promotion_id=' . $result['promotion_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $promotion_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['add'] = $this->url->link('account/promotion/add', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/promotion_list', $data));
	}

	public function add() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/promotion/add', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/promotion');

		$this->document->setTitle($this->language->get('heading_add'));

		$this->load->model('account/promotion');
		$this->load->model('marketplace/extension');
		$this->load->model('account/transaction');

		$raw_packages = $this->model_account_promotion->getPackages();
		$package_labels = array(
			'1w' => $this->language->get('text_package_1w'),
			'1m' => $this->language->get('text_package_1m'),
			'3m' => $this->language->get('text_package_3m'),
			'6m' => $this->language->get('text_package_6m'),
			'1y' => $this->language->get('text_package_1y')
		);

		$balance = $this->model_account_transaction->getTransactionTotal($this->member->getId());

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateAdd($raw_packages, $balance)) {
			$selected_pkg = $raw_packages[$this->request->post['package']];
			$extension_info = $this->model_marketplace_extension->getExtension((int)$this->request->post['extension_id']);
			$payment_option = isset($this->request->post['payment_option']) ? $this->request->post['payment_option'] : 'invoice';

			$promotion_id = $this->model_account_promotion->addPromotion(array(
				'extension_id'   => (int)$this->request->post['extension_id'],
				'package'        => $selected_pkg['code'],
				'days'           => $selected_pkg['days'],
				'total'          => $selected_pkg['price'],
				'payment_method' => ($payment_option === 'balance') ? 'Account Balance' : 'Invoice / Card'
			));

			if ($payment_option === 'balance') {
				$tx_id = 'BAL-PROMO-' . $promotion_id . '-' . strtoupper(token(6));
				$this->model_account_transaction->addTransaction(
					sprintf($this->language->get('text_transaction_desc'), $extension_info['name'], $selected_pkg['days']),
					-abs((float)$selected_pkg['price']),
					0,
					$this->member->getId()
				);

				$this->model_account_promotion->activatePromotion($promotion_id, 'Account Balance', $tx_id);

				$this->session->data['success'] = $this->language->get('text_success_paid');

				$this->response->redirect($this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true));
			} else {
				$this->session->data['success'] = sprintf($this->language->get('text_success_created'), $promotion_id);

				$this->response->redirect($this->url->link('account/promotion/info', 'member_token=' . $this->session->data['member_token'] . '&promotion_id=' . $promotion_id, true));
			}
		}

		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
		$data['error_extension'] = isset($this->error['extension']) ? $this->error['extension'] : '';
		$data['error_package'] = isset($this->error['package']) ? $this->error['package'] : '';

		$data['extensions'] = $this->model_marketplace_extension->getExtensions(array(
			'filter_member_id' => $this->member->getId(),
			'ignore_status'    => true,
			'sort'             => 'name'
		));

		$data['packages'] = array();
		foreach ($raw_packages as $code => $pkg) {
			$data['packages'][] = array(
				'code'            => $code,
				'days'            => $pkg['days'],
				'label'           => isset($package_labels[$code]) ? $package_labels[$code] : ($pkg['days'] . ' Days'),
				'price'           => $pkg['price'],
				'price_formatted' => $this->currency->format($pkg['price'], $this->config->get('config_currency'))
			);
		}

		$data['extension_id'] = isset($this->request->post['extension_id']) ? (int)$this->request->post['extension_id'] : (isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0);
		$data['selected_package'] = isset($this->request->post['package']) ? $this->request->post['package'] : '1m';
		$data['payment_option'] = isset($this->request->post['payment_option']) ? $this->request->post['payment_option'] : ($balance > 0 ? 'balance' : 'invoice');
		$data['balance_formatted'] = $this->currency->format($balance, $this->config->get('config_currency'));
		$data['text_pay_balance_formatted'] = sprintf($this->language->get('text_pay_balance'), $data['balance_formatted']);

		$data['action'] = $this->url->link('account/promotion/add', 'member_token=' . $this->session->data['member_token'], true);
		$data['cancel'] = $this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/promotion_form', $data));
	}

	public function pay() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/promotion', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/promotion');
		$this->load->model('account/promotion');
		$this->load->model('account/transaction');

		$promotion_id = isset($this->request->get['promotion_id']) ? (int)$this->request->get['promotion_id'] : 0;
		$promotion_info = $this->model_account_promotion->getPromotion($promotion_id);

		if (!$promotion_info) {
			$this->response->redirect($this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true));
		}

		$complete_status_id = (int)$this->config->get('config_download_status_id') ? (int)$this->config->get('config_download_status_id') : ((int)$this->config->get('config_complete_status_id') ? (int)$this->config->get('config_complete_status_id') : 5);
		if ((int)$promotion_info['status'] === 1 && (int)$promotion_info['order_status_id'] === $complete_status_id) {
			$this->response->redirect($this->url->link('account/promotion/info', 'member_token=' . $this->session->data['member_token'] . '&promotion_id=' . $promotion_id, true));
		}

		$balance = $this->model_account_transaction->getTransactionTotal($this->member->getId());
		$amount_due = (float)$promotion_info['total'];

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!empty($this->request->post['payment_intent_id']) || !empty($this->request->post['payment_method_nonce'])) {
				require_once(DIR_SYSTEM . 'library/payment_gateway.php');
				$gateway = new PaymentGateway($this->registry);

				if (!empty($this->request->post['payment_intent_id'])) {
					$verify = $gateway->verifyStripePaymentIntent($this->request->post['payment_intent_id'], $amount_due);
					if (!empty($verify['success'])) {
						$this->model_account_promotion->activatePromotion($promotion_id, 'Credit / Debit Card (Stripe)', $verify['transaction_id']);
						$this->session->data['success'] = $this->language->get('text_success_paid');
						$this->response->redirect($this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true));
					} else {
						$this->error['warning'] = sprintf($this->language->get('error_payment_verify'), isset($verify['error']) ? $verify['error'] : 'Invalid Stripe PaymentIntent');
					}
				} elseif (!empty($this->request->post['payment_method_nonce'])) {
					$verify = $gateway->processBraintreeSale($this->request->post['payment_method_nonce'], $amount_due, 'PROMO-' . $promotion_id);
					if (!empty($verify['success'])) {
						$this->model_account_promotion->activatePromotion($promotion_id, 'Credit / Debit Card (Braintree)', $verify['transaction_id']);
						$this->session->data['success'] = $this->language->get('text_success_paid');
						$this->response->redirect($this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true));
					} else {
						$this->error['warning'] = sprintf($this->language->get('error_payment_verify'), isset($verify['error']) ? $verify['error'] : 'Braintree transaction declined');
					}
				}
			} elseif ($balance >= $amount_due) {
				$tx_id = 'BAL-PROMO-' . $promotion_id . '-' . strtoupper(token(6));
				$this->model_account_transaction->addTransaction(
					sprintf($this->language->get('text_transaction_desc'), $promotion_info['extension'], (int)$promotion_info['days']),
					-abs($amount_due),
					0,
					$this->member->getId()
				);

				$this->model_account_promotion->activatePromotion($promotion_id, 'Account Balance', $tx_id);

				$this->session->data['success'] = $this->language->get('text_success_paid');

				$this->response->redirect($this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true));
			} else {
				$this->error['warning'] = sprintf($this->language->get('error_balance'), $this->currency->format($balance, $this->config->get('config_currency')), $this->currency->format($amount_due, $this->config->get('config_currency')));
			}
		}

		$this->info();
	}

	protected function validateAdd($raw_packages, $balance) {
		if (empty($this->request->post['extension_id'])) {
			$this->error['extension'] = $this->language->get('error_extension');
		} else {
			$ext_info = $this->model_marketplace_extension->getExtension((int)$this->request->post['extension_id']);
			if (!$ext_info || (int)$ext_info['member_id'] !== (int)$this->member->getId()) {
				$this->error['extension'] = $this->language->get('error_extension');
			}
		}

		if (empty($this->request->post['package']) || !isset($raw_packages[$this->request->post['package']])) {
			$this->error['package'] = $this->language->get('error_package');
		} else {
			$pkg = $raw_packages[$this->request->post['package']];
			$payment_option = isset($this->request->post['payment_option']) ? $this->request->post['payment_option'] : 'invoice';

			if ($payment_option === 'balance' && $balance < (float)$pkg['price']) {
				$this->error['warning'] = sprintf(
					$this->language->get('error_balance'),
					$this->currency->format($balance, $this->config->get('config_currency')),
					$this->currency->format($pkg['price'], $this->config->get('config_currency'))
				);
			}
		}

		return !$this->error;
	}

	public function info() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/promotion', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (isset($this->request->get['promotion_id'])) {
			$promotion_id = (int)$this->request->get['promotion_id'];
		} else {
			$promotion_id = 0;
		}

		$this->load->language('account/promotion');

		$this->load->model('account/promotion');

		$promotion_info = $this->model_account_promotion->getPromotion($promotion_id);

		if ($promotion_info) {
			$this->document->setTitle(sprintf($this->language->get('text_invoice_title'), $promotion_info['promotion_id']));

			$this->load->model('account/member');
			$this->load->model('account/seller');
			$this->load->model('localisation/country');
			$this->load->model('localisation/zone');

			$member_info = $this->model_account_member->getMember($this->member->getId());
			$seller_info = $this->model_account_seller->getSeller($this->member->getId());

			$data['title'] = sprintf($this->language->get('text_invoice_title'), $promotion_info['promotion_id']);
			$data['logo'] = $this->config->get('config_name');

			$data['company'] = !empty($seller_info['company']) ? $seller_info['company'] : (!empty($member_info['company']) ? $member_info['company'] : '');
			$data['firstname'] = !empty($seller_info['firstname']) ? $seller_info['firstname'] : (!empty($member_info['firstname']) ? $member_info['firstname'] : '');
			$data['lastname'] = !empty($seller_info['lastname']) ? $seller_info['lastname'] : (!empty($member_info['lastname']) ? $member_info['lastname'] : '');
			$data['address_1'] = !empty($seller_info['address_1']) ? $seller_info['address_1'] : '';
			$data['address_2'] = !empty($seller_info['address_2']) ? $seller_info['address_2'] : '';
			$data['city'] = !empty($seller_info['city']) ? $seller_info['city'] : '';
			$data['postcode'] = !empty($seller_info['postcode']) ? $seller_info['postcode'] : '';

			$zone_id = !empty($seller_info['zone_id']) ? $seller_info['zone_id'] : 0;
			if ($zone_id) {
				$zone_info = $this->model_localisation_zone->getZone($zone_id);
				$data['zone'] = $zone_info ? $zone_info['name'] : '';
			} else {
				$data['zone'] = '';
			}

			$country_id = !empty($seller_info['country_id']) ? $seller_info['country_id'] : (!empty($member_info['country_id']) ? $member_info['country_id'] : 0);
			if ($country_id) {
				$country_info = $this->model_localisation_country->getCountry($country_id);
				$data['country'] = $country_info ? $country_info['name'] : '';
			} else {
				$data['country'] = '';
			}

			$data['telephone'] = !empty($seller_info['telephone']) ? $seller_info['telephone'] : (!empty($member_info['telephone']) ? $member_info['telephone'] : '');
			$data['email'] = !empty($member_info['email']) ? $member_info['email'] : '';
			$data['username'] = !empty($member_info['username']) ? $member_info['username'] : '';

			$data['promotion_id'] = $promotion_info['promotion_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($promotion_info['date_added']));
			$data['payment_method'] = $promotion_info['payment_method'];
			$data['transaction_id'] = $promotion_info['transaction_id'];
			$data['extension'] = $promotion_info['extension'];
			$data['days'] = $promotion_info['days'];
			$data['total'] = $this->currency->format($promotion_info['total'], $this->config->get('config_currency'));

			$complete_status_id = (int)$this->config->get('config_download_status_id') ? (int)$this->config->get('config_download_status_id') : ((int)$this->config->get('config_complete_status_id') ? (int)$this->config->get('config_complete_status_id') : 5);
			$data['is_paid'] = ((int)$promotion_info['status'] === 1 && (int)$promotion_info['order_status_id'] === $complete_status_id);
			$data['pay_action'] = $this->url->link('account/promotion/pay', 'member_token=' . $this->session->data['member_token'] . '&promotion_id=' . $promotion_info['promotion_id'], true);
			$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];
				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['support'] = $this->url->link('support/contact', '', true);
			$data['cancel'] = $this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true);

			$data['menu'] = $this->load->controller('account/menu');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('account/promotion_info', $data));
		} else {
			$this->document->setTitle($this->language->get('heading_not_found'));

			$data['home'] = $this->url->link('common/home');
			$data['continue'] = $this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true);

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}

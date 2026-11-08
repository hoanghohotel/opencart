<?php
class ControllerAccountSubscription extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/subscription');

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
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

		$data['subscription_active_status'] = 1;

		$data['subscriptions'] = array();

		$filter_data = array(
			'member_id' => $this->member->getId(),
			'start'     => ($page - 1) * 10,
			'limit'     => 10
		);

		$subscription_total = $this->model_account_subscription->getTotalSubscriptions($filter_data);

		$results = $this->model_account_subscription->getSubscriptions($filter_data);

		foreach ($results as $result) {
			$data['subscriptions'][] = array(
				'subscription_id'        => $result['subscription_id'],
				'name'                   => $result['name'],
				'subscription_plan'      => $result['plan_name'],
				'subscription_status_id' => $result['subscription_status_id'],
				'subscription_status'    => $result['status_name'],
				'date_added'             => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'backup'                 => $this->url->link('account/subscription/backup', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $result['subscription_id'], true),
				'database_backup'        => $this->url->link('account/subscription/databaseBackup', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $result['subscription_id'], true),
				'history_url'            => $this->url->link('account/subscription/history', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $result['subscription_id'], true),
				'view'                   => $this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $result['subscription_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $subscription_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['add'] = $this->url->link('account/subscription/add', 'member_token=' . $this->session->data['member_token'], true);
		$data['cancel'] = $this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_list', $data));
	}

	public function add() {
		$this->load->language('account/subscription');

		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			if ($this->request->server['REQUEST_METHOD'] == 'POST') {
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode(array('error' => array('warning' => $this->language->get('error_session_expired')))));
				return;
			}

			$this->session->data['redirect'] = $this->url->link('account/subscription/add', '', true);
			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('account/subscription');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$json = array();

			if (empty($this->request->post['name']) || utf8_strlen(trim($this->request->post['name'])) < 3 || utf8_strlen(trim($this->request->post['name'])) > 32) {
				$json['error']['name'] = $this->language->get('error_store_name');
			}

			if (empty($this->request->post['admin_email']) || !filter_var($this->request->post['admin_email'], FILTER_VALIDATE_EMAIL)) {
				$json['error']['admin_email'] = $this->language->get('error_admin_email');
			}

			if (empty($this->request->post['admin_username']) || utf8_strlen(trim($this->request->post['admin_username'])) < 3) {
				$json['error']['admin_username'] = $this->language->get('error_admin_username');
			}

			if (empty($this->request->post['agree']) || $this->request->post['agree'] != '1') {
				$json['error']['agree'] = $this->language->get('error_agree');
			}

			if (!$json) {
				$subscription_id = $this->model_account_subscription->addSubscription(array(
					'name'                 => trim($this->request->post['name']),
					'subscription_plan_id' => isset($this->request->post['subscription_plan_id']) ? (int)$this->request->post['subscription_plan_id'] : 1,
					'member_payment_id'    => isset($this->request->post['payment_id']) ? (int)$this->request->post['payment_id'] : 0,
					'admin_email'          => $this->request->post['admin_email'],
					'admin_username'       => $this->request->post['admin_username']
				));

				$domain_name = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', $this->request->post['name'])) . $this->language->get('text_cloud_subdomain');
				$this->model_account_subscription->addDomain($subscription_id, $domain_name);

				$this->load->controller('mail/subscription', array(
					'email'     => $this->member->getEmail(),
					'text'      => sprintf($this->language->get('text_mail_subscription'), trim($this->request->post['name'])),
					'mail_link' => $this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true)
				));

				$this->load->controller('mail/cloud_store', array(
					'email' => $this->request->post['admin_email'],
					'name'  => trim($this->request->post['name']),
					'url'   => 'https://' . $domain_name,
					'text'  => sprintf($this->language->get('text_mail_cloud_store'), trim($this->request->post['name']))
				));

				$json['success'] = $this->language->get('text_success_create');
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
				$json['process_statuses'] = array(
					$this->language->get('text_process_status_1'),
					$this->language->get('text_process_status_2'),
					$this->language->get('text_process_status_3'),
					$this->language->get('text_process_status_4')
				);
			}

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
			return;
		}

		$this->document->setTitle($this->language->get('heading_create'));

		$data['error_warning'] = '';
		$data['success'] = '';

		$data['name'] = '';
		$data['admin_email'] = $this->member->getEmail();
		$data['admin_username'] = 'admin';
		$data['member_id'] = $this->member->getId();
		$data['member_token'] = $this->session->data['member_token'];

		$data['subscription_plans'] = array();

		$plans = $this->model_account_subscription->getSubscriptionPlans();

		foreach ($plans as $plan) {
			$data['subscription_plans'][] = array(
				'subscription_plan_id' => $plan['subscription_plan_id'],
				'name'                 => $plan['name'],
				'description'          => $plan['description'],
				'price'                => $this->currency->format($plan['price'], $this->config->get('config_currency')),
				'label_active'         => isset($plan['label_active']) ? $plan['label_active'] : 0
			);
		}

		$this->load->model('account/payment');

		$data['payment_methods'] = array();

		$payments = $this->model_account_payment->getPayments($this->member->getId());

		foreach ($payments as $payment) {
			$data['payment_methods'][] = array(
				'payment_id'  => $payment['member_payment_id'],
				'name'        => $payment['name'],
				'image'       => $payment['image'] ? $payment['image'] : 'application/view/image/cloud/cloud_credit_card.svg',
				'date_expire' => $payment['date_expire']
			);
		}

		$data['subscription_payment_create_info'] = $this->language->get('text_add_payment_method');
		$data['subscription_payment_create_url'] = $this->url->link('account/payment/add', 'member_token=' . $this->session->data['member_token'], true);
		$data['subscription_terms'] = $this->url->link('cloud/terms', '', true);
		$data['banner'] = '';

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_form', $data));
	}

	public function info() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		if (isset($this->request->get['subscription_id'])) {
			$subscription_id = (int)$this->request->get['subscription_id'];
		} else {
			$subscription_id = 0;
		}

		$this->load->model('account/subscription');

		$subscription_info = $this->model_account_subscription->getSubscription($subscription_id);

		if (!$subscription_info) {
			$this->response->redirect($this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->document->setTitle($this->language->get('heading_details'));

		if (isset($this->session->data['error'])) {
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

		$data['countdown'] = '';
		$data['subscription'] = $subscription_info;
		$data['subscription_active_status'] = 1;
		$data['subscription_canceled_status'] = 3;

		$data['store_info'] = array(
			'status' => ($subscription_info['store_status'] == 'Active' || $subscription_info['subscription_status_id'] == 1) ? 1 : 0
		);

		$domain_rows = $this->model_account_subscription->getDomains($subscription_id);

		$data['active_domains'] = array();
		$data['domains'] = array();

		foreach ($domain_rows as $domain) {
			$status_lower = strtolower($domain['status']);

			if (!empty($domain['pointed'])) {
				$data['active_domains'][] = array(
					'url'          => (strpos($domain['name'], 'http') === 0 ? $domain['name'] : 'https://' . $domain['name']),
					'unpoint_href' => $this->url->link('account/subscription/unpointDomain', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id . '&subscription_domain_id=' . $domain['subscription_domain_id'], true)
				);
			}

			$data['domains'][] = array(
				'subscription_domain_id' => $domain['subscription_domain_id'],
				'name'                   => $domain['name'],
				'status'                 => $status_lower,
				'connected_to'           => !empty($domain['pointed']) ? $subscription_info['name'] : '',
				'point'                  => $this->url->link('account/subscription/pointDomain', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id . '&subscription_domain_id=' . $domain['subscription_domain_id'], true),
				'delete'                 => $this->url->link('account/subscription/deleteDomain', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id . '&subscription_domain_id=' . $domain['subscription_domain_id'], true)
			);
		}

		$data['add_domain'] = $this->url->link('account/subscription/addDomain', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true);
		$data['member_id'] = $this->member->getId();
		$data['member_token'] = $this->session->data['member_token'];

		$data['subscription_plans'] = array();

		$plans = $this->model_account_subscription->getSubscriptionPlans();

		foreach ($plans as $plan) {
			$data['subscription_plans'][] = array(
				'subscription_plan_id' => $plan['subscription_plan_id'],
				'name'                 => $plan['name'],
				'description'          => $plan['description'],
				'price'                => $this->currency->format($plan['price'], $this->config->get('config_currency'))
			);
		}

		$this->load->model('account/payment');

		$data['payment_methods'] = array();

		$payments = $this->model_account_payment->getPayments($this->member->getId());

		foreach ($payments as $payment) {
			$data['payment_methods'][] = array(
				'payment_id' => $payment['member_payment_id'],
				'name'       => $payment['name'],
				'image'      => $payment['image'] ? $payment['image'] : 'application/view/image/cloud/cloud_credit_card.svg'
			);
		}

		$data['add_payment'] = $this->url->link('account/payment/add', 'member_token=' . $this->session->data['member_token'], true);
		$data['cancel'] = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_info', $data));
	}

	public function update() {
		$this->load->language('account/subscription');

		$json = array();

		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$json['error'] = $this->language->get('error_permission');
		}

		$this->load->model('account/subscription');

		$subscription_id = isset($this->request->post['subscription_id']) ? (int)$this->request->post['subscription_id'] : 0;

		$subscription_info = $this->model_account_subscription->getSubscription($subscription_id);

		if (!$subscription_info) {
			$json['error'] = $this->language->get('error_not_found');
		}

		if (!$json) {
			if (isset($this->request->post['payment_id'])) {
				$this->model_account_subscription->editSubscriptionPayment($subscription_id, (int)$this->request->post['payment_id']);
				$json['success'] = $this->language->get('text_success_payment_update');
			} elseif (isset($this->request->post['subscription_plan_id'])) {
				$this->model_account_subscription->editSubscriptionPlan($subscription_id, (int)$this->request->post['subscription_plan_id']);
				$json['success'] = $this->language->get('text_success_plan_update');
			} else {
				$json['error'] = $this->language->get('error_select_update');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function cancelSubscription() {
		$this->load->language('account/subscription');

		$json = array();

		if ($this->member->isLogged() && isset($this->request->get['member_token']) && isset($this->session->data['member_token']) && ($this->request->get['member_token'] == $this->session->data['member_token'])) {
			$this->load->model('account/subscription');

			$subscription_id = isset($this->request->post['subscription_id']) ? (int)$this->request->post['subscription_id'] : 0;

			$subscription_info = $this->model_account_subscription->getSubscription($subscription_id);

			if ($subscription_info) {
				$this->model_account_subscription->cancelSubscription($subscription_id);

				$this->session->data['success'] = $this->language->get('text_success_cancel');
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function renewSubscription() {
		$this->load->language('account/subscription');

		$json = array();

		if ($this->member->isLogged() && isset($this->request->get['member_token']) && isset($this->session->data['member_token']) && ($this->request->get['member_token'] == $this->session->data['member_token'])) {
			$this->load->model('account/subscription');

			$subscription_id = isset($this->request->post['subscription_id']) ? (int)$this->request->post['subscription_id'] : 0;

			$subscription_info = $this->model_account_subscription->getSubscription($subscription_id);

			if ($subscription_info) {
				$this->model_account_subscription->editSubscription($subscription_id, array(
					'subscription_status_id' => 1,
					'store_status'           => 'Active'
				));

				$this->model_account_subscription->addSubscriptionHistory($subscription_id, 'Active', $this->language->get('text_history_renewed'));

				$this->session->data['success'] = $this->language->get('text_success_renew');
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function restartSubscription() {
		$this->renewSubscription();
	}

	public function history() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		if (isset($this->request->get['subscription_id'])) {
			$subscription_id = (int)$this->request->get['subscription_id'];
		} else {
			$subscription_id = 0;
		}

		$this->load->model('account/subscription');

		$subscription_info = $this->model_account_subscription->getSubscription($subscription_id);

		if (!$subscription_info) {
			$this->response->redirect($this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->document->setTitle($this->language->get('heading_history'));

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['error_warning'] = '';
		$data['success'] = '';

		$data['subscription_history_rows'] = array();

		$history_total = $this->model_account_subscription->getTotalSubscriptionHistories($subscription_id);

		$results = $this->model_account_subscription->getSubscriptionHistories($subscription_id, ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['subscription_history_rows'][] = array(
				'status'     => $result['status'],
				'comment'    => $result['comment'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/subscription/history', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['cancel'] = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_history', $data));
	}

	public function backup() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;

		$this->document->setTitle($this->language->get('heading_backup'));

		$data['get_backup_list'] = str_replace('&amp;', '&', $this->url->link('account/subscription/getBackupList', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
		$data['get_backup_restore_list'] = str_replace('&amp;', '&', $this->url->link('account/subscription/getBackupList', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_backup', $data));
	}

	public function getBackupList() {
		$this->load->language('account/subscription');

		$this->response->setOutput($this->renderBackupList('Manual', 'account/subscription_backup_list'));
	}

	public function createBackup() {
		$this->load->language('account/subscription');

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;

		$this->load->model('account/subscription');

		if ($subscription_id) {
			$this->model_account_subscription->addBackup($subscription_id, 'Manual');
		}

		$json = array(
			'html' => $this->renderBackupList('Manual', 'account/subscription_backup_list', $this->language->get('text_success_backup_create'))
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function restoreBackup() {
		$this->load->language('account/subscription');

		$json = array(
			'html' => $this->renderBackupList('Manual', 'account/subscription_backup_list', $this->language->get('text_success_backup_restore'))
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeBackup() {
		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;
		$backup_id = isset($this->request->get['backup_id']) ? (int)$this->request->get['backup_id'] : 0;

		$this->load->model('account/subscription');

		if ($backup_id) {
			$this->model_account_subscription->deleteBackup($backup_id);
		}

		$this->response->redirect($this->url->link('account/subscription/backup', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
	}

	public function databaseBackup() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;

		$this->document->setTitle($this->language->get('heading_database_backup'));

		$data['get_database_backup_list'] = str_replace('&amp;', '&', $this->url->link('account/subscription/getDatabaseBackupList', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
		$data['get_database_backup_restore_list'] = str_replace('&amp;', '&', $this->url->link('account/subscription/getDatabaseBackupList', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_database_backup', $data));
	}

	public function getDatabaseBackupList() {
		$this->load->language('account/subscription');

		$this->response->setOutput($this->renderBackupList('Database', 'account/subscription_database_backup_list'));
	}

	public function createDatabaseBackup() {
		$this->load->language('account/subscription');

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;

		$this->load->model('account/subscription');

		if ($subscription_id) {
			$this->model_account_subscription->addBackup($subscription_id, 'Database');
		}

		$json = array(
			'html' => $this->renderBackupList('Database', 'account/subscription_database_backup_list', $this->language->get('text_success_db_backup_create'))
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function restoreDatabaseBackup() {
		$this->load->language('account/subscription');

		$json = array(
			'html' => $this->renderBackupList('Database', 'account/subscription_database_backup_list', $this->language->get('text_success_db_backup_restore'))
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeDatabaseBackup() {
		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;
		$backup_id = isset($this->request->get['backup_id']) ? (int)$this->request->get['backup_id'] : 0;

		$this->load->model('account/subscription');

		if ($backup_id) {
			$this->model_account_subscription->deleteBackup($backup_id);
		}

		$this->response->redirect($this->url->link('account/subscription/databaseBackup', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
	}

	protected function renderBackupList($type, $template, $success = '') {
		$this->load->language('account/subscription');

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;

		$this->load->model('account/subscription');

		$data['error_warning'] = '';
		$data['success'] = $success;
		$data['warnings'] = array();
		$data['backups'] = array();

		$results = $this->model_account_subscription->getBackups($subscription_id, 0, 20);

		foreach ($results as $result) {
			$status_norm = (strtolower($result['status']) == 'completed' || strtolower($result['status']) == 'complete') ? 'complete' : strtolower($result['status']);

			if ($type == 'Database') {
				$restore_route = 'account/subscription/restoreDatabaseBackup';
				$remove_route = 'account/subscription/removeDatabaseBackup';
			} else {
				$restore_route = 'account/subscription/restoreBackup';
				$remove_route = 'account/subscription/removeBackup';
			}

			$data['backups'][] = array(
				'backup_id' => $result['backup_id'],
				'status'    => $status_norm,
				'created'   => date($this->language->get('date_format_short'), strtotime($result['created'])),
				'restore'   => str_replace('&amp;', '&', $this->url->link($restore_route, 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id . '&backup_id=' . $result['backup_id'], true)),
				'remove'    => $this->url->link($remove_route, 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id . '&backup_id=' . $result['backup_id'], true)
			);
		}

		$data['cancel'] = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true);

		if ($type == 'Database') {
			$data['create_backup'] = str_replace('&amp;', '&', $this->url->link('account/subscription/createDatabaseBackup', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
		} else {
			$data['create_backup'] = str_replace('&amp;', '&', $this->url->link('account/subscription/createBackup', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
		}

		return $this->load->view($template, $data);
	}

	public function domain() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription/domain', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$this->document->setTitle($this->language->get('heading_domains'));

		if (isset($this->session->data['error'])) {
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

		$total_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscription_domain` WHERE member_id = '" . (int)$this->member->getId() . "'");
		$domain_total = (int)$total_query->row['total'];

		$start = ($page - 1) * 10;
		if ($start < 0) {
			$start = 0;
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_domain` WHERE member_id = '" . (int)$this->member->getId() . "' ORDER BY date_added DESC LIMIT " . (int)$start . ", 10");

		$data['domains'] = array();

		foreach ($query->rows as $result) {
			$data['domains'][] = array(
				'subscription_domain_id' => $result['subscription_domain_id'],
				'name'                   => $result['name'],
				'status'                 => strtolower($result['status']),
				'href'                   => $this->url->link('account/subscription/domainSettings', 'member_token=' . $this->session->data['member_token'] . '&subscription_domain_id=' . $result['subscription_domain_id'], true),
				'delete'                 => $this->url->link('account/subscription/deleteDomain', 'member_token=' . $this->session->data['member_token'] . '&subscription_domain_id=' . $result['subscription_domain_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $domain_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/subscription/domain', 'member_token=' . $this->session->data['member_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['subscription_list'] = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true);
		$data['add'] = $this->url->link('account/subscription/addDomain', 'member_token=' . $this->session->data['member_token'], true);
		$data['cancel'] = $this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true);
		$data['refresh'] = false;

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_domain_list', $data));
	}

	public function addDomain() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription/domain', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$this->document->setTitle($this->language->get('heading_your_domains'));

		$this->load->model('account/subscription');

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;

		if (!$subscription_id) {
			$subs = $this->model_account_subscription->getSubscriptions(array('member_id' => $this->member->getId(), 'start' => 0, 'limit' => 1));
			if ($subs) {
				$subscription_id = (int)$subs[0]['subscription_id'];
			}
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (empty($this->request->post['cloud_domain']) || utf8_strlen(trim($this->request->post['cloud_domain'])) < 4) {
				$this->error['cloud_domain'] = $this->language->get('error_cloud_domain');
			} else {
				$this->model_account_subscription->addDomain($subscription_id, trim($this->request->post['cloud_domain']));

				$this->session->data['success'] = $this->language->get('text_success_domain_register');

				if (isset($this->request->get['subscription_id'])) {
					$this->response->redirect($this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . (int)$this->request->get['subscription_id'], true));
				} else {
					$this->response->redirect($this->url->link('account/subscription/domain', 'member_token=' . $this->session->data['member_token'], true));
				}
			}
		}

		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
		$data['error_cloud_domain'] = isset($this->error['cloud_domain']) ? $this->error['cloud_domain'] : '';

		$data['cloud_domain'] = isset($this->request->post['cloud_domain']) ? $this->request->post['cloud_domain'] : '';
		$data['subscription_list'] = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true);

		$url = isset($this->request->get['subscription_id']) ? '&subscription_id=' . (int)$this->request->get['subscription_id'] : '';

		$data['action'] = $this->url->link('account/subscription/addDomain', 'member_token=' . $this->session->data['member_token'] . $url, true);
		$data['cancel'] = isset($this->request->get['subscription_id']) ? $this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . $url, true) : $this->url->link('account/subscription/domain', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_domain_form', $data));
	}

	public function editDomain() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$this->document->setTitle($this->language->get('heading_edit_domain'));

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;

		$this->load->model('account/subscription');

		$subscription_info = $this->model_account_subscription->getSubscription($subscription_id);

		$data['error_warning'] = '';
		$data['subscription_store_subdomain'] = $subscription_info ? $subscription_info['name'] : '';
		$data['cloud_store_subdomain'] = $this->language->get('text_cloud_subdomain');
		$data['subscription_store_id'] = $subscription_id;
		$data['back_url'] = $this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true);
		$data['member_token'] = $this->session->data['member_token'];

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_domain_edit', $data));
	}

	public function domainSettings() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription/domain', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$this->document->setTitle($this->language->get('heading_domain_settings'));

		$this->load->model('account/subscription');

		$subscription_domain_id = isset($this->request->get['subscription_domain_id']) ? (int)$this->request->get['subscription_domain_id'] : 0;

		$domain_info = $this->model_account_subscription->getDomain($subscription_domain_id);

		if (!$domain_info) {
			$this->response->redirect($this->url->link('account/subscription/domain', 'member_token=' . $this->session->data['member_token'], true));
		}

		$data['error_warning'] = '';

		$data['domain'] = array(
			'name'      => $domain_info['name'],
			'status'    => strtolower($domain_info['status']),
			'challenge' => array(
				'servers' => array('52.200.100.1')
			)
		);

		$data['cancel'] = $this->url->link('account/subscription/domain', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/subscription_domain_settings', $data));
	}

	public function deleteDomain() {
		$this->load->language('account/subscription');

		if ($this->member->isLogged() && isset($this->request->get['member_token']) && isset($this->session->data['member_token']) && ($this->request->get['member_token'] == $this->session->data['member_token'])) {
			$this->load->model('account/subscription');

			if (isset($this->request->get['subscription_domain_id'])) {
				$this->model_account_subscription->deleteDomain((int)$this->request->get['subscription_domain_id']);
				$this->session->data['success'] = $this->language->get('text_success_domain_remove');
			}
		}

		if (isset($this->request->get['subscription_id'])) {
			$this->response->redirect($this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . (int)$this->request->get['subscription_id'], true));
		} else {
			$this->response->redirect($this->url->link('account/subscription/domain', 'member_token=' . $this->session->data['member_token'], true));
		}
	}

	public function pointDomain() {
		$this->load->language('account/subscription');

		if ($this->member->isLogged() && isset($this->request->get['member_token']) && isset($this->session->data['member_token']) && ($this->request->get['member_token'] == $this->session->data['member_token'])) {
			if (isset($this->request->get['subscription_domain_id'])) {
				$this->db->query("UPDATE `" . DB_PREFIX . "subscription_domain` SET pointed = '1', status = 'Active' WHERE subscription_domain_id = '" . (int)$this->request->get['subscription_domain_id'] . "' AND member_id = '" . (int)$this->member->getId() . "'");
				$this->session->data['success'] = $this->language->get('text_success_domain_connect');
			}
		}

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;
		$this->response->redirect($this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
	}

	public function unpointDomain() {
		$this->load->language('account/subscription');

		if ($this->member->isLogged() && isset($this->request->get['member_token']) && isset($this->session->data['member_token']) && ($this->request->get['member_token'] == $this->session->data['member_token'])) {
			if (isset($this->request->get['subscription_domain_id'])) {
				$this->db->query("UPDATE `" . DB_PREFIX . "subscription_domain` SET pointed = '0' WHERE subscription_domain_id = '" . (int)$this->request->get['subscription_domain_id'] . "' AND member_id = '" . (int)$this->member->getId() . "'");
				$this->session->data['success'] = $this->language->get('text_success_domain_disconnect');
			}
		}

		$subscription_id = isset($this->request->get['subscription_id']) ? (int)$this->request->get['subscription_id'] : 0;
		$this->response->redirect($this->url->link('account/subscription/info', 'member_token=' . $this->session->data['member_token'] . '&subscription_id=' . $subscription_id, true));
	}

	public function invoice() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/subscription/invoice', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/subscription');

		$this->load->model('account/subscription');

		if (isset($this->request->get['subscription_transaction_id'])) {
			$transaction_info = $this->model_account_subscription->getSubscriptionTransaction((int)$this->request->get['subscription_transaction_id']);
		} else {
			$transactions = $this->model_account_subscription->getSubscriptionTransactions(0, 0, 1);
			$transaction_info = $transactions ? $transactions[0] : array();
		}

		if ($transaction_info) {
			$this->document->setTitle(sprintf($this->language->get('heading_invoice_title'), $transaction_info['subscription_transaction_id']));

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['title'] = sprintf($this->language->get('heading_invoice_title'), $transaction_info['subscription_transaction_id']);
			$data['logo'] = $this->config->get('config_name');

			$this->load->model('account/member');
			$this->load->model('localisation/country');

			$member_info = $this->model_account_member->getMember($this->member->getId());
			$country_name = '';

			if (!empty($member_info['country_id'])) {
				$country_info = $this->model_localisation_country->getCountry($member_info['country_id']);
				if ($country_info) {
					$country_name = $country_info['name'];
				}
			}

			$data['member'] = array(
				'username'  => $member_info ? $member_info['username'] : '',
				'firstname' => $member_info ? $member_info['firstname'] : '',
				'lastname'  => $member_info ? $member_info['lastname'] : '',
				'company'   => $member_info ? $member_info['company'] : '',
				'tax_id'    => $member_info ? $member_info['tax_id'] : '',
				'country'   => $country_name
			);

			$subscription_info = $this->model_account_subscription->getSubscription($transaction_info['subscription_id']);

			$data['subscription'] = array(
				'name'       => $subscription_info ? $subscription_info['name'] : $transaction_info['store_name'],
				'plan_name'  => $subscription_info ? $subscription_info['plan_name'] : $this->language->get('text_standard_plan'),
				'plan_price' => number_format((float)($subscription_info ? $subscription_info['plan_price'] : $transaction_info['amount']), 2)
			);

			$data['transaction'] = array(
				'subscription_transaction_id' => $transaction_info['subscription_transaction_id'],
				'transaction_id'              => $transaction_info['transaction_id'],
				'amount'                      => number_format((float)$transaction_info['amount'], 2),
				'store_name'                  => $transaction_info['store_name'],
				'transaction_card'            => $transaction_info['transaction_card'],
				'transaction_card_image'      => $transaction_info['transaction_card_image'] ? $transaction_info['transaction_card_image'] : 'application/view/image/cloud/cloud_credit_card.svg',
				'date_added'                  => date($this->language->get('date_format_short'), strtotime($transaction_info['date_added']))
			);

			$data['support'] = $this->url->link('support/contact', '', true);
			$data['cancel'] = $this->url->link('account/subscription', 'member_token=' . $this->session->data['member_token'], true);

			$data['menu'] = $this->load->controller('account/menu');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('account/subscription_invoice_info', $data));
		} else {
			$this->document->setTitle($this->language->get('heading_invoice_default'));

			$data['menu'] = $this->load->controller('account/menu');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('cloud/invoice_list', $data));
		}
	}

	public function invoiceInfo() {
		$this->invoice();
	}
}

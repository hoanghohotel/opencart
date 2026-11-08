<?php
class ControllerCloudSubscription extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('cloud/subscription');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cloud/subscription');

		$this->getList();
	}

	public function add() {
		$this->load->language('cloud/subscription');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cloud/subscription');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cloud_subscription->addSubscription($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->getFilterUrl();

			$this->response->redirect($this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('cloud/subscription');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cloud/subscription');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cloud_subscription->editSubscription($this->request->get['subscription_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->getFilterUrl();

			$this->response->redirect($this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('cloud/subscription');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cloud/subscription');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $subscription_id) {
				$this->model_cloud_subscription->deleteSubscription($subscription_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->getFilterUrl();

			$this->response->redirect($this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getFilterUrl() {
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . urlencode(html_entity_decode($this->request->get['filter_member'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_subscription_plan_id'])) {
			$url .= '&filter_subscription_plan_id=' . $this->request->get['filter_subscription_plan_id'];
		}

		if (isset($this->request->get['filter_subscription_status_id'])) {
			$url .= '&filter_subscription_status_id=' . $this->request->get['filter_subscription_status_id'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		return $url;
	}

	protected function getList() {
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : '';
		$filter_member = isset($this->request->get['filter_member']) ? $this->request->get['filter_member'] : '';
		$filter_subscription_plan_id = isset($this->request->get['filter_subscription_plan_id']) ? $this->request->get['filter_subscription_plan_id'] : '';
		$filter_subscription_status_id = isset($this->request->get['filter_subscription_status_id']) ? $this->request->get['filter_subscription_status_id'] : '';

		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 's.date_added';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'DESC';
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;

		$url = $this->getFilterUrl();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('cloud/subscription/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('cloud/subscription/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['subscriptions'] = array();

		$filter_data = array(
			'filter_name'                   => $filter_name,
			'filter_member'                 => $filter_member,
			'filter_subscription_plan_id'   => $filter_subscription_plan_id,
			'filter_subscription_status_id' => $filter_subscription_status_id,
			'sort'                          => $sort,
			'order'                         => $order,
			'start'                         => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                         => $this->config->get('config_limit_admin')
		);

		$subscription_total = $this->model_cloud_subscription->getTotalSubscriptions($filter_data);

		$results = $this->model_cloud_subscription->getSubscriptions($filter_data);

		foreach ($results as $result) {
			$data['subscriptions'][] = array(
				'subscription_id' => $result['subscription_id'],
				'name'            => $result['name'],
				'member'          => $result['member_name'] ? $result['member_name'] . ' (' . $result['member_username'] . ')' : 'Member #' . $result['member_id'],
				'plan'            => $result['plan_name'] . ' ($' . number_format((float)$result['plan_price'], 2) . '/mo)',
				'status'          => $result['status_name'],
				'store_status'    => $result['store_status'] ? $this->language->get('text_online') : $this->language->get('text_offline'),
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'            => $this->url->link('cloud/subscription/edit', 'user_token=' . $this->session->data['user_token'] . '&subscription_id=' . $result['subscription_id'] . $url, true)
			);
		}

		$data['subscription_plans'] = $this->model_cloud_subscription->getSubscriptionPlans();
		$data['subscription_statuses'] = $this->model_cloud_subscription->getSubscriptionStatuses();

		$data['user_token'] = $this->session->data['user_token'];

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . urlencode(html_entity_decode($this->request->get['filter_member'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_subscription_plan_id'])) {
			$url .= '&filter_subscription_plan_id=' . $this->request->get['filter_subscription_plan_id'];
		}

		if (isset($this->request->get['filter_subscription_status_id'])) {
			$url .= '&filter_subscription_status_id=' . $this->request->get['filter_subscription_status_id'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . '&sort=s.name' . $url, true);
		$data['sort_member'] = $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . '&sort=member_name' . $url, true);
		$data['sort_plan'] = $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . '&sort=plan_name' . $url, true);
		$data['sort_status'] = $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . '&sort=status_name' . $url, true);
		$data['sort_date_added'] = $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . '&sort=s.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . urlencode(html_entity_decode($this->request->get['filter_member'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_subscription_plan_id'])) {
			$url .= '&filter_subscription_plan_id=' . $this->request->get['filter_subscription_plan_id'];
		}

		if (isset($this->request->get['filter_subscription_status_id'])) {
			$url .= '&filter_subscription_status_id=' . $this->request->get['filter_subscription_status_id'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $subscription_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($subscription_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($subscription_total - $this->config->get('config_limit_admin'))) ? $subscription_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $subscription_total, ceil($subscription_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_member'] = $filter_member;
		$data['filter_subscription_plan_id'] = $filter_subscription_plan_id;
		$data['filter_subscription_status_id'] = $filter_subscription_status_id;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cloud/subscription_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['subscription_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['admin_email'])) {
			$data['error_admin_email'] = $this->error['admin_email'];
		} else {
			$data['error_admin_email'] = '';
		}

		$url = $this->getFilterUrl();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['subscription_id'])) {
			$data['action'] = $this->url->link('cloud/subscription/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('cloud/subscription/edit', 'user_token=' . $this->session->data['user_token'] . '&subscription_id=' . $this->request->get['subscription_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['subscription_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$subscription_info = $this->model_cloud_subscription->getSubscription($this->request->get['subscription_id']);
		}

		$fields = array(
			'member_id'              => 0,
			'subscription_plan_id'   => 1,
			'member_payment_id'      => 0,
			'subscription_status_id' => 1,
			'name'                   => '',
			'admin_email'            => '',
			'admin_username'         => 'admin',
			'store_status'           => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($subscription_info)) {
				$data[$field] = $subscription_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		if (isset($this->request->post['member'])) {
			$data['member'] = $this->request->post['member'];
		} elseif (!empty($subscription_info)) {
			$data['member'] = $subscription_info['member_username'] . ' (' . $subscription_info['member_name'] . ')';
		} else {
			$data['member'] = '';
		}

		$data['subscription_plans'] = $this->model_cloud_subscription->getSubscriptionPlans();
		$data['subscription_statuses'] = $this->model_cloud_subscription->getSubscriptionStatuses();

		if (isset($this->request->get['subscription_id'])) {
			$data['domains'] = $this->model_cloud_subscription->getSubscriptionDomains($this->request->get['subscription_id']);
			$data['histories'] = $this->model_cloud_subscription->getSubscriptionHistories($this->request->get['subscription_id']);
			$data['transactions'] = $this->model_cloud_subscription->getSubscriptionTransactions($this->request->get['subscription_id']);
		} else {
			$data['domains'] = array();
			$data['histories'] = array();
			$data['transactions'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cloud/subscription_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'cloud/subscription')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['admin_email']) > 96) || !filter_var($this->request->post['admin_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['admin_email'] = $this->language->get('error_admin_email');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cloud/subscription')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

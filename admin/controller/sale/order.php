<?php
class ControllerSaleOrder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$this->getList();
	}

	public function add() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_order->addOrder($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_order->editOrder($this->request->get['order_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $order_id) {
				$this->model_sale_order->deleteOrder($order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getList();
	}

	protected function getList() {
		$filter_order_id = isset($this->request->get['filter_order_id']) ? $this->request->get['filter_order_id'] : '';
		$filter_buyer = isset($this->request->get['filter_buyer']) ? $this->request->get['filter_buyer'] : '';
		$filter_seller = isset($this->request->get['filter_seller']) ? $this->request->get['filter_seller'] : '';
		$filter_extension = isset($this->request->get['filter_extension']) ? $this->request->get['filter_extension'] : '';
		$filter_order_status_id = isset($this->request->get['filter_order_status_id']) ? $this->request->get['filter_order_status_id'] : '';
		$filter_total = isset($this->request->get['filter_total']) ? $this->request->get['filter_total'] : '';
		$filter_date_added = isset($this->request->get['filter_date_added']) ? $this->request->get['filter_date_added'] : '';

		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'o.order_id';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'DESC';
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_buyer'])) {
			$url .= '&filter_buyer=' . urlencode(html_entity_decode($this->request->get['filter_buyer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_seller'])) {
			$url .= '&filter_seller=' . urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_extension'])) {
			$url .= '&filter_extension=' . urlencode(html_entity_decode($this->request->get['filter_extension'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('sale/order/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('sale/order/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_buyer'           => $filter_buyer,
			'filter_seller'          => $filter_seller,
			'filter_extension'       => $filter_extension,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_total'           => $filter_total,
			'filter_date_added'      => $filter_date_added,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_sale_order->getTotalOrders($filter_data);

		$results = $this->model_sale_order->getOrders($filter_data);

		foreach ($results as $result) {
			$order_status = $result['order_status'] ? $result['order_status'] : 'Complete';
			$order_status_id = isset($result['order_status_id']) ? (int)$result['order_status_id'] : 5;

			$data['orders'][] = array(
				'order_id'        => $result['order_id'],
				'buyer'           => $result['buyer_name'] ? $result['buyer_name'] . ' (' . $result['buyer_username'] . ')' : 'Member #' . $result['member_id'],
				'seller'          => $result['seller_username'],
				'extension'       => $result['extension'],
				'payment_method'  => $result['payment_method'],
				'order_status_id' => $order_status_id,
				'order_status'    => $order_status,
				'status_class'    => $this->getStatusClass($order_status_id, $order_status),
				'total'           => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'            => $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'] . $url, true),
				'edit'            => $this->url->link('sale/order/edit', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'] . $url, true)
			);
		}

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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_buyer'])) {
			$url .= '&filter_buyer=' . urlencode(html_entity_decode($this->request->get['filter_buyer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_seller'])) {
			$url .= '&filter_seller=' . urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_extension'])) {
			$url .= '&filter_extension=' . urlencode(html_entity_decode($this->request->get['filter_extension'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.order_id' . $url, true);
		$data['sort_buyer'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=buyer_name' . $url, true);
		$data['sort_seller'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=seller_username' . $url, true);
		$data['sort_extension'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.extension' . $url, true);
		$data['sort_status'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=order_status' . $url, true);
		$data['sort_total'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_buyer'])) {
			$url .= '&filter_buyer=' . urlencode(html_entity_decode($this->request->get['filter_buyer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_seller'])) {
			$url .= '&filter_seller=' . urlencode(html_entity_decode($this->request->get['filter_seller'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_extension'])) {
			$url .= '&filter_extension=' . urlencode(html_entity_decode($this->request->get['filter_extension'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_buyer'] = $filter_buyer;
		$data['filter_seller'] = $filter_seller;
		$data['filter_extension'] = $filter_extension;
		$data['filter_order_status_id'] = $filter_order_status_id;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_list', $data));
	}

	public function info() {
		$this->load->language('sale/order');

		$this->load->model('sale/order');

		$order_id = isset($this->request->get['order_id']) ? (int)$this->request->get['order_id'] : 0;

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['order_status_id']) && $this->user->hasPermission('modify', 'sale/order')) {
			$comment = isset($this->request->post['comment']) ? $this->request->post['comment'] : '';
			$this->model_sale_order->updateOrderStatus($order_id, $this->request->post['order_status_id'], $comment);
			$this->session->data['success'] = $this->language->get('text_success_status_email');
			$this->response->redirect($this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id, true));
		}

		$order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
			$this->document->setTitle($this->language->get('heading_title'));

			$data['text_order'] = sprintf($this->language->get('text_order'), $order_info['order_id']);

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true)
			);

			$data['edit'] = $this->url->link('sale/order/edit', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . (int)$order_info['order_id'], true);
			$data['cancel'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true);
			$data['action'] = $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . (int)$order_info['order_id'], true);

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];
				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['order_id'] = $order_info['order_id'];
			$data['buyer_name'] = $order_info['buyer_name'];
			$data['buyer_username'] = $order_info['buyer_username'];
			$data['buyer_email'] = $order_info['buyer_email'];
			$data['buyer_href'] = $this->url->link('member/member/edit', 'user_token=' . $this->session->data['user_token'] . '&member_id=' . $order_info['member_id'], true);

			$data['seller_name'] = $order_info['seller_name'];
			$data['seller_username'] = $order_info['seller_username'];
			$data['seller_href'] = $this->url->link('member/member/edit', 'user_token=' . $this->session->data['user_token'] . '&member_id=' . $order_info['seller_id'], true);

			$data['extension'] = $order_info['extension'];
			$data['extension_href'] = $this->url->link('marketplace/extension/edit', 'user_token=' . $this->session->data['user_token'] . '&extension_id=' . $order_info['extension_id'], true);
			$data['quantity'] = $order_info['quantity'];
			$data['price'] = $this->currency->format($order_info['price'], $this->config->get('config_currency'));
			$data['total'] = $this->currency->format($order_info['total'], $this->config->get('config_currency'));
			$data['payment_method'] = $order_info['payment_method'];
			$data['transaction_id'] = $order_info['transaction_id'];
			$data['order_status_id'] = $order_info['order_status_id'];
			$data['order_status'] = $order_info['order_status'] ? $order_info['order_status'] : 'Complete';
			$data['status_class'] = $this->getStatusClass((int)$order_info['order_status_id'], $data['order_status']);
			$data['ip'] = $order_info['ip'];
			$data['date_added'] = date($this->language->get('datetime_format'), strtotime($order_info['date_added']));

			$this->load->model('localisation/order_status');
			$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('sale/order_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['order_id'])) {
			$data['action'] = $this->url->link('sale/order/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('sale/order/edit', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $this->request->get['order_id'], true);
		}

		$data['cancel'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		}

		$fields = array(
			'member_id'       => 1,
			'seller_id'       => 2,
			'extension_id'    => 101,
			'extension'       => 'SEO Pack Pro - Complete SEO Suite',
			'quantity'        => 1,
			'price'           => '79.99',
			'total'           => '79.99',
			'payment_method'  => 'PayPal',
			'transaction_id'  => '',
			'order_status_id' => 5
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($order_info)) {
				$data[$field] = $order_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$member_query = $this->db->query("SELECT member_id, username, firstname, lastname FROM `" . DB_PREFIX . "member` ORDER BY username ASC");
		$data['members'] = $member_query->rows;

		$ext_query = $this->db->query("SELECT extension_id, name, price, member_id FROM `" . DB_PREFIX . "extension` ORDER BY name ASC");
		$data['extensions'] = $ext_query->rows;

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function getStatusClass($order_status_id, $order_status = '') {
		$status_lower = strtolower(trim((string)$order_status));
		$id = (int)$order_status_id;

		if ($id === 5 || strpos($status_lower, 'complete') !== false || strpos($status_lower, 'shipped') !== false || strpos($status_lower, 'delivered') !== false) {
			return 'label-success';
		}

		if ($id === 3 || strpos($status_lower, 'paid') !== false) {
			return 'label-primary';
		}

		if ($id === 2 || $id === 15 || strpos($status_lower, 'process') !== false) {
			return 'label-info';
		}

		if ($id === 1 || $id === 9 || strpos($status_lower, 'pending') !== false || strpos($status_lower, 'reversal') !== false) {
			return 'label-warning';
		}

		if (in_array($id, array(7, 8, 10, 12, 13), true) || strpos($status_lower, 'cancel') !== false || strpos($status_lower, 'fail') !== false || strpos($status_lower, 'denied') !== false || strpos($status_lower, 'chargeback') !== false || strpos($status_lower, 'revers') !== false) {
			return 'label-danger';
		}

		if (in_array($id, array(11, 14, 16), true) || strpos($status_lower, 'refund') !== false || strpos($status_lower, 'void') !== false || strpos($status_lower, 'expir') !== false) {
			return 'label-default';
		}

		return 'label-info';
	}
}

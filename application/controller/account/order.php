<?php
class ControllerAccountOrder extends Controller {
	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/order');

		$this->document->setTitle($this->language->get('heading_title'));

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

		$data['config_download_status_id'] = (int)$this->config->get('config_download_status_id');
		$data['config_order_status_id'] = (int)$this->config->get('config_order_status_id');

		$this->load->model('account/order');
		$this->load->model('localisation/order_status');

		$order_statuses = array();
		foreach ($this->model_localisation_order_status->getOrderStatuses() as $os) {
			$order_statuses[$os['order_status_id']] = $os['name'];
		}

		$data['orders'] = array();

		$filter_data = array(
			'member_id' => $this->member->getId(),
			'start'     => ($page - 1) * $limit,
			'limit'     => $limit
		);

		$order_total = $this->model_account_order->getTotalOrders($filter_data);

		$ref = new ReflectionMethod('ModelAccountOrder', 'getOrders');
		if ($ref->getNumberOfParameters() >= 2) {
			$results = $this->model_account_order->getOrders($this->member->getId(), ($page - 1) * $limit, $limit);
		} else {
			$results = $this->model_account_order->getOrders($filter_data);
		}

		foreach ($results as $result) {
			$status_name = !empty($result['status']) ? $result['status'] : (!empty($result['order_status']) ? $result['order_status'] : (isset($order_statuses[$result['order_status_id']]) ? $order_statuses[$result['order_status_id']] : $this->language->get('text_complete')));

			$data['orders'][] = array(
				'order_id'        => $result['order_id'],
				'extension'       => $result['extension'],
				'total'           => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'order_status_id' => (int)$result['order_status_id'],
				'status'          => $status_name,
				'date_added'      => date('d M Y', strtotime($result['date_added'])),
				'href'            => $this->url->link('account/order/info', $token . '&order_id=' . $result['order_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/order', $token . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/order_list', $data));
	}

	public function info() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = (int)$this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id, $this->member->getId());

		if ($order_info && (int)$order_info['member_id'] === (int)$this->member->getId()) {
			$this->document->setTitle(sprintf($this->language->get('text_order_info'), $order_info['order_id']));

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['title'] = sprintf($this->language->get('text_order_info'), $order_info['order_id']);
			$data['logo'] = $this->config->get('config_name');

			$data['company'] = $this->member->getCompany();
			$data['firstname'] = $this->member->getFirstName();
			$data['lastname'] = $this->member->getLastName();
			$data['address_1'] = isset($order_info['address_1']) ? $order_info['address_1'] : '';
			$data['address_2'] = isset($order_info['address_2']) ? $order_info['address_2'] : '';
			$data['city'] = isset($order_info['city']) ? $order_info['city'] : '';
			$data['postcode'] = isset($order_info['postcode']) ? $order_info['postcode'] : '';
			$data['zone'] = isset($order_info['zone']) ? $order_info['zone'] : '';

			$this->load->model('localisation/country');
			$country_info = $this->model_localisation_country->getCountry($this->member->getCountryId());
			$data['country'] = $country_info ? $country_info['name'] : '';

			$data['tax'] = $this->member->getTaxId();

			$data['order_id'] = $order_info['order_id'];
			$data['date_added'] = date('d M Y', strtotime($order_info['date_added']));
			$data['username'] = $this->member->getUsername();
			$data['payment_method'] = $order_info['payment_method'];
			$data['transaction_id'] = $order_info['transaction_id'];
			$data['extension_id'] = $order_info['extension_id'];
			$data['extension'] = $order_info['extension'];
			$data['price'] = $this->currency->format($order_info['price'], $this->config->get('config_currency'));
			$data['quantity'] = (int)$order_info['quantity'];
			$data['total'] = $this->currency->format($order_info['total'], $this->config->get('config_currency'));

			$data['support'] = $this->url->link('support/contact', '', true);
			$data['cancel'] = $this->url->link('account/order', 'member_token=' . $this->session->data['member_token'], true);

			$data['menu'] = $this->load->controller('account/menu');
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('account/order_info', $data));
		} else {
			$this->response->redirect($this->url->link('account/order', 'member_token=' . $this->session->data['member_token'], true));
		}
	}
}

<?php
class ControllerAccountSale extends Controller {
	public function index() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/sale', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('Your Sales');

		$this->load->model('account/order');

		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = '';
		}

		if (isset($this->request->get['filter_extension'])) {
			$filter_extension = $this->request->get['filter_extension'];
		} else {
			$filter_extension = '';
		}

		if (isset($this->request->get['filter_member'])) {
			$filter_member = $this->request->get['filter_member'];
		} else {
			$filter_member = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = '';
		}

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . urlencode(html_entity_decode($this->request->get['filter_order_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_extension'])) {
			$url .= '&filter_extension=' . urlencode(html_entity_decode($this->request->get['filter_extension'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . urlencode(html_entity_decode($this->request->get['filter_member'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . urlencode(html_entity_decode($this->request->get['filter_order_status_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . urlencode(html_entity_decode($this->request->get['filter_date_start'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . urlencode(html_entity_decode($this->request->get['filter_date_end'], ENT_QUOTES, 'UTF-8'));
		}

		$data['sales'] = array();

		$filter_data = array(
			'seller_id'              => $this->member->getId(),
			'filter_order_id'        => $filter_order_id,
			'filter_extension'       => $filter_extension,
			'filter_member'          => $filter_member,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_date_start'      => $filter_date_start,
			'filter_date_end'        => $filter_date_end,
			'start'                  => ($page - 1) * 10,
			'limit'                  => 10
		);

		if ($filter_extension !== '' || $filter_member !== '' || $filter_date_start !== '' || $filter_date_end !== '') {
			$sale_total = $this->getFilteredTotalSales($filter_data);
			$results = $this->getFilteredSales($filter_data);
		} else {
			$sale_total = $this->model_account_order->getTotalSales($filter_data);
			$results = $this->model_account_order->getSales($filter_data);
		}

		foreach ($results as $result) {
			$data['sales'][] = array(
				'order_id'        => $result['order_id'],
				'extension'       => $result['extension'],
				'buyer'           => isset($result['username']) && $result['username'] ? $result['username'] : (isset($result['member']) ? $result['member'] : ''),
				'order_status_id' => $result['order_status_id'],
				'order_status'    => $result['status'],
				'total'           => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$status_query = $this->db->query("SELECT order_status_id, name FROM `" . DB_PREFIX . "order_status` WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name ASC");
		$data['order_statuses'] = $status_query->rows;

		$data['config_download_status_id'] = $this->config->get('config_download_status_id') ? $this->config->get('config_download_status_id') : ($this->config->get('config_complete_status_id') ? $this->config->get('config_complete_status_id') : 5);
		$data['config_order_status_id'] = $this->config->get('config_order_status_id') ? $this->config->get('config_order_status_id') : 1;

		$pagination = new Pagination();
		$pagination->total = $sale_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/sale', 'member_token=' . $this->session->data['member_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_extension'] = $filter_extension;
		$data['filter_member'] = $filter_member;
		$data['filter_order_status_id'] = $filter_order_status_id;
		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;

		$data['member_token'] = $this->session->data['member_token'];

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/sale', $data));
	}

	public function export() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/sale', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$filter_data = array(
			'seller_id'              => $this->member->getId(),
			'filter_order_id'        => isset($this->request->get['filter_order_id']) ? $this->request->get['filter_order_id'] : '',
			'filter_extension'       => isset($this->request->get['filter_extension']) ? $this->request->get['filter_extension'] : '',
			'filter_member'          => isset($this->request->get['filter_member']) ? $this->request->get['filter_member'] : '',
			'filter_order_status_id' => isset($this->request->get['filter_order_status_id']) ? $this->request->get['filter_order_status_id'] : '',
			'filter_date_start'      => isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : '',
			'filter_date_end'        => isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : ''
		);

		$results = $this->getFilteredSales($filter_data);

		$output = fopen('php://temp', 'r+');
		fputcsv($output, array('Order ID', 'Extension', 'Buyer', 'Order Status', 'Total', 'Date Added'));

		foreach ($results as $result) {
			fputcsv($output, array(
				$result['order_id'],
				$result['extension'],
				isset($result['username']) ? $result['username'] : '',
				$result['status'],
				$this->currency->format($result['total'], $this->config->get('config_currency')),
				date($this->language->get('date_format_short'), strtotime($result['date_added']))
			));
		}

		rewind($output);
		$csv = stream_get_contents($output);
		fclose($output);

		$this->response->addHeader('Content-Type: text/csv; charset=utf-8');
		$this->response->addHeader('Content-Disposition: attachment; filename="sales_' . date('Y-m-d') . '.csv"');
		$this->response->setOutput($csv);
	}

	protected function getFilteredSales($data = array()) {
		$sql = "SELECT o.*, m.username, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` m ON (o.member_id = m.member_id) WHERE o.seller_id = '" . (int)$this->member->getId() . "'";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		if (!empty($data['filter_member'])) {
			$sql .= " AND m.username LIKE '%" . $this->db->escape($data['filter_member']) . "%'";
		}

		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "')";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "')";
		}

		$sql .= " ORDER BY o.date_added DESC, o.order_id DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			$start = isset($data['start']) && $data['start'] >= 0 ? (int)$data['start'] : 0;
			$limit = isset($data['limit']) && $data['limit'] >= 1 ? (int)$data['limit'] : 10;

			$sql .= " LIMIT " . $start . "," . $limit;
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	protected function getFilteredTotalSales($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` m ON (o.member_id = m.member_id) WHERE o.seller_id = '" . (int)$this->member->getId() . "'";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		if (!empty($data['filter_member'])) {
			$sql .= " AND m.username LIKE '%" . $this->db->escape($data['filter_member']) . "%'";
		}

		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "')";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "')";
		}

		$query = $this->db->query($sql);

		return (int)$query->row['total'];
	}
}

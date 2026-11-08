<?php
class ModelSaleOrder extends Model {
	public function addOrder($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET member_id = '" . (int)$data['member_id'] . "', seller_id = '" . (int)$data['seller_id'] . "', extension_id = '" . (int)$data['extension_id'] . "', extension = '" . $this->db->escape($data['extension']) . "', quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', ip = '127.0.0.1', date_added = NOW(), date_modified = NOW()");

		return $this->db->getLastId();
	}

	public function editOrder($order_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET member_id = '" . (int)$data['member_id'] . "', seller_id = '" . (int)$data['seller_id'] . "', extension_id = '" . (int)$data['extension_id'] . "', extension = '" . $this->db->escape($data['extension']) . "', quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	}

	public function updateOrderStatus($order_id, $order_status_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	}

	public function deleteOrder($order_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
	}

	public function getOrder($order_id) {
		$query = $this->db->query("SELECT o.*, mb.username AS buyer_username, CONCAT(mb.firstname, ' ', mb.lastname) AS buyer_name, mb.email AS buyer_email, ms.username AS seller_username, CONCAT(ms.firstname, ' ', ms.lastname) AS seller_name, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` mb ON (o.member_id = mb.member_id) LEFT JOIN `" . DB_PREFIX . "member` ms ON (o.seller_id = ms.member_id) WHERE o.order_id = '" . (int)$order_id . "'");

		return $query->row;
	}

	public function getOrders($data = array()) {
		$sql = "SELECT o.*, mb.username AS buyer_username, CONCAT(mb.firstname, ' ', mb.lastname) AS buyer_name, ms.username AS seller_username, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` mb ON (o.member_id = mb.member_id) LEFT JOIN `" . DB_PREFIX . "member` ms ON (o.seller_id = ms.member_id) WHERE 1=1";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_buyer'])) {
			$buyer_kw = $this->db->escape($data['filter_buyer']);
			$sql .= " AND (CONCAT(mb.firstname, ' ', mb.lastname) LIKE '%" . $buyer_kw . "%' OR mb.username LIKE '%" . $buyer_kw . "%' OR mb.email LIKE '%" . $buyer_kw . "%')";
		}

		if (!empty($data['filter_seller'])) {
			$seller_kw = $this->db->escape($data['filter_seller']);
			$sql .= " AND (CONCAT(ms.firstname, ' ', ms.lastname) LIKE '%" . $seller_kw . "%' OR ms.username LIKE '%" . $seller_kw . "%')";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'o.order_id',
			'buyer_name',
			'seller_username',
			'o.extension',
			'order_status',
			'o.total',
			'o.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` mb ON (o.member_id = mb.member_id) LEFT JOIN `" . DB_PREFIX . "member` ms ON (o.seller_id = ms.member_id) WHERE 1=1";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_buyer'])) {
			$buyer_kw = $this->db->escape($data['filter_buyer']);
			$sql .= " AND (CONCAT(mb.firstname, ' ', mb.lastname) LIKE '%" . $buyer_kw . "%' OR mb.username LIKE '%" . $buyer_kw . "%' OR mb.email LIKE '%" . $buyer_kw . "%')";
		}

		if (!empty($data['filter_seller'])) {
			$seller_kw = $this->db->escape($data['filter_seller']);
			$sql .= " AND (CONCAT(ms.firstname, ' ', ms.lastname) LIKE '%" . $seller_kw . "%' OR ms.username LIKE '%" . $seller_kw . "%')";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "'");

		return $query->row['total'];
	}
}

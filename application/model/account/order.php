<?php
class ModelAccountOrder extends Model {
	public function addOrder($data) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();
		$extension_id = isset($data['extension_id']) ? (int)$data['extension_id'] : 0;
		$seller_id = isset($data['seller_id']) ? (int)$data['seller_id'] : 0;
		$extension_name = isset($data['extension']) ? $data['extension'] : '';
		$price = isset($data['price']) ? (float)$data['price'] : 0.0;

		if ($extension_id && (!$seller_id || !$extension_name)) {
			$ext_query = $this->db->query("SELECT member_id, name, price FROM `" . DB_PREFIX . "extension` WHERE extension_id = '" . (int)$extension_id . "'");
			if ($ext_query->num_rows) {
				if (!$seller_id) {
					$seller_id = (int)$ext_query->row['member_id'];
				}
				if (!$extension_name) {
					$extension_name = $ext_query->row['name'];
				}
				if (!$price) {
					$price = (float)$ext_query->row['price'];
				}
			}
		}

		$quantity = isset($data['quantity']) && (int)$data['quantity'] > 0 ? (int)$data['quantity'] : 1;
		$total = isset($data['total']) ? (float)$data['total'] : ($price * $quantity);
		$payment_method = isset($data['payment_method']) ? $data['payment_method'] : 'PayPal';
		$transaction_id = isset($data['transaction_id']) ? $data['transaction_id'] : token(16);
		$order_status_id = isset($data['order_status_id']) ? (int)$data['order_status_id'] : (int)($this->config->get('config_complete_status_id') ? $this->config->get('config_complete_status_id') : 5);
		$ip = isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '';

		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET member_id = '" . (int)$member_id . "', seller_id = '" . (int)$seller_id . "', extension_id = '" . (int)$extension_id . "', extension = '" . $this->db->escape($extension_name) . "', quantity = '" . (int)$quantity . "', price = '" . (float)$price . "', total = '" . (float)$total . "', payment_method = '" . $this->db->escape($payment_method) . "', transaction_id = '" . $this->db->escape($transaction_id) . "', order_status_id = '" . (int)$order_status_id . "', ip = '" . $this->db->escape($ip) . "', date_added = NOW(), date_modified = NOW()");

		$order_id = $this->db->getLastId();

		if ($order_status_id == 5 || $order_status_id == (int)$this->config->get('config_complete_status_id')) {
			$this->db->query("UPDATE `" . DB_PREFIX . "extension` SET sales = (sales + " . (int)$quantity . ") WHERE extension_id = '" . (int)$extension_id . "'");

			if ($seller_id && $total > 0) {
				$seller_query = $this->db->query("SELECT commission FROM `" . DB_PREFIX . "member_seller` WHERE member_id = '" . (int)$seller_id . "'");
				$commission_rate = $seller_query->num_rows && $seller_query->row['commission'] > 0 ? (float)$seller_query->row['commission'] : 70.0;
				$seller_amount = round($total * ($commission_rate / 100), 2);

				$this->db->query("INSERT INTO `" . DB_PREFIX . "member_transaction` SET member_id = '" . (int)$seller_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape('Order #' . $order_id . ' - ' . $extension_name) . "', amount = '" . (float)$seller_amount . "', date_added = NOW()");
			}
		}

		$this->load->controller('mail/order', array('order_id' => $order_id, 'status' => true));

		return $order_id;
	}

	public function editOrderStatus($order_id, $order_status_id, $transaction_id = '') {
		$sql = "UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "'";

		if ($transaction_id) {
			$sql .= ", transaction_id = '" . $this->db->escape($transaction_id) . "'";
		}

		$sql .= ", date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'";

		$this->db->query($sql);

		$this->load->controller('mail/order', array('order_id' => $order_id, 'status' => false));
	}

	public function getOrder($order_id) {
		$query = $this->db->query("SELECT o.*, e.image, e.license_period, m.username AS buyer_username, m.firstname, m.lastname, m.email AS buyer_email, m.company, c.name AS country, s.username AS seller_username, (SELECT ms.support_email FROM `" . DB_PREFIX . "member_seller` ms WHERE ms.member_id = o.seller_id LIMIT 1) AS support_email, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "extension` e ON (o.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (o.member_id = m.member_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (m.country_id = c.country_id) LEFT JOIN `" . DB_PREFIX . "member` s ON (o.seller_id = s.member_id) WHERE o.order_id = '" . (int)$order_id . "'");

		return $query->row;
	}

	public function getOrders($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$sql = "SELECT o.*, e.image, e.license_period, s.username AS seller_username, (SELECT ms.support_email FROM `" . DB_PREFIX . "member_seller` ms WHERE ms.member_id = o.seller_id LIMIT 1) AS support_email, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "extension` e ON (o.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` s ON (o.seller_id = s.member_id) WHERE o.member_id = '" . (int)$member_id . "'";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		$sql .= " ORDER BY o.date_added DESC, o.order_id DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE o.member_id = '" . (int)$member_id . "'";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getSale($order_id) {
		$query = $this->db->query("SELECT o.*, e.image, m.username AS member, m.username, m.firstname, m.lastname, m.email, m.company, c.name AS country, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, (SELECT mt.amount FROM `" . DB_PREFIX . "member_transaction` mt WHERE mt.order_id = o.order_id AND mt.member_id = o.seller_id LIMIT 1) AS commission_amount FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "extension` e ON (o.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (o.member_id = m.member_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (m.country_id = c.country_id) WHERE o.order_id = '" . (int)$order_id . "' AND o.seller_id = '" . (int)$this->member->getId() . "'");

		return $query->row;
	}

	public function getSales($data = array()) {
		$seller_id = isset($data['seller_id']) ? (int)$data['seller_id'] : (int)$this->member->getId();

		$sql = "SELECT o.*, e.image, m.username AS member, m.username, m.firstname, m.lastname, m.email, c.name AS country, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "extension` e ON (o.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (o.member_id = m.member_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (m.country_id = c.country_id) WHERE o.seller_id = '" . (int)$seller_id . "'";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_extension_id'])) {
			$sql .= " AND o.extension_id = '" . (int)$data['filter_extension_id'] . "'";
		}

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sql .= " ORDER BY o.date_added DESC, o.order_id DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalSales($data = array()) {
		$seller_id = isset($data['seller_id']) ? (int)$data['seller_id'] : (int)$this->member->getId();

		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE o.seller_id = '" . (int)$seller_id . "'";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_extension_id'])) {
			$sql .= " AND o.extension_id = '" . (int)$data['filter_extension_id'] . "'";
		}

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function hasPurchasedExtension($extension_id, $member_id = 0) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		if (!$member_id) {
			return false;
		}

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE member_id = '" . (int)$member_id . "' AND extension_id = '" . (int)$extension_id . "' AND order_status_id IN ('5', '" . (int)$this->config->get('config_complete_status_id') . "')");

		return $query->row['total'] > 0;
	}

	public function getPurchasedExtensions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$sql = "SELECT DISTINCT e.*, o.order_id, o.date_added AS order_date_added, m.username AS seller_username FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "extension` e ON (o.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) WHERE o.member_id = '" . (int)$member_id . "' AND o.order_status_id IN ('5', '" . (int)$this->config->get('config_complete_status_id') . "') GROUP BY e.extension_id ORDER BY o.date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalPurchasedExtensions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$query = $this->db->query("SELECT COUNT(DISTINCT o.extension_id) AS total FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "extension` e ON (o.extension_id = e.extension_id) WHERE o.member_id = '" . (int)$member_id . "' AND o.order_status_id IN ('5', '" . (int)$this->config->get('config_complete_status_id') . "')");

		return $query->row['total'];
	}
}

<?php
class ModelCloudSubscription extends Model {
	public function addSubscription($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "subscription` SET member_id = '" . (int)$data['member_id'] . "', subscription_plan_id = '" . (int)$data['subscription_plan_id'] . "', member_payment_id = '" . (int)($data['member_payment_id'] ?? 0) . "', subscription_status_id = '" . (int)$data['subscription_status_id'] . "', name = '" . $this->db->escape($data['name']) . "', admin_email = '" . $this->db->escape($data['admin_email']) . "', admin_username = '" . $this->db->escape($data['admin_username']) . "', store_status = '" . (int)$data['store_status'] . "', date_added = NOW(), date_modified = NOW()");

		return $this->db->getLastId();
	}

	public function editSubscription($subscription_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "subscription` SET member_id = '" . (int)$data['member_id'] . "', subscription_plan_id = '" . (int)$data['subscription_plan_id'] . "', member_payment_id = '" . (int)($data['member_payment_id'] ?? 0) . "', subscription_status_id = '" . (int)$data['subscription_status_id'] . "', name = '" . $this->db->escape($data['name']) . "', admin_email = '" . $this->db->escape($data['admin_email']) . "', admin_username = '" . $this->db->escape($data['admin_username']) . "', store_status = '" . (int)$data['store_status'] . "', date_modified = NOW() WHERE subscription_id = '" . (int)$subscription_id . "'");
	}

	public function deleteSubscription($subscription_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "subscription` WHERE subscription_id = '" . (int)$subscription_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "subscription_domain` WHERE subscription_id = '" . (int)$subscription_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "subscription_history` WHERE subscription_id = '" . (int)$subscription_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "subscription_transaction` WHERE subscription_id = '" . (int)$subscription_id . "'");
	}

	public function getSubscription($subscription_id) {
		$query = $this->db->query("SELECT s.*, sp.name AS plan_name, sp.price AS plan_price, ss.name AS status_name, m.username AS member_username, CONCAT(m.firstname, ' ', m.lastname) AS member_name, m.email AS member_email FROM `" . DB_PREFIX . "subscription` s LEFT JOIN `" . DB_PREFIX . "subscription_plan` sp ON (s.subscription_plan_id = sp.subscription_plan_id) LEFT JOIN `" . DB_PREFIX . "subscription_status` ss ON (s.subscription_status_id = ss.subscription_status_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (s.member_id = m.member_id) WHERE s.subscription_id = '" . (int)$subscription_id . "'");

		return $query->row;
	}

	public function getSubscriptions($data = array()) {
		$sql = "SELECT s.*, sp.name AS plan_name, sp.price AS plan_price, ss.name AS status_name, m.username AS member_username, CONCAT(m.firstname, ' ', m.lastname) AS member_name FROM `" . DB_PREFIX . "subscription` s LEFT JOIN `" . DB_PREFIX . "subscription_plan` sp ON (s.subscription_plan_id = sp.subscription_plan_id) LEFT JOIN `" . DB_PREFIX . "subscription_status` ss ON (s.subscription_status_id = ss.subscription_status_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (s.member_id = m.member_id) WHERE 1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND s.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_member'])) {
			$sql .= " AND (m.username LIKE '%" . $this->db->escape($data['filter_member']) . "%' OR CONCAT(m.firstname, ' ', m.lastname) LIKE '%" . $this->db->escape($data['filter_member']) . "%')";
		}

		if (!empty($data['filter_subscription_plan_id'])) {
			$sql .= " AND s.subscription_plan_id = '" . (int)$data['filter_subscription_plan_id'] . "'";
		}

		if (!empty($data['filter_subscription_status_id'])) {
			$sql .= " AND s.subscription_status_id = '" . (int)$data['filter_subscription_status_id'] . "'";
		}

		$sort_data = array(
			's.subscription_id',
			's.name',
			'member_name',
			'plan_name',
			'status_name',
			's.store_status',
			's.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY s.date_added";
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

	public function getTotalSubscriptions($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscription` s LEFT JOIN `" . DB_PREFIX . "member` m ON (s.member_id = m.member_id) WHERE 1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND s.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_member'])) {
			$sql .= " AND (m.username LIKE '%" . $this->db->escape($data['filter_member']) . "%' OR CONCAT(m.firstname, ' ', m.lastname) LIKE '%" . $this->db->escape($data['filter_member']) . "%')";
		}

		if (!empty($data['filter_subscription_plan_id'])) {
			$sql .= " AND s.subscription_plan_id = '" . (int)$data['filter_subscription_plan_id'] . "'";
		}

		if (!empty($data['filter_subscription_status_id'])) {
			$sql .= " AND s.subscription_status_id = '" . (int)$data['filter_subscription_status_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getSubscriptionPlans() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_plan` ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getSubscriptionStatuses() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_status` ORDER BY subscription_status_id ASC");

		return $query->rows;
	}

	public function getSubscriptionDomains($subscription_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_domain` WHERE subscription_id = '" . (int)$subscription_id . "' ORDER BY date_added DESC");

		return $query->rows;
	}

	public function getSubscriptionHistories($subscription_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_history` WHERE subscription_id = '" . (int)$subscription_id . "' ORDER BY date_added DESC");

		return $query->rows;
	}

	public function getSubscriptionTransactions($subscription_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_transaction` WHERE subscription_id = '" . (int)$subscription_id . "' ORDER BY date_added DESC");

		return $query->rows;
	}
}

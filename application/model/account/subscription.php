<?php
class ModelAccountSubscription extends Model {
	public function getSubscriptionPlan($subscription_plan_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_plan` WHERE subscription_plan_id = '" . (int)$subscription_plan_id . "' AND status = '1'");

		return $query->row;
	}

	public function getSubscriptionPlans() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_plan` WHERE status = '1' ORDER BY sort_order ASC, subscription_plan_id ASC");

		return $query->rows;
	}

	public function getSubscriptionStatus($subscription_status_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_status` WHERE subscription_status_id = '" . (int)$subscription_status_id . "'");

		return $query->row;
	}

	public function getSubscriptionStatuses() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_status` ORDER BY subscription_status_id ASC");

		return $query->rows;
	}

	public function addSubscription($data) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();
		$subscription_plan_id = isset($data['subscription_plan_id']) ? (int)$data['subscription_plan_id'] : 1;
		$member_payment_id = isset($data['member_payment_id']) ? (int)$data['member_payment_id'] : 0;
		$subscription_status_id = isset($data['subscription_status_id']) ? (int)$data['subscription_status_id'] : 1;
		$name = isset($data['name']) ? $data['name'] : '';
		$admin_email = isset($data['admin_email']) ? $data['admin_email'] : $this->member->getEmail();
		$admin_username = isset($data['admin_username']) ? $data['admin_username'] : 'admin';

		$this->db->query("INSERT INTO `" . DB_PREFIX . "subscription` SET member_id = '" . (int)$member_id . "', subscription_plan_id = '" . (int)$subscription_plan_id . "', member_payment_id = '" . (int)$member_payment_id . "', subscription_status_id = '" . (int)$subscription_status_id . "', name = '" . $this->db->escape($name) . "', admin_email = '" . $this->db->escape($admin_email) . "', admin_username = '" . $this->db->escape($admin_username) . "', store_status = 'Active', date_added = NOW(), date_modified = NOW()");

		$subscription_id = $this->db->getLastId();

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET cloud = '1' WHERE member_id = '" . (int)$member_id . "'");

		$this->addSubscriptionHistory($subscription_id, 'Active', 'Cloud store subscription created.');

		$plan = $this->getSubscriptionPlan($subscription_plan_id);
		$price = $plan ? (float)$plan['price'] : 0.0;

		$card_name = 'Credit Card';
		$card_image = 'application/view/image/cloud/cloud_credit_card.svg';
		if ($member_payment_id) {
			$payment_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_payment` WHERE member_payment_id = '" . (int)$member_payment_id . "' AND member_id = '" . (int)$member_id . "'");
			if ($payment_query->num_rows) {
				$card_name = $payment_query->row['name'];
				$card_image = $payment_query->row['image'];
			}
		}

		$this->addSubscriptionTransaction($subscription_id, array(
			'member_id'              => $member_id,
			'transaction_id'         => strtoupper(token(12)),
			'amount'                 => $price,
			'store_name'             => $name,
			'transaction_card'       => $card_name,
			'transaction_card_image' => $card_image
		));

		return $subscription_id;
	}

	public function editSubscription($subscription_id, $data) {
		$sql = "UPDATE `" . DB_PREFIX . "subscription` SET date_modified = NOW()";

		if (isset($data['subscription_plan_id'])) {
			$sql .= ", subscription_plan_id = '" . (int)$data['subscription_plan_id'] . "'";
		}

		if (isset($data['member_payment_id'])) {
			$sql .= ", member_payment_id = '" . (int)$data['member_payment_id'] . "'";
		}

		if (isset($data['subscription_status_id'])) {
			$sql .= ", subscription_status_id = '" . (int)$data['subscription_status_id'] . "'";
		}

		if (isset($data['name'])) {
			$sql .= ", name = '" . $this->db->escape($data['name']) . "'";
		}

		if (isset($data['admin_email'])) {
			$sql .= ", admin_email = '" . $this->db->escape($data['admin_email']) . "'";
		}

		if (isset($data['admin_username'])) {
			$sql .= ", admin_username = '" . $this->db->escape($data['admin_username']) . "'";
		}

		if (isset($data['store_status'])) {
			$sql .= ", store_status = '" . $this->db->escape($data['store_status']) . "'";
		}

		$sql .= " WHERE subscription_id = '" . (int)$subscription_id . "' AND member_id = '" . (int)$this->member->getId() . "'";

		$this->db->query($sql);
	}

	public function editSubscriptionPlan($subscription_id, $subscription_plan_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "subscription` SET subscription_plan_id = '" . (int)$subscription_plan_id . "', date_modified = NOW() WHERE subscription_id = '" . (int)$subscription_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		$plan = $this->getSubscriptionPlan($subscription_plan_id);
		if ($plan) {
			$this->addSubscriptionHistory($subscription_id, 'Plan Updated', 'Changed plan to ' . $plan['name']);
		}
	}

	public function editSubscriptionPayment($subscription_id, $member_payment_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "subscription` SET member_payment_id = '" . (int)$member_payment_id . "', date_modified = NOW() WHERE subscription_id = '" . (int)$subscription_id . "' AND member_id = '" . (int)$this->member->getId() . "'");
		$this->addSubscriptionHistory($subscription_id, 'Payment Updated', 'Updated payment method.');
	}

	public function cancelSubscription($subscription_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "subscription` SET subscription_status_id = '3', store_status = 'Cancelled', date_modified = NOW() WHERE subscription_id = '" . (int)$subscription_id . "' AND member_id = '" . (int)$this->member->getId() . "'");
		$this->addSubscriptionHistory($subscription_id, 'Cancelled', 'Subscription cancelled by member.');
	}

	public function getSubscription($subscription_id) {
		$query = $this->db->query("SELECT s.*, sp.name AS plan_name, sp.description AS plan_description, sp.price AS plan_price, ss.name AS status_name, mp.type AS payment_type, mp.name AS payment_name, mp.image AS payment_image, mp.date_expire AS payment_date_expire FROM `" . DB_PREFIX . "subscription` s LEFT JOIN `" . DB_PREFIX . "subscription_plan` sp ON (s.subscription_plan_id = sp.subscription_plan_id) LEFT JOIN `" . DB_PREFIX . "subscription_status` ss ON (s.subscription_status_id = ss.subscription_status_id) LEFT JOIN `" . DB_PREFIX . "member_payment` mp ON (s.member_payment_id = mp.member_payment_id) WHERE s.subscription_id = '" . (int)$subscription_id . "' AND s.member_id = '" . (int)$this->member->getId() . "'");

		if (!$query->num_rows) {
			return array();
		}

		$row = $query->row;
		$formatted_price = $this->currency->format($row['plan_price'], $this->config->get('config_currency'));

		$row['subscription_store'] = array(
			'name'           => $row['name'],
			'admin_email'    => $row['admin_email'],
			'admin_username' => $row['admin_username'],
			'store_status'   => $row['store_status']
		);

		$row['subscription_plan'] = array(
			'subscription_plan_id' => $row['subscription_plan_id'],
			'name'                 => $row['plan_name'],
			'description'          => $row['plan_description'],
			'price'                => $formatted_price
		);

		$row['subscription_payment'] = array(
			'member_payment_id' => $row['member_payment_id'],
			'type'              => $row['payment_type'] ? $row['payment_type'] : 'Credit Card',
			'name'              => $row['payment_name'] ? $row['payment_name'] : 'Default Payment',
			'image'             => $row['payment_image'] ? $row['payment_image'] : 'application/view/image/cloud/cloud_credit_card.svg',
			'date_expire'       => $row['payment_date_expire']
		);

		return $row;
	}

	public function getSubscriptions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$sql = "SELECT s.*, sp.name AS plan_name, sp.price AS plan_price, ss.name AS status_name, mp.name AS payment_name, mp.image AS payment_image FROM `" . DB_PREFIX . "subscription` s LEFT JOIN `" . DB_PREFIX . "subscription_plan` sp ON (s.subscription_plan_id = sp.subscription_plan_id) LEFT JOIN `" . DB_PREFIX . "subscription_status` ss ON (s.subscription_status_id = ss.subscription_status_id) LEFT JOIN `" . DB_PREFIX . "member_payment` mp ON (s.member_payment_id = mp.member_payment_id) WHERE s.member_id = '" . (int)$member_id . "' ORDER BY s.date_added DESC";

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

	public function getTotalSubscriptions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscription` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row['total'];
	}

	public function addSubscriptionDomain($subscription_id, $name) {
		if (is_array($name)) {
			$name = isset($name['name']) ? $name['name'] : '';
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "subscription_domain` SET subscription_id = '" . (int)$subscription_id . "', member_id = '" . (int)$this->member->getId() . "', name = '" . $this->db->escape($name) . "', status = 'Active', pointed = '1', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function addDomain($subscription_id, $name) {
		return $this->addSubscriptionDomain($subscription_id, $name);
	}

	public function deleteSubscriptionDomain($subscription_domain_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "subscription_domain` WHERE subscription_domain_id = '" . (int)$subscription_domain_id . "' AND member_id = '" . (int)$this->member->getId() . "'");
	}

	public function deleteDomain($subscription_domain_id) {
		$this->deleteSubscriptionDomain($subscription_domain_id);
	}

	public function getSubscriptionDomain($subscription_domain_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_domain` WHERE subscription_domain_id = '" . (int)$subscription_domain_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		return $query->row;
	}

	public function getDomain($subscription_domain_id) {
		return $this->getSubscriptionDomain($subscription_domain_id);
	}

	public function getSubscriptionDomains($subscription_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_domain` WHERE subscription_id = '" . (int)$subscription_id . "' AND member_id = '" . (int)$this->member->getId() . "' ORDER BY date_added DESC");

		return $query->rows;
	}

	public function getDomains($subscription_id) {
		return $this->getSubscriptionDomains($subscription_id);
	}

	public function getTotalSubscriptionDomains($subscription_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscription_domain` WHERE subscription_id = '" . (int)$subscription_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		return $query->row['total'];
	}

	public function getTotalDomains($subscription_id) {
		return $this->getTotalSubscriptionDomains($subscription_id);
	}

	public function addSubscriptionHistory($subscription_id, $status, $comment = '') {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "subscription_history` SET subscription_id = '" . (int)$subscription_id . "', status = '" . $this->db->escape($status) . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function getSubscriptionHistories($subscription_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_history` WHERE subscription_id = '" . (int)$subscription_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalSubscriptionHistories($subscription_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscription_history` WHERE subscription_id = '" . (int)$subscription_id . "'");

		return $query->row['total'];
	}

	public function addSubscriptionTransaction($subscription_id, $data) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$this->db->query("INSERT INTO `" . DB_PREFIX . "subscription_transaction` SET subscription_id = '" . (int)$subscription_id . "', member_id = '" . (int)$member_id . "', transaction_id = '" . $this->db->escape(isset($data['transaction_id']) ? $data['transaction_id'] : strtoupper(token(12))) . "', amount = '" . (float)(isset($data['amount']) ? $data['amount'] : 0) . "', store_name = '" . $this->db->escape(isset($data['store_name']) ? $data['store_name'] : '') . "', transaction_card = '" . $this->db->escape(isset($data['transaction_card']) ? $data['transaction_card'] : 'Credit Card') . "', transaction_card_image = '" . $this->db->escape(isset($data['transaction_card_image']) ? $data['transaction_card_image'] : 'application/view/image/cloud/cloud_credit_card.svg') . "', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function getSubscriptionTransaction($subscription_transaction_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_transaction` WHERE subscription_transaction_id = '" . (int)$subscription_transaction_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		return $query->row;
	}

	public function getSubscriptionTransactions($subscription_id = 0, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$sql = "SELECT * FROM `" . DB_PREFIX . "subscription_transaction` WHERE member_id = '" . (int)$this->member->getId() . "'";

		if ($subscription_id) {
			$sql .= " AND subscription_id = '" . (int)$subscription_id . "'";
		}

		$sql .= " ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit;

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalSubscriptionTransactions($subscription_id = 0) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscription_transaction` WHERE member_id = '" . (int)$this->member->getId() . "'";

		if ($subscription_id) {
			$sql .= " AND subscription_id = '" . (int)$subscription_id . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function addSubscriptionBackup($subscription_id, $type = 'Manual') {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "subscription_backup` SET subscription_id = '" . (int)$subscription_id . "', `type` = '" . $this->db->escape($type) . "', status = 'Completed', created = NOW()");

		return $this->db->getLastId();
	}

	public function addBackup($subscription_id, $type = 'Manual') {
		return $this->addSubscriptionBackup($subscription_id, $type);
	}

	public function deleteSubscriptionBackup($backup_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "subscription_backup` WHERE backup_id = '" . (int)$backup_id . "'");
	}

	public function deleteBackup($backup_id) {
		$this->deleteSubscriptionBackup($backup_id);
	}

	public function getSubscriptionBackup($backup_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_backup` WHERE backup_id = '" . (int)$backup_id . "'");

		return $query->row;
	}

	public function getBackup($backup_id) {
		return $this->getSubscriptionBackup($backup_id);
	}

	public function getSubscriptionBackups($subscription_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "subscription_backup` WHERE subscription_id = '" . (int)$subscription_id . "' ORDER BY created DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getBackups($subscription_id, $start = 0, $limit = 10) {
		return $this->getSubscriptionBackups($subscription_id, $start, $limit);
	}

	public function getTotalSubscriptionBackups($subscription_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "subscription_backup` WHERE subscription_id = '" . (int)$subscription_id . "'");

		return $query->row['total'];
	}

	public function getTotalBackups($subscription_id) {
		return $this->getTotalSubscriptionBackups($subscription_id);
	}
}

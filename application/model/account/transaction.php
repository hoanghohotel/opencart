<?php
class ModelAccountTransaction extends Model {
	public function addTransaction($description, $amount = 0, $order_id = 0, $member_id = 0) {
		if (is_array($description)) {
			$data = $description;
			$description = isset($data['description']) ? $data['description'] : '';
			$amount = isset($data['amount']) ? (float)$data['amount'] : 0;
			$order_id = isset($data['order_id']) ? (int)$data['order_id'] : 0;
			$member_id = isset($data['member_id']) ? (int)$data['member_id'] : 0;
		}

		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_transaction` SET member_id = '" . (int)$member_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function getTransactions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$sql = "SELECT * FROM `" . DB_PREFIX . "member_transaction` WHERE member_id = '" . (int)$member_id . "' ORDER BY date_added DESC, member_transaction_id DESC";

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

	public function getTotalTransactions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_transaction` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row['total'];
	}

	public function getTransactionTotal($member_id = 0) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		$query = $this->db->query("SELECT SUM(amount) AS total FROM `" . DB_PREFIX . "member_transaction` WHERE member_id = '" . (int)$member_id . "'");

		return (float)$query->row['total'];
	}
}

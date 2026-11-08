<?php
class ModelMemberMember extends Model {
	public function addMember($data) {
		$salt = token(9);
		$password = !empty($data['password']) ? $data['password'] : '123456';

		$this->db->query("INSERT INTO `" . DB_PREFIX . "member` SET username = '" . $this->db->escape($data['username']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', tax_id = '" . $this->db->escape($data['tax_id']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', image = '" . $this->db->escape($data['image']) . "', country_id = '" . (int)$data['country_id'] . "', salt = '" . $this->db->escape($salt) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', notify = '" . (int)$data['notify'] . "', verified = '1', seller_status = '" . (int)$data['seller_status'] . "', partner_status = '" . (int)$data['partner_status'] . "', moderator = '" . (int)$data['moderator'] . "', cloud = '" . (int)$data['cloud'] . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_modified = NOW()");

		return $this->db->getLastId();
	}

	public function editMember($member_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET username = '" . $this->db->escape($data['username']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', tax_id = '" . $this->db->escape($data['tax_id']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', image = '" . $this->db->escape($data['image']) . "', country_id = '" . (int)$data['country_id'] . "', notify = '" . (int)$data['notify'] . "', seller_status = '" . (int)$data['seller_status'] . "', partner_status = '" . (int)$data['partner_status'] . "', moderator = '" . (int)$data['moderator'] . "', cloud = '" . (int)$data['cloud'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE member_id = '" . (int)$member_id . "'");

		if (!empty($data['password'])) {
			$salt = token(9);
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET salt = '" . $this->db->escape($salt) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE member_id = '" . (int)$member_id . "'");
		}

		if (!empty($data['transaction_description']) && isset($data['transaction_amount']) && $data['transaction_amount'] !== '') {
			$this->addTransaction($member_id, $data['transaction_description'], $data['transaction_amount']);
		}
	}

	public function deleteMember($member_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_transaction` WHERE member_id = '" . (int)$member_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$member_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_payment` WHERE member_id = '" . (int)$member_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_store` WHERE member_id = '" . (int)$member_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member` WHERE member_id = '" . (int)$member_id . "'");
	}

	public function getMember($member_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row;
	}

	public function getMembers($data = array()) {
		$sql = "SELECT m.*, c.name AS country_name, (SELECT COALESCE(SUM(mt.amount), 0) FROM `" . DB_PREFIX . "member_transaction` mt WHERE mt.member_id = m.member_id) AS balance FROM `" . DB_PREFIX . "member` m LEFT JOIN `" . DB_PREFIX . "country` c ON (m.country_id = c.country_id) ORDER BY m.date_added DESC";

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

	public function getTotalMembers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member`");

		return $query->row['total'];
	}

	public function addTransaction($member_id, $description, $amount = 0, $order_id = 0) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_transaction` SET member_id = '" . (int)$member_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");
	}

	public function getTransactions($member_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_transaction` WHERE member_id = '" . (int)$member_id . "' ORDER BY date_added DESC");

		return $query->rows;
	}

	public function getTransactionTotal($member_id) {
		$query = $this->db->query("SELECT COALESCE(SUM(amount), 0) AS total FROM `" . DB_PREFIX . "member_transaction` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row['total'];
	}
}

<?php
class ModelMemberSeller extends Model {
	public function addSeller($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_seller` SET member_id = '" . (int)$data['member_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', support_email = '" . $this->db->escape($data['support_email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', website = '" . $this->db->escape($data['website']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_email = '" . $this->db->escape($data['payment_email']) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', commission = '" . (int)$data['commission'] . "', seller_group = '" . $this->db->escape($data['seller_group']) . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_modified = NOW()");

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET seller_status = '" . (int)$data['status'] . "' WHERE member_id = '" . (int)$data['member_id'] . "'");

		return $this->db->getLastId();
	}

	public function editSeller($member_seller_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "member_seller` SET member_id = '" . (int)$data['member_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', support_email = '" . $this->db->escape($data['support_email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', website = '" . $this->db->escape($data['website']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_email = '" . $this->db->escape($data['payment_email']) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', commission = '" . (int)$data['commission'] . "', seller_group = '" . $this->db->escape($data['seller_group']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE member_seller_id = '" . (int)$member_seller_id . "'");

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET seller_status = '" . (int)$data['status'] . "' WHERE member_id = '" . (int)$data['member_id'] . "'");
	}

	public function deleteSeller($member_seller_id) {
		$seller_info = $this->getSeller($member_seller_id);

		if ($seller_info) {
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET seller_status = '0' WHERE member_id = '" . (int)$seller_info['member_id'] . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_seller` WHERE member_seller_id = '" . (int)$member_seller_id . "'");
	}

	public function approveSeller($member_seller_id) {
		$seller_info = $this->getSeller($member_seller_id);

		if ($seller_info) {
			$this->db->query("UPDATE `" . DB_PREFIX . "member_seller` SET status = '1', date_modified = NOW() WHERE member_seller_id = '" . (int)$member_seller_id . "'");
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET seller_status = '1' WHERE member_id = '" . (int)$seller_info['member_id'] . "'");
		}
	}

	public function getSeller($member_seller_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_seller` WHERE member_seller_id = '" . (int)$member_seller_id . "'");

		return $query->row;
	}

	public function getSellers($data = array()) {
		$sql = "SELECT ms.*, m.username AS member_username, c.name AS country_name FROM `" . DB_PREFIX . "member_seller` ms LEFT JOIN `" . DB_PREFIX . "member` m ON (ms.member_id = m.member_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (ms.country_id = c.country_id) ORDER BY ms.date_added DESC";

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

	public function getTotalSellers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_seller`");

		return $query->row['total'];
	}
}

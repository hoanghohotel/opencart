<?php
class ModelMarketplacePromotion extends Model {
	public function addPromotion($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_promotion` SET extension_id = '" . (int)$data['extension_id'] . "', member_id = '" . (int)$data['member_id'] . "', days = '" . (int)$data['days'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function editPromotion($promotion_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "extension_promotion` SET extension_id = '" . (int)$data['extension_id'] . "', member_id = '" . (int)$data['member_id'] . "', days = '" . (int)$data['days'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "' WHERE promotion_id = '" . (int)$promotion_id . "'");
	}

	public function deletePromotion($promotion_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_promotion` WHERE promotion_id = '" . (int)$promotion_id . "'");
	}

	public function getPromotion($promotion_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_promotion` WHERE promotion_id = '" . (int)$promotion_id . "'");

		return $query->row;
	}

	public function getPromotions($data = array()) {
		$sql = "SELECT ep.*, e.name AS extension_name, m.username AS member_username FROM `" . DB_PREFIX . "extension_promotion` ep LEFT JOIN `" . DB_PREFIX . "extension` e ON (ep.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (ep.member_id = m.member_id) ORDER BY ep.date_added DESC";

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

	public function getTotalPromotions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_promotion`");

		return $query->row['total'];
	}
}

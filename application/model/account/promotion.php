<?php
class ModelAccountPromotion extends Model {
	public function addPromotion($data) {
		$days = isset($data['days']) ? (int)$data['days'] : 7;
		$total = isset($data['total']) ? (float)$data['total'] : ($days * 10.0);
		$date_start = isset($data['date_start']) && $data['date_start'] ? $data['date_start'] : date('Y-m-d');
		$date_end = isset($data['date_end']) && $data['date_end'] ? $data['date_end'] : date('Y-m-d', strtotime($date_start . ' + ' . $days . ' days'));

		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_promotion` SET extension_id = '" . (int)(isset($data['extension_id']) ? $data['extension_id'] : 0) . "', member_id = '" . (int)$this->member->getId() . "', days = '" . (int)$days . "', total = '" . (float)$total . "', payment_method = '" . $this->db->escape(isset($data['payment_method']) ? $data['payment_method'] : 'PayPal') . "', transaction_id = '" . $this->db->escape(isset($data['transaction_id']) ? $data['transaction_id'] : token(16)) . "', order_status_id = '" . (int)(isset($data['order_status_id']) ? $data['order_status_id'] : 5) . "', date_start = '" . $this->db->escape($date_start) . "', date_end = '" . $this->db->escape($date_end) . "', status = '1', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function deletePromotion($promotion_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_promotion` WHERE promotion_id = '" . (int)$promotion_id . "' AND member_id = '" . (int)$this->member->getId() . "'");
	}

	public function getPromotion($promotion_id) {
		$query = $this->db->query("SELECT ep.*, e.name AS extension, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = ep.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "extension_promotion` ep LEFT JOIN `" . DB_PREFIX . "extension` e ON (ep.extension_id = e.extension_id) WHERE ep.promotion_id = '" . (int)$promotion_id . "' AND ep.member_id = '" . (int)$this->member->getId() . "'");

		return $query->row;
	}

	public function getPromotions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$sql = "SELECT ep.*, e.name AS extension, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = ep.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "extension_promotion` ep LEFT JOIN `" . DB_PREFIX . "extension` e ON (ep.extension_id = e.extension_id) WHERE ep.member_id = '" . (int)$member_id . "' ORDER BY ep.date_added DESC";

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

	public function getTotalPromotions($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_promotion` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row['total'];
	}
}

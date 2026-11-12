<?php
class ModelMarketplacePromotion extends Model {
	public function addPromotion($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_promotion` SET extension_id = '" . (int)$data['extension_id'] . "', member_id = '" . (int)$data['member_id'] . "', days = '" . (int)$data['days'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$promotion_id = $this->db->getLastId();

		$this->syncExtensionFeatured((int)$data['extension_id']);

		return $promotion_id;
	}

	public function editPromotion($promotion_id, $data) {
		$old_info = $this->getPromotion($promotion_id);

		$this->db->query("UPDATE `" . DB_PREFIX . "extension_promotion` SET extension_id = '" . (int)$data['extension_id'] . "', member_id = '" . (int)$data['member_id'] . "', days = '" . (int)$data['days'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "' WHERE promotion_id = '" . (int)$promotion_id . "'");

		if ($old_info && (int)$old_info['extension_id'] !== (int)$data['extension_id']) {
			$this->syncExtensionFeatured((int)$old_info['extension_id']);
		}

		$this->syncExtensionFeatured((int)$data['extension_id']);
	}

	public function deletePromotion($promotion_id) {
		$old_info = $this->getPromotion($promotion_id);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_promotion` WHERE promotion_id = '" . (int)$promotion_id . "'");

		if ($old_info) {
			$this->syncExtensionFeatured((int)$old_info['extension_id']);
		}
	}

	public function approvePayment($promotion_id) {
		$promotion_info = $this->getPromotion($promotion_id);

		if ($promotion_info) {
			$complete_status_id = (int)$this->config->get('config_download_status_id') ? (int)$this->config->get('config_download_status_id') : ((int)$this->config->get('config_complete_status_id') ? (int)$this->config->get('config_complete_status_id') : 5);
			$days = max(1, (int)$promotion_info['days']);
			$date_start = date('Y-m-d');
			$date_end = date('Y-m-d', strtotime('+' . $days . ' days'));

			$this->db->query("UPDATE `" . DB_PREFIX . "extension_promotion` SET order_status_id = '" . (int)$complete_status_id . "', status = '1', date_start = '" . $this->db->escape($date_start) . "', date_end = '" . $this->db->escape($date_end) . "' WHERE promotion_id = '" . (int)$promotion_id . "'");

			$this->syncExtensionFeatured((int)$promotion_info['extension_id']);
		}
	}

	public function syncExtensionFeatured($extension_id) {
		$complete_status_id = (int)$this->config->get('config_download_status_id') ? (int)$this->config->get('config_download_status_id') : ((int)$this->config->get('config_complete_status_id') ? (int)$this->config->get('config_complete_status_id') : 5);

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_promotion` WHERE extension_id = '" . (int)$extension_id . "' AND status = '1' AND order_status_id = '" . (int)$complete_status_id . "' AND date_start <= CURDATE() AND date_end >= CURDATE()");

		$featured = ($query->row['total'] > 0) ? 1 : 0;

		$this->db->query("UPDATE `" . DB_PREFIX . "extension` SET featured = '" . (int)$featured . "' WHERE extension_id = '" . (int)$extension_id . "'");
	}

	public function getPromotion($promotion_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_promotion` WHERE promotion_id = '" . (int)$promotion_id . "'");

		return $query->row;
	}

	public function getPromotions($data = array()) {
		$sql = "SELECT ep.*, e.name AS extension_name, m.username AS member_username, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = ep.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "extension_promotion` ep LEFT JOIN `" . DB_PREFIX . "extension` e ON (ep.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (ep.member_id = m.member_id) ORDER BY ep.date_added DESC";

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

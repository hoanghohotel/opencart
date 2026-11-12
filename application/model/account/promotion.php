<?php
class ModelAccountPromotion extends Model {
	public function getPackages() {
		$p1w = $this->config->get('config_promotion_price_1w');
		$p1m = $this->config->get('config_promotion_price_1m');
		$p3m = $this->config->get('config_promotion_price_3m');
		$p6m = $this->config->get('config_promotion_price_6m');
		$p1y = $this->config->get('config_promotion_price_1y');

		return array(
			'1w' => array(
				'code'  => '1w',
				'days'  => 7,
				'price' => ($p1w !== null && $p1w !== '') ? (float)$p1w : 49.00
			),
			'1m' => array(
				'code'  => '1m',
				'days'  => 30,
				'price' => ($p1m !== null && $p1m !== '') ? (float)$p1m : 149.00
			),
			'3m' => array(
				'code'  => '3m',
				'days'  => 90,
				'price' => ($p3m !== null && $p3m !== '') ? (float)$p3m : 399.00
			),
			'6m' => array(
				'code'  => '6m',
				'days'  => 180,
				'price' => ($p6m !== null && $p6m !== '') ? (float)$p6m : 699.00
			),
			'1y' => array(
				'code'  => '1y',
				'days'  => 365,
				'price' => ($p1y !== null && $p1y !== '') ? (float)$p1y : 1199.00
			)
		);
	}

	public function resolvePackage($package_or_days) {
		$packages = $this->getPackages();

		if (is_string($package_or_days) && isset($packages[$package_or_days])) {
			return $packages[$package_or_days];
		}

		$days = (int)$package_or_days;
		foreach ($packages as $pkg) {
			if ((int)$pkg['days'] === $days) {
				return $pkg;
			}
		}

		return $packages['1m'];
	}

	public function addPromotion($data) {
		$pkg = $this->resolvePackage(isset($data['package']) ? $data['package'] : (isset($data['days']) ? $data['days'] : '1m'));
		$days = (int)$pkg['days'];
		$total = (float)$pkg['price'];

		$pending_status_id = (int)$this->config->get('config_order_status_id') ? (int)$this->config->get('config_order_status_id') : 1;
		$date_start = isset($data['date_start']) && $data['date_start'] ? $data['date_start'] : date('Y-m-d');
		$date_end = isset($data['date_end']) && $data['date_end'] ? $data['date_end'] : date('Y-m-d', strtotime($date_start . ' + ' . $days . ' days'));
		$payment_method = isset($data['payment_method']) && $data['payment_method'] ? $data['payment_method'] : 'Pending Payment';
		$transaction_id = isset($data['transaction_id']) && $data['transaction_id'] ? $data['transaction_id'] : ('PROMO-' . strtoupper(token(10)));

		// Promotions always start as unpaid (status = 0, order_status_id = pending) until payment is confirmed
		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_promotion` SET extension_id = '" . (int)(isset($data['extension_id']) ? $data['extension_id'] : 0) . "', member_id = '" . (int)$this->member->getId() . "', days = '" . (int)$days . "', total = '" . (float)$total . "', payment_method = '" . $this->db->escape($payment_method) . "', transaction_id = '" . $this->db->escape($transaction_id) . "', order_status_id = '" . (int)$pending_status_id . "', date_start = '" . $this->db->escape($date_start) . "', date_end = '" . $this->db->escape($date_end) . "', status = '0', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function activatePromotion($promotion_id, $payment_method, $transaction_id) {
		$promotion_info = $this->getPromotion($promotion_id);

		if (!$promotion_info) {
			return false;
		}

		$complete_status_id = (int)$this->config->get('config_download_status_id') ? (int)$this->config->get('config_download_status_id') : ((int)$this->config->get('config_complete_status_id') ? (int)$this->config->get('config_complete_status_id') : 5);
		$days = max(1, (int)$promotion_info['days']);
		$date_start = date('Y-m-d');
		$date_end = date('Y-m-d', strtotime('+' . $days . ' days'));

		$this->db->query("UPDATE `" . DB_PREFIX . "extension_promotion` SET payment_method = '" . $this->db->escape($payment_method) . "', transaction_id = '" . $this->db->escape($transaction_id) . "', order_status_id = '" . (int)$complete_status_id . "', date_start = '" . $this->db->escape($date_start) . "', date_end = '" . $this->db->escape($date_end) . "', status = '1' WHERE promotion_id = '" . (int)$promotion_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		$this->db->query("UPDATE `" . DB_PREFIX . "extension` SET featured = '1' WHERE extension_id = '" . (int)$promotion_info['extension_id'] . "'");

		return true;
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

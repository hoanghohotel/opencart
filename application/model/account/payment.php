<?php
class ModelAccountPayment extends Model {
	public function addPayment($arg1, $arg2 = null) {
		if (is_array($arg1)) {
			$member_id = (int)$this->member->getId();
			$data = $arg1;
		} else {
			$member_id = (int)$arg1 ? (int)$arg1 : (int)$this->member->getId();
			$data = is_array($arg2) ? $arg2 : array();
		}

		if ($member_id <= 0) {
			return 0;
		}

		$total = $this->getTotalPayments($member_id);
		$default = !empty($data['default']) || !$total ? 1 : 0;

		if ($default) {
			$this->db->query("UPDATE `" . DB_PREFIX . "member_payment` SET `default` = '0' WHERE member_id = '" . (int)$member_id . "'");
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_payment` SET member_id = '" . (int)$member_id . "', `type` = '" . $this->db->escape(isset($data['type']) ? $data['type'] : 'Credit Card') . "', `name` = '" . $this->db->escape(isset($data['name']) ? $data['name'] : '') . "', `token` = '" . $this->db->escape(isset($data['token']) ? $data['token'] : token(32)) . "', `image` = '" . $this->db->escape(isset($data['image']) ? $data['image'] : 'application/view/image/cloud/cloud_credit_card.svg') . "', `date_expire` = '" . $this->db->escape(isset($data['date_expire']) ? $data['date_expire'] : date('Y-m-d', strtotime('+3 years'))) . "', `default` = '" . (int)$default . "', `date_added` = NOW()");

		return $this->db->getLastId();
	}

	public function editPayment($member_payment_id, $data) {
		$member_id = (int)$this->member->getId();

		if ($member_id <= 0) {
			return;
		}

		if (!empty($data['default'])) {
			$this->db->query("UPDATE `" . DB_PREFIX . "member_payment` SET `default` = '0' WHERE member_id = '" . (int)$member_id . "'");
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "member_payment` SET `type` = '" . $this->db->escape(isset($data['type']) ? $data['type'] : 'Credit Card') . "', `name` = '" . $this->db->escape(isset($data['name']) ? $data['name'] : '') . "', `date_expire` = '" . $this->db->escape(isset($data['date_expire']) ? $data['date_expire'] : date('Y-m-d')) . "', `default` = '" . (int)(!empty($data['default']) ? 1 : 0) . "' WHERE member_payment_id = '" . (int)$member_payment_id . "' AND member_id = '" . (int)$member_id . "'");
	}

	public function setDefaultPayment($arg1, $arg2 = null) {
		if ($arg2 !== null) {
			$member_id = (int)$arg1 ? (int)$arg1 : (int)$this->member->getId();
			$member_payment_id = (int)$arg2;
		} else {
			$member_id = (int)$this->member->getId();
			$member_payment_id = (int)$arg1;
		}

		if ($member_id <= 0 || $member_payment_id <= 0) {
			return;
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "member_payment` SET `default` = '0' WHERE member_id = '" . (int)$member_id . "'");
		$this->db->query("UPDATE `" . DB_PREFIX . "member_payment` SET `default` = '1' WHERE member_payment_id = '" . (int)$member_payment_id . "' AND member_id = '" . (int)$member_id . "'");
	}

	public function deletePayment($arg1, $arg2 = null) {
		if ($arg2 !== null) {
			$member_id = (int)$arg1 ? (int)$arg1 : (int)$this->member->getId();
			$member_payment_id = (int)$arg2;
		} else {
			$member_id = (int)$this->member->getId();
			$member_payment_id = (int)$arg1;
		}

		if ($member_id <= 0 || $member_payment_id <= 0) {
			return;
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_payment` WHERE member_payment_id = '" . (int)$member_payment_id . "' AND member_id = '" . (int)$member_id . "'");
	}

	public function getPayment($member_payment_id) {
		$member_id = (int)$this->member->getId();

		if ($member_id <= 0 || (int)$member_payment_id <= 0) {
			return array();
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_payment` WHERE member_payment_id = '" . (int)$member_payment_id . "' AND member_id = '" . (int)$member_id . "'");

		return $query->row;
	}

	public function getDefaultPayment($member_id = 0) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		if ((int)$member_id <= 0) {
			return array();
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_payment` WHERE member_id = '" . (int)$member_id . "' ORDER BY `default` DESC, member_payment_id DESC LIMIT 1");

		return $query->row;
	}

	public function getPayments($member_id = 0, $start = 0, $limit = 100) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		if ((int)$member_id <= 0) {
			return array();
		}

		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 100;
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_payment` WHERE member_id = '" . (int)$member_id . "' ORDER BY `default` DESC, date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalPayments($member_id = 0) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		if ((int)$member_id <= 0) {
			return 0;
		}

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_payment` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row['total'];
	}
}

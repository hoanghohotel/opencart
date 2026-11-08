<?php
class ModelAccountStore extends Model {
	public function addStore($data) {
		$secret = isset($data['secret']) && $data['secret'] !== '' ? $data['secret'] : token(32);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_store` SET member_id = '" . (int)$this->member->getId() . "', domain = '" . $this->db->escape(isset($data['domain']) ? $data['domain'] : '') . "', username = '" . $this->db->escape(isset($data['username']) ? $data['username'] : '') . "', secret = '" . $this->db->escape($secret) . "', date_added = NOW(), date_modified = NOW()");

		return $this->db->getLastId();
	}

	public function editStore($member_store_id, $data) {
		$sql = "UPDATE `" . DB_PREFIX . "member_store` SET domain = '" . $this->db->escape(isset($data['domain']) ? $data['domain'] : '') . "', username = '" . $this->db->escape(isset($data['username']) ? $data['username'] : '') . "'";

		if (!empty($data['secret'])) {
			$sql .= ", secret = '" . $this->db->escape($data['secret']) . "'";
		}

		$sql .= ", date_modified = NOW() WHERE member_store_id = '" . (int)$member_store_id . "' AND member_id = '" . (int)$this->member->getId() . "'";

		$this->db->query($sql);
	}

	public function deleteStore($member_store_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_store` WHERE member_store_id = '" . (int)$member_store_id . "' AND member_id = '" . (int)$this->member->getId() . "'");
	}

	public function getStore($member_store_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_store` WHERE member_store_id = '" . (int)$member_store_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		return $query->row;
	}

	public function getStores($data = array()) {
		$member_id = isset($data['member_id']) ? (int)$data['member_id'] : (int)$this->member->getId();

		$sql = "SELECT * FROM `" . DB_PREFIX . "member_store` WHERE member_id = '" . (int)$member_id . "' ORDER BY date_added DESC";

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

	public function getTotalStores($member_id = 0) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_store` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row['total'];
	}
}

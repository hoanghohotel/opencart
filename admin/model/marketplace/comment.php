<?php
class ModelMarketplaceComment extends Model {
	public function editComment($extension_comment_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "extension_comment` SET comment = '" . $this->db->escape($data['comment']) . "', status = '" . (int)$data['status'] . "' WHERE extension_comment_id = '" . (int)$extension_comment_id . "'");
	}

	public function approveComment($extension_comment_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "extension_comment` SET status = '1' WHERE extension_comment_id = '" . (int)$extension_comment_id . "'");
	}

	public function deleteComment($extension_comment_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_comment` WHERE extension_comment_id = '" . (int)$extension_comment_id . "' OR parent_id = '" . (int)$extension_comment_id . "'");
	}

	public function getComment($extension_comment_id) {
		$query = $this->db->query("SELECT ec.*, e.name AS extension_name, m.username AS member_username FROM `" . DB_PREFIX . "extension_comment` ec LEFT JOIN `" . DB_PREFIX . "extension` e ON (ec.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id) WHERE ec.extension_comment_id = '" . (int)$extension_comment_id . "'");

		return $query->row;
	}

	public function getComments($data = array()) {
		$sql = "SELECT ec.*, e.name AS extension_name, m.username AS member_username FROM `" . DB_PREFIX . "extension_comment` ec LEFT JOIN `" . DB_PREFIX . "extension` e ON (ec.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id) WHERE 1=1";

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND ec.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " ORDER BY ec.date_added DESC";

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

	public function getTotalComments($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_comment` ec WHERE 1=1";

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND ec.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}

<?php
class ModelCmsShowcase extends Model {
	public function addShowcase($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "showcase` SET member_id = '" . (int)$data['member_id'] . "', showcase_category_id = '" . (int)$data['showcase_category_id'] . "', name = '" . $this->db->escape($data['name']) . "', link = '" . $this->db->escape($data['link']) . "', image = '" . $this->db->escape($data['image']) . "', date_launch = '" . $this->db->escape($data['date_launch']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function editShowcase($showcase_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "showcase` SET member_id = '" . (int)$data['member_id'] . "', showcase_category_id = '" . (int)$data['showcase_category_id'] . "', name = '" . $this->db->escape($data['name']) . "', link = '" . $this->db->escape($data['link']) . "', image = '" . $this->db->escape($data['image']) . "', date_launch = '" . $this->db->escape($data['date_launch']) . "', status = '" . (int)$data['status'] . "' WHERE showcase_id = '" . (int)$showcase_id . "'");
	}

	public function deleteShowcase($showcase_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "showcase` WHERE showcase_id = '" . (int)$showcase_id . "'");
	}

	public function approveShowcase($showcase_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "showcase` SET status = '1' WHERE showcase_id = '" . (int)$showcase_id . "'");
	}

	public function getShowcase($showcase_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "showcase` WHERE showcase_id = '" . (int)$showcase_id . "'");

		return $query->row;
	}

	public function getShowcases($data = array()) {
		$sql = "SELECT s.*, sc.name AS category_name, m.username AS member_username FROM `" . DB_PREFIX . "showcase` s LEFT JOIN `" . DB_PREFIX . "showcase_category` sc ON (s.showcase_category_id = sc.showcase_category_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (s.member_id = m.member_id) ORDER BY s.date_added DESC";

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

	public function getTotalShowcases() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "showcase`");

		return $query->row['total'];
	}

	public function getShowcaseCategories() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "showcase_category` ORDER BY sort_order ASC, name ASC");

		return $query->rows;
	}
}

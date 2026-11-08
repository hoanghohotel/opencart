<?php
class ModelCmsShowcase extends Model {
	public function getShowcaseCategory($showcase_category_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "showcase_category` WHERE showcase_category_id = '" . (int)$showcase_category_id . "' AND status = '1'");

		return $query->row;
	}

	public function getShowcaseCategories() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "showcase_category` WHERE status = '1' ORDER BY sort_order ASC, name ASC");

		return $query->rows;
	}

	public function getShowcase($showcase_id) {
		$query = $this->db->query("SELECT s.*, sc.name AS category FROM `" . DB_PREFIX . "showcase` s LEFT JOIN `" . DB_PREFIX . "showcase_category` sc ON (s.showcase_category_id = sc.showcase_category_id) WHERE s.showcase_id = '" . (int)$showcase_id . "'");

		return $query->row;
	}

	public function getShowcases($data = array()) {
		$sql = "SELECT s.*, sc.name AS category FROM `" . DB_PREFIX . "showcase` s LEFT JOIN `" . DB_PREFIX . "showcase_category` sc ON (s.showcase_category_id = sc.showcase_category_id) WHERE 1=1";

		if (isset($data['filter_status'])) {
			$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
		} elseif (empty($data['filter_member_id'])) {
			$sql .= " AND s.status = '1'";
		}

		if (!empty($data['filter_showcase_category_id'])) {
			$sql .= " AND s.showcase_category_id = '" . (int)$data['filter_showcase_category_id'] . "'";
		}

		if (!empty($data['filter_member_id'])) {
			$sql .= " AND s.member_id = '" . (int)$data['filter_member_id'] . "'";
		}

		$sql .= " ORDER BY s.date_added DESC, s.showcase_id DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 12;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalShowcases($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "showcase` s WHERE 1=1";

		if (isset($data['filter_status'])) {
			$sql .= " AND s.status = '" . (int)$data['filter_status'] . "'";
		} elseif (empty($data['filter_member_id'])) {
			$sql .= " AND s.status = '1'";
		}

		if (!empty($data['filter_showcase_category_id'])) {
			$sql .= " AND s.showcase_category_id = '" . (int)$data['filter_showcase_category_id'] . "'";
		}

		if (!empty($data['filter_member_id'])) {
			$sql .= " AND s.member_id = '" . (int)$data['filter_member_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function addShowcase($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "showcase` SET member_id = '" . (int)$this->member->getId() . "', showcase_category_id = '" . (int)(isset($data['showcase_category_id']) ? $data['showcase_category_id'] : 0) . "', name = '" . $this->db->escape(isset($data['name']) ? $data['name'] : '') . "', link = '" . $this->db->escape(isset($data['link']) ? $data['link'] : '') . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', date_launch = '" . $this->db->escape(isset($data['date_launch']) ? $data['date_launch'] : date('Y-m-d')) . "', status = '0', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function editShowcase($showcase_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "showcase` SET showcase_category_id = '" . (int)(isset($data['showcase_category_id']) ? $data['showcase_category_id'] : 0) . "', name = '" . $this->db->escape(isset($data['name']) ? $data['name'] : '') . "', link = '" . $this->db->escape(isset($data['link']) ? $data['link'] : '') . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', date_launch = '" . $this->db->escape(isset($data['date_launch']) ? $data['date_launch'] : date('Y-m-d')) . "' WHERE showcase_id = '" . (int)$showcase_id . "' AND member_id = '" . (int)$this->member->getId() . "'");
	}

	public function deleteShowcase($showcase_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "showcase` WHERE showcase_id = '" . (int)$showcase_id . "' AND member_id = '" . (int)$this->member->getId() . "'");
	}
}

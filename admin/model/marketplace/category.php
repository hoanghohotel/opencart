<?php
class ModelMarketplaceCategory extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_category` SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

		return $this->db->getLastId();
	}

	public function editCategory($extension_category_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "extension_category` SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE extension_category_id = '" . (int)$extension_category_id . "'");
	}

	public function deleteCategory($extension_category_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_category` WHERE extension_category_id = '" . (int)$extension_category_id . "'");
	}

	public function getCategory($extension_category_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_category` WHERE extension_category_id = '" . (int)$extension_category_id . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT ec.*, (SELECT COUNT(*) FROM `" . DB_PREFIX . "extension` e WHERE e.extension_category_id = ec.extension_category_id) AS total_extensions FROM `" . DB_PREFIX . "extension_category` ec";

		$sort_data = array(
			'name',
			'sort_order',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_category`");

		return $query->row['total'];
	}
}

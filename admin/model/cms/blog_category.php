<?php
class ModelCmsBlogCategory extends Model {
	public function addBlogCategory($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category` SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

		return $this->db->getLastId();
	}

	public function editBlogCategory($blog_category_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "blog_category` SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE blog_category_id = '" . (int)$blog_category_id . "'");
	}

	public function deleteBlogCategory($blog_category_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_category` WHERE blog_category_id = '" . (int)$blog_category_id . "'");
	}

	public function getBlogCategory($blog_category_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category` WHERE blog_category_id = '" . (int)$blog_category_id . "'");

		return $query->row;
	}

	public function getBlogCategories($data = array()) {
		$sql = "SELECT bc.*, (SELECT COUNT(*) FROM `" . DB_PREFIX . "blog` b WHERE b.blog_category_id = bc.blog_category_id) AS total_posts FROM `" . DB_PREFIX . "blog_category` bc ORDER BY bc.sort_order ASC, bc.name ASC";

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

	public function getTotalBlogCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_category`");

		return $query->row['total'];
	}
}

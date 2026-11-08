<?php
class ModelCmsBlog extends Model {
	public function addBlog($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "blog` SET blog_category_id = '" . (int)$data['blog_category_id'] . "', title = '" . $this->db->escape($data['title']) . "', description = '" . $this->db->escape($data['description']) . "', author = '" . $this->db->escape($data['author']) . "', image = '" . $this->db->escape($data['image']) . "', image_status = '" . (int)(isset($data['image_status']) ? $data['image_status'] : 1) . "', trending = '" . (int)(isset($data['trending']) ? $data['trending'] : 0) . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_modified = NOW()");

		return $this->db->getLastId();
	}

	public function editBlog($blog_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "blog` SET blog_category_id = '" . (int)$data['blog_category_id'] . "', title = '" . $this->db->escape($data['title']) . "', description = '" . $this->db->escape($data['description']) . "', author = '" . $this->db->escape($data['author']) . "', image = '" . $this->db->escape($data['image']) . "', image_status = '" . (int)(isset($data['image_status']) ? $data['image_status'] : 1) . "', trending = '" . (int)(isset($data['trending']) ? $data['trending'] : 0) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blog_id = '" . (int)$blog_id . "'");
	}

	public function deleteBlog($blog_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_comment` WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blog` WHERE blog_id = '" . (int)$blog_id . "'");
	}

	public function getBlog($blog_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog` WHERE blog_id = '" . (int)$blog_id . "'");

		return $query->row;
	}

	public function getBlogs($data = array()) {
		$sql = "SELECT b.*, bc.name AS category_name FROM `" . DB_PREFIX . "blog` b LEFT JOIN `" . DB_PREFIX . "blog_category` bc ON (b.blog_category_id = bc.blog_category_id) ORDER BY b.date_added DESC";

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

	public function getTotalBlogs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog`");

		return $query->row['total'];
	}
}

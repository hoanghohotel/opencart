<?php
class ModelCmsBlogComment extends Model {
	public function editBlogComment($blog_comment_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "blog_comment` SET comment = '" . $this->db->escape($data['comment']) . "', status = '" . (int)$data['status'] . "' WHERE blog_comment_id = '" . (int)$blog_comment_id . "'");
	}

	public function approveBlogComment($blog_comment_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "blog_comment` SET status = '1' WHERE blog_comment_id = '" . (int)$blog_comment_id . "'");
	}

	public function deleteBlogComment($blog_comment_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_comment` WHERE blog_comment_id = '" . (int)$blog_comment_id . "' OR parent_id = '" . (int)$blog_comment_id . "'");
	}

	public function getBlogComment($blog_comment_id) {
		$query = $this->db->query("SELECT bc.*, b.title AS blog_title, m.username AS member_username FROM `" . DB_PREFIX . "blog_comment` bc LEFT JOIN `" . DB_PREFIX . "blog` b ON (bc.blog_id = b.blog_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (bc.member_id = m.member_id) WHERE bc.blog_comment_id = '" . (int)$blog_comment_id . "'");

		return $query->row;
	}

	public function getBlogComments($data = array()) {
		$sql = "SELECT bc.*, b.title AS blog_title, m.username AS member_username FROM `" . DB_PREFIX . "blog_comment` bc LEFT JOIN `" . DB_PREFIX . "blog` b ON (bc.blog_id = b.blog_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (bc.member_id = m.member_id) ORDER BY bc.date_added DESC";

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

	public function getTotalBlogComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_comment`");

		return $query->row['total'];
	}
}

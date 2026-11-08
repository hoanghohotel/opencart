<?php
class ModelCmsBlog extends Model {
	public function getBlogCategory($blog_category_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category` WHERE blog_category_id = '" . (int)$blog_category_id . "' AND status = '1'");

		return $query->row;
	}

	public function getBlogCategories() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category` WHERE status = '1' ORDER BY sort_order ASC, name ASC");

		return $query->rows;
	}

	public function getBlog($blog_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT bc.name FROM `" . DB_PREFIX . "blog_category` bc WHERE bc.blog_category_id = b.blog_category_id) AS category, (SELECT COUNT(*) FROM `" . DB_PREFIX . "blog_comment` bcm WHERE bcm.blog_id = b.blog_id AND bcm.parent_id = '0' AND bcm.status = '1') AS comment_total FROM `" . DB_PREFIX . "blog` b WHERE b.blog_id = '" . (int)$blog_id . "' AND b.status = '1'");

		return $query->row;
	}

	public function getBlogs($data = array()) {
		$sql = "SELECT b.*, (SELECT bc.name FROM `" . DB_PREFIX . "blog_category` bc WHERE bc.blog_category_id = b.blog_category_id) AS category, (SELECT COUNT(*) FROM `" . DB_PREFIX . "blog_comment` bcm WHERE bcm.blog_id = b.blog_id AND bcm.parent_id = '0' AND bcm.status = '1') AS comment_total FROM `" . DB_PREFIX . "blog` b WHERE b.status = '1'";

		if (!empty($data['filter_blog_category_id'])) {
			$sql .= " AND b.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
		}

		if (!empty($data['filter_search'])) {
			$sql .= " AND (b.title LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR b.description LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR b.author LIKE '%" . $this->db->escape($data['filter_search']) . "%')";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND b.author = '" . $this->db->escape($data['filter_author']) . "'";
		}

		if (isset($data['filter_trending']) && $data['filter_trending'] !== '') {
			$sql .= " AND b.trending = '" . (int)$data['filter_trending'] . "'";
		}

		$sort_data = array(
			'b.date_added',
			'b.viewed',
			'b.title'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY b.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

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

	public function getTotalBlogs($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog` b WHERE b.status = '1'";

		if (!empty($data['filter_blog_category_id'])) {
			$sql .= " AND b.blog_category_id = '" . (int)$data['filter_blog_category_id'] . "'";
		}

		if (!empty($data['filter_search'])) {
			$sql .= " AND (b.title LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR b.description LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR b.author LIKE '%" . $this->db->escape($data['filter_search']) . "%')";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND b.author = '" . $this->db->escape($data['filter_author']) . "'";
		}

		if (isset($data['filter_trending']) && $data['filter_trending'] !== '') {
			$sql .= " AND b.trending = '" . (int)$data['filter_trending'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function updateViewed($blog_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "blog` SET viewed = (viewed + 1) WHERE blog_id = '" . (int)$blog_id . "'");
	}

	public function addComment($blog_id, $parent_id = 0, $comment = '') {
		if (is_array($parent_id)) {
			$comment = isset($parent_id['comment']) ? $parent_id['comment'] : '';
			$parent_id = isset($parent_id['parent_id']) ? (int)$parent_id['parent_id'] : 0;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_comment` SET blog_id = '" . (int)$blog_id . "', parent_id = '" . (int)$parent_id . "', member_id = '" . (int)$this->member->getId() . "', comment = '" . $this->db->escape($comment) . "', status = '1', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function deleteComment($blog_comment_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_comment` WHERE blog_comment_id = '" . (int)$blog_comment_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_comment` WHERE parent_id = '" . (int)$blog_comment_id . "'");
	}

	public function getComment($blog_comment_id) {
		$query = $this->db->query("SELECT bc.*, m.username AS member, m.username, m.image FROM `" . DB_PREFIX . "blog_comment` bc LEFT JOIN `" . DB_PREFIX . "member` m ON (bc.member_id = m.member_id) WHERE bc.blog_comment_id = '" . (int)$blog_comment_id . "'");

		return $query->row;
	}

	public function getCommentsByBlogId($blog_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT bc.*, m.username AS member, m.username, m.image, (SELECT COUNT(*) FROM `" . DB_PREFIX . "blog_comment` bcr WHERE bcr.parent_id = bc.blog_comment_id AND bcr.status = '1') AS reply_total FROM `" . DB_PREFIX . "blog_comment` bc LEFT JOIN `" . DB_PREFIX . "member` m ON (bc.member_id = m.member_id) WHERE bc.blog_id = '" . (int)$blog_id . "' AND bc.parent_id = '0' AND bc.status = '1' ORDER BY bc.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getComments($blog_id, $start = 0, $limit = 10) {
		return $this->getCommentsByBlogId($blog_id, $start, $limit);
	}

	public function getTotalCommentsByBlogId($blog_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_comment` WHERE blog_id = '" . (int)$blog_id . "' AND parent_id = '0' AND status = '1'");

		return $query->row['total'];
	}

	public function getTotalComments($blog_id) {
		return $this->getTotalCommentsByBlogId($blog_id);
	}

	public function getRepliesByCommentId($blog_id, $parent_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT bc.*, m.username AS member, m.username, m.image FROM `" . DB_PREFIX . "blog_comment` bc LEFT JOIN `" . DB_PREFIX . "member` m ON (bc.member_id = m.member_id) WHERE bc.blog_id = '" . (int)$blog_id . "' AND bc.parent_id = '" . (int)$parent_id . "' AND bc.status = '1' ORDER BY bc.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getReplies($parent_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT bc.*, m.username AS member, m.username, m.image FROM `" . DB_PREFIX . "blog_comment` bc LEFT JOIN `" . DB_PREFIX . "member` m ON (bc.member_id = m.member_id) WHERE bc.parent_id = '" . (int)$parent_id . "' AND bc.status = '1' ORDER BY bc.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalRepliesByCommentId($blog_id, $parent_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_comment` WHERE blog_id = '" . (int)$blog_id . "' AND parent_id = '" . (int)$parent_id . "' AND status = '1'");

		return $query->row['total'];
	}

	public function getTotalReplies($parent_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blog_comment` WHERE parent_id = '" . (int)$parent_id . "' AND status = '1'");

		return $query->row['total'];
	}
}

<?php
class ModelMarketplaceExtension extends Model {
	public function getExtensionCategory($extension_category_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_category` WHERE extension_category_id = '" . (int)$extension_category_id . "' AND status = '1'");

		return $query->row;
	}

	public function getExtensionCategories() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_category` WHERE status = '1' ORDER BY sort_order ASC, name ASC");

		return $query->rows;
	}

	public function getExtension($extension_id) {
		$query = $this->db->query("SELECT DISTINCT e.*, ec.name AS category, m.username, m.image AS member_image, m.date_added AS member_date_added, m.partner_status, m.seller_status, m.email AS member_email, (SELECT ms.support_email FROM `" . DB_PREFIX . "member_seller` ms WHERE ms.member_id = e.member_id LIMIT 1) AS support_email, (SELECT COUNT(*) FROM `" . DB_PREFIX . "extension_comment` ecm WHERE ecm.extension_id = e.extension_id AND ecm.parent_id = '0' AND ecm.status = '1') AS comment_total FROM `" . DB_PREFIX . "extension` e LEFT JOIN `" . DB_PREFIX . "extension_category` ec ON (e.extension_category_id = ec.extension_category_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) WHERE e.extension_id = '" . (int)$extension_id . "'");

		return $query->row;
	}

	public function getExtensions($data = array()) {
		$sql = "SELECT e.*, ec.name AS category, m.username, m.image AS member_image, m.date_added AS member_date_added, m.partner_status, m.seller_status, (SELECT COUNT(*) FROM `" . DB_PREFIX . "extension_comment` ecm WHERE ecm.extension_id = e.extension_id AND ecm.parent_id = '0' AND ecm.status = '1') AS comment_total FROM `" . DB_PREFIX . "extension` e LEFT JOIN `" . DB_PREFIX . "extension_category` ec ON (e.extension_category_id = ec.extension_category_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) WHERE 1=1";

		if (empty($data['ignore_status'])) {
			if (isset($data['filter_status']) && $data['filter_status'] !== '') {
				$sql .= " AND e.status = '" . (int)$data['filter_status'] . "'";
			} else {
				$sql .= " AND e.status = '1'";
			}

			if (isset($data['filter_publish']) && $data['filter_publish'] !== '') {
				$sql .= " AND e.publish = '" . (int)$data['filter_publish'] . "'";
			} else {
				$sql .= " AND e.publish = '1'";
			}

			$sql .= " AND m.seller_status = '1'";
		}

		if (!empty($data['filter_category_id'])) {
			$sql .= " AND e.extension_category_id = '" . (int)$data['filter_category_id'] . "'";
		} elseif (!empty($data['filter_extension_category_id'])) {
			$sql .= " AND e.extension_category_id = '" . (int)$data['filter_extension_category_id'] . "'";
		}

		if (!empty($data['filter_search'])) {
			$sql .= " AND (e.name LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR e.tag LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR e.description LIKE '%" . $this->db->escape($data['filter_search']) . "%')";
		}

		if (!empty($data['filter_download_id'])) {
			$sql .= " AND EXISTS (SELECT * FROM `" . DB_PREFIX . "extension_download` ed LEFT JOIN `" . DB_PREFIX . "extension_download_path` edp ON (ed.extension_download_id = edp.extension_download_id) WHERE ed.extension_id = e.extension_id AND edp.download_id = '" . (int)$data['filter_download_id'] . "')";
		}

		if (!empty($data['filter_rating'])) {
			$sql .= " AND e.rating >= '" . (int)$data['filter_rating'] . "'";
		}

		if (isset($data['filter_license']) && $data['filter_license'] !== '') {
			if ($data['filter_license'] === 'free' || $data['filter_license'] === '0' || $data['filter_license'] === 0) {
				$sql .= " AND e.license = '0'";
			} elseif ($data['filter_license'] === 'paid' || $data['filter_license'] === 'commercial' || $data['filter_license'] === '1' || $data['filter_license'] === 1) {
				$sql .= " AND e.license = '1'";
			}
		}

		if (isset($data['filter_partner']) && $data['filter_partner'] !== '') {
			if ($data['filter_partner'] === 'partner' || $data['filter_partner'] === '1' || $data['filter_partner'] === 1) {
				$sql .= " AND m.partner_status = '1'";
			} elseif ($data['filter_partner'] === 'developer' || $data['filter_partner'] === '0' || $data['filter_partner'] === 0) {
				$sql .= " AND m.partner_status = '0'";
			}
		}

		if (!empty($data['filter_member_id'])) {
			$sql .= " AND e.member_id = '" . (int)$data['filter_member_id'] . "'";
		}

		if (!empty($data['filter_member'])) {
			$sql .= " AND m.username = '" . $this->db->escape($data['filter_member']) . "'";
		}

		if (isset($data['filter_cloud']) && $data['filter_cloud'] !== '') {
			$sql .= " AND e.cloud = '" . (int)$data['filter_cloud'] . "'";
		}

		if (isset($data['filter_recommended']) && $data['filter_recommended'] !== '') {
			$sql .= " AND e.recommended = '" . (int)$data['filter_recommended'] . "'";
		}

		if (isset($data['filter_featured']) && $data['filter_featured'] !== '') {
			$sql .= " AND e.featured = '" . (int)$data['filter_featured'] . "'";
		}

		$sort = isset($data['sort']) ? $data['sort'] : 'recommended';

		switch ($sort) {
			case 'date_added':
				$sql .= " ORDER BY e.date_added DESC";
				break;
			case 'date_modified':
				$sql .= " ORDER BY e.date_modified DESC";
				break;
			case 'name':
				$sql .= " ORDER BY LCASE(e.name) ASC";
				break;
			case 'price':
			case 'price_asc':
				$sql .= " ORDER BY e.price ASC, e.rating DESC";
				break;
			case 'price_desc':
				$sql .= " ORDER BY e.price DESC, e.rating DESC";
				break;
			case 'rating':
				$sql .= " ORDER BY e.rating DESC, e.rating_total DESC";
				break;
			case 'sales':
				$sql .= " ORDER BY e.sales DESC";
				break;
			case 'downloaded':
				$sql .= " ORDER BY e.downloaded DESC";
				break;
			case 'recommended':
			default:
				$sql .= " ORDER BY e.date_modified DESC, e.recommended DESC, e.sales DESC";
				break;
		}

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

	public function getTotalExtensions($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension` e LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) WHERE 1=1";

		if (empty($data['ignore_status'])) {
			if (isset($data['filter_status']) && $data['filter_status'] !== '') {
				$sql .= " AND e.status = '" . (int)$data['filter_status'] . "'";
			} else {
				$sql .= " AND e.status = '1'";
			}

			if (isset($data['filter_publish']) && $data['filter_publish'] !== '') {
				$sql .= " AND e.publish = '" . (int)$data['filter_publish'] . "'";
			} else {
				$sql .= " AND e.publish = '1'";
			}

			$sql .= " AND m.seller_status = '1'";
		}

		if (!empty($data['filter_category_id'])) {
			$sql .= " AND e.extension_category_id = '" . (int)$data['filter_category_id'] . "'";
		} elseif (!empty($data['filter_extension_category_id'])) {
			$sql .= " AND e.extension_category_id = '" . (int)$data['filter_extension_category_id'] . "'";
		}

		if (!empty($data['filter_search'])) {
			$sql .= " AND (e.name LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR e.tag LIKE '%" . $this->db->escape($data['filter_search']) . "%' OR e.description LIKE '%" . $this->db->escape($data['filter_search']) . "%')";
		}

		if (!empty($data['filter_download_id'])) {
			$sql .= " AND EXISTS (SELECT * FROM `" . DB_PREFIX . "extension_download` ed LEFT JOIN `" . DB_PREFIX . "extension_download_path` edp ON (ed.extension_download_id = edp.extension_download_id) WHERE ed.extension_id = e.extension_id AND edp.download_id = '" . (int)$data['filter_download_id'] . "')";
		}

		if (!empty($data['filter_rating'])) {
			$sql .= " AND e.rating >= '" . (int)$data['filter_rating'] . "'";
		}

		if (isset($data['filter_license']) && $data['filter_license'] !== '') {
			if ($data['filter_license'] === 'free' || $data['filter_license'] === '0' || $data['filter_license'] === 0) {
				$sql .= " AND e.license = '0'";
			} elseif ($data['filter_license'] === 'paid' || $data['filter_license'] === 'commercial' || $data['filter_license'] === '1' || $data['filter_license'] === 1) {
				$sql .= " AND e.license = '1'";
			}
		}

		if (isset($data['filter_partner']) && $data['filter_partner'] !== '') {
			if ($data['filter_partner'] === 'partner' || $data['filter_partner'] === '1' || $data['filter_partner'] === 1) {
				$sql .= " AND m.partner_status = '1'";
			} elseif ($data['filter_partner'] === 'developer' || $data['filter_partner'] === '0' || $data['filter_partner'] === 0) {
				$sql .= " AND m.partner_status = '0'";
			}
		}

		if (!empty($data['filter_member_id'])) {
			$sql .= " AND e.member_id = '" . (int)$data['filter_member_id'] . "'";
		}

		if (!empty($data['filter_member'])) {
			$sql .= " AND m.username = '" . $this->db->escape($data['filter_member']) . "'";
		}

		if (isset($data['filter_cloud']) && $data['filter_cloud'] !== '') {
			$sql .= " AND e.cloud = '" . (int)$data['filter_cloud'] . "'";
		}

		if (isset($data['filter_recommended']) && $data['filter_recommended'] !== '') {
			$sql .= " AND e.recommended = '" . (int)$data['filter_recommended'] . "'";
		}

		if (isset($data['filter_featured']) && $data['filter_featured'] !== '') {
			$sql .= " AND e.featured = '" . (int)$data['filter_featured'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getPromotions($extension_category_id = 0, $limit = 3) {
		$complete_status_id = (int)$this->config->get('config_complete_status_id') ? (int)$this->config->get('config_complete_status_id') : 5;

		$sql = "SELECT DISTINCT e.*, ec.name AS category, m.username, m.partner_status, m.seller_status, (SELECT COUNT(*) FROM `" . DB_PREFIX . "extension_comment` ecm WHERE ecm.extension_id = e.extension_id AND ecm.parent_id = '0' AND ecm.status = '1') AS comment_total FROM `" . DB_PREFIX . "extension` e LEFT JOIN `" . DB_PREFIX . "extension_category` ec ON (e.extension_category_id = ec.extension_category_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) LEFT JOIN `" . DB_PREFIX . "extension_promotion` ep ON (e.extension_id = ep.extension_id AND ep.status = '1' AND ep.order_status_id = '" . (int)$complete_status_id . "' AND ep.date_start <= NOW() AND ep.date_end >= NOW()) WHERE e.status = '1' AND e.publish = '1' AND m.seller_status = '1'";

		if ($extension_category_id) {
			$sql .= " AND e.extension_category_id = '" . (int)$extension_category_id . "'";
		}

		$sql .= " AND (ep.promotion_id IS NOT NULL OR e.featured = '1' OR e.recommended = '1') ORDER BY (ep.promotion_id IS NOT NULL) DESC, ep.promotion_id ASC, e.featured DESC, e.recommended DESC, e.rating DESC LIMIT " . (int)$limit;

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getExtensionImages($extension_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_image` WHERE extension_id = '" . (int)$extension_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getExtensionDownload($extension_download_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_download` WHERE extension_download_id = '" . (int)$extension_download_id . "'");

		return $query->row;
	}

	public function getExtensionDownloads($extension_id) {
		$extension_download_data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "' ORDER BY date_added DESC, extension_download_id DESC");

		foreach ($query->rows as $result) {
			$path_data = array();

			$path_query = $this->db->query("SELECT download_id FROM `" . DB_PREFIX . "extension_download_path` WHERE extension_download_id = '" . (int)$result['extension_download_id'] . "'");

			foreach ($path_query->rows as $path) {
				$path_data[] = $path['download_id'];
			}

			$result['download_id'] = $path_data;
			$extension_download_data[] = $result;
		}

		return $extension_download_data;
	}

	public function getExtensionDownloadPaths($extension_download_id) {
		$path_data = array();

		$query = $this->db->query("SELECT download_id FROM `" . DB_PREFIX . "extension_download_path` WHERE extension_download_id = '" . (int)$extension_download_id . "'");

		foreach ($query->rows as $result) {
			$path_data[] = $result['download_id'];
		}

		return $path_data;
	}

	public function getExtensionCompatibilities($extension_id) {
		$query = $this->db->query("SELECT DISTINCT d.* FROM `" . DB_PREFIX . "download` d INNER JOIN `" . DB_PREFIX . "extension_download_path` edp ON (d.download_id = edp.download_id) INNER JOIN `" . DB_PREFIX . "extension_download` ed ON (edp.extension_download_id = ed.extension_download_id) WHERE ed.extension_id = '" . (int)$extension_id . "' ORDER BY d.date_added DESC, d.download_id DESC");

		return $query->rows;
	}

	public function updateDownloaded($extension_id, $extension_download_id = 0) {
		$this->db->query("UPDATE `" . DB_PREFIX . "extension` SET downloaded = (downloaded + 1) WHERE extension_id = '" . (int)$extension_id . "'");

		if ($extension_download_id) {
			$this->db->query("UPDATE `" . DB_PREFIX . "extension_download` SET downloaded = (downloaded + 1) WHERE extension_download_id = '" . (int)$extension_download_id . "'");
		}
	}

	public function addExtensionRating($extension_id, $data) {
		$functionality = isset($data['functionality']) ? (int)$data['functionality'] : 5;
		$appearance = isset($data['appearance']) ? (int)$data['appearance'] : 5;
		$user_friendly = isset($data['user_friendly']) ? (int)$data['user_friendly'] : 5;
		$support = isset($data['support']) ? (int)$data['support'] : 5;
		$documentation = isset($data['documentation']) ? (int)$data['documentation'] : 5;
		$rating = isset($data['rating']) ? (int)$data['rating'] : (int)round(($functionality + $appearance + $user_friendly + $support + $documentation) / 5);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_rating` SET extension_id = '" . (int)$extension_id . "', member_id = '" . (int)$this->member->getId() . "', order_id = '" . (int)(isset($data['order_id']) ? $data['order_id'] : 0) . "', functionality = '" . (int)$functionality . "', appearance = '" . (int)$appearance . "', user_friendly = '" . (int)$user_friendly . "', support = '" . (int)$support . "', documentation = '" . (int)$documentation . "', rating = '" . (int)$rating . "', comment = '" . $this->db->escape(isset($data['comment']) ? $data['comment'] : '') . "', status = '1', date_added = NOW()");

		$extension_rating_id = $this->db->getLastId();

		$this->updateExtensionRatingStats($extension_id);

		return $extension_rating_id;
	}

	public function addRating($extension_id, $data) {
		return $this->addExtensionRating($extension_id, $data);
	}

	public function updateExtensionRatingStats($extension_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total, AVG(rating) AS avg_rating FROM `" . DB_PREFIX . "extension_rating` WHERE extension_id = '" . (int)$extension_id . "' AND status = '1'");

		$total = (int)$query->row['total'];
		$avg = $total ? (int)round($query->row['avg_rating']) : 0;

		$this->db->query("UPDATE `" . DB_PREFIX . "extension` SET rating = '" . (int)$avg . "', rating_total = '" . (int)$total . "' WHERE extension_id = '" . (int)$extension_id . "'");
	}

	public function getExtensionRatings($extension_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT er.*, m.username AS member, m.username, m.image FROM `" . DB_PREFIX . "extension_rating` er LEFT JOIN `" . DB_PREFIX . "member` m ON (er.member_id = m.member_id) WHERE er.extension_id = '" . (int)$extension_id . "' AND er.status = '1' ORDER BY er.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getRatings($extension_id, $start = 0, $limit = 10) {
		return $this->getExtensionRatings($extension_id, $start, $limit);
	}

	public function getReviewsByExtensionId($extension_id, $start = 0, $limit = 10) {
		return $this->getExtensionRatings($extension_id, $start, $limit);
	}

	public function getTotalExtensionRatings($extension_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_rating` WHERE extension_id = '" . (int)$extension_id . "' AND status = '1'");

		return $query->row['total'];
	}

	public function getTotalRatings($extension_id) {
		return $this->getTotalExtensionRatings($extension_id);
	}

	public function getTotalReviewsByExtensionId($extension_id) {
		return $this->getTotalExtensionRatings($extension_id);
	}

	public function getRatingByOrderId($order_id, $extension_id = 0) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "extension_rating` WHERE order_id = '" . (int)$order_id . "'";

		if ($extension_id) {
			$sql .= " AND extension_id = '" . (int)$extension_id . "'";
		}

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getMemberRating($member_id, $extension_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_rating` WHERE member_id = '" . (int)$member_id . "' AND extension_id = '" . (int)$extension_id . "' ORDER BY date_added DESC LIMIT 1");

		return $query->row;
	}

	public function addComment($extension_id, $parent_id = 0, $comment = '') {
		if (is_array($parent_id)) {
			$comment = isset($parent_id['comment']) ? $parent_id['comment'] : '';
			$parent_id = isset($parent_id['parent_id']) ? (int)$parent_id['parent_id'] : 0;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_comment` SET extension_id = '" . (int)$extension_id . "', parent_id = '" . (int)$parent_id . "', member_id = '" . (int)$this->member->getId() . "', comment = '" . $this->db->escape($comment) . "', status = '1', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function deleteComment($extension_comment_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_comment` WHERE extension_comment_id = '" . (int)$extension_comment_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_comment` WHERE parent_id = '" . (int)$extension_comment_id . "'");
	}

	public function getComment($extension_comment_id) {
		$query = $this->db->query("SELECT ec.*, m.username AS member, m.username, m.image FROM `" . DB_PREFIX . "extension_comment` ec LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id) WHERE ec.extension_comment_id = '" . (int)$extension_comment_id . "'");

		return $query->row;
	}

	public function getCommentsByExtensionId($extension_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT ec.*, m.username AS member, m.username, m.image, (SELECT COUNT(*) FROM `" . DB_PREFIX . "extension_comment` ecr WHERE ecr.parent_id = ec.extension_comment_id AND ecr.status = '1') AS reply_total FROM `" . DB_PREFIX . "extension_comment` ec LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id) WHERE ec.extension_id = '" . (int)$extension_id . "' AND ec.parent_id = '0' AND ec.status = '1' ORDER BY ec.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getComments($extension_id, $start = 0, $limit = 10) {
		return $this->getCommentsByExtensionId($extension_id, $start, $limit);
	}

	public function getTotalCommentsByExtensionId($extension_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_comment` WHERE extension_id = '" . (int)$extension_id . "' AND parent_id = '0' AND status = '1'");

		return $query->row['total'];
	}

	public function getTotalComments($extension_id) {
		return $this->getTotalCommentsByExtensionId($extension_id);
	}

	public function getRepliesByCommentId($extension_id, $parent_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT ec.*, m.username AS member, m.username, m.image FROM `" . DB_PREFIX . "extension_comment` ec LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id) WHERE ec.extension_id = '" . (int)$extension_id . "' AND ec.parent_id = '" . (int)$parent_id . "' AND ec.status = '1' ORDER BY ec.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getReplies($parent_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT ec.*, m.username AS member, m.username, m.image FROM `" . DB_PREFIX . "extension_comment` ec LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id) WHERE ec.parent_id = '" . (int)$parent_id . "' AND ec.status = '1' ORDER BY ec.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalRepliesByCommentId($extension_id, $parent_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_comment` WHERE extension_id = '" . (int)$extension_id . "' AND parent_id = '" . (int)$parent_id . "' AND status = '1'");

		return $query->row['total'];
	}

	public function getTotalReplies($parent_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_comment` WHERE parent_id = '" . (int)$parent_id . "' AND status = '1'");

		return $query->row['total'];
	}

	public function addExtension($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension` SET member_id = '" . (int)$this->member->getId() . "', extension_category_id = '" . (int)(isset($data['extension_category_id']) ? $data['extension_category_id'] : 0) . "', name = '" . $this->db->escape(isset($data['name']) ? $data['name'] : '') . "', description = '" . $this->db->escape(isset($data['description']) ? $data['description'] : '') . "', documentation = '" . $this->db->escape(isset($data['documentation']) ? $data['documentation'] : '') . "', history = '" . $this->db->escape(isset($data['history']) ? $data['history'] : '') . "', license = '" . (int)(isset($data['license']) ? $data['license'] : 0) . "', license_period = '" . $this->db->escape(isset($data['license_period']) ? $data['license_period'] : '1 Year') . "', price = '" . (float)(isset($data['price']) ? $data['price'] : 0) . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', banner = '" . $this->db->escape(isset($data['banner']) ? $data['banner'] : '') . "', tag = '" . $this->db->escape(isset($data['tag']) ? $data['tag'] : '') . "', cloud = '" . (int)(isset($data['cloud']) ? $data['cloud'] : 0) . "', publish = '" . (int)(isset($data['publish']) ? $data['publish'] : 0) . "', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 0) . "', alert = '" . (int)(isset($data['alert']) ? $data['alert'] : 0) . "', reviews_enabled = '" . (int)(isset($data['reviews_enabled']) ? $data['reviews_enabled'] : 1) . "', comments_enabled = '" . (int)(isset($data['comments_enabled']) ? $data['comments_enabled'] : 1) . "', status = '1', date_added = NOW(), date_modified = NOW()");

		$extension_id = $this->db->getLastId();

		if (isset($data['extension_image']) && is_array($data['extension_image'])) {
			foreach ($data['extension_image'] as $sort_order => $extension_image) {
				$img = is_array($extension_image) ? (isset($extension_image['image']) ? $extension_image['image'] : '') : $extension_image;
				$order = is_array($extension_image) && isset($extension_image['sort_order']) ? (int)$extension_image['sort_order'] : (int)$sort_order;
				if ($img) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_image` SET extension_id = '" . (int)$extension_id . "', image = '" . $this->db->escape($img) . "', sort_order = '" . (int)$order . "'");
				}
			}
		}

		if (isset($data['extension_download']) && is_array($data['extension_download'])) {
			foreach ($data['extension_download'] as $extension_download) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_download` SET extension_id = '" . (int)$extension_id . "', name = '" . $this->db->escape(isset($extension_download['name']) ? $extension_download['name'] : '') . "', filename = '" . $this->db->escape(isset($extension_download['filename']) ? $extension_download['filename'] : '') . "', mask = '" . $this->db->escape(isset($extension_download['mask']) ? $extension_download['mask'] : '') . "', cloud = '" . (int)(isset($extension_download['cloud']) ? $extension_download['cloud'] : 0) . "', approved = '1', downloaded = '0', date_added = NOW()");

				$extension_download_id = $this->db->getLastId();

				if (isset($extension_download['download_id']) && is_array($extension_download['download_id'])) {
					foreach ($extension_download['download_id'] as $download_id) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_download_path` SET extension_download_id = '" . (int)$extension_download_id . "', download_id = '" . (int)$download_id . "'");
					}
				}
			}
		}

		return $extension_id;
	}

	public function editExtension($extension_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "extension` SET extension_category_id = '" . (int)(isset($data['extension_category_id']) ? $data['extension_category_id'] : 0) . "', name = '" . $this->db->escape(isset($data['name']) ? $data['name'] : '') . "', description = '" . $this->db->escape(isset($data['description']) ? $data['description'] : '') . "', documentation = '" . $this->db->escape(isset($data['documentation']) ? $data['documentation'] : '') . "', history = '" . $this->db->escape(isset($data['history']) ? $data['history'] : '') . "', license = '" . (int)(isset($data['license']) ? $data['license'] : 0) . "', license_period = '" . $this->db->escape(isset($data['license_period']) ? $data['license_period'] : '1 Year') . "', price = '" . (float)(isset($data['price']) ? $data['price'] : 0) . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', banner = '" . $this->db->escape(isset($data['banner']) ? $data['banner'] : '') . "', tag = '" . $this->db->escape(isset($data['tag']) ? $data['tag'] : '') . "', cloud = '" . (int)(isset($data['cloud']) ? $data['cloud'] : 0) . "', publish = '" . (int)(isset($data['publish']) ? $data['publish'] : 0) . "', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 0) . "', alert = '" . (int)(isset($data['alert']) ? $data['alert'] : 0) . "', reviews_enabled = '" . (int)(isset($data['reviews_enabled']) ? $data['reviews_enabled'] : 1) . "', comments_enabled = '" . (int)(isset($data['comments_enabled']) ? $data['comments_enabled'] : 1) . "', date_modified = NOW() WHERE extension_id = '" . (int)$extension_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		if (isset($data['extension_image'])) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_image` WHERE extension_id = '" . (int)$extension_id . "'");

			if (is_array($data['extension_image'])) {
				foreach ($data['extension_image'] as $sort_order => $extension_image) {
					$img = is_array($extension_image) ? (isset($extension_image['image']) ? $extension_image['image'] : '') : $extension_image;
					$order = is_array($extension_image) && isset($extension_image['sort_order']) ? (int)$extension_image['sort_order'] : (int)$sort_order;
					if ($img) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_image` SET extension_id = '" . (int)$extension_id . "', image = '" . $this->db->escape($img) . "', sort_order = '" . (int)$order . "'");
					}
				}
			}
		}

		if (isset($data['extension_download'])) {
			$old_downloads = $this->db->query("SELECT extension_download_id FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");
			foreach ($old_downloads->rows as $old_dl) {
				$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download_path` WHERE extension_download_id = '" . (int)$old_dl['extension_download_id'] . "'");
			}
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");

			if (is_array($data['extension_download'])) {
				foreach ($data['extension_download'] as $extension_download) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_download` SET extension_id = '" . (int)$extension_id . "', name = '" . $this->db->escape(isset($extension_download['name']) ? $extension_download['name'] : '') . "', filename = '" . $this->db->escape(isset($extension_download['filename']) ? $extension_download['filename'] : '') . "', mask = '" . $this->db->escape(isset($extension_download['mask']) ? $extension_download['mask'] : '') . "', cloud = '" . (int)(isset($extension_download['cloud']) ? $extension_download['cloud'] : 0) . "', approved = '1', downloaded = '" . (int)(isset($extension_download['downloaded']) ? $extension_download['downloaded'] : 0) . "', date_added = NOW()");

					$extension_download_id = $this->db->getLastId();

					if (isset($extension_download['download_id']) && is_array($extension_download['download_id'])) {
						foreach ($extension_download['download_id'] as $download_id) {
							$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_download_path` SET extension_download_id = '" . (int)$extension_download_id . "', download_id = '" . (int)$download_id . "'");
						}
					}
				}
			}
		}
	}

	public function deleteExtension($extension_id) {
		$check = $this->db->query("SELECT extension_id FROM `" . DB_PREFIX . "extension` WHERE extension_id = '" . (int)$extension_id . "' AND member_id = '" . (int)$this->member->getId() . "'");

		if ($check->num_rows) {
			$old_downloads = $this->db->query("SELECT extension_download_id FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");
			foreach ($old_downloads->rows as $old_dl) {
				$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download_path` WHERE extension_download_id = '" . (int)$old_dl['extension_download_id'] . "'");
			}
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_image` WHERE extension_id = '" . (int)$extension_id . "'");
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_comment` WHERE extension_id = '" . (int)$extension_id . "'");
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_rating` WHERE extension_id = '" . (int)$extension_id . "'");
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension` WHERE extension_id = '" . (int)$extension_id . "'");
		}
	}
}

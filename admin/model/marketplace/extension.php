<?php
class ModelMarketplaceExtension extends Model {
	public function addExtension($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "extension` SET member_id = '" . (int)$data['member_id'] . "', extension_category_id = '" . (int)$data['extension_category_id'] . "', name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', documentation = '" . $this->db->escape($data['documentation']) . "', history = '" . $this->db->escape($data['history']) . "', license = '" . (int)$data['license'] . "', license_period = '" . (int)$data['license_period'] . "', price = '" . (float)$data['price'] . "', image = '" . $this->db->escape($data['image']) . "', banner = '" . $this->db->escape($data['banner']) . "', tag = '" . $this->db->escape($data['tag']) . "', cloud = '" . $this->db->escape(isset($data['cloud']) ? $data['cloud'] : '1') . "', recommended = '" . (int)(isset($data['recommended']) ? $data['recommended'] : 0) . "', featured = '" . (int)(isset($data['featured']) ? $data['featured'] : 0) . "', publish = '" . (int)(isset($data['publish']) ? $data['publish'] : 1) . "', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 1) . "', alert = '" . (int)(isset($data['alert']) ? $data['alert'] : 1) . "', reviews_enabled = '" . (int)(isset($data['reviews_enabled']) ? $data['reviews_enabled'] : 1) . "', comments_enabled = '" . (int)(isset($data['comments_enabled']) ? $data['comments_enabled'] : 1) . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_modified = NOW()");

		$extension_id = $this->db->getLastId();

		if (isset($data['extension_image'])) {
			foreach ($data['extension_image'] as $extension_image) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_image` SET extension_id = '" . (int)$extension_id . "', image = '" . $this->db->escape($extension_image['image']) . "', sort_order = '" . (int)$extension_image['sort_order'] . "'");
			}
		}

		if (isset($data['extension_download'])) {
			foreach ($data['extension_download'] as $extension_download) {
				if (!empty($extension_download['name'])) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_download` SET extension_id = '" . (int)$extension_id . "', name = '" . $this->db->escape($extension_download['name']) . "', filename = '" . $this->db->escape($extension_download['filename']) . "', mask = '" . $this->db->escape($extension_download['mask']) . "', cloud = '" . (int)(isset($extension_download['cloud']) ? $extension_download['cloud'] : 1) . "', approved = '" . (int)(isset($extension_download['approved']) ? $extension_download['approved'] : 1) . "', date_added = NOW()");

					$extension_download_id = $this->db->getLastId();

					if (isset($extension_download['download_id']) && is_array($extension_download['download_id'])) {
						foreach ($extension_download['download_id'] as $download_id) {
							$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_download_path` SET extension_download_id = '" . (int)$extension_download_id . "', download_id = '" . (int)$download_id . "'");
						}
					}
				}
			}
		}

		return $extension_id;
	}

	public function editExtension($extension_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "extension` SET member_id = '" . (int)$data['member_id'] . "', extension_category_id = '" . (int)$data['extension_category_id'] . "', name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', documentation = '" . $this->db->escape($data['documentation']) . "', history = '" . $this->db->escape($data['history']) . "', license = '" . (int)$data['license'] . "', license_period = '" . (int)$data['license_period'] . "', price = '" . (float)$data['price'] . "', image = '" . $this->db->escape($data['image']) . "', banner = '" . $this->db->escape($data['banner']) . "', tag = '" . $this->db->escape($data['tag']) . "', cloud = '" . $this->db->escape(isset($data['cloud']) ? $data['cloud'] : '1') . "', recommended = '" . (int)(isset($data['recommended']) ? $data['recommended'] : 0) . "', featured = '" . (int)(isset($data['featured']) ? $data['featured'] : 0) . "', publish = '" . (int)(isset($data['publish']) ? $data['publish'] : 1) . "', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 1) . "', alert = '" . (int)(isset($data['alert']) ? $data['alert'] : 1) . "', reviews_enabled = '" . (int)(isset($data['reviews_enabled']) ? $data['reviews_enabled'] : 1) . "', comments_enabled = '" . (int)(isset($data['comments_enabled']) ? $data['comments_enabled'] : 1) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE extension_id = '" . (int)$extension_id . "'");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_image` WHERE extension_id = '" . (int)$extension_id . "'");

		if (isset($data['extension_image'])) {
			foreach ($data['extension_image'] as $extension_image) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_image` SET extension_id = '" . (int)$extension_id . "', image = '" . $this->db->escape($extension_image['image']) . "', sort_order = '" . (int)$extension_image['sort_order'] . "'");
			}
		}

		// Clear old downloads & paths
		$old_downloads = $this->db->query("SELECT extension_download_id FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");
		foreach ($old_downloads->rows as $old_dl) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download_path` WHERE extension_download_id = '" . (int)$old_dl['extension_download_id'] . "'");
		}
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");

		if (isset($data['extension_download'])) {
			foreach ($data['extension_download'] as $extension_download) {
				if (!empty($extension_download['name'])) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "extension_download` SET extension_id = '" . (int)$extension_id . "', name = '" . $this->db->escape($extension_download['name']) . "', filename = '" . $this->db->escape($extension_download['filename']) . "', mask = '" . $this->db->escape($extension_download['mask']) . "', cloud = '" . (int)(isset($extension_download['cloud']) ? $extension_download['cloud'] : 1) . "', approved = '" . (int)(isset($extension_download['approved']) ? $extension_download['approved'] : 1) . "', downloaded = '" . (int)(isset($extension_download['downloaded']) ? $extension_download['downloaded'] : 0) . "', date_added = NOW()");

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
		$old_downloads = $this->db->query("SELECT extension_download_id FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");
		foreach ($old_downloads->rows as $old_dl) {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download_path` WHERE extension_download_id = '" . (int)$old_dl['extension_download_id'] . "'");
		}
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_image` WHERE extension_id = '" . (int)$extension_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_comment` WHERE extension_id = '" . (int)$extension_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_rating` WHERE extension_id = '" . (int)$extension_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_promotion` WHERE extension_id = '" . (int)$extension_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension` WHERE extension_id = '" . (int)$extension_id . "'");
	}

	public function getExtension($extension_id) {
		$query = $this->db->query("SELECT e.*, ec.name AS category_name, m.username AS member_username FROM `" . DB_PREFIX . "extension` e LEFT JOIN `" . DB_PREFIX . "extension_category` ec ON (e.extension_category_id = ec.extension_category_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) WHERE e.extension_id = '" . (int)$extension_id . "'");

		return $query->row;
	}

	public function getExtensions($data = array()) {
		$sql = "SELECT e.*, ec.name AS category_name, m.username AS member_username FROM `" . DB_PREFIX . "extension` e LEFT JOIN `" . DB_PREFIX . "extension_category` ec ON (e.extension_category_id = ec.extension_category_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) WHERE 1=1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND e.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_extension_category_id'])) {
			$sql .= " AND e.extension_category_id = '" . (int)$data['filter_extension_category_id'] . "'";
		}

		if (isset($data['filter_license']) && $data['filter_license'] !== '') {
			$sql .= " AND e.license = '" . (int)$data['filter_license'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND e.status = '" . (int)$data['filter_status'] . "'";
		}

		$sort_data = array(
			'e.name',
			'category_name',
			'member_username',
			'e.price',
			'e.sales',
			'e.downloaded',
			'e.status',
			'e.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY e.date_modified";
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
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalExtensions($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension` e WHERE 1=1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND e.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_extension_category_id'])) {
			$sql .= " AND e.extension_category_id = '" . (int)$data['filter_extension_category_id'] . "'";
		}

		if (isset($data['filter_license']) && $data['filter_license'] !== '') {
			$sql .= " AND e.license = '" . (int)$data['filter_license'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND e.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getExtensionImages($extension_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_image` WHERE extension_id = '" . (int)$extension_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getExtensionDownloads($extension_id) {
		$downloads = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_download` WHERE extension_id = '" . (int)$extension_id . "' ORDER BY extension_download_id ASC");

		foreach ($query->rows as $row) {
			$path_query = $this->db->query("SELECT download_id FROM `" . DB_PREFIX . "extension_download_path` WHERE extension_download_id = '" . (int)$row['extension_download_id'] . "'");
			$download_ids = array();
			foreach ($path_query->rows as $p) {
				$download_ids[] = $p['download_id'];
			}
			$row['download_id'] = $download_ids;
			$downloads[] = $row;
		}

		return $downloads;
	}
}

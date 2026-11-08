<?php
class ModelCmsDownload extends Model {
	private static $synced = false;

	private static $github_releases = array(
		'4.1.0.4' => 'https://github.com/opencart/opencart/releases/download/4.1.0.4/opencart-4.1.0.4.zip',
		'3.0.5.1' => 'https://github.com/opencart/opencart/releases/download/3.0.5.1/opencart-3.0.5.1.zip',
		'3.0.5.0' => 'https://github.com/opencart/opencart/releases/download/3.0.5.0/opencart-3.0.5.0.zip',
		'3.0.4.1' => 'https://github.com/opencart/opencart/releases/download/3.0.4.1/3.0.4.1.zip',
		'4.1.0.3' => 'https://github.com/opencart/opencart/releases/download/4.1.0.3/opencart-4.1.0.3.zip',
		'4.1.0.2' => 'https://github.com/opencart/opencart/releases/download/4.1.0.2/opencart-4.1.0.2.zip',
		'4.1.0.1' => 'https://github.com/opencart/opencart/releases/download/4.1.0.1/opencart-4.1.0.1.zip',
		'4.1.0.0' => 'https://github.com/opencart/opencart/releases/download/4.1.0.0/opencart-4.1.0.0.zip',
		'3.0.4.0' => 'https://github.com/opencart/opencart/releases/download/3.0.4.0/opencart-3.0.4.0.zip',
		'3.0.3.9' => 'https://github.com/opencart/opencart/releases/download/3.0.3.9/opencart-3.0.3.9.zip',
		'4.0.2.3' => 'https://github.com/opencart/opencart/releases/download/4.0.2.3/opencart-4.0.2.3.zip',
		'4.0.2.2' => 'https://github.com/opencart/opencart/releases/download/4.0.2.2/opencart-4.0.2.2.zip',
		'4.0.2.1' => 'https://github.com/opencart/opencart/releases/download/4.0.2.1/opencart-4.0.2.1.zip',
		'4.0.2.0' => 'https://github.com/opencart/opencart/releases/download/4.0.2.0/opencart-4.0.2.0.zip',
		'4.0.1.1' => 'https://github.com/opencart/opencart/releases/download/4.0.1.1/opencart-4.0.1.1.zip',
		'4.0.1.0' => 'https://github.com/opencart/opencart/releases/download/4.0.1.0/opencart-4.0.1.0.zip',
		'4.0.0.0' => 'https://github.com/opencart/opencart/releases/download/4.0.0.0/opencart-4.0.0.0.zip',
		'3.0.3.8' => 'https://github.com/opencart/opencart/releases/download/3.0.3.8/opencart-3.0.3.8.zip',
		'3.0.3.7' => 'https://github.com/opencart/opencart/releases/download/3.0.3.7/opencart-3.0.3.7.zip',
		'3.0.3.6' => 'https://github.com/opencart/opencart/releases/download/3.0.3.6/opencart-3.0.3.6.zip',
		'3.0.3.5' => 'https://github.com/opencart/opencart/releases/download/3.0.3.5/opencart-3.0.3.5.zip',
		'3.0.3.4' => 'https://github.com/opencart/opencart/releases/download/3.0.3.4/opencart-3.0.3.4-core-pre.zip',
		'3.0.3.3' => 'https://github.com/opencart/opencart/releases/download/3.0.3.3/opencart-3.0.3.3.zip',
		'3.0.3.2' => 'https://github.com/opencart/opencart/releases/download/3.0.3.2/opencart-3.0.3.2.zip',
		'3.0.3.1' => 'https://github.com/opencart/opencart/releases/download/3.0.3.1/opencart-3.0.3.1.zip',
		'3.0.3.0' => 'https://github.com/opencart/opencart/releases/download/3.0.3.0/opencart-3.0.3.0.zip',
		'3.0.2.0' => 'https://github.com/opencart/opencart/releases/download/3.0.2.0/3.0.2.0-OpenCart.zip',
		'3.0.1.3' => 'https://github.com/opencart/opencart/releases/download/3.0.1.2/3.0.1.2-opencart.zip',
		'3.0.1.2' => 'https://github.com/opencart/opencart/releases/download/3.0.1.2/3.0.1.2-opencart.zip',
		'3.0.1.1' => 'https://github.com/opencart/opencart/releases/download/3.0.1.1/3.0.1.1-compiled.zip',
		'3.0.1.0' => 'https://github.com/opencart/opencart/archive/refs/tags/3.0.0.2.zip',
		'3.0.0.0' => 'https://github.com/opencart/opencart/releases/download/3.0.0.0/3.0.0.0-compiled.zip',
		'2.3.0.2' => 'https://github.com/opencart/opencart/releases/download/2.3.0.2/2.3.0.2-compiled.zip',
		'2.3.0.1' => 'https://github.com/opencart/opencart/releases/download/2.3.0.1/2.3.0.1-compiled.zip',
		'2.3.0.0' => 'https://github.com/opencart/opencart/releases/download/2.3.0.0/2.3.0.0-compiled.zip',
		'2.2.0.0' => 'https://github.com/opencart/opencart/releases/download/2.2.0.0/2.2.0.0-compiled.zip',
		'2.1.0.2' => 'https://github.com/opencart/opencart/archive/refs/tags/2.1.0.2.zip',
		'2.1.0.1' => 'https://github.com/opencart/opencart/archive/refs/tags/2.1.0.1.zip',
		'2.1.0.0' => 'https://github.com/opencart/opencart/archive/refs/tags/2.1.0.0.zip',
		'2.0.3.1' => 'https://github.com/opencart/opencart/archive/refs/tags/2.0.3.1.zip',
		'2.0.3.0' => 'https://github.com/opencart/opencart/archive/refs/tags/2.0.3.0.zip',
		'2.0.2.0' => 'https://github.com/opencart/opencart/archive/refs/tags/2.0.2.0.zip',
		'2.0.1.1' => 'https://github.com/opencart/opencart/archive/refs/tags/2.0.1.1.zip',
		'2.0.1.0' => 'https://github.com/opencart/opencart/archive/refs/tags/2.0.1.0.zip',
		'2.0.0.0' => 'https://github.com/opencart/opencart/archive/refs/tags/2.0.0.0.zip',
		'1.5.6.4' => 'https://github.com/opencart/opencart/archive/refs/tags/1.5.6.4.zip',
		'1.5.6.3' => 'https://github.com/opencart/opencart/archive/refs/tags/1.5.6.3.zip',
		'1.5.6.2' => 'https://github.com/opencart/opencart/archive/refs/tags/1.5.6.2.zip',
		'1.5.6.1' => 'https://github.com/opencart/opencart/archive/refs/tags/1.5.6.1.zip',
		'1.5.6'   => 'https://github.com/opencart/opencart/archive/refs/tags/1.5.6.zip',
		'1.5.5.1' => 'https://github.com/opencart/opencart/archive/refs/tags/1.5.5.1.zip'
	);

	private function syncReleaseLinks() {
		if (self::$synced) {
			return;
		}
		self::$synced = true;

		$check = $this->db->query("SELECT download_id, name, href FROM `" . DB_PREFIX . "download` WHERE href = '' OR href IS NULL");
		if ($check && !empty($check->rows)) {
			foreach ($check->rows as $row) {
				$version = trim((string)$row['name']);
				if ($version !== '') {
					$resolved_href = isset(self::$github_releases[$version])
						? self::$github_releases[$version]
						: ('https://github.com/opencart/opencart/releases/download/' . $version . '/opencart-' . $version . '.zip');
					$this->db->query("UPDATE `" . DB_PREFIX . "download` SET href = '" . $this->db->escape($resolved_href) . "' WHERE download_id = '" . (int)$row['download_id'] . "'");
				}
			}
		}
	}

	public function addDownload($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "download` SET name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', href = '" . $this->db->escape($data['href']) . "', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function editDownload($download_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "download` SET name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', href = '" . $this->db->escape($data['href']) . "' WHERE download_id = '" . (int)$download_id . "'");
	}

	public function deleteDownload($download_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "extension_download_path` WHERE download_id = '" . (int)$download_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "download` WHERE download_id = '" . (int)$download_id . "'");
	}

	public function getDownload($download_id) {
		$this->syncReleaseLinks();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "download` WHERE download_id = '" . (int)$download_id . "'");

		return $query->row;
	}

	public function getDownloads($data = array()) {
		$this->syncReleaseLinks();

		$sql = "SELECT * FROM `" . DB_PREFIX . "download` ORDER BY date_added DESC, download_id DESC";

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

	public function getTotalDownloads() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "download`");

		return $query->row['total'];
	}
}

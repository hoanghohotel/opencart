<?php
class ModelUpgrade1006 extends Model {
	private function tableExists($table) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "'");
		return !empty($query->row['total']);
	}

	private function columnExists($table, $column) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "' AND COLUMN_NAME = '" . $this->db->escape($column) . "'");
		return !empty($query->row['total']);
	}

	public function upgrade() {
		if ($this->tableExists(DB_PREFIX . 'setting')) {
			// Update some language settings
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = 'en-gb' WHERE `key` = 'config_language' AND `value` = 'en'");
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = 'en-gb' WHERE `key` = 'config_admin_language' AND `value` = 'en'");
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `key` = 'config_theme' WHERE `key` = 'config_template'");
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = 'default' WHERE `key` = 'config_theme' AND `value` = 'theme_default'");
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = REPLACE(`value`, 'data/', 'catalog/')");
		}

		if ($this->tableExists(DB_PREFIX . 'language')) {
			$this->db->query("UPDATE `" . DB_PREFIX . "language` SET `code` = 'en-gb' WHERE `code` = 'en'");
		}

		// Update image paths from data/ to catalog/ on tables that have image/description columns
		$image_tables = array('banner_image', 'category', 'manufacturer', 'product', 'product_image', 'option_value', 'voucher_theme');
		foreach ($image_tables as $tbl) {
			if ($this->tableExists(DB_PREFIX . $tbl) && $this->columnExists(DB_PREFIX . $tbl, 'image')) {
				$this->db->query("UPDATE `" . DB_PREFIX . $tbl . "` SET `image` = REPLACE(`image`, 'data/', 'catalog/')");
			}
		}

		$desc_tables = array('product_description', 'category_description', 'information_description', 'blog', 'extension');
		foreach ($desc_tables as $tbl) {
			if ($this->tableExists(DB_PREFIX . $tbl) && $this->columnExists(DB_PREFIX . $tbl, 'description')) {
				$this->db->query("UPDATE `" . DB_PREFIX . $tbl . "` SET `description` = REPLACE(`description`, 'data/', 'catalog/')");
			}
		}

		// Ensure config.php and admin/config.php define DB_PORT without corrupting DIR_STORAGE paths
		if (is_file(DIR_OPENCART . 'config.php')) {
			$files = glob(DIR_OPENCART . '{config.php,*/config.php}', GLOB_BRACE);

			foreach ($files as $file) {
				if (!is_writable($file)) {
					continue;
				}

				$content = file_get_contents($file);
				if (strpos($content, 'DB_PORT') === false && strpos($content, 'DB_DATABASE') !== false) {
					$lines = file($file);
					for ($i = 0; $i < count($lines); $i++) {
						if (strpos($lines[$i], 'DB_DATABASE') !== false) {
							array_splice($lines, $i + 1, 0, array("define('DB_PORT', '" . ini_get('mysqli.default_port') . "');\n"));
							break;
						}
					}
					$output = implode('', $lines);
					$fp = fopen($file, 'w');
					fwrite($fp, $output);
					fclose($fp);
				}
			}
		}
	}
}

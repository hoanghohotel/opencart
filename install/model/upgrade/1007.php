<?php
class ModelUpgrade1007 extends Model {
	private function tableExists($table) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "'");
		return !empty($query->row['total']);
	}

	private function columnExists($table, $column) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "' AND COLUMN_NAME = '" . $this->db->escape($column) . "'");
		return !empty($query->row['total']);
	}

	public function upgrade() {
		// Download filename length
		if ($this->tableExists(DB_PREFIX . 'download') && $this->columnExists(DB_PREFIX . 'download', 'filename')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "download` CHANGE `filename` `filename` VARCHAR(160) NOT NULL");
		}

		// Legacy extension table check (only when `type` and `code` columns exist)
		if ($this->tableExists(DB_PREFIX . 'extension') && $this->columnExists(DB_PREFIX . 'extension', 'type') && $this->columnExists(DB_PREFIX . 'extension', 'code')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type` = 'theme'");

			if (!$query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "extension` SET `type` = 'theme', `code` = 'theme_default'");
			}
		}
	}
}

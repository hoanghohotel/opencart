<?php
class ModelUpgrade1008 extends Model {
	private function tableExists($table) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "'");
		return !empty($query->row['total']);
	}

	private function columnExists($table, $column) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "' AND COLUMN_NAME = '" . $this->db->escape($column) . "'");
		return !empty($query->row['total']);
	}

	public function upgrade() {
		if ($this->tableExists(DB_PREFIX . 'option') && $this->columnExists(DB_PREFIX . 'option', 'type')) {
			$this->db->query("UPDATE `" . DB_PREFIX . "option` SET `type` = 'radio' WHERE `type` = 'image'");
		}

		// Legacy extension dashboard check (only when `type` and `code` columns exist)
		if ($this->tableExists(DB_PREFIX . 'extension') && $this->columnExists(DB_PREFIX . 'extension', 'type') && $this->columnExists(DB_PREFIX . 'extension', 'code')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type` = 'dashboard'");

			if (!$query->num_rows) {
				$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `key` = 'payment_free_checkout_order_status_id' WHERE `key` = 'free_checkout_order_status_id'");
			}
		}
	}
}

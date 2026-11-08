<?php
class ModelUpgrade1004 extends Model {
	private function tableExists($table) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "'");
		return !empty($query->row['total']);
	}

	private function columnExists($table, $column) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "' AND COLUMN_NAME = '" . $this->db->escape($column) . "'");
		return !empty($query->row['total']);
	}

	public function upgrade() {
		// custom_field
		if ($this->tableExists(DB_PREFIX . 'custom_field') && $this->columnExists(DB_PREFIX . 'custom_field', 'required')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "custom_field` DROP `required`");
		}

		// Update some language settings
		if ($this->tableExists(DB_PREFIX . 'setting')) {
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `code` = 'config', `key` = 'config_Receive_mail' WHERE `key` = 'config_alert_mail'");

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_detection'");

			if ($query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `code` = 'maxmind', `key` = 'maxmind_status', `value` = '" . $this->db->escape($query->row['value']) . "', `serialized` = '0'");
				$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_detection'");
			}

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_key'");

			if ($query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `code` = 'maxmind', `key` = 'maxmind_key', `value` = '" . $this->db->escape($query->row['value']) . "', `serialized` = '0'");
				$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_key'");
			}

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_score'");

			if ($query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `code` = 'maxmind', `key` = 'maxmind_score', `value` = '" . $this->db->escape($query->row['value']) . "', `serialized` = '0'");
				$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_score'");
			}

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_status_id'");

			if ($query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `code` = 'maxmind', `key` = 'maxmind_order_status_id', `value` = '" . $this->db->escape($query->row['value']) . "', `serialized` = '0'");
				$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_status_id'");
			}

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_secure'");

			if (!$query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '0', `code` = 'config', `key` = 'config_secure', `value` = '0', `serialized` = '0'");
			}
		}

		// order
		if ($this->tableExists(DB_PREFIX . 'order') && $this->columnExists(DB_PREFIX . 'order', 'commission') && $this->columnExists(DB_PREFIX . 'order', 'affiliate_id')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` MODIFY `commission` decimal(15,4) NOT NULL AFTER `affiliate_id`");
		}

		// Legacy extension table (only if it has `type` and `code` columns, NOT Marketplace `oc_extension`)
		if ($this->tableExists(DB_PREFIX . 'extension') && $this->columnExists(DB_PREFIX . 'extension', 'type') && $this->columnExists(DB_PREFIX . 'extension', 'code')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'maxmind_status'");

			if ($query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "extension` SET `type` = 'fraud', `code` = 'maxmind'");
			}
		}
	}
}

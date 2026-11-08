<?php
class ModelUpgrade1005 extends Model {
	private function tableExists($table) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "'");
		return !empty($query->row['total']);
	}

	private function columnExists($table, $column) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "' AND COLUMN_NAME = '" . $this->db->escape($column) . "'");
		return !empty($query->row['total']);
	}

	public function upgrade() {
		// api
		if ($this->tableExists(DB_PREFIX . 'api')) {
			if ($this->columnExists(DB_PREFIX . 'api', 'name') && !$this->columnExists(DB_PREFIX . 'api', 'username')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "api` CHANGE `name` `username` VARCHAR(64) NOT NULL");
			} elseif ($this->columnExists(DB_PREFIX . 'api', 'name') && $this->columnExists(DB_PREFIX . 'api', 'username')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "api` DROP `name`");
			}
		}

		// custom_field
		if ($this->tableExists(DB_PREFIX . 'custom_field') && !$this->columnExists(DB_PREFIX . 'custom_field', 'validation')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "custom_field` ADD `validation` varchar(255) NOT NULL AFTER `value`");
		}

		// product
		if ($this->tableExists(DB_PREFIX . 'product') && $this->columnExists(DB_PREFIX . 'product', 'model')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` CHANGE `model` `model` VARCHAR(64) NOT NULL");
		}

		// product_description
		if ($this->tableExists(DB_PREFIX . 'product_description') && $this->columnExists(DB_PREFIX . 'product_description', 'meta_title')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` CHANGE `meta_title` `meta_title` VARCHAR(255) NOT NULL");
		}

		// category_description
		if ($this->tableExists(DB_PREFIX . 'category_description') && $this->columnExists(DB_PREFIX . 'category_description', 'meta_title')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` CHANGE `meta_title` `meta_title` VARCHAR(255) NOT NULL");
		}

		// setting
		if ($this->tableExists(DB_PREFIX . 'setting')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_encryption'");

			if (!$query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `code` = 'config', `key` = 'config_encryption', `value` = '" . $this->db->escape(token(1024)) . "'");
			}
		}
	}
}

<?php
class ModelUpgrade1002 extends Model {
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
			// Setting
			$query = $this->db->query("SELECT `setting_id` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_product_count'");

			if (!$query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `key` = 'config_product_count', `value` = '1', `code` = 'config', `serialized` = '0', `store_id` = 0");
			}

			// Account
			$query = $this->db->query("SELECT `setting_id` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_fraud_status_id'");

			if (!$query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `key` = 'config_fraud_status_id', `value` = '8', `code` = 'config', `serialized` = '0', `store_id` = 0");
			}

			// API
			$query = $this->db->query("SELECT `setting_id` FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_api_id'");

			if (!$query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `key` = 'config_api_id', `value` = '1', `code` = 'config', `serialized` = '0', `store_id` = 0");
			}
		}

		// Customer
		if ($this->tableExists(DB_PREFIX . 'customer') && $this->columnExists(DB_PREFIX . 'customer', 'safe')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "customer` CHANGE `safe` `safe` tinyint(1) NOT NULL DEFAULT '0'");
		}

		// Product
		if ($this->tableExists(DB_PREFIX . 'product_option')) {
			if ($this->columnExists(DB_PREFIX . 'product_option', 'option_value')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option` CHANGE `option_value` `value` TEXT NOT NULL");
			} elseif ($this->columnExists(DB_PREFIX . 'product_option', 'value')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option` CHANGE `value` `value` TEXT NOT NULL");
			}
		}

		// Categories
		if ($this->tableExists(DB_PREFIX . 'category_description') && $this->columnExists(DB_PREFIX . 'category_description', 'meta_title') && $this->columnExists(DB_PREFIX . 'category_description', 'description')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` MODIFY `meta_title` varchar(255) NOT NULL AFTER `description`");
		}

		// Sort the categories to take advantage of the nested set model
		if ($this->tableExists(DB_PREFIX . 'category') && $this->tableExists(DB_PREFIX . 'category_path')) {
			$this->repairCategories(0);
		}
	}

	// Function to repair any erroneous categories that are not in the category path table.
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category` WHERE `parent_id` = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$category['category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE `category_id` = '" . (int)$parent_id . "' ORDER BY `level` ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', `level` = '" . (int)$level . "'");

			$this->repairCategories($category['category_id']);
		}
	}
}

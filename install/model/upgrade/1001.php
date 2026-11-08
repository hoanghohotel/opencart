<?php
class ModelUpgrade1001 extends Model {
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

			// Update some currency settings
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `key` = 'config_limit_admin' WHERE `key` = 'config_admin_limit'");

			// Update the config.php by adding aprocessing and complete status
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `key` = 'config_processing_status', `value` = '[\"2\"]', `serialized` = '1' WHERE `key` = 'config_order_status_id'");

			$setting_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_complete_status_id'");

			foreach ($setting_query->rows as $setting) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '" . (int)$setting['store_id'] . "', `code` = 'config', `key` = 'config_complete_status', `value` = '[\"" . (int)$setting['value'] . "\"]', `serialized` = '1'");
			}

			$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'config_complete_status_id'");
		}

		// Convert rows in the address table into the new custom field structure
		if ($this->tableExists(DB_PREFIX . 'address') && $this->tableExists(DB_PREFIX . 'custom_field') && $this->tableExists(DB_PREFIX . 'custom_field_description') && $this->columnExists(DB_PREFIX . 'address', 'custom_field')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "address` WHERE `company_id` != '' OR `tax_id` != ''");

			if ($query->num_rows) {
				$language_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language`");

				if ($this->columnExists(DB_PREFIX . 'address', 'company_id')) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "custom_field` SET `type` = 'text', `value` = '', `location` = 'address', `status` = '1', `sort_order` = '1'");

					$custom_field_id = $this->db->getLastId();

					foreach ($language_query->rows as $language) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "custom_field_description` SET `custom_field_id` = '" . (int)$custom_field_id . "', `language_id` = '" . (int)$language['language_id'] . "', `name` = 'Company ID'");
					}

					foreach ($query->rows as $result) {
						if (!empty($result['custom_field'])) {
							$custom_field_data = json_decode($result['custom_field'], true);
						} else {
							$custom_field_data = array();
						}

						if (!empty($result['company_id'])) {
							$custom_field_data[$custom_field_id] = $result['company_id'];

							$this->db->query("UPDATE `" . DB_PREFIX . "address` SET `custom_field` = '" . $this->db->escape(json_encode($custom_field_data)) . "' WHERE `address_id` = '" . (int)$result['address_id'] . "'");
						}
					}

					$this->db->query("ALTER TABLE `" . DB_PREFIX . "address` DROP `company_id`");
				}

				if ($this->columnExists(DB_PREFIX . 'address', 'tax_id')) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "custom_field` SET `type` = 'text', `value` = '', `location` = 'address', `status` = '1', `sort_order` = '1'");

					$custom_field_id = $this->db->getLastId();

					foreach ($language_query->rows as $language) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "custom_field_description` SET `custom_field_id` = '" . (int)$custom_field_id . "', `language_id` = '" . (int)$language['language_id'] . "', `name` = 'Tax ID'");
					}

					foreach ($query->rows as $result) {
						if (!empty($result['custom_field'])) {
							$custom_field_data = json_decode($result['custom_field'], true);
						} else {
							$custom_field_data = array();
						}

						if (!empty($result['tax_id'])) {
							$custom_field_data[$custom_field_id] = $result['tax_id'];

							$this->db->query("UPDATE `" . DB_PREFIX . "address` SET `custom_field` = '" . $this->db->escape(json_encode($custom_field_data)) . "' WHERE `address_id` = '" . (int)$result['address_id'] . "'");
						}
					}

					$this->db->query("ALTER TABLE `" . DB_PREFIX . "address` DROP `tax_id`");
				}
			}
		}

		if ($this->tableExists(DB_PREFIX . 'order')) {
			if ($this->columnExists(DB_PREFIX . 'order', 'payment_company_id')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` DROP `payment_company_id`");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'payment_tax_id')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` DROP `payment_tax_id`");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'payment_company')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` CHANGE `payment_company` `payment_company` VARCHAR(60) NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'shipping_company')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` CHANGE `shipping_company` `shipping_company` VARCHAR(60) NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'payment_address_format') && $this->columnExists(DB_PREFIX . 'order', 'payment_custom_field')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` MODIFY `payment_custom_field` TEXT NOT NULL AFTER `payment_address_format`");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'shipping_address_format') && $this->columnExists(DB_PREFIX . 'order', 'shipping_custom_field')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` MODIFY `shipping_custom_field` TEXT NOT NULL AFTER `shipping_address_format`");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'telephone') && $this->columnExists(DB_PREFIX . 'order', 'custom_field')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` MODIFY `custom_field` TEXT NOT NULL AFTER `telephone`");
			}
		}

		// Sort the categories to take advantage of the nested set model
		if ($this->tableExists(DB_PREFIX . 'order_history') && $this->columnExists(DB_PREFIX . 'order_history', 'comment')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_history` CHANGE `comment` `comment` TEXT NOT NULL");
		}

		// Order Recurring
		if ($this->tableExists(DB_PREFIX . 'order_recurring')) {
			if ($this->columnExists(DB_PREFIX . 'order_recurring', 'profile_id')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_recurring` CHANGE `profile_id` `recurring_id` int(11) NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order_recurring', 'profile_name')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_recurring` CHANGE `profile_name` `recurring_name` varchar(255) NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order_recurring', 'profile_description')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_recurring` CHANGE `profile_description` `recurring_description` varchar(255) NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order_recurring', 'created')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_recurring` CHANGE `created` `date_added` datetime NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order_recurring', 'order_recurring_id')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_recurring` MODIFY `order_recurring_id` int(11) NOT NULL AUTO_INCREMENT FIRST");
			}
		}

		// Customer
		if ($this->tableExists(DB_PREFIX . 'customer') && $this->columnExists(DB_PREFIX . 'customer', 'ip') && $this->columnExists(DB_PREFIX . 'customer', 'custom_field')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "customer` MODIFY `custom_field` TEXT NOT NULL AFTER `ip`");
		}
	}
}

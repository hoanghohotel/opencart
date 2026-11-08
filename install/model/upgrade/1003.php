<?php
class ModelUpgrade1003 extends Model {
	private function tableExists($table) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "'");
		return !empty($query->row['total']);
	}

	private function columnExists($table, $column) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "' AND COLUMN_NAME = '" . $this->db->escape($column) . "'");
		return !empty($query->row['total']);
	}

	public function upgrade() {
		// address
		if ($this->tableExists(DB_PREFIX . 'address') && $this->columnExists(DB_PREFIX . 'address', 'custom_field')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "address` CHANGE `custom_field` `custom_field` TEXT NOT NULL");
		}

		// customer
		if ($this->tableExists(DB_PREFIX . 'customer') && $this->columnExists(DB_PREFIX . 'customer', 'custom_field')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "customer` CHANGE `custom_field` `custom_field` TEXT NOT NULL");
		}

		// order
		if ($this->tableExists(DB_PREFIX . 'order')) {
			if ($this->columnExists(DB_PREFIX . 'order', 'custom_field')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` CHANGE `custom_field` `custom_field` TEXT NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'payment_custom_field')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` CHANGE `payment_custom_field` `payment_custom_field` TEXT NOT NULL");
			}

			if ($this->columnExists(DB_PREFIX . 'order', 'shipping_custom_field')) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` CHANGE `shipping_custom_field` `shipping_custom_field` TEXT NOT NULL");
			}
		}

		// customer_activity
		if ($this->tableExists(DB_PREFIX . 'customer_activity') && $this->columnExists(DB_PREFIX . 'customer_activity', 'activity_id')) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "customer_activity` CHANGE `activity_id` `customer_activity_id` INT(11) NOT NULL AUTO_INCREMENT");
		}

		// module
		if ($this->tableExists(DB_PREFIX . 'module') && $this->columnExists(DB_PREFIX . 'module', 'setting')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module`");

			foreach ($query->rows as $result) {
				if (preg_match('/^(a:[0-9]+:\{.*\})$/', $result['setting'])) {
					$setting = unserialize($result['setting']);

					$this->db->query("UPDATE `" . DB_PREFIX . "module` SET `setting` = '" . $this->db->escape(json_encode($setting)) . "' WHERE `module_id` = '" . (int)$result['module_id'] . "'");
				}
			}
		}

		// customer
		if ($this->tableExists(DB_PREFIX . 'customer')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer`");

			foreach ($query->rows as $result) {
				if (isset($result['cart']) && preg_match('/^(a:[0-9]+:\{.*\})$/', $result['cart'])) {
					$cart = unserialize($result['cart']);

					$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `cart` = '" . $this->db->escape(json_encode($cart)) . "' WHERE `customer_id` = '" . (int)$result['customer_id'] . "'");
				}

				if (isset($result['wishlist']) && preg_match('/^(a:[0-9]+:\{.*\})$/', $result['wishlist'])) {
					$wishlist = unserialize($result['wishlist']);

					$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `wishlist` = '" . $this->db->escape(json_encode($wishlist)) . "' WHERE `customer_id` = '" . (int)$result['customer_id'] . "'");
				}

				if (isset($result['custom_field']) && preg_match('/^(a:[0-9]+:\{.*\})$/', $result['custom_field'])) {
					$custom_field = unserialize($result['custom_field']);

					$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `custom_field` = '" . $this->db->escape(json_encode($custom_field)) . "' WHERE `customer_id` = '" . (int)$result['customer_id'] . "'");
				}
			}
		}

		// address
		if ($this->tableExists(DB_PREFIX . 'address') && $this->columnExists(DB_PREFIX . 'address', 'custom_field')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "address`");

			foreach ($query->rows as $result) {
				if (preg_match('/^(a:[0-9]+:\{.*\})$/', $result['custom_field'])) {
					$custom_field = unserialize($result['custom_field']);

					$this->db->query("UPDATE `" . DB_PREFIX . "address` SET `custom_field` = '" . $this->db->escape(json_encode($custom_field)) . "' WHERE `address_id` = '" . (int)$result['address_id'] . "'");
				}
			}
		}

		// order
		if ($this->tableExists(DB_PREFIX . 'order') && $this->columnExists(DB_PREFIX . 'order', 'custom_field')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order`");

			foreach ($query->rows as $result) {
				if (isset($result['custom_field']) && preg_match('/^(a:[0-9]+:\{.*\})$/', $result['custom_field'])) {
					$custom_field = unserialize($result['custom_field']);

					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET `custom_field` = '" . $this->db->escape(json_encode($custom_field)) . "' WHERE `order_id` = '" . (int)$result['order_id'] . "'");
				}

				if (isset($result['payment_custom_field']) && preg_match('/^(a:[0-9]+:\{.*\})$/', $result['payment_custom_field'])) {
					$custom_field = unserialize($result['payment_custom_field']);

					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_custom_field` = '" . $this->db->escape(json_encode($custom_field)) . "' WHERE `order_id` = '" . (int)$result['order_id'] . "'");
				}

				if (isset($result['shipping_custom_field']) && preg_match('/^(a:[0-9]+:\{.*\})$/', $result['shipping_custom_field'])) {
					$custom_field = unserialize($result['shipping_custom_field']);

					$this->db->query("UPDATE `" . DB_PREFIX . "order` SET `shipping_custom_field` = '" . $this->db->escape(json_encode($custom_field)) . "' WHERE `order_id` = '" . (int)$result['order_id'] . "'");
				}
			}
		}

		// customer_activity
		if ($this->tableExists(DB_PREFIX . 'customer_activity') && $this->columnExists(DB_PREFIX . 'customer_activity', 'data')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_activity`");

			foreach ($query->rows as $result) {
				if (preg_match('/^(a:[0-9]+:\{.*\})$/', $result['data'])) {
					$data = unserialize($result['data']);

					$this->db->query("UPDATE `" . DB_PREFIX . "customer_activity` SET `data` = '" . $this->db->escape(json_encode($data)) . "' WHERE `customer_activity_id` = '" . (int)$result['customer_activity_id'] . "'");
				}
			}
		}
	}
}

<?php
class ModelUpgrade1009 extends Model {
	private function tableExists($table) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "'");
		return !empty($query->row['total']);
	}

	private function columnExists($table, $column) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->db->escape(DB_DATABASE) . "' AND TABLE_NAME = '" . $this->db->escape($table) . "' AND COLUMN_NAME = '" . $this->db->escape($column) . "'");
		return !empty($query->row['total']);
	}

	public function upgrade() {
		// Convert affiliate to customer_affiliate if both legacy tables exist
		if ($this->tableExists(DB_PREFIX . 'affiliate') && $this->tableExists(DB_PREFIX . 'customer') && $this->tableExists(DB_PREFIX . 'customer_affiliate')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "affiliate`");

			foreach ($query->rows as $result) {
				$customer_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE `email` = '" . $this->db->escape($result['email']) . "'");

				if (!$customer_query->num_rows) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "customer` SET `customer_group_id` = '1', `language_id` = '1', `firstname` = '" . $this->db->escape($result['firstname']) . "', `lastname` = '" . $this->db->escape($result['lastname']) . "', `email` = '" . $this->db->escape($result['email']) . "', `telephone` = '" . $this->db->escape($result['telephone']) . "', `password` = '" . $this->db->escape($result['password']) . "', `salt` = '" . $this->db->escape($result['salt']) . "', `cart` = '', `wishlist` = '', `newsletter` = '0', `custom_field` = '', `ip` = '" . $this->db->escape($result['ip']) . "', `status` = '" . $this->db->escape($result['status']) . "', `safe` = '0', `token` = '', `code` = '', `date_added` = '" . $this->db->escape($result['date_added']) . "'");

					$customer_id = $this->db->getLastId();

					$this->db->query("INSERT INTO `" . DB_PREFIX . "address` SET `customer_id` = '" . (int)$customer_id . "', `firstname` = '" . $this->db->escape($result['firstname']) . "', `lastname` = '" . $this->db->escape($result['lastname']) . "', `company` = '" . $this->db->escape($result['company']) . "', `address_1` = '" . $this->db->escape($result['address_1']) . "', `address_2` = '" . $this->db->escape($result['address_2']) . "', `city` = '" . $this->db->escape($result['city']) . "', `postcode` = '" . $this->db->escape($result['postcode']) . "', `zone_id` = '" . (int)$result['zone_id'] . "', `country_id` = '" . (int)$result['country_id'] . "', `custom_field` = ''");

					$address_id = $this->db->getLastId();

					$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `address_id` = '" . (int)$address_id . "' WHERE `customer_id` = '" . (int)$customer_id . "'");
				} else {
					$customer_id = $customer_query->row['customer_id'];
				}

				$affiliate_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_affiliate` WHERE `customer_id` = '" . (int)$customer_id . "'");

				if (!$affiliate_query->num_rows) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_affiliate` SET `customer_id` = '" . (int)$customer_id . "', `company` = '" . $this->db->escape($result['company']) . "', `tracking` = '" . $this->db->escape($result['code']) . "', `commission` = '" . (float)$result['commission'] . "', `tax` = '" . $this->db->escape($result['tax']) . "', `payment` = '" . $this->db->escape($result['payment']) . "', `cheque` = '" . $this->db->escape($result['cheque']) . "', `paypal` = '" . $this->db->escape($result['paypal']) . "', `bank_name` = '" . $this->db->escape($result['bank_name']) . "', `bank_branch_number` = '" . $this->db->escape($result['bank_branch_number']) . "', `bank_swift_code` = '" . $this->db->escape($result['bank_swift_code']) . "', `bank_account_name` = '" . $this->db->escape($result['bank_account_name']) . "', `bank_account_number` = '" . $this->db->escape($result['bank_account_number']) . "', `status` = '" . (int)$result['status'] . "', `date_added` = '" . $this->db->escape($result['date_added']) . "'");
				}
			}
		}

		// Migrate url_alias to seo_url if legacy table exists
		if ($this->tableExists(DB_PREFIX . 'url_alias') && $this->tableExists(DB_PREFIX . 'seo_url')) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias`");

			foreach ($query->rows as $result) {
				$seo_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `query` = '" . $this->db->escape($result['query']) . "' AND `keyword` = '" . $this->db->escape($result['keyword']) . "'");
				if (!$seo_query->num_rows) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '0', `language_id` = '1', `query` = '" . $this->db->escape($result['query']) . "', `keyword` = '" . $this->db->escape($result['keyword']) . "'");
				}
			}
		}

		// Ensure config.php and admin/config.php define DIR_STORAGE and DIR_SESSION without duplicating lines
		$files = glob(DIR_OPENCART . '{config.php,*/config.php}', GLOB_BRACE);

		foreach ($files as $file) {
			if (!is_writable($file)) {
				continue;
			}

			$content = file_get_contents($file);
			$has_storage = (strpos($content, 'DIR_STORAGE') !== false);
			$has_session = (strpos($content, 'DIR_SESSION') !== false);

			if (!$has_storage || !$has_session) {
				$lines = file($file);

				for ($i = 0; $i < count($lines); $i++) {
					if (!$has_storage && strpos($lines[$i], 'DIR_IMAGE') !== false) {
						array_splice($lines, $i + 1, 0, array("define('DIR_STORAGE', DIR_SYSTEM . 'storage/');\n"));
						$has_storage = true;
					}

					if (!$has_session && strpos($lines[$i], 'DIR_MODIFICATION') !== false) {
						array_splice($lines, $i + 1, 0, array("define('DIR_SESSION', DIR_STORAGE . 'session/');\n"));
						$has_session = true;
					}
				}

				$output = implode('', $lines);
				$handle = fopen($file, 'w');
				fwrite($handle, $output);
				fclose($handle);
			}
		}

		// Ensure Administrator user_group (user_group_id = 1) has permissions for all admin controllers
		if ($this->tableExists(DB_PREFIX . 'user_group')) {
			$ug_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user_group` WHERE `user_group_id` = '1'");
			if ($ug_query->num_rows) {
				$permissions = json_decode($ug_query->row['permission'], true);
				if (!is_array($permissions)) {
					$permissions = array('access' => array(), 'modify' => array());
				}
				if (!isset($permissions['access']) || !is_array($permissions['access'])) {
					$permissions['access'] = array();
				}
				if (!isset($permissions['modify']) || !is_array($permissions['modify'])) {
					$permissions['modify'] = array();
				}

				$ignore = array(
					'common/dashboard',
					'common/startup',
					'common/login',
					'common/logout',
					'common/forgotten',
					'common/reset',
					'Common/footer',
					'common/header',
					'error/not_found',
					'error/permission'
				);

				$admin_controller_dir = DIR_OPENCART . 'admin/controller/';
				if (is_dir($admin_controller_dir)) {
					$controller_files = glob($admin_controller_dir . '*/*.php');
					if (is_array($controller_files)) {
						foreach ($controller_files as $cfile) {
							$route = substr($cfile, strlen($admin_controller_dir), -4);
							$route = str_replace('\\', '/', $route);
							if (!in_array($route, $ignore)) {
								if (!in_array($route, $permissions['access'])) {
									$permissions['access'][] = $route;
								}
								if (!in_array($route, $permissions['modify'])) {
									$permissions['modify'][] = $route;
								}
							}
						}
					}
				}

				sort($permissions['access']);
				sort($permissions['modify']);

				$this->db->query("UPDATE `" . DB_PREFIX . "user_group` SET `permission` = '" . $this->db->escape(json_encode($permissions)) . "' WHERE `user_group_id` = '1'");
			}
		}
	}
}

<?php
class ModelAccountMember extends Model {
	public function addMember($data) {
		$salt = token(9);
		$code = isset($data['code']) && $data['code'] !== '' ? $data['code'] : token(40);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "member` SET username = '" . $this->db->escape(isset($data['username']) ? $data['username'] : '') . "', firstname = '" . $this->db->escape(isset($data['firstname']) ? $data['firstname'] : '') . "', lastname = '" . $this->db->escape(isset($data['lastname']) ? $data['lastname'] : '') . "', company = '" . $this->db->escape(isset($data['company']) ? $data['company'] : '') . "', tax_id = '" . $this->db->escape(isset($data['tax_id']) ? $data['tax_id'] : '') . "', email = '" . $this->db->escape(isset($data['email']) ? $data['email'] : '') . "', telephone = '" . $this->db->escape(isset($data['telephone']) ? $data['telephone'] : '') . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', country_id = '" . (int)(isset($data['country_id']) ? $data['country_id'] : 0) . "', salt = '" . $this->db->escape($salt) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1(isset($data['password']) ? $data['password'] : '')))) . "', code = '" . $this->db->escape($code) . "', pin = '', pin_attempts = '0', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 0) . "', verified = '0', seller_status = '0', partner_status = '0', moderator = '0', cloud = '0', status = '1', ip = '" . $this->db->escape(isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '') . "', date_added = NOW(), date_modified = NOW()");

		$member_id = $this->db->getLastId();

		if (!empty($data['notify']) && !empty($data['email'])) {
			$check = $this->db->query("SELECT newsletter_id FROM `" . DB_PREFIX . "newsletter` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($data['email'])) . "'");
			if (!$check->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "newsletter` SET email = '" . $this->db->escape($data['email']) . "', date_added = NOW()");
			}
		}

		return $member_id;
	}

	public function editMember($member_id, $data = null) {
		if (is_array($member_id) && $data === null) {
			$data = $member_id;
			$member_id = $this->member->getId();
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET firstname = '" . $this->db->escape(isset($data['firstname']) ? $data['firstname'] : '') . "', lastname = '" . $this->db->escape(isset($data['lastname']) ? $data['lastname'] : '') . "', company = '" . $this->db->escape(isset($data['company']) ? $data['company'] : '') . "', tax_id = '" . $this->db->escape(isset($data['tax_id']) ? $data['tax_id'] : '') . "', email = '" . $this->db->escape(isset($data['email']) ? $data['email'] : '') . "', telephone = '" . $this->db->escape(isset($data['telephone']) ? $data['telephone'] : '') . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', country_id = '" . (int)(isset($data['country_id']) ? $data['country_id'] : 0) . "', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 0) . "', date_modified = NOW() WHERE member_id = '" . (int)$member_id . "'");

		if (isset($data['username']) && $data['username'] !== '') {
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET username = '" . $this->db->escape($data['username']) . "' WHERE member_id = '" . (int)$member_id . "'");
		}
	}

	public function editPassword($email_or_id, $password) {
		$salt = token(9);

		if (is_numeric($email_or_id)) {
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET salt = '" . $this->db->escape($salt) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE member_id = '" . (int)$email_or_id . "'");
		} else {
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET salt = '" . $this->db->escape($salt) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email_or_id)) . "'");
		}
	}

	public function editCode($email_or_id, $code) {
		if (is_numeric($email_or_id)) {
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET code = '" . $this->db->escape($code) . "' WHERE member_id = '" . (int)$email_or_id . "'");
		} else {
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET code = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email_or_id)) . "'");
		}
	}

	public function editPin($member_id, $pin = null) {
		if ($pin === null) {
			$pin = $member_id;
			$member_id = $this->member->getId();
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET pin = '" . $this->db->escape($pin) . "', pin_attempts = '0', date_modified = NOW() WHERE member_id = '" . (int)$member_id . "'");
	}

	public function incrementPinAttempts($member_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET pin_attempts = pin_attempts + 1, date_modified = NOW() WHERE member_id = '" . (int)$member_id . "'");
	}

	public function resetPinAttempts($member_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET pin_attempts = '0', date_modified = NOW() WHERE member_id = '" . (int)$member_id . "'");
	}

	public function resetMemberPin($member_id, $new_pin, $code = '') {
		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET pin = '" . $this->db->escape($new_pin) . "', pin_attempts = '0', code = '" . $this->db->escape($code) . "', date_modified = NOW() WHERE member_id = '" . (int)$member_id . "'");
	}

	public function editNewsletter($notify) {
		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET notify = '" . (int)$notify . "' WHERE member_id = '" . (int)$this->member->getId() . "'");
	}

	public function verifyMember($code) {
		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET verified = '1', code = '' WHERE code = '" . $this->db->escape($code) . "' AND code != ''");
	}

	public function getMember($member_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row;
	}

	public function getMemberByEmail($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getMemberByUsername($username) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE LCASE(username) = '" . $this->db->escape(utf8_strtolower($username)) . "'");

		return $query->row;
	}

	public function getMemberByLogin($login) {
		$clean = $this->db->escape(utf8_strtolower(trim($login)));
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE LOWER(email) = '" . $clean . "' OR LOWER(username) = '" . $clean . "'");

		return $query->row;
	}

	public function getMemberByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE code = '" . $this->db->escape($code) . "' AND code != ''");

		return $query->row;
	}

	public function getTotalMembersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}

	public function getTotalMembersByUsername($username) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member` WHERE LCASE(username) = '" . $this->db->escape(utf8_strtolower($username)) . "'");

		return $query->row['total'];
	}

	public function addMemberIp($member_id, $ip) {
		$query = $this->db->query("SELECT member_ip_id FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$member_id . "' AND ip = '" . $this->db->escape($ip) . "'");
		if (!$query->num_rows) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "member_ip` SET member_id = '" . (int)$member_id . "', ip = '" . $this->db->escape($ip) . "', date_added = NOW()");
		}
	}

	public function isTrustedIp($member_id, $ip) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$member_id . "' AND ip = '" . $this->db->escape($ip) . "'");

		return $query->row['total'] > 0;
	}

	public function getIps($member_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$member_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalIps($member_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row['total'];
	}

	public function addLoginAttempt($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_login` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

		if (!$query->num_rows) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "member_login` SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
		} else {
			$this->db->query("UPDATE `" . DB_PREFIX . "member_login` SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE member_login_id = '" . (int)$query->row['member_login_id'] . "'");
		}
	}

	public function getLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_login` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower((string)$email)) . "'");

		return $query->row;
	}

	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_login` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower((string)$email)) . "'");
	}
}

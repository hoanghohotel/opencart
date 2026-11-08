<?php
namespace Cart;
class Member {
	private $config;
	private $db;
	private $request;
	private $session;

	private $member_id = 0;
	private $username = '';
	private $firstname = '';
	private $lastname = '';
	private $company = '';
	private $tax_id = '';
	private $email = '';
	private $telephone = '';
	private $image = '';
	private $country_id = 0;
	private $pin = '';
	private $pin_attempts = 0;
	private $verified = 0;
	private $ip_verified = false;
	private $notify = 1;
	private $seller_status = 0;
	private $partner_status = 0;
	private $moderator = 0;
	private $cloud = 0;
	private $date_added = '';

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['member_id'])) {
			$member_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE member_id = '" . (int)$this->session->data['member_id'] . "' AND status = '1' AND verified = '1'");

			if ($member_query->num_rows) {
				$this->setFromRow($member_query->row);

				$ip = $this->getCurrentIp();

				$this->db->query("UPDATE `" . DB_PREFIX . "member` SET ip = '" . $this->db->escape($ip) . "' WHERE member_id = '" . (int)$this->member_id . "'");

				$query = $this->db->query("SELECT member_ip_id FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$this->member_id . "' AND ip = '" . $this->db->escape($ip) . "'");
				$this->ip_verified = ($query->num_rows > 0);

				if (empty($this->session->data['member_token'])) {
					$this->session->data['member_token'] = token(32);
				}

				$GLOBALS['__oc_active_member_token'] = $this->session->data['member_token'];
			} else {
				$this->logout();
			}
		}
	}

	public function getCurrentIp() {
		return isset($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '127.0.0.1';
	}

	private function setFromRow($row) {
		$this->member_id = (int)$row['member_id'];
		$this->username = $row['username'];
		$this->firstname = $row['firstname'];
		$this->lastname = $row['lastname'];
		$this->company = $row['company'];
		$this->tax_id = $row['tax_id'];
		$this->email = $row['email'];
		$this->telephone = $row['telephone'];
		$this->image = $row['image'];
		$this->country_id = (int)$row['country_id'];
		$this->pin = isset($row['pin']) ? (string)$row['pin'] : '';
		$this->pin_attempts = isset($row['pin_attempts']) ? (int)$row['pin_attempts'] : 0;
		$this->verified = isset($row['verified']) ? (int)$row['verified'] : 0;
		$this->notify = (int)$row['notify'];
		$this->seller_status = (int)$row['seller_status'];
		$this->partner_status = (int)$row['partner_status'];
		$this->moderator = (int)$row['moderator'];
		$this->cloud = (int)$row['cloud'];
		$this->date_added = $row['date_added'];
	}

	public function login($email, $password, $override = false) {
		$login = $this->db->escape(utf8_strtolower(trim($email)));

		if ($override) {
			$member_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE (LOWER(email) = '" . $login . "' OR LOWER(username) = '" . $login . "') AND status = '1' AND verified = '1'");
		} else {
			$member_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` WHERE (LOWER(email) = '" . $login . "' OR LOWER(username) = '" . $login . "') AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND verified = '1'");
		}

		if ($member_query->num_rows) {
			$this->session->data['member_id'] = (int)$member_query->row['member_id'];
			$this->session->data['member_token'] = token(32);
			$GLOBALS['__oc_active_member_token'] = $this->session->data['member_token'];

			$this->setFromRow($member_query->row);

			$ip = $this->getCurrentIp();
			$this->db->query("UPDATE `" . DB_PREFIX . "member` SET ip = '" . $this->db->escape($ip) . "' WHERE member_id = '" . (int)$this->member_id . "'");

			$query = $this->db->query("SELECT member_ip_id FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$this->member_id . "' AND ip = '" . $this->db->escape($ip) . "'");
			$this->ip_verified = ($query->num_rows > 0);

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['member_id']);
		unset($this->session->data['member_token']);
		$GLOBALS['__oc_active_member_token'] = '';

		$this->member_id = 0;
		$this->username = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->company = '';
		$this->tax_id = '';
		$this->email = '';
		$this->telephone = '';
		$this->image = '';
		$this->country_id = 0;
		$this->pin = '';
		$this->pin_attempts = 0;
		$this->verified = 0;
		$this->ip_verified = false;
		$this->notify = 1;
		$this->seller_status = 0;
		$this->partner_status = 0;
		$this->moderator = 0;
		$this->cloud = 0;
		$this->date_added = '';
	}

	public function isLogged() {
		return $this->member_id;
	}

	public function isVerified() {
		return (bool)$this->verified;
	}

	public function hasPin() {
		return $this->pin !== '';
	}

	public function getPin() {
		return $this->pin;
	}

	public function getPinAttempts() {
		return (int)$this->pin_attempts;
	}

	public function isIpVerified() {
		return (bool)$this->ip_verified;
	}

	public function trustCurrentIp() {
		if (!$this->member_id) {
			return;
		}
		$ip = $this->getCurrentIp();
		$query = $this->db->query("SELECT member_ip_id FROM `" . DB_PREFIX . "member_ip` WHERE member_id = '" . (int)$this->member_id . "' AND ip = '" . $this->db->escape($ip) . "'");
		if (!$query->num_rows) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "member_ip` SET member_id = '" . (int)$this->member_id . "', ip = '" . $this->db->escape($ip) . "', date_added = NOW()");
		}
		$this->ip_verified = true;
	}

	public function getId() {
		return $this->member_id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

	public function getCompany() {
		return $this->company;
	}

	public function getTaxId() {
		return $this->tax_id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getImage() {
		return $this->image;
	}

	public function getCountryId() {
		return $this->country_id;
	}

	public function getNotify() {
		return $this->notify;
	}

	public function isSeller() {
		return (bool)$this->seller_status;
	}

	public function isPartner() {
		return (bool)$this->partner_status;
	}

	public function isModerator() {
		return (bool)$this->moderator;
	}

	public function hasCloud() {
		return (bool)$this->cloud;
	}

	public function getDateAdded() {
		return $this->date_added;
	}

	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM `" . DB_PREFIX . "member_transaction` WHERE member_id = '" . (int)$this->member_id . "'");

		return (float)$query->row['total'];
	}
}

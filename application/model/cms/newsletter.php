<?php
class ModelCmsNewsletter extends Model {
	public function addNewsletter($email) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "newsletter` SET email = '" . $this->db->escape($email) . "', date_added = NOW()");

		return $this->db->getLastId();
	}

	public function deleteNewsletter($email) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "newsletter` WHERE email = '" . $this->db->escape($email) . "'");
	}

	public function getNewsletterByEmail($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "newsletter` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getTotalNewslettersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "newsletter` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}
}

<?php
class ModelMemberPartner extends Model {
	public function addPartner($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_partner` SET member_id = '" . (int)$data['member_id'] . "', member_partner_type_id = '" . (int)$data['member_partner_type_id'] . "', member_partner_status_id = '" . (int)$data['member_partner_status_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', website = '" . $this->db->escape($data['website']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', description_short = '" . $this->db->escape($data['description_short']) . "', description_long = '" . $this->db->escape($data['description_long']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', image = '" . $this->db->escape($data['image']) . "', facebook = '" . $this->db->escape($data['facebook']) . "', twitter = '" . $this->db->escape($data['twitter']) . "', linkedin = '" . $this->db->escape($data['linkedin']) . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_modified = NOW()");

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET partner_status = '" . (int)$data['status'] . "' WHERE member_id = '" . (int)$data['member_id'] . "'");

		return $this->db->getLastId();
	}

	public function editPartner($member_partner_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "member_partner` SET member_id = '" . (int)$data['member_id'] . "', member_partner_type_id = '" . (int)$data['member_partner_type_id'] . "', member_partner_status_id = '" . (int)$data['member_partner_status_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', website = '" . $this->db->escape($data['website']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', description_short = '" . $this->db->escape($data['description_short']) . "', description_long = '" . $this->db->escape($data['description_long']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', image = '" . $this->db->escape($data['image']) . "', facebook = '" . $this->db->escape($data['facebook']) . "', twitter = '" . $this->db->escape($data['twitter']) . "', linkedin = '" . $this->db->escape($data['linkedin']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE member_partner_id = '" . (int)$member_partner_id . "'");

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET partner_status = '" . (int)$data['status'] . "' WHERE member_id = '" . (int)$data['member_id'] . "'");
	}

	public function deletePartner($member_partner_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_partner` WHERE member_partner_id = '" . (int)$member_partner_id . "'");
	}

	public function getPartner($member_partner_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_partner` WHERE member_partner_id = '" . (int)$member_partner_id . "'");

		return $query->row;
	}

	public function getPartners($data = array()) {
		$sql = "SELECT mp.*, mpt.name AS partner_type, mps.name AS partner_tier, c.name AS country_name FROM `" . DB_PREFIX . "member_partner` mp LEFT JOIN `" . DB_PREFIX . "member_partner_type` mpt ON (mp.member_partner_type_id = mpt.member_partner_type_id) LEFT JOIN `" . DB_PREFIX . "member_partner_status` mps ON (mp.member_partner_status_id = mps.member_partner_status_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (mp.country_id = c.country_id) ORDER BY mp.date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalPartners() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_partner`");

		return $query->row['total'];
	}

	public function getPartnerTypes() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_partner_type` ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getPartnerStatuses() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_partner_status` ORDER BY sort_order ASC");

		return $query->rows;
	}
}

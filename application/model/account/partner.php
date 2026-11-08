<?php
class ModelAccountPartner extends Model {
	public function getPartner($member_partner_id) {
		$query = $this->db->query("SELECT DISTINCT mp.*, mpt.name AS type, mps.name AS status_name, mps.image AS status_image, c.name AS country, c.iso_code_2, z.name AS zone, m.username, m.image AS member_image, m.date_added AS member_date_added FROM `" . DB_PREFIX . "member_partner` mp LEFT JOIN `" . DB_PREFIX . "member_partner_type` mpt ON (mp.member_partner_type_id = mpt.member_partner_type_id) LEFT JOIN `" . DB_PREFIX . "member_partner_status` mps ON (mp.member_partner_status_id = mps.member_partner_status_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (mp.country_id = c.country_id) LEFT JOIN `" . DB_PREFIX . "zone` z ON (mp.zone_id = z.zone_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (mp.member_id = m.member_id) WHERE mp.member_partner_id = '" . (int)$member_partner_id . "'");

		if ($query->num_rows) {
			return $query->row;
		}

		$query = $this->db->query("SELECT DISTINCT mp.*, mpt.name AS type, mps.name AS status_name, mps.image AS status_image, c.name AS country, c.iso_code_2, z.name AS zone, m.username, m.image AS member_image, m.date_added AS member_date_added FROM `" . DB_PREFIX . "member_partner` mp LEFT JOIN `" . DB_PREFIX . "member_partner_type` mpt ON (mp.member_partner_type_id = mpt.member_partner_type_id) LEFT JOIN `" . DB_PREFIX . "member_partner_status` mps ON (mp.member_partner_status_id = mps.member_partner_status_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (mp.country_id = c.country_id) LEFT JOIN `" . DB_PREFIX . "zone` z ON (mp.zone_id = z.zone_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (mp.member_id = m.member_id) WHERE mp.member_id = '" . (int)$member_partner_id . "'");

		return $query->row;
	}

	public function getPartnerByMemberId($member_id = 0) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		$query = $this->db->query("SELECT DISTINCT mp.*, mpt.name AS type, mps.name AS status_name, mps.image AS status_image, c.name AS country, c.iso_code_2, z.name AS zone FROM `" . DB_PREFIX . "member_partner` mp LEFT JOIN `" . DB_PREFIX . "member_partner_type` mpt ON (mp.member_partner_type_id = mpt.member_partner_type_id) LEFT JOIN `" . DB_PREFIX . "member_partner_status` mps ON (mp.member_partner_status_id = mps.member_partner_status_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (mp.country_id = c.country_id) LEFT JOIN `" . DB_PREFIX . "zone` z ON (mp.zone_id = z.zone_id) WHERE mp.member_id = '" . (int)$member_id . "'");

		return $query->row;
	}

	public function getPartners($data = array()) {
		$sql = "SELECT mp.*, mpt.name AS type, mps.name AS status_name, mps.image AS status_image, c.name AS country, c.iso_code_2, z.name AS zone FROM `" . DB_PREFIX . "member_partner` mp LEFT JOIN `" . DB_PREFIX . "member_partner_type` mpt ON (mp.member_partner_type_id = mpt.member_partner_type_id) LEFT JOIN `" . DB_PREFIX . "member_partner_status` mps ON (mp.member_partner_status_id = mps.member_partner_status_id) LEFT JOIN `" . DB_PREFIX . "country` c ON (mp.country_id = c.country_id) LEFT JOIN `" . DB_PREFIX . "zone` z ON (mp.zone_id = z.zone_id) WHERE mp.status = '1'";

		if (!empty($data['filter_country_id'])) {
			$sql .= " AND mp.country_id = '" . (int)$data['filter_country_id'] . "'";
		}

		if (!empty($data['filter_partner_type_id'])) {
			$sql .= " AND mp.member_partner_type_id = '" . (int)$data['filter_partner_type_id'] . "'";
		} elseif (!empty($data['filter_member_partner_type_id'])) {
			$sql .= " AND mp.member_partner_type_id = '" . (int)$data['filter_member_partner_type_id'] . "'";
		}

		if (!empty($data['filter_partner_status_id'])) {
			$sql .= " AND mp.member_partner_status_id = '" . (int)$data['filter_partner_status_id'] . "'";
		}

		$sql .= " ORDER BY mp.member_partner_id ASC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 12;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalPartners($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_partner` mp WHERE mp.status = '1'";

		if (!empty($data['filter_country_id'])) {
			$sql .= " AND mp.country_id = '" . (int)$data['filter_country_id'] . "'";
		}

		if (!empty($data['filter_partner_type_id'])) {
			$sql .= " AND mp.member_partner_type_id = '" . (int)$data['filter_partner_type_id'] . "'";
		} elseif (!empty($data['filter_member_partner_type_id'])) {
			$sql .= " AND mp.member_partner_type_id = '" . (int)$data['filter_member_partner_type_id'] . "'";
		}

		if (!empty($data['filter_partner_status_id'])) {
			$sql .= " AND mp.member_partner_status_id = '" . (int)$data['filter_partner_status_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getPartnerCountries() {
		$query = $this->db->query("SELECT c.country_id, c.name, c.iso_code_2, COUNT(mp.member_partner_id) AS total FROM `" . DB_PREFIX . "member_partner` mp LEFT JOIN `" . DB_PREFIX . "country` c ON (mp.country_id = c.country_id) WHERE mp.status = '1' AND c.status = '1' GROUP BY mp.country_id ORDER BY c.name ASC");

		return $query->rows;
	}

	public function getPartnerTypes() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_partner_type` ORDER BY sort_order ASC, name ASC");

		return $query->rows;
	}

	public function getMemberPartnerTypes() {
		return $this->getPartnerTypes();
	}

	public function getPartnerStatuses() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_partner_status` ORDER BY sort_order ASC, name ASC");

		return $query->rows;
	}

	public function getMemberPartnerStatuses() {
		return $this->getPartnerStatuses();
	}

	public function addPartner($data) {
		return $this->editPartner($data);
	}

	public function editPartner($data) {
		$member_id = $this->member->getId();
		$existing = $this->getPartnerByMemberId($member_id);

		if ($existing) {
			$this->db->query("UPDATE `" . DB_PREFIX . "member_partner` SET firstname = '" . $this->db->escape(isset($data['firstname']) ? $data['firstname'] : '') . "', lastname = '" . $this->db->escape(isset($data['lastname']) ? $data['lastname'] : '') . "', company = '" . $this->db->escape(isset($data['company']) ? $data['company'] : '') . "', website = '" . $this->db->escape(isset($data['website']) ? $data['website'] : '') . "', email = '" . $this->db->escape(isset($data['email']) ? $data['email'] : '') . "', telephone = '" . $this->db->escape(isset($data['telephone']) ? $data['telephone'] : '') . "', description_short = '" . $this->db->escape(isset($data['description_short']) ? $data['description_short'] : '') . "', description_long = '" . $this->db->escape(isset($data['description_long']) ? $data['description_long'] : '') . "', address_1 = '" . $this->db->escape(isset($data['address_1']) ? $data['address_1'] : '') . "', address_2 = '" . $this->db->escape(isset($data['address_2']) ? $data['address_2'] : '') . "', city = '" . $this->db->escape(isset($data['city']) ? $data['city'] : '') . "', postcode = '" . $this->db->escape(isset($data['postcode']) ? $data['postcode'] : '') . "', country_id = '" . (int)(isset($data['country_id']) ? $data['country_id'] : 0) . "', zone_id = '" . (int)(isset($data['zone_id']) ? $data['zone_id'] : 0) . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', facebook = '" . $this->db->escape(isset($data['facebook']) ? $data['facebook'] : '') . "', twitter = '" . $this->db->escape(isset($data['twitter']) ? $data['twitter'] : '') . "', linkedin = '" . $this->db->escape(isset($data['linkedin']) ? $data['linkedin'] : '') . "', date_modified = NOW() WHERE member_id = '" . (int)$member_id . "'");
		} else {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "member_partner` SET member_id = '" . (int)$member_id . "', member_partner_type_id = '" . (int)(isset($data['member_partner_type_id']) ? $data['member_partner_type_id'] : 1) . "', member_partner_status_id = '" . (int)(isset($data['member_partner_status_id']) ? $data['member_partner_status_id'] : 1) . "', firstname = '" . $this->db->escape(isset($data['firstname']) ? $data['firstname'] : '') . "', lastname = '" . $this->db->escape(isset($data['lastname']) ? $data['lastname'] : '') . "', company = '" . $this->db->escape(isset($data['company']) ? $data['company'] : '') . "', website = '" . $this->db->escape(isset($data['website']) ? $data['website'] : '') . "', email = '" . $this->db->escape(isset($data['email']) ? $data['email'] : '') . "', telephone = '" . $this->db->escape(isset($data['telephone']) ? $data['telephone'] : '') . "', description_short = '" . $this->db->escape(isset($data['description_short']) ? $data['description_short'] : '') . "', description_long = '" . $this->db->escape(isset($data['description_long']) ? $data['description_long'] : '') . "', address_1 = '" . $this->db->escape(isset($data['address_1']) ? $data['address_1'] : '') . "', address_2 = '" . $this->db->escape(isset($data['address_2']) ? $data['address_2'] : '') . "', city = '" . $this->db->escape(isset($data['city']) ? $data['city'] : '') . "', postcode = '" . $this->db->escape(isset($data['postcode']) ? $data['postcode'] : '') . "', country_id = '" . (int)(isset($data['country_id']) ? $data['country_id'] : 0) . "', zone_id = '" . (int)(isset($data['zone_id']) ? $data['zone_id'] : 0) . "', image = '" . $this->db->escape(isset($data['image']) ? $data['image'] : '') . "', facebook = '" . $this->db->escape(isset($data['facebook']) ? $data['facebook'] : '') . "', twitter = '" . $this->db->escape(isset($data['twitter']) ? $data['twitter'] : '') . "', linkedin = '" . $this->db->escape(isset($data['linkedin']) ? $data['linkedin'] : '') . "', status = '1', date_added = NOW(), date_modified = NOW()");
		}
	}
}

<?php
class ModelSupportEnquiry extends Model {
	public function deleteEnquiry($enquiry_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "support_enquiry` WHERE enquiry_id = '" . (int)$enquiry_id . "'");
	}

	public function getEnquiry($enquiry_id) {
		$query = $this->db->query("SELECT se.*, c.name AS country_name, p.company AS partner_company FROM `" . DB_PREFIX . "support_enquiry` se LEFT JOIN `" . DB_PREFIX . "country` c ON (se.country_id = c.country_id) LEFT JOIN `" . DB_PREFIX . "member_partner` p ON (se.partner_id = p.member_partner_id) WHERE se.enquiry_id = '" . (int)$enquiry_id . "'");

		return $query->row;
	}

	public function getEnquiries($data = array()) {
		$sql = "SELECT se.*, c.name AS country_name, p.company AS partner_company FROM `" . DB_PREFIX . "support_enquiry` se LEFT JOIN `" . DB_PREFIX . "country` c ON (se.country_id = c.country_id) LEFT JOIN `" . DB_PREFIX . "member_partner` p ON (se.partner_id = p.member_partner_id) WHERE 1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND (se.name LIKE '%" . $this->db->escape($data['filter_name']) . "%' OR se.email LIKE '%" . $this->db->escape($data['filter_name']) . "%')";
		}

		if (!empty($data['filter_type'])) {
			$sql .= " AND se.type = '" . $this->db->escape($data['filter_type']) . "'";
		}

		$sort_data = array(
			'se.enquiry_id',
			'se.name',
			'se.email',
			'se.type',
			'se.subject',
			'se.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY se.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

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

	public function getTotalEnquiries($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "support_enquiry` se WHERE 1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND (se.name LIKE '%" . $this->db->escape($data['filter_name']) . "%' OR se.email LIKE '%" . $this->db->escape($data['filter_name']) . "%')";
		}

		if (!empty($data['filter_type'])) {
			$sql .= " AND se.type = '" . $this->db->escape($data['filter_type']) . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}

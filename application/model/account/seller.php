<?php
class ModelAccountSeller extends Model {
	public function addSeller($data) {
		$member_id = $this->member->getId();

		$this->db->query("DELETE FROM `" . DB_PREFIX . "member_seller` WHERE member_id = '" . (int)$member_id . "'");

		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_seller` SET member_id = '" . (int)$member_id . "', firstname = '" . $this->db->escape(isset($data['firstname']) ? $data['firstname'] : '') . "', lastname = '" . $this->db->escape(isset($data['lastname']) ? $data['lastname'] : '') . "', email = '" . $this->db->escape(isset($data['email']) ? $data['email'] : '') . "', support_email = '" . $this->db->escape(isset($data['support_email']) ? $data['support_email'] : '') . "', telephone = '" . $this->db->escape(isset($data['telephone']) ? $data['telephone'] : '') . "', website = '" . $this->db->escape(isset($data['website']) ? $data['website'] : '') . "', payment_method = '" . $this->db->escape(isset($data['payment_method']) ? $data['payment_method'] : 'paypal') . "', payoneer_token = '" . $this->db->escape(isset($data['payoneer_token']) ? $data['payoneer_token'] : '') . "', payment_email = '" . $this->db->escape(isset($data['payment_email']) ? $data['payment_email'] : '') . "', company = '" . $this->db->escape(isset($data['company']) ? $data['company'] : '') . "', address_1 = '" . $this->db->escape(isset($data['address_1']) ? $data['address_1'] : '') . "', address_2 = '" . $this->db->escape(isset($data['address_2']) ? $data['address_2'] : '') . "', city = '" . $this->db->escape(isset($data['city']) ? $data['city'] : '') . "', postcode = '" . $this->db->escape(isset($data['postcode']) ? $data['postcode'] : '') . "', country_id = '" . (int)(isset($data['country_id']) ? $data['country_id'] : 0) . "', zone_id = '" . (int)(isset($data['zone_id']) ? $data['zone_id'] : 0) . "', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 0) . "', api_status = '" . (int)(isset($data['api_status']) ? $data['api_status'] : 0) . "', api_url = '" . $this->db->escape(isset($data['api_url']) ? $data['api_url'] : '') . "', commission = '70', seller_group = 'Default', status = '0', date_added = NOW(), date_modified = NOW()");

		$this->db->query("UPDATE `" . DB_PREFIX . "member` SET seller_status = '0' WHERE member_id = '" . (int)$member_id . "'");

		return $this->db->getLastId();
	}

	public function editSeller($data) {
		$seller = $this->getSeller($this->member->getId());

		if (!$seller) {
			return $this->addSeller($data);
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "member_seller` SET firstname = '" . $this->db->escape(isset($data['firstname']) ? $data['firstname'] : '') . "', lastname = '" . $this->db->escape(isset($data['lastname']) ? $data['lastname'] : '') . "', email = '" . $this->db->escape(isset($data['email']) ? $data['email'] : '') . "', support_email = '" . $this->db->escape(isset($data['support_email']) ? $data['support_email'] : '') . "', telephone = '" . $this->db->escape(isset($data['telephone']) ? $data['telephone'] : '') . "', website = '" . $this->db->escape(isset($data['website']) ? $data['website'] : '') . "', payment_method = '" . $this->db->escape(isset($data['payment_method']) ? $data['payment_method'] : 'paypal') . "', payoneer_token = '" . $this->db->escape(isset($data['payoneer_token']) ? $data['payoneer_token'] : '') . "', payment_email = '" . $this->db->escape(isset($data['payment_email']) ? $data['payment_email'] : '') . "', company = '" . $this->db->escape(isset($data['company']) ? $data['company'] : '') . "', address_1 = '" . $this->db->escape(isset($data['address_1']) ? $data['address_1'] : '') . "', address_2 = '" . $this->db->escape(isset($data['address_2']) ? $data['address_2'] : '') . "', city = '" . $this->db->escape(isset($data['city']) ? $data['city'] : '') . "', postcode = '" . $this->db->escape(isset($data['postcode']) ? $data['postcode'] : '') . "', country_id = '" . (int)(isset($data['country_id']) ? $data['country_id'] : 0) . "', zone_id = '" . (int)(isset($data['zone_id']) ? $data['zone_id'] : 0) . "', notify = '" . (int)(isset($data['notify']) ? $data['notify'] : 0) . "', api_status = '" . (int)(isset($data['api_status']) ? $data['api_status'] : 0) . "', api_url = '" . $this->db->escape(isset($data['api_url']) ? $data['api_url'] : '') . "', date_modified = NOW() WHERE member_id = '" . (int)$this->member->getId() . "'");
	}

	public function getSeller($member_id = 0) {
		if (!$member_id) {
			$member_id = $this->member->getId();
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member_seller` WHERE member_id = '" . (int)$member_id . "'");

		return $query->row;
	}

	public function getSellerByMemberId($member_id) {
		return $this->getSeller($member_id);
	}
}

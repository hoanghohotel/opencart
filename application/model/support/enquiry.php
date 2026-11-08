<?php
class ModelSupportEnquiry extends Model {
	public function addEnquiry($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "support_enquiry` SET `type` = '" . $this->db->escape(isset($data['type']) ? $data['type'] : 'general') . "', `reason` = '" . $this->db->escape(isset($data['reason']) ? $data['reason'] : '') . "', `partner_id` = '" . (int)(isset($data['partner_id']) ? $data['partner_id'] : 0) . "', `name` = '" . $this->db->escape(isset($data['name']) ? $data['name'] : '') . "', `email` = '" . $this->db->escape(isset($data['email']) ? $data['email'] : '') . "', `telephone` = '" . $this->db->escape(isset($data['telephone']) ? $data['telephone'] : '') . "', `company` = '" . $this->db->escape(isset($data['company']) ? $data['company'] : '') . "', `website` = '" . $this->db->escape(isset($data['website']) ? $data['website'] : '') . "', `country_id` = '" . (int)(isset($data['country_id']) ? $data['country_id'] : 0) . "', `order_id` = '" . (int)(isset($data['order_id']) ? $data['order_id'] : 0) . "', `version_id` = '" . (int)(isset($data['version_id']) ? $data['version_id'] : 0) . "', `extension_url` = '" . $this->db->escape(isset($data['extension_url']) ? $data['extension_url'] : '') . "', `original_url` = '" . $this->db->escape(isset($data['original_url']) ? $data['original_url'] : '') . "', `subject` = '" . $this->db->escape(isset($data['subject']) ? $data['subject'] : '') . "', `enquiry` = '" . $this->db->escape(isset($data['enquiry']) ? $data['enquiry'] : '') . "', `date_added` = NOW()");

		return $this->db->getLastId();
	}
}

<?php
class ModelDesignSeoUrl extends Model {
	public function getSeoUrlsByKeyword($keyword) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $this->db->escape($keyword) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->rows;
	}

	public function getSeoUrlsByQuery($query_str) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE query = '" . $this->db->escape($query_str) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->rows;
	}
}

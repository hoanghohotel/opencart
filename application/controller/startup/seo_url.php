<?php
class ControllerStartupSeoUrl extends Controller {
	public function index() {
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE keyword = '" . $this->db->escape($part) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);

					if ($url[0] == 'extension_id') {
						$this->request->get['extension_id'] = $url[1];
					}

					if ($url[0] == 'extension_category_id') {
						$this->request->get['filter_category_id'] = $url[1];
					}

					if ($url[0] == 'blog_id') {
						$this->request->get['blog_id'] = $url[1];
					}

					if ($url[0] == 'blog_category_id') {
						$this->request->get['filter_blog_category_id'] = $url[1];
					}

					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}

					if ($url[0] == 'member_partner_id') {
						$this->request->get['partner_id'] = $url[1];
					}

					if ($query->row['query'] && $url[0] != 'Information_id' && $url[0] != 'information_id' && $url[0] != 'extension_id' && $url[0] != 'extension_category_id' && $url[0] != 'blog_id' && $url[0] != 'blog_category_id' && $url[0] != 'member_partner_id') {
						$this->request->get['route'] = $query->row['query'];
					}
				} else {
					$this->request->get['route'] = 'error/not_found';

					break;
				}
			}

			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['extension_id'])) {
					$this->request->get['route'] = 'marketplace/extension/info';
				} elseif (isset($this->request->get['filter_category_id'])) {
					$this->request->get['route'] = 'marketplace/extension';
				} elseif (isset($this->request->get['blog_id'])) {
					$this->request->get['route'] = 'cms/blog/info';
				} elseif (isset($this->request->get['filter_blog_category_id'])) {
					$this->request->get['route'] = 'cms/blog';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'cms/information';
				} elseif (isset($this->request->get['partner_id'])) {
					$this->request->get['route'] = 'support/partner/info';
				}
			}
		}
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';

		$data = array();

		if (isset($url_info['query'])) {
			parse_str($url_info['query'], $data);

			foreach ($data as $key => $value) {
				if (isset($data['route'])) {
					if (($data['route'] == 'marketplace/extension/info' && $key == 'extension_id') || ($data['route'] == 'cms/blog/info' && $key == 'blog_id') || ($data['route'] == 'cms/information' && $key == 'information_id')) {
						$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];

							unset($data[$key]);
						}
					} elseif ($key == 'route') {
						$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `query` = '" . $this->db->escape($value) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];

							unset($data[$key]);
						}
					}
				}
			}
		}

		if ($url) {
			unset($data['route']);

			$query = '';

			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
				}

				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}
}

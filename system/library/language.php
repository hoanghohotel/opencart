<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Language class
*/
class Language {
	private $default = 'en-gb';
	private $directory;
	public $data = array();
	
	/**
	 * Constructor
	 *
	 * @param	string	$file
	 *
 	*/
	public function __construct($directory = '') {
		$this->directory = $directory;
	}
	
	public static function getTokenMap($config = null) {
		if (!$config && isset($GLOBALS['__oc_site_config'])) {
			$config = $GLOBALS['__oc_site_config'];
		}

		$store_url = '';
		if ($config && $config->get('config_url')) {
			$store_url = (string)$config->get('config_url');
		} elseif (defined('HTTP_CATALOG')) {
			$store_url = HTTP_CATALOG;
		} elseif (defined('HTTP_SERVER')) {
			$store_url = HTTP_SERVER;
		}

		$store_domain = parse_url($store_url, PHP_URL_HOST);
		if (!$store_domain) {
			$store_domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
		}

		$store_name = ($config && $config->get('config_name')) ? (string)$config->get('config_name') : 'OpenCart';
		$store_owner = ($config && $config->get('config_owner')) ? (string)$config->get('config_owner') : $store_name;
		$store_address_raw = ($config && $config->get('config_address')) ? (string)$config->get('config_address') : '';
		$store_address = nl2br(htmlspecialchars($store_address_raw, ENT_QUOTES, 'UTF-8'));
		$store_email = ($config && $config->get('config_email')) ? (string)$config->get('config_email') : ('noreply@' . $store_domain);
		$store_telephone = ($config && $config->get('config_telephone')) ? (string)$config->get('config_telephone') : '';
		$contact_support = ($config && $config->get('config_contact_support')) ? (string)$config->get('config_contact_support') : $store_email;
		$contact_partner = ($config && $config->get('config_contact_partner')) ? (string)$config->get('config_contact_partner') : $store_email;
		$contact_marketing = ($config && $config->get('config_contact_marketing')) ? (string)$config->get('config_contact_marketing') : $store_email;

		$base_catalog = rtrim($store_url, '/') . '/';
		$forum = ($config && $config->get('config_forum_url')) ? (string)$config->get('config_forum_url') : ($base_catalog . 'index.php?route=support/support');
		$documentation = ($config && $config->get('config_docs_url')) ? (string)$config->get('config_docs_url') : ($base_catalog . 'index.php?route=cms/guide');
		$book = ($config && $config->get('config_book_url')) ? (string)$config->get('config_book_url') : ($base_catalog . 'index.php?route=cms/guide');
		$developer = ($config && $config->get('config_developer_url')) ? (string)$config->get('config_developer_url') : ($base_catalog . 'index.php?route=cms/information&information_id=2');
		$dedicated_support = ($config && $config->get('config_dedicated_support_url')) ? (string)$config->get('config_dedicated_support_url') : ($base_catalog . 'index.php?route=support/support');
		$demo_store_url = ($config && $config->get('config_demo_store_url')) ? (string)$config->get('config_demo_store_url') : $base_catalog;
		$demo_admin_url = ($config && $config->get('config_demo_admin_url')) ? (string)$config->get('config_demo_admin_url') : ($base_catalog . 'admin/');
		$config_logo = ($config && $config->get('config_logo')) ? (string)$config->get('config_logo') : '';
		$store_logo_url = ($config_logo !== '' && defined('DIR_IMAGE') && is_file(DIR_IMAGE . $config_logo))
			? ($base_catalog . 'image/' . ltrim($config_logo, '/'))
			: ($base_catalog . 'application/view/image/icon/opencart-logo.png');

		return array(
			'{store_name}'        => $store_name,
			'{store_owner}'       => $store_owner,
			'{store_domain}'      => $store_domain,
			'{store_url}'         => $base_catalog,
			'{store_email}'       => $store_email,
			'{store_telephone}'   => $store_telephone,
			'{store_address}'     => $store_address,
			'{store_address_raw}' => $store_address_raw,
			'{store_logo_url}'    => $store_logo_url,
			'{contact_support}'   => $contact_support,
			'{contact_partner}'   => $contact_partner,
			'{contact_marketing}' => $contact_marketing,
			'{contact_telephone}' => $store_telephone,
			'{forum}'             => $forum,
			'{documentation}'     => $documentation,
			'{book}'              => $book,
			'{developer}'         => $developer,
			'{dedicated_support}' => $dedicated_support,
			'{demo_store_url}'    => $demo_store_url,
			'{demo_admin_url}'    => $demo_admin_url
		);
	}

	/**
     * 
     *
     * @param	string	$key
	 * 
	 * @return	string
     */
	public function get($key) {
		$val = isset($this->data[$key]) ? $this->data[$key] : $key;
		if (is_string($val) && strpos($val, '{') !== false) {
			$val = strtr($val, self::getTokenMap());
		}
		return $val;
	}
	
	public function set($key, $value) {
		if (is_string($value) && strpos($value, '{') !== false) {
			$value = strtr($value, self::getTokenMap());
		}
		$this->data[$key] = $value;
	}
	
	/**
     * 
     *
	 * @return	array
     */	
	public function all() {
		return $this->data;
	}
	
	/**
     * 
     *
     * @param	string	$filename
	 * @param	string	$key
	 * 
	 * @return	array
     */	
	public function load($filename, $key = '') {
		if (!$key) {
			$_ = array();
	
			$file = DIR_LANGUAGE . $this->default . '/' . $filename . '.php';
	
			if (is_file($file)) {
				require($file);
			}
	
			$file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';
			
			if (is_file($file)) {
				require($file);
			}

			$token_map = self::getTokenMap();
			foreach ($_ as $k => $v) {
				if (is_string($v) && strpos($v, '{') !== false) {
					$_[$k] = strtr($v, $token_map);
				}
			}
	
			$this->data = array_merge($this->data, $_);
		} else {
			// Put the language into a sub key
			$this->data[$key] = new Language($this->directory);
			$this->data[$key]->load($filename);
		}
		
		return $this->data;
	}
}
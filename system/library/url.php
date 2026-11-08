<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* URL class
*/
class Url {
	private $url;
	private $ssl;
	private $rewrite = array();
	private $token_param = '';
	
	/**
	 * Constructor
	 *
	 * @param	string	$url
	 * @param	string	$ssl
	 *
 	*/
	public function __construct($url, $ssl = '') {
		$this->url = $url;
		$this->ssl = $ssl;
	}

	/**
	 * Set default token parameter for frontend links
	 *
	 * @param	string	$token_param
	 */
	public function setToken($token_param = '') {
		$this->token_param = (string)$token_param;
	}

	/**
	 *
	 *
	 * @param	object	$rewrite
 	*/	
	public function addRewrite($rewrite) {
		$this->rewrite[] = $rewrite;
	}

	/**
	 * 
	 *
	 * @param	string		$route
	 * @param	mixed		$args
	 * @param	bool		$secure
	 *
	 * @return	string
 	*/
	public function link($route, $args = '', $secure = false) {
		if ($this->ssl && $secure) {
			$url = $this->ssl . 'index.php?route=' . $route;
		} else {
			$url = $this->url . 'index.php?route=' . $route;
		}

		$is_admin = (strpos($this->url, '/admin/') !== false || strpos($this->ssl, '/admin/') !== false);
		$active_token = (!$is_admin && empty($GLOBALS['__oc_suppress_url_token']) && !empty($GLOBALS['__oc_active_member_token'])) ? (string)$GLOBALS['__oc_active_member_token'] : '';

		$no_token_routes = array(
			'account/verify',
			'account/reset',
			'account/security/confirm'
		);

		if ($active_token !== '' && !in_array($route, $no_token_routes)) {
			if (is_array($args)) {
				if (!isset($args['member_token'])) {
					$args = array_merge(array('member_token' => $active_token), $args);
				}
			} else {
				$clean_args = str_replace('&amp;', '&', (string)$args);
				if (strpos($clean_args, 'member_token=') === false) {
					$args = 'member_token=' . $active_token . ($clean_args !== '' ? '&' . ltrim($clean_args, '&') : '');
				} else {
					$args = $clean_args;
				}
			}
		}

		if ($args) {
			if (is_array($args)) {
				$url .= '&amp;' . str_replace('&', '&amp;', http_build_query($args));
			} else {
				$clean_args = str_replace('&amp;', '&', (string)$args);
				$url .= str_replace('&', '&amp;', '&' . ltrim($clean_args, '&'));
			}
		}
		
		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}
		
		return $url; 
	}
}
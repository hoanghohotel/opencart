<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Loader class
*/
final class Loader {
	protected $registry;

	/**
	 * Constructor
	 *
	 * @param	object	$registry
 	*/
	public function __construct($registry) {
		$this->registry = $registry;
	}

	/**
	 * 
	 *
	 * @param	string	$route
	 * @param	array	$data
	 *
	 * @return	mixed
 	*/	
	public function controller($route, $data = array()) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		// Keep the original trigger
		$trigger = $route;
		
		// Trigger the pre events
		$result = $this->registry->get('event')->trigger('controller/' . $trigger . '/before', array(&$route, &$data));
		
		// Make sure its only the last event that returns an output if required.
		if ($result != null && !$result instanceof Exception) {
			$output = $result;
		} else {
			$is_mail_route = (strpos($route, 'mail/') === 0);
			$prev_suppress = !empty($GLOBALS['__oc_suppress_url_token']);
			if ($is_mail_route) {
				$GLOBALS['__oc_suppress_url_token'] = true;
			}

			$action = new Action($route);
			$output = $action->execute($this->registry, array(&$data));

			if ($is_mail_route) {
				$GLOBALS['__oc_suppress_url_token'] = $prev_suppress;
			}
		}
		
		// Trigger the post events
		$result = $this->registry->get('event')->trigger('controller/' . $trigger . '/after', array(&$route, &$data, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}

		if (!$output instanceof Exception) {
			return $output;
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/	
	public function model($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		if (!$this->registry->has('model_' . str_replace('/', '_', $route))) {
			$file  = DIR_APPLICATION . 'model/' . $route . '.php';
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $route);
			
			if (is_file($file)) {
				include_once($file);
	
				$proxy = new Proxy();
				
				// Overriding models is a little harder so we have to use PHP's magic methods
				// In future version we can use runkit
				foreach (get_class_methods($class) as $method) {
					$proxy->{$method} = $this->callback($this->registry, $route . '/' . $method);
				}
				
				$this->registry->set('model_' . str_replace('/', '_', (string)$route), $proxy);
			} else {
				throw new \Exception('Error: Could not load model ' . $route . '!');
			}
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
	 * @param	array	$data
	 *
	 * @return	string
 	*/
	public function view($route, $data = array()) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

		if (is_array($data)) {
			if (empty($data['member_token']) && !empty($GLOBALS['__oc_active_member_token']) && empty($GLOBALS['__oc_suppress_url_token'])) {
				$data['member_token'] = $GLOBALS['__oc_active_member_token'];
			}

			// Auto-load matching language files for the view route and its base controller route
			if ($this->registry->has('language') && defined('DIR_LANGUAGE')) {
				$lang_obj = $this->registry->get('language');
				$base_route = preg_replace('/_(list|info|form|history|comment|reply|success|confirm|reset|invoice_info|landing|agree|partner)$/', '', $route);
				if ($base_route !== $route && is_file(DIR_LANGUAGE . 'en-gb/' . $base_route . '.php')) {
					$lang_obj->load($base_route);
				}
				if (is_file(DIR_LANGUAGE . 'en-gb/' . $route . '.php')) {
					$lang_obj->load($route);
				}
			}

			// Auto-inject dynamic store configuration variables so templates never rely on hardcoded values
			$cfg = $this->registry->has('config') ? $this->registry->get('config') : null;
			$token_map = Language::getTokenMap($cfg);
			$config_vars = array(
				'store_name'        => $token_map['{store_name}'],
				'store_owner'       => $token_map['{store_owner}'],
				'store_domain'      => $token_map['{store_domain}'],
				'store_url'         => $token_map['{store_url}'],
				'store_email'       => $token_map['{store_email}'],
				'store_telephone'   => $token_map['{store_telephone}'],
				'store_address'     => $token_map['{store_address}'],
				'store_address_raw' => $token_map['{store_address_raw}'],
				'store_logo_url'    => $token_map['{store_logo_url}'],
				'contact_support'   => $token_map['{contact_support}'],
				'contact_partner'   => $token_map['{contact_partner}'],
				'contact_marketing' => $token_map['{contact_marketing}'],
				'contact_telephone' => $token_map['{contact_telephone}'],
				'forum'             => $token_map['{forum}'],
				'documentation'     => $token_map['{documentation}'],
				'book'              => $token_map['{book}'],
				'developer'         => $token_map['{developer}'],
				'dedicated_support' => $token_map['{dedicated_support}'],
				'demo_store_url'    => $token_map['{demo_store_url}'],
				'demo_admin_url'    => $token_map['{demo_admin_url}']
			);
			foreach ($config_vars as $ck => $cv) {
				if (!isset($data[$ck]) || $data[$ck] === '') {
					$data[$ck] = $cv;
				}
			}

			if (strpos($route, 'mail/') === 0 && empty($data['store'])) {
				$data['store'] = html_entity_decode($token_map['{store_name}'], ENT_QUOTES, 'UTF-8');
			}

			// Merge all loaded language strings into view data
			if ($this->registry->has('language')) {
				foreach ($this->registry->get('language')->all() as $lk => $lv) {
					if (!isset($data[$lk])) {
						$data[$lk] = is_string($lv) && strpos($lv, '{') !== false ? strtr($lv, $token_map) : $lv;
					}
				}
			}
		}
		
		// Keep the original trigger
		$trigger = $route;
		
		// Template contents. Not the output!
		$code = '';
		
		// Trigger the pre events
		$result = $this->registry->get('event')->trigger('view/' . $trigger . '/before', array(&$route, &$data, &$code));
		
		// Make sure its only the last event that returns an output if required.
		if ($result && !$result instanceof Exception) {
			$output = $result;
		} else {
			$template = new Template($this->registry->get('config')->get('template_engine'));
				
			foreach ($data as $key => $value) {
				$template->set($key, $value);
			}

			$output = $template->render($this->registry->get('config')->get('template_directory') . $route, $code);
		}
		
		// Trigger the post events
		$result = $this->registry->get('event')->trigger('view/' . $trigger . '/after', array(&$route, &$data, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}
		
		return $output;
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/
	public function library($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
			
		$file = DIR_SYSTEM . 'library/' . $route . '.php';
		$class = str_replace('/', '\\', $route);

		if (is_file($file)) {
			include_once($file);

			$this->registry->set(basename($route), new $class($this->registry));
		} else {
			throw new \Exception('Error: Could not load library ' . $route . '!');
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/	
	public function helper($route) {
		$file = DIR_SYSTEM . 'helper/' . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route) . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load helper ' . $route . '!');
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/	
	public function config($route) {
		$this->registry->get('event')->trigger('config/' . $route . '/before', array(&$route));
		
		$this->registry->get('config')->load($route);
		
		$this->registry->get('event')->trigger('config/' . $route . '/after', array(&$route));
	}

	/**
	 * 
	 *
	 * @param	string	$route
	 * @param	string	$key
	 *
	 * @return	array
 	*/
	public function language($route, $key = '') {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		// Keep the original trigger
		$trigger = $route;
				
		$result = $this->registry->get('event')->trigger('language/' . $trigger . '/before', array(&$route, &$key));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		} else {
			$output = $this->registry->get('language')->load($route, $key);
		}
		
		$result = $this->registry->get('event')->trigger('language/' . $trigger . '/after', array(&$route, &$key, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}
				
		return $output;
	}
	
	protected function callback($registry, $route) {
		return function($args) use($registry, $route) {
			static $model;
			
			$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

			// Keep the original trigger
			$trigger = $route;
					
			// Trigger the pre events
			$result = $registry->get('event')->trigger('model/' . $trigger . '/before', array(&$route, &$args));
			
			if ($result && !$result instanceof Exception) {
				$output = $result;
			} else {
				$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', substr($route, 0, strrpos($route, '/')));
				
				// Store the model object
				$key = substr($route, 0, strrpos($route, '/'));
				
				if (!isset($model[$key])) {
					$model[$key] = new $class($registry);
				}
				
				$method = substr($route, strrpos($route, '/') + 1);
				
				$callable = array($model[$key], $method);
	
				if (is_callable($callable)) {
					$output = call_user_func_array($callable, $args);
				} else {
					throw new \Exception('Error: Could not call model/' . $route . '!');
				}					
			}
			
			// Trigger the post events
			$result = $registry->get('event')->trigger('model/' . $trigger . '/after', array(&$route, &$args, &$output));
			
			if ($result && !$result instanceof Exception) {
				$output = $result;
			}
						
			return $output;
		};
	}	
}
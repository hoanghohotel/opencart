<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Response class
*/
class Response {
	private $headers = array();
	private $level = 0;
	private $output;
	private static $img_dims = null;
	private static $img_dims_dirty = false;

	/**
	 * Constructor
	 *
	 * @param	string	$header
	 *
 	*/
	public function addHeader($header) {
		$this->headers[] = $header;
	}
	
	/**
	 * 
	 *
	 * @param	string	$url
	 * @param	int		$status
	 *
 	*/
	public function redirect($url, $status = 302) {
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}
	
	/**
	 * 
	 *
	 * @param	int		$level
 	*/
	public function setCompression($level) {
		$this->level = $level;
	}
	
	/**
	 * 
	 *
	 * @return	array
 	*/
	public function getOutput() {
		return $this->output;
	}
	
	/**
	 * 
	 *
	 * @param	string	$output
 	*/	
	public function setOutput($output) {
		$this->output = $output;
	}

	/**
	 * Resolve image pixel dimensions with persistent caching to eliminate CLS (Cumulative Layout Shift)
	 *
	 * @param	string	$src
	 * @return	array|null
	 */
	private function getImageDimensions($src) {
		if (self::$img_dims === null) {
			$cache_file = defined('DIR_CACHE') ? DIR_CACHE . 'cache.cwv_img_dims.json' : '';
			if ($cache_file && is_file($cache_file)) {
				$decoded = @json_decode(@file_get_contents($cache_file), true);
				self::$img_dims = is_array($decoded) ? $decoded : array();
			} else {
				self::$img_dims = array();
			}
		}

		$clean_src = trim($src);
		foreach (array('HTTPS_CATALOG', 'HTTP_CATALOG', 'HTTPS_SERVER', 'HTTP_SERVER') as $srv_const) {
			if (defined($srv_const) && constant($srv_const) !== '' && stripos($clean_src, constant($srv_const)) === 0) {
				$clean_src = substr($clean_src, strlen(constant($srv_const)));
				break;
			}
		}
		$clean_src = preg_replace('#^(?:https?://[^/]+)?(?:/[^/]+)*?/(?=(?:image|application|admin)/)#i', '', $clean_src);
		$clean_src = ltrim(preg_replace('/\?.*$/', '', $clean_src), '/');

		if (!$clean_src || strpos($clean_src, 'data:') === 0 || strpos($clean_src, 'http://') === 0 || strpos($clean_src, 'https://') === 0) {
			return null;
		}

		if (isset(self::$img_dims[$clean_src])) {
			return self::$img_dims[$clean_src];
		}

		$root_dir = defined('DIR_SYSTEM') ? dirname(rtrim(DIR_SYSTEM, '/\\')) . '/' : '';
		if (!$root_dir) {
			return null;
		}

		$candidates = array(
			$root_dir . $clean_src,
			$root_dir . 'admin/' . $clean_src
		);

		$file_path = '';
		foreach ($candidates as $candidate) {
			if (is_file($candidate)) {
				$file_path = $candidate;
				break;
			}
		}

		if (!$file_path) {
			return null;
		}

		$ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
		$dims = null;

		if ($ext === 'svg') {
			$svg = @file_get_contents($file_path);
			if ($svg) {
				if (preg_match('/viewBox=["\']\s*[\d.]+\s+[\d.]+\s+([\d.]+)\s+([\d.]+)\s*["\']/i', $svg, $m)) {
					$w = (int)round((float)$m[1]);
					$h = (int)round((float)$m[2]);
					if ($w > 0 && $h > 0) {
						$dims = array($w, $h);
					}
				}
				if (!$dims && preg_match('/\bwidth=["\']([\d.]+)/i', $svg, $mw) && preg_match('/\bheight=["\']([\d.]+)/i', $svg, $mh)) {
					$w = (int)round((float)$mw[1]);
					$h = (int)round((float)$mh[1]);
					if ($w > 0 && $h > 0) {
						$dims = array($w, $h);
					}
				}
			}
			if (!$dims) {
				$dims = array(168, 168);
			}
		} else {
			$info = @getimagesize($file_path);
			if ($info && !empty($info[0]) && !empty($info[1])) {
				$dims = array((int)$info[0], (int)$info[1]);
			}
		}

		if ($dims) {
			self::$img_dims[$clean_src] = $dims;
			self::$img_dims_dirty = true;
		}

		return $dims;
	}

	/**
	 * Build and cache minified inline CSS for bootstrap.css + stylesheet.css
	 * to completely eliminate render-blocking stylesheet requests.
	 *
	 * @return	string
	 */
	private function getInlinedCoreCss() {
		$root_fs = defined('DIR_SYSTEM') ? dirname(rtrim(DIR_SYSTEM, '/\\')) . '/' : '';
		$bs_file = $root_fs . 'application/view/stylesheet/bootstrap.css';
		$st_file = $root_fs . 'application/view/stylesheet/stylesheet.css';
		if (!$root_fs || !is_file($bs_file) || !is_file($st_file)) {
			return '';
		}

		$ver_hash = md5(filemtime($bs_file) . ':' . filesize($bs_file) . ':' . filemtime($st_file) . ':' . filesize($st_file));
		$cache_file = (defined('DIR_CACHE') && is_dir(DIR_CACHE)) ? (DIR_CACHE . 'cache.cwv_core_css.' . $ver_hash . '.css') : '';
		if ($cache_file && is_file($cache_file)) {
			$cached = @file_get_contents($cache_file);
			if (is_string($cached) && $cached !== '') {
				return $cached;
			}
		}

		$raw_bs = (string)@file_get_contents($bs_file);
		$raw_st = (string)@file_get_contents($st_file);
		$combined = $raw_bs . "\n" . $raw_st;

		// Remove @charset rules (only valid at byte 0 of an external stylesheet)
		$combined = preg_replace('/@charset\s+["\'][^"\']*["\']\s*;/i', '', $combined);

		// Rewrite relative url(...) paths from application/view/stylesheet/ to document <base> root
		$combined = preg_replace_callback('/url\(\s*([\'"]?)([^\'")]+)\1\s*\)/i', function($m) {
			$q = $m[1];
			$u = trim($m[2]);
			if ($u === '' || strpos($u, 'data:') === 0 || strpos($u, 'http://') === 0 || strpos($u, 'https://') === 0 || strpos($u, '/') === 0) {
				return $m[0];
			}
			if (strpos($u, '../') === 0) {
				$u = 'application/view/' . substr($u, 3);
			} elseif (strpos($u, 'application/') !== 0) {
				$u = 'application/view/stylesheet/' . ltrim($u, './');
			}
			return 'url(' . $q . $u . $q . ')';
		}, $combined);

		// Minify CSS safely while preserving descendant pseudo-selector spaces
		$combined = preg_replace('#/\*.*?\*/#s', '', $combined);
		$combined = preg_replace('/\s+/', ' ', $combined);
		$combined = preg_replace('/\s*([\{\};,])\s*/', '$1', $combined);
		$combined = preg_replace('/:\s+/', ':', $combined);
		$combined = str_replace(';}', '}', trim($combined));

		if ($cache_file) {
			foreach ((array)@glob(DIR_CACHE . 'cache.cwv_core_css.*.css') as $old_cache) {
				@unlink($old_cache);
			}
			@file_put_contents($cache_file, $combined);
		}

		return $combined;
	}

	/**
	 * Automatically optimize HTML output for Core Web Vitals (LCP, INP, CLS, FCP, TTFB)
	 * without modifying any original .twig template files on disk.
	 *
	 * @param	string	$html
	 * @return	string
	 */
	private function optimizeCoreWebVitals($html) {
		if (!is_string($html) || (stripos($html, '<!DOCTYPE html') === false && stripos($html, '<html') === false)) {
			return $html;
		}

		$is_frontend = (strpos($html, 'application/view/stylesheet/stylesheet.css') !== false);
		$cfg = isset($GLOBALS['__oc_site_config']) ? $GLOBALS['__oc_site_config'] : null;
		$site_name = ($cfg && trim((string)$cfg->get('config_name')) !== '') ? trim((string)$cfg->get('config_name')) : 'OpenCart';
		$site_meta_title = ($cfg && trim((string)$cfg->get('config_meta_title')) !== '') ? trim((string)$cfg->get('config_meta_title')) : $site_name;
		$site_meta_desc = ($cfg && trim((string)$cfg->get('config_meta_description')) !== '') ? trim((string)$cfg->get('config_meta_description')) : ($site_name . ' is an open source PHP-based online e-commerce solution.');
		$config_logo = ($cfg && trim((string)$cfg->get('config_logo')) !== '') ? trim((string)$cfg->get('config_logo')) : '';

		if ($is_frontend) {
			// Ensure <base href="..."> always matches the active HTTP_HOST and protocol to prevent www vs non-www CORS font blocks
			if (!empty($_SERVER['HTTP_HOST'])) {
				$is_https_req = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
					|| (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
					|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
					|| (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on')
					|| (isset($_SERVER['REQUEST_SCHEME']) && strtolower($_SERVER['REQUEST_SCHEME']) === 'https')
					|| (isset($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false);
				$req_proto = $is_https_req ? 'https://' : 'http://';
				$req_host = $_SERVER['HTTP_HOST'];
				$html = preg_replace_callback('/<base\s+href=(["\'])https?:\/\/[^\/]+(\/[^"\']*)?\1/i', function($bm) use ($req_proto, $req_host) {
					$path = isset($bm[2]) && $bm[2] !== '' ? $bm[2] : '/';
					return '<base href=' . $bm[1] . $req_proto . $req_host . $path . $bm[1];
				}, $html, 1);
			}

			$active_token = !empty($GLOBALS['__oc_active_member_token']) ? (string)$GLOBALS['__oc_active_member_token'] : '';

			// Preserve member_token on inline JavaScript navigation/AJAX URLs when logged in
			if ($active_token !== '') {
				$html = preg_replace_callback('/<script\b[^>]*>.*?<\/script>/is', function($sm) use ($active_token) {
					return preg_replace_callback('/(["\'])(\/?index\.php\?route=[a-zA-Z0-9_\/]+[^"\']*?)\1/i', function($um) use ($active_token) {
						$q = $um[1];
						$u = ltrim($um[2], '/');
						if (strpos($u, 'member_token=') === false && !preg_match('/route=(account\/verify|account\/reset|account\/security\/confirm)\b/i', $u)) {
							$u = preg_replace('/(index\.php\?route=[a-zA-Z0-9_\/]+)/i', '$1&member_token=' . $active_token, $u, 1);
						}
						return $q . $u . $q;
					}, $sm[0]);
				}, $html);
			}

			// 1. Preload critical fonts & LCP hero image in <head>
			$preloads = '<script>window.ga=window.ga||function(){};(function(){var b=document.querySelector(\'base\');if(b&&b.href&&typeof location!==\'undefined\'){try{var u=new URL(b.href,location.href);if(u.origin!==location.origin){b.href=location.origin+u.pathname;}}catch(e){}}})();</script>' . "\n";
			$preloads .= '<link rel="preload" href="application/view/stylesheet/fonts/SourceSansPro-Regular.ttf" as="font" type="font/ttf" crossorigin />' . "\n";
			$preloads .= '<link rel="preload" href="application/view/stylesheet/fonts/opencart.woff?h4wsna" as="font" type="font/woff" crossorigin />' . "\n";

			if (strpos($html, 'id="common-home"') !== false) {
				$hero_fg = is_file(dirname(rtrim(DIR_SYSTEM, '/\\')) . '/application/view/image/home/hero-image.webp')
					? 'application/view/image/home/hero-image.webp'
					: 'application/view/image/home/hero-image.png';
				$preloads .= '<link rel="preload" href="' . $hero_fg . '" as="image" fetchpriority="high" />' . "\n";

				// Unhide desktop hero <img> inside #common-home #hero .device so the LCP element is a real <img fetchpriority="high"> in the initial HTML document
				$html = preg_replace(
					'/(<div\s+class=["\']device\s+hidden-xs\s+hidden-sm["\']>\s*<img\b[^>]*?\bclass=["\'])hidden(["\'])/i',
					'$1img-responsive$2',
					$html,
					1
				);
			}

			// Make any secondary page-level stylesheets added via $this->document->addStyle() non-render-blocking
			$html = preg_replace(
				'#<link\s+href=(["\'])([^"\']+)\1\s+type=["\']text/css["\']\s+rel=["\']stylesheet["\']\s+media=["\'](?:all|screen)["\']\s*/?>#i',
				'<link href="$2" type="text/css" rel="stylesheet" media="print" onload="this.media=\'all\'" /><noscript><link href="$2" type="text/css" rel="stylesheet" /></noscript>',
				$html
			);

			// Make FontAwesome CSS non-render-blocking to shorten critical network dependency tree
			$html = str_replace(
				'<link href="application/view/javascript/fontawesome/css/font-awesome.min.css" rel="stylesheet" />',
				'<style>.fa{display:inline-block;font:normal normal normal 14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased}</style><link href="application/view/javascript/fontawesome/css/font-awesome.min.css" rel="stylesheet" media="print" onload="this.media=\'all\'" /><noscript><link href="application/view/javascript/fontawesome/css/font-awesome.min.css" rel="stylesheet" /></noscript>',
				$html
			);

			// 2. Remove unused heavy third-party scripts to keep TBT = 0ms and INP < 50ms
			$needs_braintree = (
				strpos($html, 'braintree.client.create') !== false ||
				strpos($html, 'id="modal-checkout"') !== false ||
				strpos($html, 'id="extension-info"') !== false
			);

			if (strpos($html, 'class="fb-') === false) {
				$html = preg_replace('#<script[^>]+connect\.facebook\.net[^>]*></script>\s*#i', '', $html);
			}

			if (strpos($html, 'intlTelInput(') === false) {
				$html = preg_replace('#<script[^>]+intl-tel-input[^>]*></script>\s*#i', '', $html);
			}

			if (strpos($html, 'new Cleave(') === false) {
				$html = preg_replace('#<script[^>]+cleave[^>]*></script>\s*#i', '', $html);
			}

			if (!$needs_braintree) {
				$html = preg_replace('#<script[^>]+js\.braintreegateway\.com[^>]*></script>\s*#i', '', $html);
			}

			// 3. Make non-critical datetimepicker CSS non-render-blocking when not used on page
			$has_datepicker = (strpos($html, '.datetimepicker(') !== false);
			if (!$has_datepicker) {
				$html = str_replace(
					'<link href="application/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />',
					'<link href="application/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="print" onload="this.media=\'all\'" />',
					$html
				);
			}

			// 4. Only defer <head> scripts when <body> has NO <script> tags (so inline body scripts like #button-comment, #button-download, #button-send, upload always have synchronous $, bootstrap, and common.js)
			$body_pos = stripos($html, '<body');
			$has_body_scripts = ($body_pos !== false && stripos($html, '<script', $body_pos) !== false);

			if (!$has_body_scripts && !$has_datepicker && !$needs_braintree) {
				$html = str_replace(
					array(
						'<script src="application/view/javascript/jquery/jquery-1.12.2.min.js"></script>',
						'<script src="application/view/javascript/bootstrap/js/bootstrap.min.js"></script>',
						'<script src="application/view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>',
						'<script src="application/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>',
						'<script src="application/view/javascript/common.js"></script>'
					),
					array(
						'<script src="application/view/javascript/jquery/jquery-1.12.2.min.js" defer></script>',
						'<script src="application/view/javascript/bootstrap/js/bootstrap.min.js" defer></script>',
						'<script src="application/view/javascript/jquery/datetimepicker/moment.js" type="text/javascript" defer></script>',
						'<script src="application/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript" defer></script>',
						'<script src="application/view/javascript/common.js" defer></script>'
					),
					$html
				);
			}

			// Rewrite dead external banner image URLs to local cloud banner image
			$html = str_replace(
				array(
					'https://image.opencart.com/original/59ae4157d77e2.jpg',
					'https://image.opencart.com/original/6aaaf0de522d0.jpg'
				),
				'application/view/image/cloud/subscription_create.png',
				$html
			);

			// Apply configured Store Logo (config_logo) to navbar-brand if set in Admin Settings
			if ($config_logo !== '' && defined('DIR_IMAGE') && is_file(DIR_IMAGE . $config_logo)) {
				$html = preg_replace(
					'/(<a\b[^>]*\bclass=["\'][^"\']*navbar-brand[^"\']*["\'][^>]*>\s*<img\b[^>]*\bsrc=["\'])application\/view\/image\/icon\/opencart-logo\.png(["\'])/i',
					'$1image/' . ltrim($config_logo, '/') . '$2',
					$html,
					1
				);
			}
		}

		// Mask all <script>...</script> blocks before running HTML attribute/element transformations so inline JS template strings are never modified
		$masked_scripts = array();
		$html = preg_replace_callback('/<script\b[^>]*>.*?<\/script>/is', function($sm) use (&$masked_scripts) {
			$key = '<!--__OC_SCRIPT_MASK_' . count($masked_scripts) . '__-->';
			$masked_scripts[$key] = $sm[0];
			return $key;
		}, $html);

		if ($is_frontend) {
			$active_token = !empty($GLOBALS['__oc_active_member_token']) ? (string)$GLOBALS['__oc_active_member_token'] : '';

			// Normalize hardcoded internal links and preserve member_token across all HTML links & forms when logged in
			$html = preg_replace_callback('/\b(href|action)=(["\'])\s*([^"\']*?index\.php\?route=[a-zA-Z0-9_\/]+[^"\']*?)\s*\2/i', function($m) use ($active_token) {
				$attr = $m[1];
				$quote = $m[2];
				$val = trim($m[3]);

				if (strpos($val, '/index.php?route=') === 0) {
					$val = ltrim($val, '/');
				} elseif (stripos($val, 'https://www.opencart.com/index.php?route=') === 0) {
					$val = substr($val, strlen('https://www.opencart.com/'));
				}

				if ($active_token !== '' && strpos($val, 'member_token=') === false && !preg_match('/route=(account\/verify|account\/reset|account\/security\/confirm)\b/i', $val)) {
					$val = preg_replace('/(index\.php\?route=[a-zA-Z0-9_\/]+)/i', '$1&amp;member_token=' . $active_token, $val, 1);
				}

				return $attr . '=' . $quote . $val . $quote;
			}, $html);
		}

		// 5. Inject explicit width/height (eliminates CLS), fetchpriority="high" for LCP, loading="lazy" for below-the-fold images, and non-empty alt attributes
		$img_index = 0;
		$html = preg_replace_callback('/<img\b[^>]*>/i', function($matches) use (&$img_index, $site_name) {
			$tag = $matches[0];
			$img_index++;

			// Normalize invalid width="150px" -> width="150"
			$tag = preg_replace('/\b(width|height)=["\'](\d+)px["\']/i', '$1="$2"', $tag);

			// Normalize leading slash on /application/view/... image paths so they resolve relative to <base>
			$tag = preg_replace('/\bsrc=(["\'])\/application\/view\//i', 'src=$1application/view/', $tag);

			// Remove empty title="" attributes on images
			$tag = preg_replace('/\s+\btitle=["\']\s*["\']/i', '', $tag);

			$src = '';
			if (preg_match('/\bsrc=["\']([^"\']+)["\']/i', $tag, $ms)) {
				$src = $ms[1];
			}

			// Automatically switch local PNG/JPG image src to next-gen WebP when available on disk
			if ($src && preg_match('/\.(png|jpe?g)$/i', $src)) {
				$clean_rel = trim($src);
				foreach (array('HTTPS_CATALOG', 'HTTP_CATALOG', 'HTTPS_SERVER', 'HTTP_SERVER') as $srv_c) {
					if (defined($srv_c) && constant($srv_c) !== '' && stripos($clean_rel, constant($srv_c)) === 0) {
						$clean_rel = substr($clean_rel, strlen(constant($srv_c)));
						break;
					}
				}
				$clean_rel = preg_replace('#^(?:https?://[^/]+)?(?:/[^/]+)*?/(?=(?:image|application)/)#i', '', $clean_rel);
				$clean_rel = ltrim(rawurldecode(preg_replace('/\?.*$/', '', $clean_rel)), '/');
				$root_fs = defined('DIR_SYSTEM') ? dirname(rtrim(DIR_SYSTEM, '/\\')) . '/' : '';
				if ($root_fs && $clean_rel && is_file($root_fs . $clean_rel)) {
					$webp_rel = preg_replace('/\.(png|jpe?g)$/i', '.webp', $clean_rel);
					if (is_file($root_fs . $webp_rel) && filesize($root_fs . $webp_rel) > 0 && filesize($root_fs . $webp_rel) < filesize($root_fs . $clean_rel)) {
						$webp_src = preg_replace('/\.(png|jpe?g)(\?.*)?$/i', '.webp$2', $src);
						$tag = str_replace($src, $webp_src, $tag);
						$src = $webp_src;
					}
				}
			}

			$has_width = (bool)preg_match('/\bwidth=["\']\d+["\']/i', $tag);
			$has_height = (bool)preg_match('/\bheight=["\']\d+["\']/i', $tag);

			if ($src && (!$has_width || !$has_height)) {
				$dims = $this->getImageDimensions($src);
				if ($dims) {
					$w = $dims[0];
					$h = $dims[1];
					if ($has_width && preg_match('/\bwidth=["\'](\d+)["\']/i', $tag, $mw)) {
						$custom_w = (int)$mw[1];
						if ($custom_w > 0 && $w > 0) {
							$h = (int)round($h * ($custom_w / $w));
							$w = $custom_w;
						}
					} elseif ($has_height && preg_match('/\bheight=["\'](\d+)["\']/i', $tag, $mh)) {
						$custom_h = (int)$mh[1];
						if ($custom_h > 0 && $h > 0) {
							$w = (int)round($w * ($custom_h / $h));
							$h = $custom_h;
						}
					} elseif (stripos($src, 'facebook_marketing_partner') !== false && $w > 100) {
						$h = (int)round($h * (100 / $w));
						$w = 100;
					} elseif (stripos($src, 'opencart-logo-white') !== false && $h > 26) {
						$w = (int)round($w * (26 / $h));
						$h = 26;
					}
					$inject_dims = '';
					if (!$has_width) {
						$inject_dims .= ' width="' . $w . '"';
					}
					if (!$has_height) {
						$inject_dims .= ' height="' . $h . '"';
					}
					if ($inject_dims) {
						$tag = preg_replace('/(\s*\/?)>$/', $inject_dims . '$1>', $tag, 1);
					}
				}
			}

			// Ensure accessible non-empty alt attribute (both when missing and when alt="" is empty)
			if (!preg_match('/\balt=["\'][^"\']+["\']/i', $tag)) {
				$alt_text = htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8');
				if (preg_match('/\btitle=["\']([^"\']+)["\']/i', $tag, $mt) && trim($mt[1]) !== '') {
					$alt_text = trim($mt[1]);
				} elseif ($src) {
					$base = pathinfo(preg_replace('/\?.*$/', '', $src), PATHINFO_FILENAME);
					$base = preg_replace('/-\d+x\d+$/', '', $base);
					if (preg_match('/^ext_\d+$/i', $base)) {
						$alt_text = htmlspecialchars($site_name . ' Extension Screenshot', ENT_QUOTES, 'UTF-8');
					} else {
						$base = trim(ucwords(str_replace(array('-', '_', '.'), ' ', $base)));
						if ($base !== '') {
							$alt_text = htmlspecialchars($base, ENT_QUOTES, 'UTF-8');
						}
					}
				}
				if (preg_match('/\balt=["\']\s*["\']/i', $tag)) {
					$tag = preg_replace('/\balt=["\']\s*["\']/i', 'alt="' . $alt_text . '"', $tag, 1);
				} else {
					$tag = preg_replace('/(\s*\/?)>$/', ' alt="' . $alt_text . '"$1>', $tag, 1);
				}
			}

			$is_hidden = (bool)preg_match('/\bclass=["\'][^"\']*\bhidden\b[^"\']*["\']/i', $tag);
			$is_hero_img = ($src !== '' && stripos($src, 'hero-image.') !== false);

			if (($img_index <= 4 || $is_hero_img) && !$is_hidden) {
				$tag = preg_replace('/\s+\bloading=["\']lazy["\']/i', '', $tag);
				if (!preg_match('/\bfetchpriority=/i', $tag)) {
					$tag = preg_replace('/(\s*\/?)>$/', ' fetchpriority="high" decoding="async"$1>', $tag, 1);
				}
			} elseif ($img_index > 5) {
				if (!preg_match('/\bloading=/i', $tag)) {
					$tag = preg_replace('/(\s*\/?)>$/', ' loading="lazy" decoding="async"$1>', $tag, 1);
				}
			}

			return $tag;
		}, $html);

		if ($is_frontend) {
			// 6. Ensure <div id="top"></div> exists right after <body...> and add role="main" landmark to primary content container after </header>
			if (!preg_match('/\bid=["\']top["\']/i', $html)) {
				$html = preg_replace('/(<body\b[^>]*>)/i', '$1<div id="top"></div>', $html, 1);
			}
			if (!preg_match('/<main\b|\brole=["\']main["\']/i', $html)) {
				$html = preg_replace('/(<\/header>\s*<div\b)(?![^>]*\brole=)/is', '$1 role="main"', $html, 1);
			}

			// 7. Accessibility: Ensure all <button> elements have an accessible name (button-name)
			$html = preg_replace_callback('/<button\b([^>]*)>(.*?)<\/button>/is', function($bm) {
				$attrs = $bm[1];
				$inner = $bm[2];
				$text = trim(strip_tags($inner));
				if ($text === '' && !preg_match('/\b(aria-label|aria-labelledby)=["\'][^"\']+["\']/i', $attrs)) {
					$label = 'Button';
					if (stripos($attrs, 'navbar-toggle') !== false || stripos($attrs, 'collapse') !== false) {
						$label = 'Toggle navigation';
					} elseif (stripos($attrs, 'button-search') !== false || stripos($inner, 'fa-search') !== false) {
						$label = 'Search';
					} elseif (stripos($attrs, 'subscribe') !== false || stripos($inner, 'fa-angle-right') !== false) {
						$label = 'Subscribe';
					} elseif (stripos($attrs, 'close') !== false || stripos($attrs, 'data-dismiss') !== false) {
						$label = 'Close';
					} elseif (stripos($inner, 'fa-calendar') !== false) {
						$label = 'Select date';
					} elseif (stripos($inner, 'fa-upload') !== false) {
						$label = 'Upload';
					}
					$attrs .= ' aria-label="' . $label . '"';
				}
				return '<button' . $attrs . '>' . $inner . '</button>';
			}, $html);

			// 8. Accessibility: Ensure all <input>, <select>, and <textarea> controls have an accessible label (label / select-name)
			$labeled_ids = array();
			if (preg_match_all('/<label\b[^>]*\bfor=["\']([^"\']+)["\']/i', $html, $lm)) {
				foreach ($lm[1] as $for_id) {
					$labeled_ids[$for_id] = true;
				}
			}

			$html = preg_replace_callback('/<(input|select|textarea)\b([^>]*)>/is', function($im) use ($labeled_ids) {
				$tag_name = strtolower($im[1]);
				$attrs = $im[2];

				if ($tag_name === 'input' && preg_match('/\btype=["\'](hidden|submit|button|reset|image)["\']/i', $attrs)) {
					return $im[0];
				}

				if (preg_match('/\b(aria-label|aria-labelledby)=["\'][^"\']+["\']/i', $attrs)) {
					return $im[0];
				}

				if (preg_match('/\bid=["\']([^"\']+)["\']/i', $attrs, $idm) && isset($labeled_ids[$idm[1]])) {
					return $im[0];
				}

				$label = '';
				if (preg_match('/\bplaceholder=["\']([^"\']+)["\']/i', $attrs, $pm) && trim($pm[1]) !== '') {
					$label = trim($pm[1]);
				} elseif (preg_match('/\btitle=["\']([^"\']+)["\']/i', $attrs, $tm) && trim($tm[1]) !== '') {
					$label = trim($tm[1]);
				} elseif (preg_match('/\bname=["\']([^"\']+)["\']/i', $attrs, $nm) && trim($nm[1]) !== '') {
					$raw_name = preg_replace('/\[.*$/', '', trim($nm[1]));
					$raw_name = preg_replace('/^(filter_|input[-_])/i', '', $raw_name);
					$label = ucwords(str_replace(array('-', '_'), ' ', $raw_name));
					if (preg_match('/\btype=["\']radio["\']/i', $attrs) && preg_match('/\bvalue=["\']([^"\']+)["\']/i', $attrs, $vm)) {
						$label .= ' ' . ucwords(str_replace(array('-', '_'), ' ', trim($vm[1])));
					}
				} elseif (preg_match('/\bid=["\']([^"\']+)["\']/i', $attrs, $idm2) && trim($idm2[1]) !== '') {
					$raw_id = preg_replace('/^(filter_|input[-_])/i', '', trim($idm2[1]));
					$label = ucwords(str_replace(array('-', '_'), ' ', $raw_id));
				}

				if ($label === '') {
					$label = ($tag_name === 'select') ? 'Select option' : 'Input field';
				}

				$label_attr = ' aria-label="' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '"';
				if (substr(rtrim($attrs), -1) === '/') {
					$attrs = preg_replace('/\/(\s*)$/', $label_attr . ' /$1', $attrs, 1);
				} else {
					$attrs .= $label_attr;
				}

				return '<' . $im[1] . $attrs . '>';
			}, $html);

			// 9. Links: target="_blank" security (rel="noopener noreferrer"), crawlable anchors, and accessible link names (link-name)
			$html = preg_replace_callback('/<a\b([^>]*)>(.*?)<\/a>/is', function($am) use ($site_name) {
				$attrs = $am[1];
				$inner = $am[2];

				// Add rel="noopener noreferrer" to target="_blank" links
				if (preg_match('/\btarget=["\']_blank["\']/i', $attrs) && !preg_match('/\brel=/i', $attrs)) {
					$attrs .= ' rel="noopener noreferrer"';
				}

				// Replace non-crawlable href="#" and href="javascript:..." anchors
				if (preg_match('/\bhref=["\'](#|javascript:[^"\']*)["\']/i', $attrs)) {
					$replacement_href = '#top';
					if (stripos($attrs, 'data-toggle="dropdown"') !== false && stripos($inner, 'Resources') !== false) {
						$replacement_href = 'index.php?route=cms/showcase';
					} elseif (stripos($attrs, 'comment-box') !== false) {
						$replacement_href = '#comment-box';
					}
					$attrs = preg_replace('/\bhref=["\'](#|javascript:[^"\']*)["\']/i', 'href="' . $replacement_href . '"', $attrs, 1);
				}

				// Ensure accessible link name if inner text and image alt are empty
				$text = trim(preg_replace('/\s+/', ' ', strip_tags($inner)));
				$has_img_alt = (bool)preg_match('/<img\b[^>]*\balt=["\'][^"\']+["\']/i', $inner);
				if ($text === '' && !$has_img_alt && !preg_match('/\b(aria-label|aria-labelledby)=["\'][^"\']+["\']/i', $attrs)) {
					$link_label = $site_name;
					if (preg_match('/\btitle=["\']([^"\']+)["\']/i', $attrs, $tm) && trim($tm[1]) !== '') {
						$link_label = trim($tm[1]);
					} elseif (preg_match('/\bhref=["\']([^"\']+)["\']/i', $attrs, $hm)) {
						$href_val = $hm[1];
						if (stripos($href_val, 'facebook.com') !== false) {
							$link_label = $site_name . ' Facebook';
						} elseif (stripos($href_val, 'twitter.com') !== false) {
							$link_label = $site_name . ' Twitter';
						} elseif (stripos($href_val, 'linkedin.com') !== false) {
							$link_label = $site_name . ' LinkedIn';
						} elseif (stripos($href_val, 'github.com') !== false) {
							$link_label = $site_name . ' GitHub';
						} elseif (stripos($href_val, 'youtube.com') !== false) {
							$link_label = $site_name . ' YouTube';
						}
					}
					$attrs .= ' aria-label="' . htmlspecialchars($link_label, ENT_QUOTES, 'UTF-8') . '"';
				}

				// SEO (link-text): Enhance generic link text ("Learn More", "Click here", "More", etc.) with descriptive context from settings
				$norm_text = strtolower(trim($text, " \t\n\r\0\x0B.!?:;,-›»>"));
				$generic_link_texts = array('learn more', 'read more', 'click here', 'click this', 'more', 'here', 'this', 'start', 'go', 'right here');
				if (in_array($norm_text, $generic_link_texts, true) && stripos($inner, 'sr-only') === false) {
					$context_suffix = ' - ' . $site_name;
					if (preg_match('/\btitle=["\']([^"\']+)["\']/i', $attrs, $tm_desc) && trim($tm_desc[1]) !== '') {
						$context_suffix = ' - ' . trim($tm_desc[1]);
					} elseif (preg_match('/\bhref=["\']([^"\']+)["\']/i', $attrs, $hm_desc)) {
						$href_desc = $hm_desc[1];
						if (stripos($href_desc, 'forum.') !== false) {
							$context_suffix = ' - ' . $site_name . ' Community Forum';
						} elseif (stripos($href_desc, 'dedicated.') !== false) {
							$context_suffix = ' - ' . $site_name . ' Dedicated Support';
						} elseif (stripos($href_desc, 'softaculous.com') !== false) {
							$context_suffix = ' - ' . $site_name . ' Softaculous';
						} elseif (stripos($href_desc, 'aws.amazon.com') !== false) {
							$context_suffix = ' - ' . $site_name . ' AWS Marketplace';
						} elseif (stripos($href_desc, 'cloud') !== false) {
							$context_suffix = ' - ' . $site_name . ' Cloud';
						} elseif (stripos($href_desc, 'marketplace') !== false) {
							$context_suffix = ' - ' . $site_name . ' Marketplace';
						} elseif (stripos($href_desc, 'support') !== false || stripos($href_desc, 'partner') !== false) {
							$context_suffix = ' - ' . $site_name . ' Support';
						} elseif (stripos($href_desc, 'download') !== false) {
							$context_suffix = ' - ' . $site_name . ' Downloads';
						}
					}
					$inner .= '<span class="sr-only">' . htmlspecialchars($context_suffix, ENT_QUOTES, 'UTF-8') . '</span>';
				}

				return '<a' . $attrs . '>' . $inner . '</a>';
			}, $html);

			// 10. Deduplicate repeated decorative DOM id="..." attributes (paypal-banner-ad, share-facebook, share-twitter, share-reddit)
			$seen_ids = array();
			$html = preg_replace_callback('/<([a-zA-Z0-9]+)\b([^>]*?\bid=["\'](paypal-banner-ad|share-facebook|share-twitter|share-reddit)["\'][^>]*)>/is', function($idm) use (&$seen_ids) {
				$tag = $idm[1];
				$attrs = $idm[2];
				$id_val = $idm[3];
				if (!isset($seen_ids[$id_val])) {
					$seen_ids[$id_val] = 1;
					return $idm[0];
				}
				$seen_ids[$id_val]++;
				$new_id = $id_val . '-' . $seen_ids[$id_val];
				$attrs = preg_replace('/\bid=(["\'])' . preg_quote($id_val, '/') . '\1/', 'id=$1' . $new_id . '$1', $attrs, 1);
				return '<' . $tag . $attrs . '>';
			}, $html);

			// 11. Normalize heading hierarchy (h1..h6) so heading levels never skip while preserving visual classes (.h1..h6)
			$prev_heading_level = 0;
			$html = preg_replace_callback('/<h([1-6])\b([^>]*)>(.*?)<\/h\1>/is', function($hm) use (&$prev_heading_level) {
				$orig_level = (int)$hm[1];
				$attrs = $hm[2];
				$inner = $hm[3];

				if ($prev_heading_level === 0) {
					$new_level = 1;
				} elseif ($orig_level > $prev_heading_level + 1) {
					$new_level = $prev_heading_level + 1;
				} else {
					$new_level = $orig_level;
				}

				$prev_heading_level = $new_level;

				if ($new_level !== $orig_level) {
					$orig_class = 'h' . $orig_level;
					if (preg_match('/\bclass=(["\'])(.*?)\1/i', $attrs, $cm)) {
						if (!preg_match('/\b' . $orig_class . '\b/i', $cm[2])) {
							$new_class_val = trim($cm[2] . ' ' . $orig_class);
							$attrs = preg_replace('/\bclass=(["\'])(.*?)\1/i', 'class=$1' . $new_class_val . '$1', $attrs, 1);
						}
					} else {
						$attrs .= ' class="' . $orig_class . '"';
					}
				}

				return '<h' . $new_level . $attrs . '>' . $inner . '</h' . $new_level . '>';
			}, $html);
		}

		// Restore masked <script>...</script> blocks
		if (!empty($masked_scripts)) {
			$html = strtr($html, $masked_scripts);
		}

		if ($is_frontend) {
			// 12. Inject OpenGraph, Twitter Card, Theme Color, and JSON-LD Structured Data in <head> for SEO using Store Settings
			if (stripos($html, 'property="og:title"') === false && stripos($html, '</head>') !== false) {
				$page_title = $site_meta_title;
				if (preg_match('/<title>(.*?)<\/title>/is', $html, $tm) && trim($tm[1]) !== '') {
					$page_title = trim( html_entity_decode(strip_tags($tm[1]), ENT_QUOTES, 'UTF-8') );
				}
				$page_desc = $site_meta_desc;
				if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\']([^"\']+)["\']/i', $html, $dm) && trim($dm[1]) !== '') {
					$page_desc = trim( html_entity_decode($dm[1], ENT_QUOTES, 'UTF-8') );
				}
				$base_url = defined('HTTPS_SERVER') ? HTTPS_SERVER : (defined('HTTP_SERVER') ? HTTP_SERVER : '/');
				if (preg_match('/<base\s+href=["\']([^"\']+)["\']/i', $html, $bm_base) && trim($bm_base[1]) !== '') {
					$base_url = rtrim(trim($bm_base[1]), '/') . '/';
				}
				$canonical = $base_url;
				if (preg_match('/<link\s+href=["\']([^"\']+)["\']\s+rel=["\']canonical["\']/i', $html, $cm) && trim($cm[1]) !== '') {
					$canonical = trim($cm[1]);
				}

				// Resolve logo URL dynamically from config_logo setting or navbar-brand img
				$logo_url = '';
				if ($config_logo !== '' && defined('DIR_IMAGE') && is_file(DIR_IMAGE . $config_logo)) {
					$logo_url = $base_url . 'image/' . ltrim($config_logo, '/');
				} elseif (preg_match('/<a\b[^>]*\bclass=["\'][^"\']*navbar-brand[^"\']*["\'][^>]*>.*?<img\b[^>]*\bsrc=["\']([^"\']+)["\']/is', $html, $lm_logo) && trim($lm_logo[1]) !== '') {
					$raw_logo = trim($lm_logo[1]);
					$logo_url = (strpos($raw_logo, 'http://') === 0 || strpos($raw_logo, 'https://') === 0) ? $raw_logo : ($base_url . ltrim($raw_logo, '/'));
				} else {
					$logo_url = $base_url . 'application/view/image/icon/opencart-logo.webp';
				}

				$esc_site_name = htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8');
				$esc_title = htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8');
				$esc_desc = htmlspecialchars($page_desc, ENT_QUOTES, 'UTF-8');
				$esc_url = htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8');
				$json_ld = json_encode(array(
					'@context' => 'https://schema.org',
					'@type'    => 'Organization',
					'name'     => $site_name,
					'url'      => $base_url,
					'logo'     => $logo_url
				), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

				$seo_meta = '<meta name="theme-color" content="#006bb3" />' . "\n";
				$seo_meta .= '<meta property="og:site_name" content="' . $esc_site_name . '" />' . "\n";
				$seo_meta .= '<meta property="og:type" content="website" />' . "\n";
				$seo_meta .= '<meta property="og:title" content="' . $esc_title . '" />' . "\n";
				$seo_meta .= '<meta property="og:description" content="' . $esc_desc . '" />' . "\n";
				$seo_meta .= '<meta property="og:url" content="' . $esc_url . '" />' . "\n";
				$seo_meta .= '<meta property="og:image" content="' . htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8') . '" />' . "\n";
				$seo_meta .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";
				$seo_meta .= '<meta name="twitter:title" content="' . $esc_title . '" />' . "\n";
				$seo_meta .= '<meta name="twitter:description" content="' . $esc_desc . '" />' . "\n";
				$seo_meta .= '<script type="application/ld+json">' . $json_ld . '</script>' . "\n";

				$html = str_ireplace('</head>', $seo_meta . '</head>', $html);
			}

			// 13. Inline minified bootstrap.css + stylesheet.css at the very end to eliminate render-blocking CSS requests
			$inlined_core_css = $this->getInlinedCoreCss();
			if ($inlined_core_css !== '') {
				$html = str_replace(
					'<link href="application/view/stylesheet/bootstrap.css" rel="stylesheet" />',
					$preloads . '<style id="oc-core-css">' . $inlined_core_css . '</style>',
					$html
				);
				$html = preg_replace('#<link\s+href=["\']application/view/stylesheet/stylesheet\.css["\']\s+rel=["\']stylesheet["\']\s*/?>\s*#i', '', $html, 1);
			} else {
				$html = str_replace(
					'<link href="application/view/stylesheet/bootstrap.css" rel="stylesheet" />',
					$preloads . '<link href="application/view/stylesheet/bootstrap.css" rel="stylesheet" />',
					$html
				);
			}
		}

		if (self::$img_dims_dirty && defined('DIR_CACHE') && is_dir(DIR_CACHE)) {
			@file_put_contents(DIR_CACHE . 'cache.cwv_img_dims.json', json_encode(self::$img_dims));
			self::$img_dims_dirty = false;
		}

		return $html;
	}
	
	/**
	 * 
	 *
	 * @param	string	$data
	 * @param	int		$level
	 * 
	 * @return	string
 	*/
	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Vary: Accept-Encoding');
		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}
	
	/**
	 * 
 	*/
	public function output() {
		if ($this->output) {
			$processed = $this->optimizeCoreWebVitals($this->output);

			$comp_level = $this->level;
			if (!$comp_level && is_string($processed) && stripos($processed, '<!DOCTYPE html') !== false) {
				$comp_level = 6;
			}

			$output = $comp_level ? $this->compress($processed, $comp_level) : $processed;
			
			if (!headers_sent()) {
				header('X-Content-Type-Options: nosniff', false);
				header('X-Frame-Options: SAMEORIGIN', false);
				header('Referrer-Policy: strict-origin-when-cross-origin', false);
				header('Permissions-Policy: geolocation=(), microphone=(), camera=()', false);
				if (isset($_SERVER['REQUEST_TIME_FLOAT'])) {
					$dur = round((microtime(true) - (float)$_SERVER['REQUEST_TIME_FLOAT']) * 1000, 1);
					header('Server-Timing: app;dur=' . $dur . ';desc="OpenCart Core"', false);
				}
				$explicit_status = 0;
				foreach ($this->headers as $header) {
					if (preg_match('/^HTTP\/\d+\.\d+\s+(\d+)/i', $header, $hm)) {
						$explicit_status = (int)$hm[1];
					}
					header($header, true);
				}
				if ($explicit_status) {
					http_response_code($explicit_status);
				}
			}
			
			echo $output;
		} elseif (!headers_sent() && !empty($this->headers)) {
			$explicit_status = 0;
			foreach ($this->headers as $header) {
				if (preg_match('/^HTTP\/\d+\.\d+\s+(\d+)/i', $header, $hm)) {
					$explicit_status = (int)$hm[1];
				}
				header($header, true);
			}
			if ($explicit_status) {
				http_response_code($explicit_status);
			}
		}
	}
}

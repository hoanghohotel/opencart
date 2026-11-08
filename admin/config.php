<?php
// Dynamic HTTP / HTTPS & Base Path Detection
$oc_is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
	|| (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
	|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');
$oc_protocol = $oc_is_https ? 'https://' : 'http://';
$oc_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost');
$oc_root_dir = rtrim(str_replace('\\', '/', dirname(__DIR__)), '/');

if (isset($_SERVER['SCRIPT_NAME']) && (!defined('PHP_SAPI') || PHP_SAPI !== 'cli')) {
	$oc_admin_base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
} else {
	$oc_admin_base = '/admin/';
}
$oc_catalog_base = preg_replace('#/admin/$#', '/', $oc_admin_base);

// HTTP
define('HTTP_SERVER', $oc_protocol . $oc_host . $oc_admin_base);
define('HTTP_CATALOG', $oc_protocol . $oc_host . $oc_catalog_base);

// HTTPS
define('HTTPS_SERVER', $oc_protocol . $oc_host . $oc_admin_base);
define('HTTPS_CATALOG', $oc_protocol . $oc_host . $oc_catalog_base);

// DIR
define('DIR_APPLICATION', $oc_root_dir . '/admin/');
define('DIR_SYSTEM', $oc_root_dir . '/system/');
define('DIR_IMAGE', $oc_root_dir . '/image/');
define('DIR_STORAGE', DIR_SYSTEM . 'storage/');
define('DIR_CATALOG', $oc_root_dir . '/application/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'retail');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

// OpenCart API
define('OPENCART_SERVER', HTTP_CATALOG);

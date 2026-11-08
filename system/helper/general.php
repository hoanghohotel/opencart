<?php
function token($length = 32) {
	// Create random token
	$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$max = strlen($string) - 1;
	
	$token = '';
	
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, $max)];
	}	
	
	return $token;
}

/**
 * Backwards support for timing safe hash string comparisons
 * 
 * http://php.net/manual/en/function.hash-equals.php
 */

if(!function_exists('hash_equals')) {
	function hash_equals($known_string, $user_string) {
		$known_string = (string)$known_string;
		$user_string = (string)$user_string;

		if(strlen($known_string) != strlen($user_string)) {
			return false;
		} else {
			$res = $known_string ^ $user_string;
			$ret = 0;

			for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);

			return !$ret;
		}
	}
}

if (!function_exists('time_ago')) {
	function time_ago($datetime) {
		$timestamp = is_numeric($datetime) ? (int)$datetime : strtotime((string)$datetime);
		if (!$timestamp || $timestamp <= 0) {
			return '';
		}

		$diff = time() - $timestamp;
		if ($diff < 60) {
			return 'just now';
		}

		$intervals = array(
			31536000 => 'year',
			2592000  => 'month',
			604800   => 'week',
			86400    => 'day',
			3600     => 'hour',
			60       => 'minute'
		);

		foreach ($intervals as $seconds => $label) {
			$count = (int)floor($diff / $seconds);
			if ($count >= 1) {
				return $count . ' ' . $label . ($count > 1 ? 's' : '') . ' ago';
			}
		}

		return 'just now';
	}
}
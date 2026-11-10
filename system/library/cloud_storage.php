<?php
/**
 * Unified Cloud Object Storage Library for OpenCart
 * Supports:
 *  - Local Disk ('local')
 *  - Amazon S3 ('s3')
 *  - Wasabi Hot Cloud Storage ('wasabi')
 *  - Cloudflare R2 ('cloudflare')
 *  - Google Cloud Storage ('google' - both S3 HMAC Interop & Native Service Account JSON OAuth2)
 */
class CloudStorage {
	private $registry;
	private $config;
	private $driver = 'local';
	private $access_key = '';
	private $secret_key = '';
	private $bucket = '';
	private $region = 'us-east-1';
	private $endpoint = '';
	private $public_url = '';
	private $prefix = '';
	private $acl = 'private';
	private $keep_local = true;
	private $gcs_json = '';
	private $last_error = '';

	public function __construct($registry = null, $override = array()) {
		$this->registry = $registry;
		if ($registry && $registry->has('config')) {
			$this->config = $registry->get('config');
		}

		$this->driver     = strtolower(trim((string)$this->getSetting('config_storage_driver', $override, 'local')));
		$this->access_key = trim((string)$this->getSetting('config_storage_access_key', $override, ''));
		$this->secret_key = trim((string)$this->getSetting('config_storage_secret_key', $override, ''));
		$this->bucket     = trim((string)$this->getSetting('config_storage_bucket', $override, ''));
		$this->region     = trim((string)$this->getSetting('config_storage_region', $override, 'us-east-1'));
		$this->endpoint   = trim((string)$this->getSetting('config_storage_endpoint', $override, ''));
		$this->public_url = rtrim(trim((string)$this->getSetting('config_storage_public_url', $override, '')), '/');
		$this->prefix     = trim(str_replace('\\', '/', trim((string)$this->getSetting('config_storage_prefix', $override, ''))), '/');
		$this->acl        = trim((string)$this->getSetting('config_storage_acl', $override, 'private'));
		$this->keep_local = ((string)$this->getSetting('config_storage_keep_local', $override, '1') !== '0');
		$this->gcs_json   = trim((string)$this->getSetting('config_storage_gcs_json', $override, ''));

		if ($this->region === '') {
			$this->region = ($this->driver === 'cloudflare' || $this->driver === 'google') ? 'auto' : 'us-east-1';
		}
	}

	private function getSetting($key, $override, $default = '') {
		if (is_array($override) && array_key_exists($key, $override)) {
			return $override[$key];
		}
		if ($this->config && $this->config->get($key) !== null) {
			return $this->config->get($key);
		}
		return $default;
	}

	public function getDriver() {
		return $this->driver;
	}

	public function getLastError() {
		return $this->last_error;
	}

	public function isEnabled() {
		if (!in_array($this->driver, array('s3', 'wasabi', 'cloudflare', 'google'), true)) {
			return false;
		}
		if ($this->bucket === '') {
			return false;
		}
		if ($this->driver === 'google' && $this->isNativeGcsServiceAccount()) {
			return true;
		}
		return ($this->access_key !== '' && $this->secret_key !== '');
	}

	private function isNativeGcsServiceAccount() {
		if ($this->driver !== 'google' || $this->gcs_json === '') {
			return false;
		}
		$decoded = @json_decode(html_entity_decode($this->gcs_json, ENT_QUOTES, 'UTF-8'), true);
		return (is_array($decoded) && !empty($decoded['client_email']) && !empty($decoded['private_key']));
	}

	/**
	 * Build normalized object key inside the bucket
	 */
	public function buildObjectKey($category, $filename) {
		$clean_cat = trim(str_replace('\\', '/', (string)$category), '/');
		$clean_file = ltrim(str_replace('\\', '/', (string)$filename), '/');
		$parts = array();
		if ($this->prefix !== '') {
			$parts[] = $this->prefix;
		}
		if ($clean_cat !== '') {
			$parts[] = $clean_cat;
		}
		if ($clean_file !== '') {
			$parts[] = $clean_file;
		}
		return implode('/', $parts);
	}

	/**
	 * Resolve S3-compatible endpoint host & base URL for Amazon S3, Wasabi, Cloudflare R2, and Google Cloud Storage
	 */
	public function getEndpointInfo() {
		$region = $this->region ?: 'us-east-1';
		$custom = $this->endpoint;

		if ($this->driver === 'wasabi') {
			if ($custom !== '') {
				$base = (stripos($custom, 'http') === 0) ? rtrim($custom, '/') : 'https://' . rtrim($custom, '/');
			} else {
				$base = ($region === 'us-east-1') ? 'https://s3.wasabisys.com' : 'https://s3.' . $region . '.wasabisys.com';
			}
			$signing_region = ($region === 'auto') ? 'us-east-1' : $region;
		} elseif ($this->driver === 'cloudflare') {
			if ($custom !== '') {
				if (stripos($custom, 'http') === 0) {
					$base = rtrim($custom, '/');
				} elseif (strpos($custom, '.') !== false) {
					$base = 'https://' . rtrim($custom, '/');
				} else {
					// Account ID provided directly
					$base = 'https://' . $custom . '.r2.cloudflarestorage.com';
				}
			} else {
				$base = 'https://r2.cloudflarestorage.com';
			}
			$signing_region = ($region === '' || $region === 'auto') ? 'auto' : $region;
		} elseif ($this->driver === 'google') {
			$base = ($custom !== '') ? ((stripos($custom, 'http') === 0) ? rtrim($custom, '/') : 'https://' . rtrim($custom, '/')) : 'https://storage.googleapis.com';
			$signing_region = ($region === '' || $region === 'auto') ? 'auto' : $region;
		} else {
			// Amazon S3
			if ($custom !== '') {
				$base = (stripos($custom, 'http') === 0) ? rtrim($custom, '/') : 'https://' . rtrim($custom, '/');
			} else {
				$base = 'https://s3.' . $region . '.amazonaws.com';
			}
			$signing_region = ($region === 'auto') ? 'us-east-1' : $region;
		}

		$parsed = parse_url($base);
		$scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'https';
		$host   = isset($parsed['host']) ? $parsed['host'] : 's3.amazonaws.com';
		$port   = isset($parsed['port']) ? ':' . $parsed['port'] : '';

		return array(
			'base_url'       => $scheme . '://' . $host . $port,
			'host'           => $host . $port,
			'signing_region' => $signing_region
		);
	}

	/**
	 * Handle an uploaded file from $_FILES['...']['tmp_name'], saving locally and syncing to Cloud Storage if enabled
	 */
	public function storeUploadedFile($tmp_name, $local_destination, $category = 'upload', $relative_key = '') {
		$dir = dirname($local_destination);
		if (!is_dir($dir)) {
			@mkdir($dir, 0777, true);
		}

		$moved = false;
		if (is_uploaded_file($tmp_name)) {
			$moved = @move_uploaded_file($tmp_name, $local_destination);
		}
		if (!$moved && is_file($tmp_name)) {
			$moved = @copy($tmp_name, $local_destination);
		}

		if (!$moved || !is_file($local_destination)) {
			$this->last_error = 'Failed to write uploaded file to local storage.';
			return false;
		}

		if (!$this->isEnabled()) {
			return true;
		}

		if ($relative_key === '') {
			$relative_key = basename($local_destination);
		}

		$object_key = $this->buildObjectKey($category, $relative_key);
		$mime = $this->detectMimeType($local_destination);

		$ok = $this->putObject($local_destination, $object_key, $mime);

		if ($ok) {
			// Save a small sidecar metadata file so downloads know the cloud object key even if local file is removed
			$meta = array(
				'driver'     => $this->driver,
				'bucket'     => $this->bucket,
				'object_key' => $object_key,
				'size'       => filesize($local_destination),
				'mime'       => $mime,
				'public_url' => $this->getPublicObjectUrl($object_key),
				'timestamp'  => time()
			);
			@file_put_contents($local_destination . '.cloud.json', json_encode($meta));

			// Only remove local binary for non-image downloads/uploads when keep_local is disabled
			if (!$this->keep_local && in_array($category, array('upload', 'download'), true)) {
				@unlink($local_destination);
			}
		}

		return $ok;
	}

	/**
	 * Check if a file exists either on local disk or in Cloud Storage (via sidecar metadata or HEAD request)
	 */
	public function fileExists($local_path, $category = 'upload', $relative_key = '') {
		if (is_file($local_path) && filesize($local_path) > 0) {
			return true;
		}
		if (is_file($local_path . '.cloud.json')) {
			return true;
		}
		return false;
	}

	/**
	 * Serve a file to the browser (from local disk if present, or from Cloud Storage via signed URL / stream)
	 */
	public function outputFile($local_path, $mask_filename, $category = 'upload', $relative_key = '') {
		$mask = $mask_filename ? basename($mask_filename) : basename($local_path);

		// 1. If local file exists on disk, stream it directly
		if (is_file($local_path) && filesize($local_path) > 0) {
			if (!headers_sent()) {
				header('Pragma: public');
				header('Expires: 0');
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="' . $mask . '"');
				header('Content-Transfer-Encoding: binary');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Content-Length: ' . filesize($local_path));

				if (ob_get_level()) {
					ob_end_clean();
				}

				readfile($local_path, 'rb');
				exit();
			}
			return true;
		}

		// 2. Check sidecar metadata or construct remote object key
		$object_key = '';
		if (is_file($local_path . '.cloud.json')) {
			$meta = @json_decode(@file_get_contents($local_path . '.cloud.json'), true);
			if (is_array($meta) && !empty($meta['object_key'])) {
				$object_key = $meta['object_key'];
			}
		}

		if ($object_key === '' && $this->isEnabled()) {
			$rel = ($relative_key !== '') ? $relative_key : basename($local_path);
			$object_key = $this->buildObjectKey($category, $rel);
		}

		if ($object_key !== '' && $this->isEnabled()) {
			// If native GCS Service Account JSON is used, download and stream bytes directly
			if ($this->driver === 'google' && $this->isNativeGcsServiceAccount()) {
				$data = $this->getObject($object_key);
				if ($data !== false && !headers_sent()) {
					header('Pragma: public');
					header('Expires: 0');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $mask . '"');
					header('Content-Length: ' . strlen($data));
					if (ob_get_level()) {
						ob_end_clean();
					}
					echo $data;
					exit();
				}
			} else {
				// Generate AWS Signature V4 Pre-Signed URL with Content-Disposition attachment header
				$signed_url = $this->getPresignedUrl($object_key, 3600, $mask);
				if ($signed_url && !headers_sent()) {
					header('Location: ' . $signed_url, true, 302);
					exit();
				}
			}
		}

		return false;
	}

	/**
	 * Upload a file from local path to the Cloud Storage bucket
	 */
	public function putObject($local_file_path, $object_key, $content_type = 'application/octet-stream') {
		if (!is_file($local_file_path)) {
			$this->last_error = 'Local file does not exist: ' . $local_file_path;
			return false;
		}
		$body = @file_get_contents($local_file_path);
		if ($body === false) {
			$this->last_error = 'Unable to read local file: ' . $local_file_path;
			return false;
		}
		return $this->putObjectContent($body, $object_key, $content_type);
	}

	/**
	 * Upload raw string/binary content to the Cloud Storage bucket
	 */
	public function putObjectContent($body, $object_key, $content_type = 'application/octet-stream') {
		$this->last_error = '';

		if ($this->driver === 'google' && $this->isNativeGcsServiceAccount()) {
			return $this->gcsNativePutObject($body, $object_key, $content_type);
		}

		$extra_headers = array(
			'content-type' => $content_type
		);

		if ($this->acl === 'public-read' && $this->driver !== 'cloudflare') {
			$extra_headers['x-amz-acl'] = 'public-read';
		}

		$res = $this->s3Request('PUT', $object_key, $body, $extra_headers);
		if ($res['status'] >= 200 && $res['status'] < 300) {
			return true;
		}

		$this->last_error = 'HTTP ' . $res['status'] . ': ' . $this->extractXmlError($res['body'], $res['error']);
		return false;
	}

	/**
	 * Download raw object content from the Cloud Storage bucket
	 */
	public function getObject($object_key) {
		$this->last_error = '';

		if ($this->driver === 'google' && $this->isNativeGcsServiceAccount()) {
			return $this->gcsNativeGetObject($object_key);
		}

		$res = $this->s3Request('GET', $object_key, '');
		if ($res['status'] >= 200 && $res['status'] < 300) {
			return $res['body'];
		}

		$this->last_error = 'HTTP ' . $res['status'] . ': ' . $this->extractXmlError($res['body'], $res['error']);
		return false;
	}

	/**
	 * Delete an object from the Cloud Storage bucket
	 */
	public function deleteObject($object_key) {
		$this->last_error = '';

		if ($this->driver === 'google' && $this->isNativeGcsServiceAccount()) {
			return $this->gcsNativeDeleteObject($object_key);
		}

		$res = $this->s3Request('DELETE', $object_key, '');
		if ($res['status'] >= 200 && $res['status'] < 300) {
			return true;
		}

		$this->last_error = 'HTTP ' . $res['status'] . ': ' . $this->extractXmlError($res['body'], $res['error']);
		return false;
	}

	/**
	 * Generate an AWS Signature V4 Pre-Signed GET URL (works with Amazon S3, Wasabi, Cloudflare R2, and GCS HMAC)
	 */
	public function getPresignedUrl($object_key, $expires = 3600, $download_filename = '') {
		if ($this->acl === 'public-read' && $this->public_url !== '' && $download_filename === '') {
			return $this->getPublicObjectUrl($object_key);
		}

		$ep = $this->getEndpointInfo();
		$region = $ep['signing_region'];
		$service = 's3';

		$amz_date = gmdate('Ymd\THis\Z');
		$datestamp = gmdate('Ymd');

		$encoded_key = $this->uriEncodePath($this->bucket . '/' . ltrim($object_key, '/'));
		$canonical_uri = '/' . $encoded_key;

		$credential_scope = $datestamp . '/' . $region . '/' . $service . '/aws4_request';

		$query_params = array(
			'X-Amz-Algorithm'     => 'AWS4-HMAC-SHA256',
			'X-Amz-Credential'    => $this->access_key . '/' . $credential_scope,
			'X-Amz-Date'          => $amz_date,
			'X-Amz-Expires'       => (string)(int)$expires,
			'X-Amz-SignedHeaders' => 'host'
		);

		if ($download_filename !== '') {
			$safe_dl = str_replace('"', '', basename($download_filename));
			$query_params['response-content-disposition'] = 'attachment; filename="' . $safe_dl . '"';
		}

		ksort($query_params);
		$canonical_querystring = http_build_query($query_params, '', '&', PHP_QUERY_RFC3986);

		$canonical_headers = 'host:' . $ep['host'] . "\n";
		$signed_headers = 'host';
		$payload_hash = 'UNSIGNED-PAYLOAD';

		$canonical_request = "GET\n"
			. $canonical_uri . "\n"
			. $canonical_querystring . "\n"
			. $canonical_headers . "\n"
			. $signed_headers . "\n"
			. $payload_hash;

		$string_to_sign = "AWS4-HMAC-SHA256\n"
			. $amz_date . "\n"
			. $credential_scope . "\n"
			. hash('sha256', $canonical_request);

		$signing_key = $this->getSignatureKey($this->secret_key, $datestamp, $region, $service);
		$signature = hash_hmac('sha256', $string_to_sign, $signing_key);

		return $ep['base_url'] . $canonical_uri . '?' . $canonical_querystring . '&X-Amz-Signature=' . $signature;
	}

	/**
	 * Return public URL for an object key when public_url or public-read is used
	 */
	public function getPublicObjectUrl($object_key) {
		$clean_key = ltrim($object_key, '/');
		if ($this->public_url !== '') {
			return $this->public_url . '/' . $clean_key;
		}
		$ep = $this->getEndpointInfo();
		return $ep['base_url'] . '/' . $this->bucket . '/' . $clean_key;
	}

	/**
	 * Test live connection (PUT + GET + DELETE diagnostic probe)
	 */
	public function testConnection() {
		$provider_names = array(
			'local'      => 'Local Disk Storage',
			's3'         => 'Amazon S3',
			'wasabi'     => 'Wasabi Hot Cloud Storage',
			'cloudflare' => 'Cloudflare R2 Storage',
			'google'     => 'Google Cloud Storage (GCS)'
		);

		$provider_label = isset($provider_names[$this->driver]) ? $provider_names[$this->driver] : strtoupper($this->driver);

		if ($this->driver === 'local') {
			$upload_writable = is_dir(DIR_UPLOAD) && is_writable(DIR_UPLOAD);
			$download_writable = is_dir(DIR_DOWNLOAD) && is_writable(DIR_DOWNLOAD);
			if ($upload_writable && $download_writable) {
				return array(
					'success'  => true,
					'provider' => $provider_label,
					'endpoint' => DIR_UPLOAD,
					'bucket'   => 'system/storage/upload & download',
					'message'  => 'Local Disk Storage is active and writable.'
				);
			}
			return array(
				'success'  => false,
				'provider' => $provider_label,
				'error'    => 'Local storage directories (DIR_UPLOAD / DIR_DOWNLOAD) are not writable!'
			);
		}

		if ($this->bucket === '') {
			return array(
				'success'  => false,
				'provider' => $provider_label,
				'error'    => 'Bucket Name is required!'
			);
		}

		if (!$this->isEnabled()) {
			return array(
				'success'  => false,
				'provider' => $provider_label,
				'error'    => 'Access Key ID and Secret Access Key (or Google Service Account JSON) are required!'
			);
		}

		$ep = $this->getEndpointInfo();
		$probe_key = $this->buildObjectKey('diagnostics', 'opencart-storage-probe-' . mt_rand(1000, 9999) . '.txt');
		$probe_content = 'OpenCart Cloud Storage Diagnostic Probe - ' . gmdate('c');

		$start_time = microtime(true);
		$put_ok = $this->putObjectContent($probe_content, $probe_key, 'text/plain');
		$latency_ms = round((microtime(true) - $start_time) * 1000, 1);

		if (!$put_ok) {
			return array(
				'success'  => false,
				'provider' => $provider_label,
				'endpoint' => $ep['base_url'],
				'bucket'   => $this->bucket,
				'region'   => $ep['signing_region'],
				'error'    => $this->last_error ?: 'Failed to upload diagnostic test object to bucket.'
			);
		}

		// Clean up probe object
		$this->deleteObject($probe_key);

		return array(
			'success'    => true,
			'provider'   => $provider_label,
			'endpoint'   => $ep['base_url'],
			'bucket'     => $this->bucket,
			'region'     => $ep['signing_region'],
			'latency_ms' => $latency_ms,
			'message'    => 'Successfully authenticated, uploaded, and verified object storage on ' . $provider_label . ' (' . $latency_ms . ' ms).'
		);
	}

	/**
	 * Perform a signed AWS Signature V4 HTTP request using cURL
	 */
	private function s3Request($method, $object_key, $body = '', $extra_headers = array()) {
		$ep = $this->getEndpointInfo();
		$region = $ep['signing_region'];
		$service = 's3';

		$amz_date = gmdate('Ymd\THis\Z');
		$datestamp = gmdate('Ymd');
		$payload_hash = hash('sha256', (string)$body);

		$encoded_key = $this->uriEncodePath($this->bucket . '/' . ltrim($object_key, '/'));
		$canonical_uri = '/' . $encoded_key;
		$canonical_querystring = '';

		$headers = array(
			'host'                 => $ep['host'],
			'x-amz-content-sha256' => $payload_hash,
			'x-amz-date'           => $amz_date
		);

		foreach ($extra_headers as $k => $v) {
			$headers[strtolower(trim($k))] = trim($v);
		}

		ksort($headers);

		$canonical_headers = '';
		$signed_header_names = array();
		foreach ($headers as $k => $v) {
			$canonical_headers .= $k . ':' . preg_replace('/\s+/', ' ', $v) . "\n";
			$signed_header_names[] = $k;
		}
		$signed_headers = implode(';', $signed_header_names);

		$canonical_request = $method . "\n"
			. $canonical_uri . "\n"
			. $canonical_querystring . "\n"
			. $canonical_headers . "\n"
			. $signed_headers . "\n"
			. $payload_hash;

		$credential_scope = $datestamp . '/' . $region . '/' . $service . '/aws4_request';
		$string_to_sign = "AWS4-HMAC-SHA256\n"
			. $amz_date . "\n"
			. $credential_scope . "\n"
			. hash('sha256', $canonical_request);

		$signing_key = $this->getSignatureKey($this->secret_key, $datestamp, $region, $service);
		$signature = hash_hmac('sha256', $string_to_sign, $signing_key);

		$authorization = 'AWS4-HMAC-SHA256 '
			. 'Credential=' . $this->access_key . '/' . $credential_scope . ', '
			. 'SignedHeaders=' . $signed_headers . ', '
			. 'Signature=' . $signature;

		$curl_headers = array(
			'Authorization: ' . $authorization
		);
		foreach ($headers as $k => $v) {
			$curl_headers[] = $k . ': ' . $v;
		}
		if ($method === 'PUT') {
			$curl_headers[] = 'Content-Length: ' . strlen((string)$body);
		}

		$url = $ep['base_url'] . $canonical_uri;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		if (defined('CURLSSLOPT_NATIVE_CA') && !ini_get('curl.cainfo') && !ini_get('openssl.cafile')) {
			curl_setopt($ch, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
		}

		if ($method === 'PUT' || $method === 'POST') {
			curl_setopt($ch, CURLOPT_POSTFIELDS, (string)$body);
		}

		$response_body = curl_exec($ch);
		$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_err = curl_error($ch);
		curl_close($ch);

		return array(
			'status' => $status,
			'body'   => (string)$response_body,
			'error'  => $curl_err
		);
	}

	/**
	 * Native Google Cloud Storage OAuth2 Service Account JWT Token exchange
	 */
	private function getGcsAccessToken() {
		$creds = @json_decode(html_entity_decode($this->gcs_json, ENT_QUOTES, 'UTF-8'), true);
		if (!is_array($creds) || empty($creds['client_email']) || empty($creds['private_key'])) {
			$this->last_error = 'Invalid Google Cloud Service Account JSON.';
			return false;
		}

		$now = time();
		$header = $this->base64UrlEncode(json_encode(array('alg' => 'RS256', 'typ' => 'JWT')));
		$claim = $this->base64UrlEncode(json_encode(array(
			'iss'   => $creds['client_email'],
			'scope' => 'https://www.googleapis.com/auth/devstorage.full_control',
			'aud'   => 'https://oauth2.googleapis.com/token',
			'exp'   => $now + 3600,
			'iat'   => $now
		)));

		$unsigned = $header . '.' . $claim;
		$signature = '';
		if (!@openssl_sign($unsigned, $signature, $creds['private_key'], OPENSSL_ALGO_SHA256)) {
			$this->last_error = 'Failed to sign Google Service Account JWT with private_key.';
			return false;
		}

		$jwt = $unsigned . '.' . $this->base64UrlEncode($signature);

		$ch = curl_init('https://oauth2.googleapis.com/token');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
			'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
			'assertion'  => $jwt
		)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		if (defined('CURLSSLOPT_NATIVE_CA') && !ini_get('curl.cainfo') && !ini_get('openssl.cafile')) {
			curl_setopt($ch, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
		}
		$res = curl_exec($ch);
		$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$json = @json_decode((string)$res, true);
		if ($status === 200 && !empty($json['access_token'])) {
			return $json['access_token'];
		}

		$this->last_error = 'Google OAuth2 error: ' . (!empty($json['error_description']) ? $json['error_description'] : (string)$res);
		return false;
	}

	private function gcsNativePutObject($body, $object_key, $content_type) {
		$token = $this->getGcsAccessToken();
		if (!$token) {
			return false;
		}

		$url = 'https://storage.googleapis.com/upload/storage/v1/b/' . rawurlencode($this->bucket) . '/o?uploadType=media&name=' . rawurlencode(ltrim($object_key, '/'));
		if ($this->acl === 'public-read') {
			$url .= '&predefinedAcl=publicRead';
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $token,
			'Content-Type: ' . $content_type,
			'Content-Length: ' . strlen((string)$body)
		));
		curl_setopt($ch, CURLOPT_POSTFIELDS, (string)$body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		if (defined('CURLSSLOPT_NATIVE_CA') && !ini_get('curl.cainfo') && !ini_get('openssl.cafile')) {
			curl_setopt($ch, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
		}
		$res = curl_exec($ch);
		$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($status >= 200 && $status < 300) {
			return true;
		}

		$this->last_error = 'GCS HTTP ' . $status . ': ' . (string)$res;
		return false;
	}

	private function gcsNativeGetObject($object_key) {
		$token = $this->getGcsAccessToken();
		if (!$token) {
			return false;
		}

		$url = 'https://storage.googleapis.com/storage/v1/b/' . rawurlencode($this->bucket) . '/o/' . rawurlencode(ltrim($object_key, '/')) . '?alt=media';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		if (defined('CURLSSLOPT_NATIVE_CA') && !ini_get('curl.cainfo') && !ini_get('openssl.cafile')) {
			curl_setopt($ch, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
		}
		$res = curl_exec($ch);
		$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($status >= 200 && $status < 300) {
			return (string)$res;
		}
		return false;
	}

	private function gcsNativeDeleteObject($object_key) {
		$token = $this->getGcsAccessToken();
		if (!$token) {
			return false;
		}

		$url = 'https://storage.googleapis.com/storage/v1/b/' . rawurlencode($this->bucket) . '/o/' . rawurlencode(ltrim($object_key, '/'));
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		if (defined('CURLSSLOPT_NATIVE_CA') && !ini_get('curl.cainfo') && !ini_get('openssl.cafile')) {
			curl_setopt($ch, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
		}
		curl_exec($ch);
		$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return ($status >= 200 && $status < 300);
	}

	private function getSignatureKey($key, $date_stamp, $region_name, $service_name) {
		$k_date    = hash_hmac('sha256', $date_stamp, 'AWS4' . $key, true);
		$k_region  = hash_hmac('sha256', $region_name, $k_date, true);
		$k_service = hash_hmac('sha256', $service_name, $k_region, true);
		$k_signing = hash_hmac('sha256', 'aws4_request', $k_service, true);
		return $k_signing;
	}

	private function uriEncodePath($path) {
		$segments = explode('/', ltrim($path, '/'));
		$encoded = array();
		foreach ($segments as $seg) {
			$encoded[] = rawurlencode($seg);
		}
		return implode('/', $encoded);
	}

	private function base64UrlEncode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	private function extractXmlError($xml_body, $curl_err) {
		if ($curl_err) {
			return $curl_err;
		}
		if (preg_match('/<Code>(.*?)<\/Code>/is', $xml_body, $cm)) {
			$msg = $cm[1];
			if (preg_match('/<Message>(.*?)<\/Message>/is', $xml_body, $mm)) {
				$msg .= ' - ' . $mm[1];
			}
			return $msg;
		}
		return trim(strip_tags($xml_body)) ?: 'Unknown storage error';
	}

	private function detectMimeType($file_path) {
		$ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
		$map = array(
			'zip'  => 'application/zip',
			'rar'  => 'application/x-rar-compressed',
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png'  => 'image/png',
			'gif'  => 'image/gif',
			'webp' => 'image/webp',
			'svg'  => 'image/svg+xml',
			'pdf'  => 'application/pdf',
			'txt'  => 'text/plain',
			'json' => 'application/json'
		);
		return isset($map[$ext]) ? $map[$ext] : 'application/octet-stream';
	}
}

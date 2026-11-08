<?php
class ControllerCommonImage extends Controller {
	public function index() {
		$this->load->language('common/image');

		$json = array();

		if (!empty($this->request->files['image']['name']) && is_file($this->request->files['image']['tmp_name'])) {
			$filename = basename(html_entity_decode($this->request->files['image']['name'], ENT_QUOTES, 'UTF-8'));

			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}

			$allowed = array(
				'jpg',
				'jpeg',
				'gif',
				'png'
			);

			if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			$allowed_mime = array(
				'image/jpeg',
				'image/pjpeg',
				'image/png',
				'image/x-png',
				'image/gif'
			);

			if (!in_array($this->request->files['image']['type'], $allowed_mime)) {
				$json['error'] = $this->language->get('error_filemime');
			}

			if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['image']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json) {
			$directory = DIR_IMAGE . 'catalog/';
			if (!is_dir($directory)) {
				@mkdir($directory, 0777, true);
			}

			$ext = utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1));
			$safe_name = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($filename, PATHINFO_FILENAME));
			if (!$safe_name) {
				$safe_name = 'image';
			}

			$new_filename = $safe_name . '-' . token(8) . '.' . $ext;
			$relative_path = 'catalog/' . $new_filename;

			require_once(DIR_SYSTEM . 'library/cloud_storage.php');
			$cloud_storage = new CloudStorage($this->registry);

			if (!$cloud_storage->storeUploadedFile($this->request->files['image']['tmp_name'], $directory . $new_filename, 'image', $relative_path)) {
				$json['error'] = sprintf($this->language->get('error_storage'), $cloud_storage->getLastError());
			} else {
				$width = isset($this->request->get['width']) && (int)$this->request->get['width'] > 0 ? (int)$this->request->get['width'] : 200;
				$height = isset($this->request->get['height']) && (int)$this->request->get['height'] > 0 ? (int)$this->request->get['height'] : 200;

				$this->load->model('tool/image');

				$json['filename'] = $relative_path;
				$json['image'] = $relative_path;
				$json['thumb'] = $this->model_tool_image->resize($relative_path, $width, $height);
				$json['storage_driver'] = $cloud_storage->getDriver();
				$json['success'] = $this->language->get('text_uploaded');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

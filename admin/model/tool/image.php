<?php
class ModelToolImage extends Model {
	public function resize($filename, $width, $height) {
		if ($filename && (strpos($filename, 'http://') === 0 || strpos($filename, 'https://') === 0)) {
			return $filename;
		}

		$base_url = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

		$source_file = '';

		if ($filename && strpos($filename, 'application/') === 0 && is_file(DIR_CATALOG . '../' . $filename)) {
			$source_file = DIR_CATALOG . '../' . $filename;
		} elseif ($filename && is_file(DIR_IMAGE . $filename)) {
			$source_file = DIR_IMAGE . $filename;
		}

		if (!$source_file) {
			if (is_file(DIR_IMAGE . 'no_image.png')) {
				$filename = 'no_image.png';
				$source_file = DIR_IMAGE . 'no_image.png';
			} else {
				return '';
			}
		}

		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		if ($extension === 'svg') {
			if (strpos($filename, 'application/') === 0) {
				return $base_url . $filename;
			} else {
				return $base_url . 'image/' . $filename;
			}
		}

		$safe_name = str_replace('application/view/image/', 'app/', $filename);
		$image_new = 'cache/' . utf8_substr($safe_name, 0, utf8_strrpos($safe_name, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $image_new) || (filemtime($source_file) > filemtime(DIR_IMAGE . $image_new))) {
			$info = @getimagesize($source_file);

			if (!$info || !in_array($info[2], array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_WEBP))) {
				if (strpos($filename, 'application/') === 0) {
					return $base_url . $filename;
				} else {
					return $base_url . 'image/' . $filename;
				}
			}

			list($width_orig, $height_orig, $image_type) = $info;

			$path = '';

			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image($source_file);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $image_new);
			} else {
				copy($source_file, DIR_IMAGE . $image_new);
			}
		}

		$image_new = str_replace(' ', '%20', $image_new);

		return $base_url . 'image/' . $image_new;
	}
}

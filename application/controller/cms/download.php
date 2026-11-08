<?php
class ControllerCmsDownload extends Controller {
	public function index() {
		$this->load->language('cms/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/download');
		$this->load->model('marketplace/extension');
		$this->load->model('tool/image');

		$data['cart2cart'] = $this->url->link('cms/cart2cart');
		$data['history'] = $this->url->link('cms/download/history');
		$data['partner'] = $this->url->link('support/partner');

		$latest_download = $this->model_cms_download->getLatestDownload();

		if ($latest_download) {
			$data['download'] = $this->url->link('cms/download/download', 'download_id=' . (int)$latest_download['download_id']);
			$data['name'] = $latest_download['name'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($latest_download['date_added']));
		} else {
			$data['download'] = '';
			$data['name'] = '';
			$data['date_added'] = '';
		}

		$data['downloads'] = array();

		$results = $this->model_cms_download->getDownloads();

		foreach ($results as $result) {
			$download_href = $this->url->link('cms/download/download', 'download_id=' . (int)$result['download_id']);

			$data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'download'    => $download_href,
				'href'        => $download_href
			);
		}

		$this->populateFeaturedItems($data, 3, 6);

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/download', $data));
	}

	public function history() {
		$this->load->language('cms/download');

		$this->document->setTitle($this->language->get('heading_title_history'));

		$this->load->model('cms/download');

		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
		$limit = 10;

		$download_total = $this->model_cms_download->getTotalDownloads();
		$results = $this->model_cms_download->getDownloads(array(
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		));

		$data['downloads'] = array();

		foreach ($results as $result) {
			$data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'href'        => $this->url->link('cms/download/download', 'download_id=' . (int)$result['download_id'])
			);
		}

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $download_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('cms/download/history', 'page={page}')
		));

		$data['banner'] = $this->load->controller('cms/banner', 1);
		$data['partner'] = $this->url->link('support/partner');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/download_history', $data));
	}

	public function download() {
		$this->load->language('cms/download');

		$this->load->model('cms/download');
		$this->load->model('marketplace/extension');
		$this->load->model('tool/image');

		$download_id = 0;
		if (isset($this->request->get['download_id'])) {
			$download_id = (int)$this->request->get['download_id'];
		} elseif (isset($this->request->get['amp;download_id'])) {
			$download_id = (int)$this->request->get['amp;download_id'];
		}

		$download_info = $this->model_cms_download->getDownload($download_id);

		if (!$download_info) {
			$download_info = $this->model_cms_download->getLatestDownload();
		}

		if (!$download_info) {
			$this->response->redirect($this->url->link('cms/download'));
			return;
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['download_id'] = (int)$download_info['download_id'];
		$data['name'] = $download_info['name'];
		$data['date_added'] = date($this->language->get('date_format_short'), strtotime($download_info['date_added']));

		if (!empty($download_info['filename']) && is_file(DIR_DOWNLOAD . $download_info['filename'])) {
			$data['download'] = str_replace('&amp;', '&', $this->url->link('cms/download/file', 'download_id=' . (int)$download_info['download_id']));
		} elseif (!empty($download_info['href'])) {
			$data['download'] = trim($download_info['href']);
		} else {
			$data['download'] = str_replace('&amp;', '&', $this->url->link('cms/download/file', 'download_id=' . (int)$download_info['download_id']));
		}

		$data['banner'] = $this->load->controller('cms/banner', 1);
		$data['partner'] = $this->url->link('support/partner');

		$this->populateFeaturedItems($data, 3, 3);

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/download_thank_you', $data));
	}

	public function file() {
		$this->load->language('cms/download');

		$this->load->model('cms/download');

		$download_id = 0;
		if (isset($this->request->get['download_id'])) {
			$download_id = (int)$this->request->get['download_id'];
		} elseif (isset($this->request->get['amp;download_id'])) {
			$download_id = (int)$this->request->get['amp;download_id'];
		}

		$download_info = $this->model_cms_download->getDownload($download_id);

		if (!$download_info) {
			$download_info = $this->model_cms_download->getLatestDownload();
		}

		if ($download_info) {
			$file = DIR_DOWNLOAD . $download_info['filename'];
			$mask = basename($download_info['mask']);

			if ($download_info['filename']) {
				require_once(DIR_SYSTEM . 'library/cloud_storage.php');
				$cloud_storage = new CloudStorage($this->registry);
				$cloud_storage->outputFile($file, $mask ? $mask : basename($file), 'download', $download_info['filename']);
			}

			if ($download_info['filename'] && is_file($file)) {
				if (!headers_sent()) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					if (ob_get_level()) {
						ob_end_clean();
					}

					readfile($file, 'rb');

					exit();
				}
			} elseif (!empty($download_info['href'])) {
				$this->response->redirect($download_info['href']);
			} else {
				$token_map = Language::getTokenMap($this->config);
				$store_name = $token_map['{store_name}'];
				$slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $store_name));
				$filename = $mask ? $mask : $slug . '-' . $download_info['name'] . '.zip';
				$fallback_file = DIR_DOWNLOAD . basename($filename);

				if (!is_file($fallback_file)) {
					if (!is_dir(DIR_DOWNLOAD)) {
						@mkdir(DIR_DOWNLOAD, 0777, true);
					}
					if (class_exists('ZipArchive')) {
						$zip = new ZipArchive();
						if ($zip->open($fallback_file, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
							$zip->addFromString('README.md', "# " . $store_name . " v" . $download_info['name'] . "\r\n\r\nRelease Date: " . $download_info['date_added'] . "\r\n\r\n" . strip_tags(html_entity_decode($download_info['description'], ENT_QUOTES, 'UTF-8')) . "\r\n");
							$zip->close();
						}
					}
				}

				if (is_file($fallback_file) && !headers_sent()) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $filename . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($fallback_file));

					if (ob_get_level()) {
						ob_end_clean();
					}

					readfile($fallback_file, 'rb');

					exit();
				}

				$content = $store_name . " Release Package v" . $download_info['name'] . "\r\n";
				if (!headers_sent()) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $filename . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . strlen($content));

					if (ob_get_level()) {
						ob_end_clean();
					}

					echo $content;

					exit();
				}
			}
		} else {
			$this->response->redirect($this->url->link('cms/download'));
		}
	}

	private function populateFeaturedItems(&$data, $ext_limit = 3, $theme_limit = 6) {
		$data['rating'] = 1;
		$data['extensions'] = array();

		$extension_results = array();
		$featured_extension_ids = array(9132, 31314, 29764);

		foreach ($featured_extension_ids as $ext_id) {
			if (count($extension_results) >= $ext_limit) {
				break;
			}
			$ext_info = $this->model_marketplace_extension->getExtension($ext_id);
			if ($ext_info && $ext_info['status']) {
				$extension_results[] = $ext_info;
			}
		}

		if (count($extension_results) < $ext_limit) {
			$fallback_extensions = $this->model_marketplace_extension->getExtensions(array(
				'sort'  => 'recommended',
				'start' => 0,
				'limit' => $ext_limit
			));
			foreach ($fallback_extensions as $fb) {
				if (count($extension_results) >= $ext_limit) {
					break;
				}
				$exists = false;
				foreach ($extension_results as $er) {
					if ((int)$er['extension_id'] === (int)$fb['extension_id']) {
						$exists = true;
						break;
					}
				}
				if (!$exists) {
					$extension_results[] = $fb;
				}
			}
		}

		foreach ($extension_results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 260, 152);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 260, 152);
			}

			$data['extensions'][] = array(
				'extension_id' => $result['extension_id'],
				'name'         => $result['name'],
				'description'  => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
				'image'        => $image,
				'price'        => ($result['license'] && (float)$result['price'] > 0) ? $this->currency->format($result['price'], $this->config->get('config_currency')) : $this->language->get('text_free'),
				'rating'       => (int)$result['rating'],
				'rating_total' => (int)$result['rating_total'],
				'href'         => $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id'])
			);
		}

		$data['themes'] = array();

		$theme_results = array();
		$featured_theme_ids = array(40361, 37931, 40345, 45030, 45326, 45330);

		foreach ($featured_theme_ids as $theme_id) {
			if (count($theme_results) >= $theme_limit) {
				break;
			}
			$theme_info = $this->model_marketplace_extension->getExtension($theme_id);
			if ($theme_info && $theme_info['status']) {
				$theme_results[] = $theme_info;
			}
		}

		if (count($theme_results) < $theme_limit) {
			$fallback_themes = $this->model_marketplace_extension->getExtensions(array(
				'filter_category_id' => 1,
				'sort'               => 'recommended',
				'start'              => 0,
				'limit'              => $theme_limit
			));
			foreach ($fallback_themes as $ft) {
				if (count($theme_results) >= $theme_limit) {
					break;
				}
				$exists = false;
				foreach ($theme_results as $tr) {
					if ((int)$tr['extension_id'] === (int)$ft['extension_id']) {
						$exists = true;
						break;
					}
				}
				if (!$exists) {
					$theme_results[] = $ft;
				}
			}
		}

		foreach ($theme_results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 260, 152);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 260, 152);
			}

			$data['themes'][] = array(
				'extension_id' => $result['extension_id'],
				'name'         => $result['name'],
				'description'  => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
				'image'        => $image,
				'price'        => ($result['license'] && (float)$result['price'] > 0) ? $this->currency->format($result['price'], $this->config->get('config_currency')) : $this->language->get('text_free'),
				'rating'       => (int)$result['rating'],
				'rating_total' => (int)$result['rating_total'],
				'href'         => $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id'])
			);
		}
	}
}

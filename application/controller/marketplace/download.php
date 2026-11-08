<?php
class ControllerMarketplaceDownload extends Controller {
	public function index() {
		$this->load->language('marketplace/download');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 38358;

		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('marketplace/download', 'extension_id=' . $extension_id, true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('marketplace/extension');
		$this->load->model('cms/download');
		$this->load->model('account/order');
		$this->load->model('tool/image');

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		if ($extension_info) {
			$this->document->setTitle(sprintf($this->language->get('heading_title'), $extension_info['name']));

			if ($extension_info['image']) {
				$data['image'] = $this->model_tool_image->resize($extension_info['image'], 260, 152);
			} else {
				$data['image'] = $this->model_tool_image->resize('no_image.png', 260, 152);
			}

			$data['name'] = $extension_info['name'];
			$data['license'] = (int)$extension_info['license'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($extension_info['date_added']));
			$data['extension'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id);
			$data['documentation'] = html_entity_decode($extension_info['documentation'], ENT_QUOTES, 'UTF-8');

			$can_download = !$extension_info['license'] || (float)$extension_info['price'] <= 0 || $this->member->getId() == $extension_info['member_id'] || $this->model_account_order->hasPurchasedExtension($extension_id, $this->member->getId());

			$all_versions = array();
			foreach ($this->model_cms_download->getDownloads() as $ver) {
				$all_versions[$ver['download_id']] = $ver['name'];
			}

			$data['downloads'] = array();

			$results = $this->model_marketplace_extension->getExtensionDownloads($extension_id);

			foreach ($results as $result) {
				$compat_names = array();
				if (!empty($result['download_id']) && is_array($result['download_id'])) {
					foreach ($result['download_id'] as $dl_id) {
						if (isset($all_versions[$dl_id])) {
							$compat_names[] = $all_versions[$dl_id];
						}
					}
				}

				$href = '';
				if ($can_download) {
					$href = $this->url->link('marketplace/download/download', 'extension_id=' . $extension_id . '&extension_download_id=' . $result['extension_download_id']);
				}

				$data['downloads'][] = array(
					'extension_download_id' => $result['extension_download_id'],
					'name'                  => $result['name'],
					'compatibility'         => $compat_names ? implode(', ', $compat_names) : '3.0.x.x',
					'date_added'            => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'upgrade'               => '',
					'href'                  => $href
				);
			}

			$data['banner'] = $this->load->controller('cms/banner', 1);

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('marketplace/download', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function download() {
		$this->load->language('marketplace/download');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 38358;
		$extension_download_id = isset($this->request->get['extension_download_id']) ? (int)$this->request->get['extension_download_id'] : 0;

		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('marketplace/download', 'extension_id=' . $extension_id, true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('marketplace/extension');
		$this->load->model('account/order');

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);
		$download_info = $this->model_marketplace_extension->getExtensionDownload($extension_download_id);

		if ($extension_info && $download_info && $download_info['extension_id'] == $extension_id) {
			$can_download = !$extension_info['license'] || (float)$extension_info['price'] <= 0 || $this->member->getId() == $extension_info['member_id'] || $this->model_account_order->hasPurchasedExtension($extension_id, $this->member->getId());

			if (!$can_download) {
				$this->session->data['redirect'] = $this->url->link('marketplace/download', 'extension_id=' . $extension_id, true);
				$this->response->redirect($this->url->link('account/login', '', true));
			}

			$this->model_marketplace_extension->updateDownloaded($extension_id, $extension_download_id);

			$file = DIR_DOWNLOAD . $download_info['filename'];
			if (!is_file($file) && is_file(DIR_UPLOAD . $download_info['filename'])) {
				$file = DIR_UPLOAD . $download_info['filename'];
			}

			$mask = $download_info['mask'] ? basename($download_info['mask']) : basename($download_info['filename']);
			if (!$mask) {
				$mask = 'extension-' . $extension_id . '.ocmod.zip';
			}

			if ($download_info['filename']) {
				require_once(DIR_SYSTEM . 'library/cloud_storage.php');
				$cloud_storage = new CloudStorage($this->registry);
				$cloud_storage->outputFile($file, $mask, 'download', $download_info['filename']);
			}

			if ($download_info['filename'] && is_file($file)) {
				if (!headers_sent()) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $mask . '"');
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
			} else {
				$content = $this->language->get('text_package_prefix') . ": " . $extension_info['name'] . " (" . $download_info['name'] . ")\r\n";
				if (!headers_sent()) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $mask . '"');
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
			$this->response->redirect($this->url->link('marketplace/extension'));
		}
	}
}

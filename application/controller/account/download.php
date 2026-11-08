<?php
class ControllerAccountDownload extends Controller {
	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/download', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/download');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 10;

		$token = 'member_token=' . $this->session->data['member_token'];

		$this->load->model('account/order');
		$this->load->model('marketplace/extension');
		$this->load->model('tool/image');

		$data['downloads'] = array();

		$filter_data = array(
			'member_id' => $this->member->getId(),
			'start'     => ($page - 1) * $limit,
			'limit'     => $limit
		);

		$download_total = $this->model_account_order->getTotalPurchasedExtensions($filter_data);

		$ref = new ReflectionMethod('ModelAccountOrder', 'getPurchasedExtensions');
		if ($ref->getNumberOfParameters() >= 2) {
			$results = $this->model_account_order->getPurchasedExtensions($this->member->getId(), ($page - 1) * $limit, $limit);
		} else {
			$results = $this->model_account_order->getPurchasedExtensions($filter_data);
		}

		foreach ($results as $result) {
			$extension_info = $this->model_marketplace_extension->getExtension($result['extension_id']);

			$image_path = !empty($result['image']) ? $result['image'] : (!empty($extension_info['image']) ? $extension_info['image'] : 'no_image.png');
			$image = $this->model_tool_image->resize($image_path, 260, 152);
			if (!$image) {
				$image = $this->model_tool_image->resize('no_image.png', 260, 152);
			}

			$license = isset($result['license']) ? (int)$result['license'] : (isset($extension_info['license']) ? (int)$extension_info['license'] : 1);
			$license_period = isset($result['license_period']) ? (int)$result['license_period'] : (isset($extension_info['license_period']) ? (int)$extension_info['license_period'] : 12);
			if ($license_period < 1) {
				$license_period = 12;
			}

			$purchase_date = !empty($result['order_date_added']) ? $result['order_date_added'] : $result['date_added'];
			$valid_timestamp = strtotime('+' . $license_period . ' months', strtotime($purchase_date));
			$date_modified = !empty($result['date_modified']) ? $result['date_modified'] : (!empty($extension_info['date_modified']) ? $extension_info['date_modified'] : $purchase_date);

			$order_id = isset($result['order_id']) ? (int)$result['order_id'] : 0;

			$data['downloads'][] = array(
				'order_id'      => $order_id,
				'extension_id'  => $result['extension_id'],
				'name'          => !empty($result['name']) ? $result['name'] : $result['extension'],
				'image'         => $image,
				'date_added'    => date('d M Y', strtotime($purchase_date)),
				'date_modified' => date('d M Y', strtotime($date_modified)),
				'license'       => $license,
				'valid'         => ($valid_timestamp >= time()),
				'date_valid'    => date('d M Y', $valid_timestamp),
				'href'          => $this->url->link('account/download/info', $token . '&order_id=' . $order_id . '&extension_id=' . $result['extension_id'], true),
				'extension'     => $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $download_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/download', $token . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/download_list', $data));
	}

	public function info() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/download', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/download');

		$order_id = isset($this->request->get['order_id']) ? (int)$this->request->get['order_id'] : 0;
		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;

		$this->load->model('account/order');
		$this->load->model('marketplace/extension');
		$this->load->model('cms/download');
		$this->load->model('tool/image');

		$order_info = array();
		if ($order_id) {
			$order_info = $this->model_account_order->getOrder($order_id);
			if ($order_info && !$extension_id) {
				$extension_id = (int)$order_info['extension_id'];
			}
		}

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		$has_purchased = false;
		if (isset($this->model_account_order->hasPurchasedExtension)) {
			$has_purchased = $this->model_account_order->hasPurchasedExtension($extension_id, $this->member->getId());
		} elseif (isset($this->model_account_order->hasPurchased)) {
			$has_purchased = $this->model_account_order->hasPurchased($this->member->getId(), $extension_id);
		}

		if (!$extension_info || (!$order_info && !$has_purchased && (int)$extension_info['member_id'] !== (int)$this->member->getId())) {
			$this->response->redirect($this->url->link('account/download', 'member_token=' . $this->session->data['member_token'], true));
			return;
		}

		$this->document->setTitle($extension_info['name']);

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['order_id'] = $order_id ? $order_id : $extension_id;
		$data['cancel'] = $this->url->link('account/download', $token, true);

		$image = $this->model_tool_image->resize($extension_info['image'], 260, 152);
		if (!$image) {
			$image = $this->model_tool_image->resize('no_image.png', 260, 152);
		}

		$data['image'] = $image;
		$data['name'] = $extension_info['name'];
		$data['date_added'] = date('d M Y', strtotime(!empty($order_info['date_added']) ? $order_info['date_added'] : $extension_info['date_added']));
		$data['extension'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true);

		$license_period = (int)$extension_info['license_period'] > 0 ? (int)$extension_info['license_period'] : 12;
		$purchase_date = !empty($order_info['date_added']) ? $order_info['date_added'] : $extension_info['date_added'];
		$valid_timestamp = strtotime('+' . $license_period . ' months', strtotime($purchase_date));

		$data['license'] = (int)$extension_info['license'];
		$data['valid'] = ($valid_timestamp >= time());
		$data['date_valid'] = date('d M Y', $valid_timestamp);

		$data['documentation'] = html_entity_decode($extension_info['documentation'], ENT_QUOTES, 'UTF-8');

		$oc_versions = array();
		foreach ($this->model_cms_download->getDownloads(array('start' => 0, 'limit' => 100)) as $dl) {
			$oc_versions[$dl['download_id']] = $dl['name'];
		}

		$data['downloads'] = array();

		$extension_downloads = $this->model_marketplace_extension->getExtensionDownloads($extension_id);

		foreach ($extension_downloads as $ext_dl) {
			$compat_names = array();
			$dl_ids = isset($ext_dl['download']) ? $ext_dl['download'] : (isset($ext_dl['download_id']) ? $ext_dl['download_id'] : array());
			if (is_array($dl_ids)) {
				foreach ($dl_ids as $did) {
					if (isset($oc_versions[$did])) {
						$compat_names[] = $oc_versions[$did];
					}
				}
			}

			$compatibility = !empty($ext_dl['compatibility']) ? $ext_dl['compatibility'] : implode(', ', $compat_names);

			$data['downloads'][] = array(
				'name'          => $ext_dl['name'],
				'compatibility' => $compatibility,
				'href'          => $this->url->link('account/download/download', $token . '&extension_download_id=' . $ext_dl['extension_download_id'] . '&order_id=' . $order_id, true)
			);
		}

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/download_info', $data));
	}

	public function download() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/download', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (isset($this->request->get['extension_download_id'])) {
			$extension_download_id = (int)$this->request->get['extension_download_id'];
		} else {
			$extension_download_id = 0;
		}

		$this->load->model('marketplace/extension');
		$this->load->model('account/order');

		$download_info = $this->model_marketplace_extension->getExtensionDownload($extension_download_id);

		if ($download_info) {
			$extension_info = $this->model_marketplace_extension->getExtension($download_info['extension_id']);

			$has_purchased = false;
			if (isset($this->model_account_order->hasPurchasedExtension)) {
				$has_purchased = $this->model_account_order->hasPurchasedExtension($download_info['extension_id'], $this->member->getId());
			} elseif (isset($this->model_account_order->hasPurchased)) {
				$has_purchased = $this->model_account_order->hasPurchased($this->member->getId(), $download_info['extension_id']);
			}

			if ($extension_info && ((int)$extension_info['license'] === 0 || (int)$extension_info['member_id'] === (int)$this->member->getId() || $has_purchased)) {
				$file = DIR_DOWNLOAD . $download_info['filename'];
				if (!is_file($file) && is_file(DIR_UPLOAD . $download_info['filename'])) {
					$file = DIR_UPLOAD . $download_info['filename'];
				}

				$mask = !empty($download_info['mask']) ? basename($download_info['mask']) : basename($download_info['filename']);

				require_once(DIR_SYSTEM . 'library/cloud_storage.php');
				$cloud_storage = new CloudStorage($this->registry);
				$cloud_storage->outputFile($file, $mask, 'download', $download_info['filename']);

				if (!headers_sent()) {
					if (is_file($file)) {
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
					} else {
						$this->load->language('account/download');

						$content = sprintf($this->language->get('text_package_content'), $download_info['name'], $mask);
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename="' . $mask . '"');
						header('Content-Length: ' . strlen($content));
						echo $content;
						exit();
					}
				}
			}
		}

		$this->response->redirect($this->url->link('account/download', 'member_token=' . $this->session->data['member_token'], true));
	}
}

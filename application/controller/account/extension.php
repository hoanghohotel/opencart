<?php
class ControllerAccountExtension extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/extension', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('Extensions');

		$this->load->model('marketplace/extension');

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['extensions'] = array();

		$filter_data = array(
			'filter_member_id' => $this->member->getId(),
			'ignore_status'    => true,
			'sort'             => 'date_added',
			'start'            => ($page - 1) * 10,
			'limit'            => 10
		);

		$extension_total = $this->model_marketplace_extension->getTotalExtensions($filter_data);

		$results = $this->model_marketplace_extension->getExtensions($filter_data);

		foreach ($results as $result) {
			$data['extensions'][] = array(
				'extension_id' => $result['extension_id'],
				'name'         => $result['name'],
				'publish'      => $result['publish'],
				'date_added'   => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'         => $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id']),
				'edit'         => $this->url->link('account/extension/edit', 'member_token=' . $this->session->data['member_token'] . '&extension_id=' . $result['extension_id'], true),
				'delete'       => $this->url->link('account/extension/delete', 'member_token=' . $this->session->data['member_token'] . '&extension_id=' . $result['extension_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $extension_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/extension', 'member_token=' . $this->session->data['member_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['add'] = $this->url->link('account/extension/add', 'member_token=' . $this->session->data['member_token'], true);
		$data['delete'] = $this->url->link('account/extension/delete', 'member_token=' . $this->session->data['member_token'], true);
		$data['cancel'] = $this->url->link('account/account', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/extension_list', $data));
	}

	public function add() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/extension', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('Add Extension');

		$this->load->model('marketplace/extension');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$post_data = $this->request->post;

			if (isset($post_data['extension_download']) && is_array($post_data['extension_download'])) {
				foreach ($post_data['extension_download'] as $k => $dl) {
					if (isset($dl['download']) && !isset($dl['download_id'])) {
						$post_data['extension_download'][$k]['download_id'] = $dl['download'];
					}
				}
			}

			$this->model_marketplace_extension->addExtension($post_data);

			$this->session->data['success'] = 'Success: You have added your extension!';

			$this->response->redirect($this->url->link('account/extension', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/extension', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('Edit Extension');

		$this->load->model('marketplace/extension');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$post_data = $this->request->post;

			if (isset($post_data['extension_download']) && is_array($post_data['extension_download'])) {
				foreach ($post_data['extension_download'] as $k => $dl) {
					if (isset($dl['download']) && !isset($dl['download_id'])) {
						$post_data['extension_download'][$k]['download_id'] = $dl['download'];
					}
				}
			}

			$this->model_marketplace_extension->editExtension($this->request->get['extension_id'], $post_data);

			$this->load->controller('mail/extension', array(
				'extension_id' => (int)$this->request->get['extension_id'],
				'comment'      => isset($post_data['comment']) ? $post_data['comment'] : ''
			));

			$this->session->data['success'] = 'Success: You have modified your extensions!';

			$this->response->redirect($this->url->link('account/extension', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/extension', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('marketplace/extension');

		if (isset($this->request->get['extension_id'])) {
			$extension_info = $this->model_marketplace_extension->getExtension($this->request->get['extension_id']);

			if ($extension_info && $extension_info['member_id'] == $this->member->getId()) {
				$this->model_marketplace_extension->deleteExtension($this->request->get['extension_id']);

				$this->session->data['success'] = 'Success: You have modified your extensions!';
			}
		}

		$this->response->redirect($this->url->link('account/extension', 'member_token=' . $this->session->data['member_token'], true));
	}

	protected function getForm() {
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = '';
		}

		if (isset($this->error['license_period'])) {
			$data['error_license_period'] = $this->error['license_period'];
		} else {
			$data['error_license_period'] = '';
		}

		if (isset($this->error['price'])) {
			$data['error_price'] = $this->error['price'];
		} else {
			$data['error_price'] = '';
		}

		if (isset($this->error['cloud'])) {
			$data['error_cloud'] = $this->error['cloud'];
		} else {
			$data['error_cloud'] = '';
		}

		if (isset($this->error['tag'])) {
			$data['error_tag'] = $this->error['tag'];
		} else {
			$data['error_tag'] = '';
		}

		if (isset($this->error['download'])) {
			$data['error_download'] = $this->error['download'];
		} else {
			$data['error_download'] = array();
		}

		if (isset($this->error['history'])) {
			$data['error_history'] = $this->error['history'];
		} else {
			$data['error_history'] = '';
		}

		if (!isset($this->request->get['extension_id'])) {
			$data['action'] = $this->url->link('account/extension/add', 'member_token=' . $this->session->data['member_token'], true);
		} else {
			$data['action'] = $this->url->link('account/extension/edit', 'member_token=' . $this->session->data['member_token'] . '&extension_id=' . $this->request->get['extension_id'], true);
		}

		$data['cancel'] = $this->url->link('account/extension', 'member_token=' . $this->session->data['member_token'], true);

		if (isset($this->request->get['extension_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$extension_info = $this->model_marketplace_extension->getExtension($this->request->get['extension_id']);

			if (!$extension_info || $extension_info['member_id'] != $this->member->getId()) {
				$this->response->redirect($this->url->link('account/extension', 'member_token=' . $this->session->data['member_token'], true));
			}
		} else {
			$extension_info = array();
		}

		$data['member_token'] = $this->session->data['member_token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($extension_info)) {
			$data['name'] = $extension_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (!empty($extension_info)) {
			$data['description'] = $extension_info['description'];
		} else {
			$data['description'] = '';
		}

		$data['categories'] = $this->model_marketplace_extension->getExtensionCategories();

		if (isset($this->request->post['extension_category_id'])) {
			$data['extension_category_id'] = $this->request->post['extension_category_id'];
		} elseif (!empty($extension_info)) {
			$data['extension_category_id'] = $extension_info['extension_category_id'];
		} else {
			$data['extension_category_id'] = '';
		}

		if (isset($this->request->post['license'])) {
			$data['license'] = $this->request->post['license'];
		} elseif (!empty($extension_info)) {
			$data['license'] = $extension_info['license'];
		} else {
			$data['license'] = 0;
		}

		if (isset($this->request->post['license_period'])) {
			$data['license_period'] = $this->request->post['license_period'];
		} elseif (!empty($extension_info)) {
			$data['license_period'] = $extension_info['license_period'];
		} else {
			$data['license_period'] = 12;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($extension_info)) {
			$data['price'] = $extension_info['price'];
		} else {
			$data['price'] = '0.00';
		}

		if (isset($this->request->post['cloud'])) {
			$data['cloud'] = $this->request->post['cloud'];
		} elseif (!empty($extension_info)) {
			$data['cloud'] = $extension_info['cloud'];
		} else {
			$data['cloud'] = 0;
		}

		if (isset($this->request->post['tag'])) {
			$data['tag'] = $this->request->post['tag'];
		} elseif (!empty($extension_info)) {
			$data['tag'] = $extension_info['tag'];
		} else {
			$data['tag'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($extension_info)) {
			$data['image'] = $extension_info['image'];
		} else {
			$data['image'] = '';
		}

		if (!empty($data['image']) && $this->model_tool_image->resize($data['image'], 260, 152)) {
			$data['image_thumb'] = $this->model_tool_image->resize($data['image'], 260, 152);
		} else {
			$data['image_thumb'] = $this->model_tool_image->resize('no_image.png', 260, 152);
		}

		if (isset($this->request->post['banner'])) {
			$data['banner'] = $this->request->post['banner'];
		} elseif (!empty($extension_info)) {
			$data['banner'] = $extension_info['banner'];
		} else {
			$data['banner'] = '';
		}

		if (!empty($data['banner']) && $this->model_tool_image->resize($data['banner'], 710, 380)) {
			$data['banner_thumb'] = $this->model_tool_image->resize($data['banner'], 710, 380);
		} else {
			$data['banner_thumb'] = $this->model_tool_image->resize('no_image.png', 710, 380);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['extension_image'])) {
			$extension_images = $this->request->post['extension_image'];
		} elseif (isset($this->request->get['extension_id'])) {
			$extension_images = $this->model_marketplace_extension->getExtensionImages($this->request->get['extension_id']);
		} else {
			$extension_images = array();
		}

		$data['extension_images'] = array();

		foreach ($extension_images as $extension_image) {
			if (!empty($extension_image['image']) && $this->model_tool_image->resize($extension_image['image'], 100, 100)) {
				$image = $extension_image['image'];
				$thumb = $extension_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['extension_images'][] = array(
				'image' => $image,
				'thumb' => $this->model_tool_image->resize($thumb, 100, 100)
			);
		}

		if (isset($this->request->post['documentation'])) {
			$data['documentation'] = $this->request->post['documentation'];
		} elseif (!empty($extension_info)) {
			$data['documentation'] = $extension_info['documentation'];
		} else {
			$data['documentation'] = '';
		}

		$this->load->model('cms/download');

		$data['downloads'] = $this->model_cms_download->getDownloads();

		if (isset($this->request->post['extension_download'])) {
			$extension_downloads = $this->request->post['extension_download'];
		} elseif (isset($this->request->get['extension_id'])) {
			$extension_downloads = $this->model_marketplace_extension->getExtensionDownloads($this->request->get['extension_id']);
		} else {
			$extension_downloads = array();
		}

		$data['extension_downloads'] = array();

		foreach ($extension_downloads as $extension_download) {
			$extension_download_id = isset($extension_download['extension_download_id']) ? $extension_download['extension_download_id'] : '';

			if (isset($extension_download['download'])) {
				$dl_ids = $extension_download['download'];
			} elseif (isset($extension_download['download_id'])) {
				$dl_ids = $extension_download['download_id'];
			} else {
				$dl_ids = array();
			}

			$data['extension_downloads'][] = array(
				'extension_download_id' => $extension_download_id,
				'name'                  => isset($extension_download['name']) ? $extension_download['name'] : '',
				'filename'              => isset($extension_download['filename']) ? $extension_download['filename'] : '',
				'mask'                  => isset($extension_download['mask']) ? $extension_download['mask'] : '',
				'cloud'                 => isset($extension_download['cloud']) ? $extension_download['cloud'] : 0,
				'approved'              => isset($extension_download['approved']) ? $extension_download['approved'] : '',
				'download'              => $dl_ids,
				'href'                  => $extension_download_id ? $this->url->link('marketplace/download/download', 'extension_download_id=' . $extension_download_id, true) : '#'
			);
		}

		if (isset($this->request->post['history'])) {
			$data['history'] = $this->request->post['history'];
		} elseif (!empty($extension_info)) {
			$data['history'] = $extension_info['history'];
		} else {
			$data['history'] = '';
		}

		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (!empty($extension_info)) {
			$data['publish'] = $extension_info['publish'];
		} else {
			$data['publish'] = '1';
		}

		if (isset($this->request->post['notify'])) {
			$data['notify'] = $this->request->post['notify'];
		} elseif (!empty($extension_info)) {
			$data['notify'] = $extension_info['notify'];
		} else {
			$data['notify'] = '1';
		}

		if (isset($this->request->post['alert'])) {
			$data['alert'] = $this->request->post['alert'];
		} elseif (!empty($extension_info)) {
			$data['alert'] = $extension_info['alert'];
		} else {
			$data['alert'] = '0';
		}

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/extension_form', $data));
	}

	protected function validateForm() {
		if (!isset($this->request->post['name']) || (utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 128)) {
			$this->error['name'] = 'Extension Name must be between 3 and 128 characters!';
		}

		if (!isset($this->request->post['description']) || (utf8_strlen(trim($this->request->post['description'])) < 10)) {
			$this->error['description'] = 'Description must be at least 10 characters!';
		}

		if (empty($this->request->post['extension_category_id'])) {
			$this->error['category'] = 'Please select a category!';
		}

		if (!empty($this->request->post['license'])) {
			if (!isset($this->request->post['price']) || (float)$this->request->post['price'] < 10) {
				$this->error['price'] = 'Price must be at least $10.00 for paid extensions!';
			}
		}

		if (isset($this->request->post['extension_download']) && is_array($this->request->post['extension_download'])) {
			foreach ($this->request->post['extension_download'] as $key => $value) {
				if (!isset($value['name']) || (utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 128)) {
					$this->error['download'][$key] = 'Download Name must be between 3 and 128 characters!';
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = 'Warning: Please check the form carefully for errors!';
		}

		return !$this->error;
	}

	public function upload() {
		$json = array();

		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$json['error'] = 'Warning: You do not have permission to upload files!';
		}

		if (!$json) {
			if (!empty($this->request->files['download']['name']) && is_file($this->request->files['download']['tmp_name'])) {
				$filename = basename(html_entity_decode($this->request->files['download']['name'], ENT_QUOTES, 'UTF-8'));

				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
					$json['error'] = 'Filename must be between 3 and 128 characters!';
				}

				$allowed = array('zip', 'rar', 'ocmod.zip');

				$ext = strtolower(substr(strrchr($filename, '.'), 1));

				if (!in_array($ext, array('zip', 'rar'))) {
					$json['error'] = 'Invalid file type! Only zip and rar files are allowed.';
				}

				if ($this->request->files['download']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'Upload error code: ' . $this->request->files['download']['error'];
				}
			} else {
				$json['error'] = 'File could not be uploaded!';
			}
		}

		if (!$json) {
			$file = $filename . '.' . token(32);

			require_once(DIR_SYSTEM . 'library/cloud_storage.php');
			$cloud_storage = new CloudStorage($this->registry);

			if (!$cloud_storage->storeUploadedFile($this->request->files['download']['tmp_name'], DIR_DOWNLOAD . $file, 'download', $file)) {
				$json['error'] = 'Cloud Storage Error: ' . $cloud_storage->getLastError();
			} else {
				$json['filename'] = $file;
				$json['mask'] = $filename;
				$json['storage_driver'] = $cloud_storage->getDriver();
				$json['success'] = 'Success: Your file has been uploaded!';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function comment() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/extension/comment', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('Extension Comments');

		if (isset($this->request->get['filter_extension'])) {
			$data['filter_extension'] = $this->request->get['filter_extension'];
		} else {
			$data['filter_extension'] = '';
		}

		if (isset($this->request->get['filter_member'])) {
			$data['filter_member'] = $this->request->get['filter_member'];
		} else {
			$data['filter_member'] = '';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$data['filter_date_added'] = $this->request->get['filter_date_added'];
			$data['filter_date_start'] = $this->request->get['filter_date_added'];
		} else {
			$data['filter_date_added'] = '';
			$data['filter_date_start'] = '';
		}

		$data['member_token'] = $this->session->data['member_token'];

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/extension_comment', $data));
	}

	public function getCommentList() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			return;
		}

		if (isset($this->request->get['filter_extension'])) {
			$filter_extension = $this->request->get['filter_extension'];
		} else {
			$filter_extension = '';
		}

		if (isset($this->request->get['filter_member'])) {
			$filter_member = $this->request->get['filter_member'];
		} else {
			$filter_member = '';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_extension'])) {
			$url .= '&filter_extension=' . urlencode(html_entity_decode($this->request->get['filter_extension'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . urlencode(html_entity_decode($this->request->get['filter_member'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		$where = " WHERE e.member_id = '" . (int)$this->member->getId() . "' AND ec.parent_id = '0'";

		if ($filter_extension) {
			$where .= " AND e.name LIKE '%" . $this->db->escape($filter_extension) . "%'";
		}

		if ($filter_member) {
			$where .= " AND m.username LIKE '%" . $this->db->escape($filter_member) . "%'";
		}

		if ($filter_date_added) {
			$where .= " AND DATE(ec.date_added) = DATE('" . $this->db->escape($filter_date_added) . "')";
		}

		$total_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "extension_comment` ec INNER JOIN `" . DB_PREFIX . "extension` e ON (ec.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id)" . $where);
		$comment_total = (int)$total_query->row['total'];

		$start = ($page - 1) * 10;
		if ($start < 0) {
			$start = 0;
		}

		$query = $this->db->query("SELECT ec.*, e.name AS extension, m.username AS member, (SELECT COUNT(*) FROM `" . DB_PREFIX . "extension_comment` ecr WHERE ecr.parent_id = ec.extension_comment_id) AS replied FROM `" . DB_PREFIX . "extension_comment` ec INNER JOIN `" . DB_PREFIX . "extension` e ON (ec.extension_id = e.extension_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (ec.member_id = m.member_id)" . $where . " ORDER BY ec.date_added DESC LIMIT " . (int)$start . ", 10");

		$data['comments'] = array();

		foreach ($query->rows as $result) {
			$data['comments'][] = array(
				'extension_comment_id' => $result['extension_comment_id'],
				'extension'            => $result['extension'],
				'view_extension'       => $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id']),
				'text'                 => $result['comment'],
				'member'               => $result['member'],
				'replied'              => (int)$result['replied'] > 0,
				'date_added'           => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'reply'                => $this->url->link('account/extension/replyComment', 'member_token=' . $this->session->data['member_token'] . '&extension_comment_id=' . $result['extension_comment_id'] . $url . '&page=' . $page, true),
				'delete'               => $this->url->link('account/extension/deleteComment', 'member_token=' . $this->session->data['member_token'] . '&extension_comment_id=' . $result['extension_comment_id'] . $url . '&page=' . $page, true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/extension/getCommentList', 'member_token=' . $this->session->data['member_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$this->response->setOutput($this->load->view('account/extension_comment_list', $data));
	}

	public function replyComment() {
		$json = array();

		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$json['error'] = 'Warning: You do not have permission to reply to comments!';
		}

		$this->load->model('marketplace/extension');

		if (isset($this->request->get['extension_comment_id'])) {
			$extension_comment_id = (int)$this->request->get['extension_comment_id'];
		} else {
			$extension_comment_id = 0;
		}

		$comment_info = $this->model_marketplace_extension->getComment($extension_comment_id);

		if (!$comment_info) {
			$json['error'] = 'Warning: Comment could not be found!';
		} else {
			$extension_info = $this->model_marketplace_extension->getExtension($comment_info['extension_id']);

			if (!$extension_info || $extension_info['member_id'] != $this->member->getId()) {
				$json['error'] = 'Warning: You do not have permission to reply to this comment!';
			}
		}

		$url = '';

		if (isset($this->request->get['filter_extension'])) {
			$url .= '&filter_extension=' . urlencode(html_entity_decode($this->request->get['filter_extension'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . urlencode(html_entity_decode($this->request->get['filter_member'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . (int)$this->request->get['page'];
		}

		if (!$json) {
			if ($this->request->server['REQUEST_METHOD'] == 'POST') {
				if (empty($this->request->post['comment']) || utf8_strlen(trim($this->request->post['comment'])) < 2) {
					$json['error'] = 'Please enter a reply!';
				} else {
					$this->model_marketplace_extension->addComment($comment_info['extension_id'], $extension_comment_id, $this->request->post['comment']);

					$json['success'] = 'Success: Your reply has been submitted!';
				}
			} else {
				$data['comment'] = array(
					'username' => $comment_info['username'],
					'comment'  => $comment_info['comment']
				);

				$data['reply'] = str_replace('&amp;', '&', $this->url->link('account/extension/replyComment', 'member_token=' . $this->session->data['member_token'] . '&extension_comment_id=' . $extension_comment_id . $url, true));
				$data['update_list'] = str_replace('&amp;', '&', $this->url->link('account/extension/getCommentList', 'member_token=' . $this->session->data['member_token'] . $url, true));

				$json['html'] = $this->load->view('account/extension_comment_form', $data);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function deleteComment() {
		$json = array();

		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$json['error'] = 'Warning: You do not have permission to delete comments!';
		}

		$this->load->model('marketplace/extension');

		if (isset($this->request->get['extension_comment_id'])) {
			$extension_comment_id = (int)$this->request->get['extension_comment_id'];
		} else {
			$extension_comment_id = 0;
		}

		$comment_info = $this->model_marketplace_extension->getComment($extension_comment_id);

		if (!$comment_info) {
			$json['error'] = 'Warning: Comment could not be found!';
		} else {
			$extension_info = $this->model_marketplace_extension->getExtension($comment_info['extension_id']);

			if (!$extension_info || $extension_info['member_id'] != $this->member->getId()) {
				$json['error'] = 'Warning: You do not have permission to delete this comment!';
			}
		}

		$url = '';

		if (isset($this->request->get['filter_extension'])) {
			$url .= '&filter_extension=' . urlencode(html_entity_decode($this->request->get['filter_extension'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . urlencode(html_entity_decode($this->request->get['filter_member'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . (int)$this->request->get['page'];
		}

		if (!$json) {
			$this->model_marketplace_extension->deleteComment($extension_comment_id);

			$json['success'] = 'Success: You have deleted the comment!';
			$json['url'] = str_replace('&amp;', '&', $this->url->link('account/extension/getCommentList', 'member_token=' . $this->session->data['member_token'] . $url, true));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

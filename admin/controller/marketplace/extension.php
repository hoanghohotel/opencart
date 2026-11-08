<?php
class ControllerMarketplaceExtension extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('marketplace/extension');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/extension');

		$this->getList();
	}

	public function add() {
		$this->load->language('marketplace/extension');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/extension');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_marketplace_extension->addExtension($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->getFilterUrl();

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('marketplace/extension');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/extension');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_marketplace_extension->editExtension($this->request->get['extension_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->getFilterUrl();

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('marketplace/extension');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/extension');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $extension_id) {
				$this->model_marketplace_extension->deleteExtension($extension_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->getFilterUrl();

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getFilterUrl() {
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_extension_category_id'])) {
			$url .= '&filter_extension_category_id=' . $this->request->get['filter_extension_category_id'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		return $url;
	}

	protected function getList() {
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : '';
		$filter_extension_category_id = isset($this->request->get['filter_extension_category_id']) ? $this->request->get['filter_extension_category_id'] : '';
		$filter_license = isset($this->request->get['filter_license']) ? $this->request->get['filter_license'] : '';
		$filter_status = isset($this->request->get['filter_status']) ? $this->request->get['filter_status'] : '';

		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'e.date_added';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'DESC';
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;

		$url = $this->getFilterUrl();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('marketplace/extension/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('marketplace/extension/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['extensions'] = array();

		$filter_data = array(
			'filter_name'                  => $filter_name,
			'filter_extension_category_id' => $filter_extension_category_id,
			'filter_license'               => $filter_license,
			'filter_status'                => $filter_status,
			'sort'                         => $sort,
			'order'                        => $order,
			'start'                        => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                        => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$extension_total = $this->model_marketplace_extension->getTotalExtensions($filter_data);

		$results = $this->model_marketplace_extension->getExtensions($filter_data);

		foreach ($results as $result) {
			$image = $this->model_tool_image->resize($result['image'], 40, 40);
			if (!$image) {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$data['extensions'][] = array(
				'extension_id' => $result['extension_id'],
				'image'        => $image,
				'name'         => $result['name'],
				'category'     => $result['category_name'],
				'member'       => $result['member_username'],
				'license'      => $result['license'] ? $this->language->get('text_commercial') : $this->language->get('text_free'),
				'price'        => $result['license'] ? $this->currency->format($result['price'], $this->config->get('config_currency')) : $this->language->get('text_free'),
				'stats'        => $result['license'] ? number_format((int)$result['sales']) . ' sales' : number_format((int)$result['downloaded']) . ' downloads',
				'recommended'  => $result['recommended'],
				'featured'     => $result['featured'],
				'status'       => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'         => $this->url->link('marketplace/extension/edit', 'user_token=' . $this->session->data['user_token'] . '&extension_id=' . $result['extension_id'] . $url, true)
			);
		}

		$this->load->model('marketplace/category');
		$data['categories'] = $this->model_marketplace_category->getCategories();

		$data['user_token'] = $this->session->data['user_token'];

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_extension_category_id'])) {
			$url .= '&filter_extension_category_id=' . $this->request->get['filter_extension_category_id'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&sort=e.name' . $url, true);
		$data['sort_category'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&sort=category_name' . $url, true);
		$data['sort_price'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&sort=e.price' . $url, true);
		$data['sort_status'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&sort=e.status' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_extension_category_id'])) {
			$url .= '&filter_extension_category_id=' . $this->request->get['filter_extension_category_id'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $extension_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($extension_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($extension_total - $this->config->get('config_limit_admin'))) ? $extension_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $extension_total, ceil($extension_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_extension_category_id'] = $filter_extension_category_id;
		$data['filter_license'] = $filter_license;
		$data['filter_status'] = $filter_status;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketplace/extension_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['extension_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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

		$url = $this->getFilterUrl();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['extension_id'])) {
			$data['action'] = $this->url->link('marketplace/extension/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('marketplace/extension/edit', 'user_token=' . $this->session->data['user_token'] . '&extension_id=' . $this->request->get['extension_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['extension_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$extension_info = $this->model_marketplace_extension->getExtension($this->request->get['extension_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$fields = array(
			'name'                  => '',
			'member_id'             => 1,
			'extension_category_id' => 5,
			'description'           => '',
			'documentation'         => '',
			'history'               => '',
			'license'               => 0,
			'license_period'        => 12,
			'price'                 => '0.00',
			'image'                 => '',
			'banner'                => '',
			'tag'                   => '',
			'cloud'                 => '1',
			'recommended'           => 0,
			'featured'              => 0,
			'publish'               => 1,
			'reviews_enabled'       => 1,
			'comments_enabled'      => 1,
			'status'                => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($extension_info)) {
				$data[$field] = $extension_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$this->load->model('marketplace/category');
		$data['categories'] = $this->model_marketplace_category->getCategories();

		$members_query = $this->db->query("SELECT member_id, username, firstname, lastname, company FROM `" . DB_PREFIX . "member` ORDER BY username ASC");
		$data['members'] = $members_query->rows;

		$releases_query = $this->db->query("SELECT download_id, name FROM `" . DB_PREFIX . "download` ORDER BY download_id DESC");
		$data['releases'] = $releases_query->rows;

		$this->load->model('tool/image');

		$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		if (!$data['thumb']) {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['banner_thumb'] = $this->model_tool_image->resize($data['banner'], 100, 100);
		if (!$data['banner_thumb']) {
			$data['banner_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Additional Images
		if (isset($this->request->post['extension_image'])) {
			$extension_images = $this->request->post['extension_image'];
		} elseif (isset($this->request->get['extension_id'])) {
			$extension_images = $this->model_marketplace_extension->getExtensionImages($this->request->get['extension_id']);
		} else {
			$extension_images = array();
		}

		$data['extension_images'] = array();

		foreach ($extension_images as $extension_image) {
			$thumb = $this->model_tool_image->resize($extension_image['image'], 100, 100);
			if (!$thumb) {
				$thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
			}

			$data['extension_images'][] = array(
				'image'      => $extension_image['image'],
				'thumb'      => $thumb,
				'sort_order' => $extension_image['sort_order']
			);
		}

		// Downloads
		if (isset($this->request->post['extension_download'])) {
			$data['extension_downloads'] = $this->request->post['extension_download'];
		} elseif (isset($this->request->get['extension_id'])) {
			$data['extension_downloads'] = $this->model_marketplace_extension->getExtensionDownloads($this->request->get['extension_id']);
		} else {
			$data['extension_downloads'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketplace/extension_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'marketplace/extension')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['description'])) {
			$this->error['description'] = $this->language->get('error_description');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'marketplace/extension')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

<?php
class ControllerCmsShowcase extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('cms/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/showcase');

		$this->getList();
	}

	public function add() {
		$this->load->language('cms/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/showcase');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_showcase->addShowcase($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('cms/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/showcase');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_showcase->editShowcase($this->request->get['showcase_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('cms/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/showcase');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $showcase_id) {
				$this->model_cms_showcase->deleteShowcase($showcase_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getList();
	}

	protected function getList() {
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('cms/showcase/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('cms/showcase/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['showcases'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$showcase_total = $this->model_cms_showcase->getTotalShowcases();

		$results = $this->model_cms_showcase->getShowcases($filter_data);

		foreach ($results as $result) {
			$image = $this->model_tool_image->resize($result['image'], 50, 50);
			if (!$image) {
				$image = $this->model_tool_image->resize('no_image.png', 50, 50);
			}

			$data['showcases'][] = array(
				'showcase_id' => $result['showcase_id'],
				'image'       => $image,
				'name'        => $result['name'],
				'category'    => $result['category_name'],
				'link'        => $result['link'],
				'date_launch' => $result['date_launch'],
				'status'      => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'        => $this->url->link('cms/showcase/edit', 'user_token=' . $this->session->data['user_token'] . '&showcase_id=' . $result['showcase_id'], true)
			);
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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$pagination = new Pagination();
		$pagination->total = $showcase_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($showcase_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($showcase_total - $this->config->get('config_limit_admin'))) ? $showcase_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $showcase_total, ceil($showcase_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/showcase_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['showcase_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['showcase_id'])) {
			$data['action'] = $this->url->link('cms/showcase/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('cms/showcase/edit', 'user_token=' . $this->session->data['user_token'] . '&showcase_id=' . $this->request->get['showcase_id'], true);
		}

		$data['cancel'] = $this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['showcase_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$showcase_info = $this->model_cms_showcase->getShowcase($this->request->get['showcase_id']);
		}

		$fields = array(
			'member_id'            => 1,
			'showcase_category_id' => 1,
			'name'                 => '',
			'link'                 => '',
			'image'                => '',
			'date_launch'          => date('Y-m-d'),
			'status'               => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($showcase_info)) {
				$data[$field] = $showcase_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$data['categories'] = $this->model_cms_showcase->getShowcaseCategories();

		$member_query = $this->db->query("SELECT member_id, username, firstname, lastname FROM `" . DB_PREFIX . "member` ORDER BY username ASC");
		$data['members'] = $member_query->rows;

		$this->load->model('tool/image');

		$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		if (!$data['thumb']) {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/showcase_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/showcase')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cms/showcase')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

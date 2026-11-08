<?php
class ControllerCmsBlogCategory extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('cms/blog_category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog_category');

		$this->getList();
	}

	public function add() {
		$this->load->language('cms/blog_category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog_category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_blog_category->addBlogCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('cms/blog_category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog_category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_blog_category->editBlogCategory($this->request->get['blog_category_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('cms/blog_category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog_category');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_category_id) {
				$this->model_cms_blog_category->deleteBlogCategory($blog_category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('cms/blog_category/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('cms/blog_category/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['blog_categories'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$category_total = $this->model_cms_blog_category->getTotalBlogCategories();

		$results = $this->model_cms_blog_category->getBlogCategories($filter_data);

		foreach ($results as $result) {
			$data['blog_categories'][] = array(
				'blog_category_id' => $result['blog_category_id'],
				'name'             => $result['name'],
				'total_posts'      => $result['total_posts'],
				'sort_order'       => $result['sort_order'],
				'status'           => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'             => $this->url->link('cms/blog_category/edit', 'user_token=' . $this->session->data['user_token'] . '&blog_category_id=' . $result['blog_category_id'], true)
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
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($category_total - $this->config->get('config_limit_admin'))) ? $category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $category_total, ceil($category_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/blog_category_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['blog_category_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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
			'href' => $this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['blog_category_id'])) {
			$data['action'] = $this->url->link('cms/blog_category/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('cms/blog_category/edit', 'user_token=' . $this->session->data['user_token'] . '&blog_category_id=' . $this->request->get['blog_category_id'], true);
		}

		$data['cancel'] = $this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['blog_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->model_cms_blog_category->getBlogCategory($this->request->get['blog_category_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($category_info)) {
			$data['name'] = $category_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = 1;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/blog_category_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/blog_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cms/blog_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

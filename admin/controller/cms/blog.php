<?php
class ControllerCmsBlog extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('cms/blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog');

		$this->getList();
	}

	public function add() {
		$this->load->language('cms/blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_blog->addBlog($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('cms/blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_blog->editBlog($this->request->get['blog_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('cms/blog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_id) {
				$this->model_cms_blog->deleteBlog($blog_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('cms/blog/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('cms/blog/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['blogs'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$blog_total = $this->model_cms_blog->getTotalBlogs();

		$results = $this->model_cms_blog->getBlogs($filter_data);

		foreach ($results as $result) {
			$data['blogs'][] = array(
				'blog_id'    => $result['blog_id'],
				'title'      => $result['title'],
				'category'   => $result['category_name'],
				'author'     => $result['author'],
				'trending'   => $result['trending'],
				'viewed'     => $result['viewed'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'       => $this->url->link('cms/blog/edit', 'user_token=' . $this->session->data['user_token'] . '&blog_id=' . $result['blog_id'], true)
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
		$pagination->total = $blog_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($blog_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($blog_total - $this->config->get('config_limit_admin'))) ? $blog_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $blog_total, ceil($blog_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/blog_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['blog_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['blog_id'])) {
			$data['action'] = $this->url->link('cms/blog/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('cms/blog/edit', 'user_token=' . $this->session->data['user_token'] . '&blog_id=' . $this->request->get['blog_id'], true);
		}

		$data['cancel'] = $this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['blog_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$blog_info = $this->model_cms_blog->getBlog($this->request->get['blog_id']);
		}

		$fields = array(
			'blog_category_id' => 1,
			'title'            => '',
			'description'      => '',
			'author'           => 'OpenCart Team',
			'image'            => '',
			'image_status'     => 1,
			'trending'         => 0,
			'status'           => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($blog_info)) {
				$data[$field] = $blog_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$this->load->model('cms/blog_category');
		$data['blog_categories'] = $this->model_cms_blog_category->getBlogCategories();

		$this->load->model('tool/image');

		$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		if (!$data['thumb']) {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/blog_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['title']) < 3) || (utf8_strlen($this->request->post['title']) > 255)) {
			$this->error['title'] = $this->language->get('error_title');
		}

		if (empty($this->request->post['description'])) {
			$this->error['description'] = $this->language->get('error_description');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cms/blog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

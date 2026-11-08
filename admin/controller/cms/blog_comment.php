<?php
class ControllerCmsBlogComment extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('cms/blog_comment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog_comment');

		$this->getList();
	}

	public function edit() {
		$this->load->language('cms/blog_comment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog_comment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_blog_comment->editBlogComment($this->request->get['blog_comment_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function approve() {
		$this->load->language('cms/blog_comment');

		$this->load->model('cms/blog_comment');

		if (isset($this->request->get['blog_comment_id']) && $this->user->hasPermission('modify', 'cms/blog_comment')) {
			$this->model_cms_blog_comment->approveBlogComment($this->request->get['blog_comment_id']);
			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'], true));
	}

	public function delete() {
		$this->load->language('cms/blog_comment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/blog_comment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_comment_id) {
				$this->model_cms_blog_comment->deleteBlogComment($blog_comment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['delete'] = $this->url->link('cms/blog_comment/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['comments'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$comment_total = $this->model_cms_blog_comment->getTotalBlogComments();

		$results = $this->model_cms_blog_comment->getBlogComments($filter_data);

		foreach ($results as $result) {
			$data['comments'][] = array(
				'blog_comment_id' => $result['blog_comment_id'],
				'blog'            => $result['blog_title'],
				'member'          => $result['member_username'],
				'comment'         => utf8_substr(strip_tags($result['comment']), 0, 120),
				'status_raw'      => $result['status'],
				'status'          => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'approve'         => $this->url->link('cms/blog_comment/approve', 'user_token=' . $this->session->data['user_token'] . '&blog_comment_id=' . $result['blog_comment_id'], true),
				'edit'            => $this->url->link('cms/blog_comment/edit', 'user_token=' . $this->session->data['user_token'] . '&blog_comment_id=' . $result['blog_comment_id'], true)
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
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($comment_total - $this->config->get('config_limit_admin'))) ? $comment_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $comment_total, ceil($comment_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/blog_comment_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['comment'])) {
			$data['error_comment'] = $this->error['comment'];
		} else {
			$data['error_comment'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('cms/blog_comment/edit', 'user_token=' . $this->session->data['user_token'] . '&blog_comment_id=' . $this->request->get['blog_comment_id'], true);
		$data['cancel'] = $this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'], true);

		$comment_info = $this->model_cms_blog_comment->getBlogComment($this->request->get['blog_comment_id']);

		$data['blog_title'] = !empty($comment_info['blog_title']) ? $comment_info['blog_title'] : '';
		$data['member_username'] = !empty($comment_info['member_username']) ? $comment_info['member_username'] : '';

		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} elseif (!empty($comment_info)) {
			$data['comment'] = $comment_info['comment'];
		} else {
			$data['comment'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($comment_info)) {
			$data['status'] = $comment_info['status'];
		} else {
			$data['status'] = 1;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/blog_comment_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/blog_comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['comment']) < 3) {
			$this->error['comment'] = $this->language->get('error_comment');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cms/blog_comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

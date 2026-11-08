<?php
class ControllerCmsDownload extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('cms/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/download');

		$this->getList();
	}

	public function add() {
		$this->load->language('cms/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/download');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_download->addDownload($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('cms/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/download');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cms_download->editDownload($this->request->get['download_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('cms/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/download');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $download_id) {
				$this->model_cms_download->deleteDownload($download_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('cms/download/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('cms/download/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['downloads'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$download_total = $this->model_cms_download->getTotalDownloads();

		$results = $this->model_cms_download->getDownloads($filter_data);

		foreach ($results as $result) {
			$data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'filename'    => $result['filename'],
				'href'        => $result['href'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'        => $this->url->link('cms/download/edit', 'user_token=' . $this->session->data['user_token'] . '&download_id=' . $result['download_id'], true)
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
		$pagination->total = $download_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($download_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($download_total - $this->config->get('config_limit_admin'))) ? $download_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $download_total, ceil($download_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/download_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['download_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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
			'href' => $this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['download_id'])) {
			$data['action'] = $this->url->link('cms/download/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('cms/download/edit', 'user_token=' . $this->session->data['user_token'] . '&download_id=' . $this->request->get['download_id'], true);
		}

		$data['cancel'] = $this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['download_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$download_info = $this->model_cms_download->getDownload($this->request->get['download_id']);
		}

		$fields = array('name', 'description', 'filename', 'mask', 'href');

		foreach ($fields as $field) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($download_info)) {
				$data[$field] = $download_info[$field];
			} else {
				$data[$field] = '';
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('cms/download_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'cms/download')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'cms/download')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

<?php
class ControllerSupportEnquiry extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('support/enquiry');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('support/enquiry');

		$this->getList();
	}

	public function info() {
		$this->load->language('support/enquiry');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('support/enquiry');

		$enquiry_id = isset($this->request->get['enquiry_id']) ? (int)$this->request->get['enquiry_id'] : 0;

		$enquiry_info = $this->model_support_enquiry->getEnquiry($enquiry_id);

		if ($enquiry_info) {
			$url = $this->getFilterUrl();

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . $url, true)
			);

			$data['cancel'] = $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . $url, true);

			$data['enquiry'] = $enquiry_info;

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('support/enquiry_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function delete() {
		$this->load->language('support/enquiry');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('support/enquiry');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $enquiry_id) {
				$this->model_support_enquiry->deleteEnquiry($enquiry_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = $this->getFilterUrl();

			$this->response->redirect($this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getFilterUrl() {
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . urlencode(html_entity_decode($this->request->get['filter_type'], ENT_QUOTES, 'UTF-8'));
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
		$filter_type = isset($this->request->get['filter_type']) ? $this->request->get['filter_type'] : '';

		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'se.date_added';
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
			'href' => $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['delete'] = $this->url->link('support/enquiry/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['enquiries'] = array();

		$filter_data = array(
			'filter_name' => $filter_name,
			'filter_type' => $filter_type,
			'sort'        => $sort,
			'order'       => $order,
			'start'       => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'       => $this->config->get('config_limit_admin')
		);

		$enquiry_total = $this->model_support_enquiry->getTotalEnquiries($filter_data);

		$results = $this->model_support_enquiry->getEnquiries($filter_data);

		foreach ($results as $result) {
			$data['enquiries'][] = array(
				'enquiry_id' => $result['enquiry_id'],
				'name'       => $result['name'],
				'email'      => $result['email'],
				'type'       => $result['type'] . ($result['reason'] ? ' - ' . $result['reason'] : ''),
				'subject'    => $result['subject'] ? $result['subject'] : utf8_substr(strip_tags($result['enquiry']), 0, 60) . '...',
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'       => $this->url->link('support/enquiry/info', 'user_token=' . $this->session->data['user_token'] . '&enquiry_id=' . $result['enquiry_id'] . $url, true)
			);
		}

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

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . urlencode(html_entity_decode($this->request->get['filter_type'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . '&sort=se.name' . $url, true);
		$data['sort_email'] = $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . '&sort=se.email' . $url, true);
		$data['sort_type'] = $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . '&sort=se.type' . $url, true);
		$data['sort_date_added'] = $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . '&sort=se.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . urlencode(html_entity_decode($this->request->get['filter_type'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $enquiry_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($enquiry_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($enquiry_total - $this->config->get('config_limit_admin'))) ? $enquiry_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $enquiry_total, ceil($enquiry_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_type'] = $filter_type;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('support/enquiry_list', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'support/enquiry')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

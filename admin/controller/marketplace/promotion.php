<?php
class ControllerMarketplacePromotion extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('marketplace/promotion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/promotion');

		$this->getList();
	}

	public function add() {
		$this->load->language('marketplace/promotion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/promotion');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_marketplace_promotion->addPromotion($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('marketplace/promotion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/promotion');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_marketplace_promotion->editPromotion($this->request->get['promotion_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('marketplace/promotion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/promotion');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $promotion_id) {
				$this->model_marketplace_promotion->deletePromotion($promotion_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('marketplace/promotion/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('marketplace/promotion/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['promotions'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$promotion_total = $this->model_marketplace_promotion->getTotalPromotions();

		$results = $this->model_marketplace_promotion->getPromotions($filter_data);

		foreach ($results as $result) {
			$data['promotions'][] = array(
				'promotion_id' => $result['promotion_id'],
				'extension'    => $result['extension_name'],
				'member'       => $result['member_username'],
				'days'         => $result['days'],
				'total'        => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'date_start'   => $result['date_start'],
				'date_end'     => $result['date_end'],
				'status'       => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'         => $this->url->link('marketplace/promotion/edit', 'user_token=' . $this->session->data['user_token'] . '&promotion_id=' . $result['promotion_id'], true)
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
		$pagination->total = $promotion_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($promotion_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($promotion_total - $this->config->get('config_limit_admin'))) ? $promotion_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $promotion_total, ceil($promotion_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketplace/promotion_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['promotion_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['promotion_id'])) {
			$data['action'] = $this->url->link('marketplace/promotion/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('marketplace/promotion/edit', 'user_token=' . $this->session->data['user_token'] . '&promotion_id=' . $this->request->get['promotion_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['promotion_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$promotion_info = $this->model_marketplace_promotion->getPromotion($this->request->get['promotion_id']);
		}

		$fields = array(
			'extension_id'    => 0,
			'member_id'       => 1,
			'days'            => 30,
			'total'           => '299.00',
			'payment_method'  => 'PayPal',
			'transaction_id'  => '',
			'order_status_id' => 5,
			'date_start'      => date('Y-m-d'),
			'date_end'        => date('Y-m-d', strtotime('+30 days')),
			'status'          => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($promotion_info)) {
				$data[$field] = $promotion_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$ext_query = $this->db->query("SELECT extension_id, name FROM `" . DB_PREFIX . "extension` ORDER BY name ASC");
		$data['extensions'] = $ext_query->rows;

		$member_query = $this->db->query("SELECT member_id, username, firstname, lastname FROM `" . DB_PREFIX . "member` ORDER BY username ASC");
		$data['members'] = $member_query->rows;

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketplace/promotion_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'marketplace/promotion')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'marketplace/promotion')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

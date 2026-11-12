<?php
class ControllerMemberSeller extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('member/seller');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/seller');

		$this->getList();
	}

	public function add() {
		$this->load->language('member/seller');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/seller');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_member_seller->addSeller($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('member/seller');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/seller');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_member_seller->editSeller($this->request->get['member_seller_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('member/seller');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/seller');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $member_seller_id) {
				$this->model_member_seller->deleteSeller($member_seller_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getList();
	}

	public function approve() {
		$this->load->language('member/seller');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/seller');

		if (isset($this->request->get['member_seller_id']) && $this->validateForm()) {
			$this->model_member_seller->approveSeller((int)$this->request->get['member_seller_id']);

			$this->session->data['success'] = $this->language->get('text_success_approve');

			$this->response->redirect($this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('member/seller/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('member/seller/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['sellers'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$seller_total = $this->model_member_seller->getTotalSellers();

		$results = $this->model_member_seller->getSellers($filter_data);

		foreach ($results as $result) {
			$data['sellers'][] = array(
				'member_seller_id' => $result['member_seller_id'],
				'username'         => $result['member_username'],
				'company'          => $result['company'] ? $result['company'] : ($result['firstname'] . ' ' . $result['lastname']),
				'email'            => $result['support_email'] ? $result['support_email'] : $result['email'],
				'seller_group'     => $result['seller_group'],
				'commission'       => $result['commission'] . '%',
				'status_id'        => (int)$result['status'],
				'status'           => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_pending'),
				'approve'          => !$result['status'] ? $this->url->link('member/seller/approve', 'user_token=' . $this->session->data['user_token'] . '&member_seller_id=' . $result['member_seller_id'], true) : '',
				'edit'             => $this->url->link('member/seller/edit', 'user_token=' . $this->session->data['user_token'] . '&member_seller_id=' . $result['member_seller_id'], true)
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
		$pagination->total = $seller_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($seller_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($seller_total - $this->config->get('config_limit_admin'))) ? $seller_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $seller_total, ceil($seller_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('member/seller_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['member_seller_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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
			'href' => $this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['member_seller_id'])) {
			$data['action'] = $this->url->link('member/seller/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('member/seller/edit', 'user_token=' . $this->session->data['user_token'] . '&member_seller_id=' . $this->request->get['member_seller_id'], true);
		}

		$data['cancel'] = $this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['member_seller_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$seller_info = $this->model_member_seller->getSeller($this->request->get['member_seller_id']);
		}

		$fields = array(
			'member_id'      => 1,
			'firstname'      => '',
			'lastname'       => '',
			'email'          => '',
			'support_email'  => '',
			'telephone'      => '',
			'website'        => '',
			'payment_method' => 'paypal',
			'payment_email'  => '',
			'company'        => '',
			'address_1'      => '',
			'city'           => '',
			'postcode'       => '',
			'country_id'     => 222,
			'zone_id'        => 0,
			'commission'     => 20,
			'seller_group'   => 'Standard Seller (80%)',
			'status'         => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($seller_info)) {
				$data[$field] = $seller_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$member_query = $this->db->query("SELECT member_id, username, firstname, lastname FROM `" . DB_PREFIX . "member` ORDER BY username ASC");
		$data['members'] = $member_query->rows;

		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('member/seller_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'member/seller')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'member/seller')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

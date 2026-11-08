<?php
class ControllerMemberMember extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('member/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/member');

		$this->getList();
	}

	public function add() {
		$this->load->language('member/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/member');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_member_member->addMember($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('member/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/member');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_member_member->editMember($this->request->get['member_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('member/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/member');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $member_id) {
				$this->model_member_member->deleteMember($member_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('member/member/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('member/member/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['members'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$member_total = $this->model_member_member->getTotalMembers();

		$results = $this->model_member_member->getMembers($filter_data);

		foreach ($results as $result) {
			$data['members'][] = array(
				'member_id'      => $result['member_id'],
				'username'       => $result['username'],
				'name'           => $result['firstname'] . ' ' . $result['lastname'],
				'company'        => $result['company'],
				'email'          => $result['email'],
				'seller_status'  => $result['seller_status'],
				'partner_status' => $result['partner_status'],
				'moderator'      => $result['moderator'],
				'balance'        => $this->currency->format($result['balance'], $this->config->get('config_currency')),
				'status'         => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'           => $this->url->link('member/member/edit', 'user_token=' . $this->session->data['user_token'] . '&member_id=' . $result['member_id'], true)
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
		$pagination->total = $member_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('member/member', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($member_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($member_total - $this->config->get('config_limit_admin'))) ? $member_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $member_total, ceil($member_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('member/member_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['member_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['member_id'])) {
			$data['action'] = $this->url->link('member/member/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('member/member/edit', 'user_token=' . $this->session->data['user_token'] . '&member_id=' . $this->request->get['member_id'], true);
		}

		$data['cancel'] = $this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['member_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$member_info = $this->model_member_member->getMember($this->request->get['member_id']);
		}

		$fields = array(
			'username'       => '',
			'firstname'      => '',
			'lastname'       => '',
			'company'        => '',
			'tax_id'         => '',
			'email'          => '',
			'telephone'      => '',
			'image'          => 'profile.png',
			'country_id'     => 222,
			'notify'         => 1,
			'seller_status'  => 0,
			'partner_status' => 0,
			'moderator'      => 0,
			'cloud'          => 1,
			'status'         => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($member_info)) {
				$data[$field] = $member_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('tool/image');

		$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		if (!$data['thumb']) {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['transactions'] = array();
		$data['balance'] = $this->currency->format(0, $this->config->get('config_currency'));

		if (isset($this->request->get['member_id'])) {
			$tx_rows = $this->model_member_member->getTransactions($this->request->get['member_id']);
			foreach ($tx_rows as $tx) {
				$data['transactions'][] = array(
					'description' => $tx['description'],
					'amount'      => $this->currency->format($tx['amount'], $this->config->get('config_currency')),
					'date_added'  => date($this->language->get('date_format_short'), strtotime($tx['date_added']))
				);
			}
			$data['balance'] = $this->currency->format($this->model_member_member->getTransactionTotal($this->request->get['member_id']), $this->config->get('config_currency'));
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('member/member_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'member/member')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 64)) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'member/member')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

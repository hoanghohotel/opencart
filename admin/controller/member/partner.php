<?php
class ControllerMemberPartner extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('member/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/partner');

		$this->getList();
	}

	public function add() {
		$this->load->language('member/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/partner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_member_partner->addPartner($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('member/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/partner');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_member_partner->editPartner($this->request->get['member_partner_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('member/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/partner');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $member_partner_id) {
				$this->model_member_partner->deletePartner($member_partner_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true));
		}

		$this->getList();
	}

	public function approve() {
		$this->load->language('member/partner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('member/partner');

		if (isset($this->request->get['member_partner_id']) && $this->validateDelete()) {
			$this->model_member_partner->approvePartner((int)$this->request->get['member_partner_id']);

			$this->session->data['success'] = $this->language->get('text_success_approve');

			$this->response->redirect($this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['add'] = $this->url->link('member/partner/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('member/partner/delete', 'user_token=' . $this->session->data['user_token'], true);

		$data['partners'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$partner_total = $this->model_member_partner->getTotalPartners();

		$results = $this->model_member_partner->getPartners($filter_data);

		foreach ($results as $result) {
			$image = $this->model_tool_image->resize($result['image'], 45, 45);
			if (!$image) {
				$image = $this->model_tool_image->resize('no_image.png', 45, 45);
			}

			$data['partners'][] = array(
				'member_partner_id' => $result['member_partner_id'],
				'image'             => $image,
				'company'           => $result['company'],
				'website'           => $result['website'],
				'partner_type'      => $result['partner_type'],
				'partner_tier'      => $result['partner_tier'],
				'country'           => $result['country_name'],
				'status_id'         => (int)$result['status'],
				'status'            => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_pending'),
				'approve'           => !$result['status'] ? $this->url->link('member/partner/approve', 'user_token=' . $this->session->data['user_token'] . '&member_partner_id=' . $result['member_partner_id'], true) : '',
				'edit'              => $this->url->link('member/partner/edit', 'user_token=' . $this->session->data['user_token'] . '&member_partner_id=' . $result['member_partner_id'], true)
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
		$pagination->total = $partner_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($partner_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($partner_total - $this->config->get('config_limit_admin'))) ? $partner_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $partner_total, ceil($partner_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('member/partner_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['member_partner_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['company'])) {
			$data['error_company'] = $this->error['company'];
		} else {
			$data['error_company'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['member_partner_id'])) {
			$data['action'] = $this->url->link('member/partner/add', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('member/partner/edit', 'user_token=' . $this->session->data['user_token'] . '&member_partner_id=' . $this->request->get['member_partner_id'], true);
		}

		$data['cancel'] = $this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->get['member_partner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$partner_info = $this->model_member_partner->getPartner($this->request->get['member_partner_id']);
		}

		$fields = array(
			'member_id'                => 1,
			'member_partner_type_id'   => 1,
			'member_partner_status_id' => 1,
			'firstname'                => '',
			'lastname'                 => '',
			'company'                  => '',
			'website'                  => '',
			'email'                    => '',
			'telephone'                => '',
			'description_short'        => '',
			'description_long'         => '',
			'address_1'                => '',
			'city'                     => '',
			'postcode'                 => '',
			'country_id'               => 222,
			'zone_id'                  => 0,
			'image'                    => '',
			'facebook'                 => '',
			'twitter'                  => '',
			'linkedin'                 => '',
			'status'                   => 1
		);

		foreach ($fields as $field => $default) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($partner_info)) {
				$data[$field] = $partner_info[$field];
			} else {
				$data[$field] = $default;
			}
		}

		$member_query = $this->db->query("SELECT member_id, username, firstname, lastname FROM `" . DB_PREFIX . "member` ORDER BY username ASC");
		$data['members'] = $member_query->rows;

		$data['partner_types'] = $this->model_member_partner->getPartnerTypes();
		$data['partner_statuses'] = $this->model_member_partner->getPartnerStatuses();

		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('tool/image');

		$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		if (!$data['thumb']) {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('member/partner_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'member/partner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['company']) < 2) || (utf8_strlen($this->request->post['company']) > 128)) {
			$this->error['company'] = $this->language->get('error_company');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'member/partner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

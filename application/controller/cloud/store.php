<?php
class ControllerCloudStore extends Controller {
	public function index() {
		if (!$this->member->isLogged() || !isset($this->session->data['member_token'])) {
			$this->session->data['redirect'] = $this->url->link('cloud/store', '', true);
			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('OpenCart Cloud - Cloud Stores');

		$this->load->model('account/subscription');

		$member_token = $this->session->data['member_token'];

		$data['stores'] = array();

		$results = $this->model_account_subscription->getSubscriptions();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id'   => $result['subscription_id'],
				'store_name' => $result['name'],
				'plan_name'  => $result['plan_name'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'status_id'  => $result['subscription_status_id'] == 1 ? 5 : $result['subscription_status_id'],
				'status'     => $result['status_name'] ? $result['status_name'] : $result['store_status'],
				'view'       => $this->url->link('account/subscription/info', 'member_token=' . $member_token . '&subscription_id=' . $result['subscription_id'], true),
				'delete'     => $this->url->link('account/subscription/cancel', 'member_token=' . $member_token . '&subscription_id=' . $result['subscription_id'], true)
			);
		}

		$data['cancel'] = $this->url->link('account/account', 'member_token=' . $member_token, true);
		$data['add'] = $this->url->link('account/subscription', 'member_token=' . $member_token, true);
		$data['error_warning'] = '';
		$data['success'] = '';

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cloud/store_list', $data));
	}
}

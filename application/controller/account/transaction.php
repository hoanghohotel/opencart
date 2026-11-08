<?php
class ControllerAccountTransaction extends Controller {
	public function index() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/transaction', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/transaction');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/transaction');
		$this->load->model('account/seller');

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$seller_info = $this->model_account_seller->getSeller($this->member->getId());

		if ($seller_info && !empty($seller_info['seller_group'])) {
			$data['seller_group'] = $seller_info['seller_group'];
		} else {
			$data['seller_group'] = $this->language->get('text_default_group');
		}

		$data['balance'] = $this->currency->format($this->model_account_transaction->getTransactionTotal($this->member->getId()), $this->config->get('config_currency'));

		$data['transactions'] = array();

		$filter_data = array(
			'member_id' => $this->member->getId(),
			'start'     => ($page - 1) * 10,
			'limit'     => 10
		);

		$transaction_total = $this->model_account_transaction->getTotalTransactions($filter_data);

		$results = $this->model_account_transaction->getTransactions($filter_data);

		foreach ($results as $result) {
			$data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/transaction', 'member_token=' . $this->session->data['member_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/transaction', $data));
	}
}

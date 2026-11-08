<?php
class ControllerAccountPromotion extends Controller {
	public function index() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/promotion', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/promotion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/promotion');

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['promotions'] = array();

		$filter_data = array(
			'member_id' => $this->member->getId(),
			'start'     => ($page - 1) * 10,
			'limit'     => 10
		);

		$promotion_total = $this->model_account_promotion->getTotalPromotions($filter_data);

		$results = $this->model_account_promotion->getPromotions($filter_data);

		foreach ($results as $result) {
			$data['promotions'][] = array(
				'promotion_id'    => $result['promotion_id'],
				'extension'       => $result['extension'],
				'date_start'      => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'        => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'order_status_id' => $result['order_status_id'],
				'order_status'    => $result['order_status'],
				'date_added'      => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'href'            => $this->url->link('account/promotion/info', 'member_token=' . $this->session->data['member_token'] . '&promotion_id=' . $result['promotion_id'], true)
			);
		}

		$data['config_download_status_id'] = $this->config->get('config_download_status_id') ? $this->config->get('config_download_status_id') : ($this->config->get('config_complete_status_id') ? $this->config->get('config_complete_status_id') : 5);
		$data['config_order_status_id'] = $this->config->get('config_order_status_id') ? $this->config->get('config_order_status_id') : 1;

		$pagination = new Pagination();
		$pagination->total = $promotion_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['add'] = $this->url->link('support/advertise', '', true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/promotion_list', $data));
	}

	public function info() {
		if (!$this->member->isLogged() || (!isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token']))) {
			$this->session->data['redirect'] = $this->url->link('account/promotion', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (isset($this->request->get['promotion_id'])) {
			$promotion_id = (int)$this->request->get['promotion_id'];
		} else {
			$promotion_id = 0;
		}

		$this->load->language('account/promotion');

		$this->load->model('account/promotion');

		$promotion_info = $this->model_account_promotion->getPromotion($promotion_id);

		if ($promotion_info) {
			$this->document->setTitle(sprintf($this->language->get('text_invoice_title'), $promotion_info['promotion_id']));

			$this->load->model('account/member');
			$this->load->model('account/seller');
			$this->load->model('localisation/country');
			$this->load->model('localisation/zone');

			$member_info = $this->model_account_member->getMember($this->member->getId());
			$seller_info = $this->model_account_seller->getSeller($this->member->getId());

			$data['title'] = sprintf($this->language->get('text_invoice_title'), $promotion_info['promotion_id']);
			$data['logo'] = $this->config->get('config_name');

			$data['company'] = !empty($seller_info['company']) ? $seller_info['company'] : (!empty($member_info['company']) ? $member_info['company'] : '');
			$data['firstname'] = !empty($seller_info['firstname']) ? $seller_info['firstname'] : (!empty($member_info['firstname']) ? $member_info['firstname'] : '');
			$data['lastname'] = !empty($seller_info['lastname']) ? $seller_info['lastname'] : (!empty($member_info['lastname']) ? $member_info['lastname'] : '');
			$data['address_1'] = !empty($seller_info['address_1']) ? $seller_info['address_1'] : '';
			$data['address_2'] = !empty($seller_info['address_2']) ? $seller_info['address_2'] : '';
			$data['city'] = !empty($seller_info['city']) ? $seller_info['city'] : '';
			$data['postcode'] = !empty($seller_info['postcode']) ? $seller_info['postcode'] : '';

			$zone_id = !empty($seller_info['zone_id']) ? $seller_info['zone_id'] : 0;
			if ($zone_id) {
				$zone_info = $this->model_localisation_zone->getZone($zone_id);
				$data['zone'] = $zone_info ? $zone_info['name'] : '';
			} else {
				$data['zone'] = '';
			}

			$country_id = !empty($seller_info['country_id']) ? $seller_info['country_id'] : (!empty($member_info['country_id']) ? $member_info['country_id'] : 0);
			if ($country_id) {
				$country_info = $this->model_localisation_country->getCountry($country_id);
				$data['country'] = $country_info ? $country_info['name'] : '';
			} else {
				$data['country'] = '';
			}

			$data['telephone'] = !empty($seller_info['telephone']) ? $seller_info['telephone'] : (!empty($member_info['telephone']) ? $member_info['telephone'] : '');
			$data['email'] = !empty($member_info['email']) ? $member_info['email'] : '';
			$data['username'] = !empty($member_info['username']) ? $member_info['username'] : '';

			$data['promotion_id'] = $promotion_info['promotion_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($promotion_info['date_added']));
			$data['payment_method'] = $promotion_info['payment_method'];
			$data['transaction_id'] = $promotion_info['transaction_id'];
			$data['extension'] = $promotion_info['extension'];
			$data['days'] = $promotion_info['days'];
			$data['total'] = $this->currency->format($promotion_info['total'], $this->config->get('config_currency'));

			$data['support'] = $this->url->link('support/contact', '', true);
			$data['cancel'] = $this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true);

			$data['menu'] = $this->load->controller('account/menu');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('account/promotion_info', $data));
		} else {
			$this->document->setTitle($this->language->get('heading_not_found'));

			$data['home'] = $this->url->link('common/home');
			$data['continue'] = $this->url->link('account/promotion', 'member_token=' . $this->session->data['member_token'], true);

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}

<?php
class ControllerAccountAccount extends Controller {
	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['edit'] = $this->url->link('account/edit', $token, true);
		$data['password'] = $this->url->link('account/password', $token, true);
		$data['payment'] = $this->url->link('account/payment', $token, true);
		$data['showcase'] = $this->url->link('account/showcase', $token, true);
		$data['partner'] = $this->url->link('account/partner', $token, true);
		$data['subscription'] = $this->url->link('account/subscription', $token, true);
		$data['order'] = $this->url->link('account/order', $token, true);
		$data['download'] = $this->url->link('account/download', $token, true);
		$data['store'] = $this->url->link('account/store', $token, true);
		$data['rating'] = $this->url->link('account/rating', $token, true);
		$data['extension'] = $this->url->link('account/extension', $token, true);
		$data['seller'] = $this->url->link('account/seller', $token, true);
		$data['sale'] = $this->url->link('account/sale', $token, true);
		$data['transaction'] = $this->url->link('account/transaction', $token, true);
		$data['promotion'] = $this->url->link('account/promotion', $token, true);
		$data['comment'] = $this->url->link('account/extension/comment', $token, true);
		$data['subscription_domain'] = $this->url->link('account/subscription/domain', $token, true);
		$data['subscription_invoice'] = $this->url->link('account/subscription/invoice', $token, true);

		$data['partner_status'] = $this->member->isPartner();
		$data['seller_status'] = $this->member->isSeller();
		$data['moderator'] = $this->member->isModerator();
		$data['cloud'] = $this->member->hasCloud();

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/account', $data));
	}
}

<?php
class ControllerMarketplacePurchase extends Controller {
	public function index() {
		$this->load->model('marketplace/extension');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;

		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('marketplace/purchase', 'extension_id=' . $extension_id, true);
			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		if ($extension_info) {
			$this->document->setTitle('Purchase License - ' . $extension_info['name']);

			$quantity = isset($this->request->post['quantity']) && (int)$this->request->post['quantity'] > 0 ? (int)$this->request->post['quantity'] : (isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1);

			$data['error_warning'] = '';
			$data['action'] = $this->url->link('marketplace/purchase', 'extension_id=' . $extension_id, true);
			$data['extension_id'] = $extension_id;
			$data['name'] = $extension_info['name'];
			$data['quantity'] = $quantity;
			$data['price'] = $this->currency->format($extension_info['price'], $this->config->get('config_currency'));
			$data['total'] = $this->currency->format($extension_info['price'] * $quantity, $this->config->get('config_currency'));
			$data['coupon'] = '';
			$data['discount_price'] = '';

			$data['paypal_status'] = true;
			$data['braintree_status'] = true;

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('marketplace/purchase', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function terms() {
		$this->response->setOutput($this->load->view('marketplace/terms'));
	}

	public function success() {
		$this->document->setTitle('Extension Purchase Success');

		$member_token = isset($this->session->data['member_token']) ? 'member_token=' . $this->session->data['member_token'] : '';

		$data['account'] = $this->url->link('account/account', $member_token, true);
		$data['history'] = $this->url->link('account/order', $member_token, true);
		$data['contact'] = $this->url->link('support/contact');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('marketplace/success', $data));
	}

	public function failure() {
		$this->document->setTitle('Extension Purchase Failure');

		$data['contact'] = $this->url->link('support/contact');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('marketplace/failure', $data));
	}
}

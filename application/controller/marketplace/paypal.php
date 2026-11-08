<?php
class ControllerMarketplacePaypal extends Controller {
	public function index() {
		$this->load->model('marketplace/extension');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		$data['extension_id'] = $extension_id;
		$data['quantity'] = $quantity;
		$data['action'] = $this->url->link('marketplace/purchase/success', '', true);
		$data['business'] = $this->config->get('config_email');
		$data['item_name'] = $extension_info ? $extension_info['name'] : 'OpenCart Extension';
		$data['item_number'] = $extension_id;
		$data['currency_code'] = $this->config->get('config_currency') ? $this->config->get('config_currency') : 'USD';
		$data['amount'] = $extension_info ? number_format((float)$extension_info['price'], 2, '.', '') : '0.00';
		$data['email'] = $this->member->getEmail();
		$data['invoice'] = '';
		$data['custom'] = '';
		$data['return'] = $this->url->link('marketplace/purchase/success', '', true);
		$data['notify_url'] = $this->url->link('marketplace/paypal/callback', '', true);
		$data['cancel_return'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true);
		$data['cancel'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true);

		$this->response->setOutput($this->load->view('marketplace/paypal', $data));
	}

	public function send() {
		$json = array();

		if (!$this->member->isLogged()) {
			$json['error'] = 'You must be logged in to purchase an extension!';
		} elseif (empty($this->request->post['agree'])) {
			$json['error'] = 'You must agree to the Terms & Conditions!';
		}

		if (!$json) {
			$this->load->model('marketplace/extension');
			$this->load->model('account/order');

			$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
			$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;

			$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

			if ($extension_info) {
				$order_id = $this->model_account_order->addOrder(array(
					'member_id'       => $this->member->getId(),
					'seller_id'       => $extension_info['member_id'],
					'extension_id'    => $extension_id,
					'extension'       => $extension_info['name'],
					'quantity'        => $quantity,
					'price'           => $extension_info['price'],
					'total'           => (float)$extension_info['price'] * $quantity,
					'payment_method'  => 'PayPal',
					'transaction_id'  => 'PP-' . strtoupper(token(10)),
					'order_status_id' => 5
				));

				$json['invoice'] = $order_id;
				$json['custom'] = $order_id;
			} else {
				$json['error'] = 'Extension not found!';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function callback() {
		$this->response->redirect($this->url->link('marketplace/purchase/success', '', true));
	}
}

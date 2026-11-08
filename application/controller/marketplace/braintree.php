<?php
class ControllerMarketplaceBraintree extends Controller {
	public function index() {
		$this->load->language('marketplace/braintree');

		$this->load->model('account/payment');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;

		$payments = $this->model_account_payment->getPayments($this->member->getId());

		$data['vaulted_payment_methods'] = array();
		$data['initial_card_image'] = 'application/view/image/cloud/cloud_credit_card.svg';

		foreach ($payments as $index => $payment) {
			if ($index === 0 && $payment['image']) {
				$data['initial_card_image'] = $payment['image'];
			}

			$data['vaulted_payment_methods'][] = array(
				'token' => $payment['token'],
				'name'  => $payment['name'],
				'image' => $payment['image'] ? $payment['image'] : 'application/view/image/cloud/cloud_credit_card.svg'
			);
		}

		$data['vault'] = true;
		$data['client_token'] = '';
		$data['payment_url'] = $this->url->link('marketplace/braintree/payment', 'extension_id=' . $extension_id . '&quantity=' . $quantity, true);

		$this->response->setOutput($this->load->view('marketplace/braintree', $data));
	}

	public function payment() {
		$this->load->language('marketplace/braintree');

		$this->load->model('marketplace/extension');
		$this->load->model('account/order');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		if ($this->member->isLogged() && $extension_info) {
			$this->model_account_order->addOrder(array(
				'member_id'       => $this->member->getId(),
				'seller_id'       => $extension_info['member_id'],
				'extension_id'    => $extension_id,
				'extension'       => $extension_info['name'],
				'quantity'        => $quantity,
				'price'           => $extension_info['price'],
				'total'           => (float)$extension_info['price'] * $quantity,
				'payment_method'  => $this->language->get('text_title'),
				'transaction_id'  => 'BT-' . strtoupper(token(10)),
				'order_status_id' => 5
			));

			$this->response->redirect($this->url->link('marketplace/purchase/success', '', true));
		} else {
			$this->response->redirect($this->url->link('marketplace/purchase/failure', '', true));
		}
	}

	public function vaulted() {
		$json = array(
			'success'        => true,
			'payment_method' => array(
				'nonce' => token(24)
			)
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('marketplace/braintree');

		$json = array(
			'success'                 => $this->language->get('text_remove'),
			'vaulted_payment_methods' => false
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

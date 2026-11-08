<?php
class ControllerMarketplaceBraintree extends Controller {
	public function index() {
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
		// Legacy forms do not carry a server-bound prepared checkout. Never
		// create a paid order from their nonce or a generated transaction ID.
		$extension_id = (int)($this->request->get['extension_id'] ?? 0);
		$this->response->redirect($this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true));
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
		$json = array(
			'success'                 => 'Payment method removed!',
			'vaulted_payment_methods' => false
		);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

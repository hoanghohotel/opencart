<?php
class ControllerMarketplacePaypal extends Controller {
	public function index() {
		$this->load->language('marketplace/paypal');

		$this->load->model('marketplace/extension');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;
		$quantity = isset($this->request->get['quantity']) && (int)$this->request->get['quantity'] > 0 ? (int)$this->request->get['quantity'] : 1;

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		$data['extension_id'] = $extension_id;
		$data['quantity'] = $quantity;
		$data['action'] = $this->url->link('marketplace/purchase/success', '', true);
		$data['business'] = $this->config->get('config_email');
		$data['item_name'] = $extension_info ? $extension_info['name'] : $this->language->get('text_default_item');
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
		if (method_exists($this->load, 'language')) {
			$this->load->language('marketplace/paypal');
		}

		// This legacy flow has no server-side capture verification. Keep the
		// JSON endpoint, but do not manufacture an invoice or a paid order.
		$extension_id = (int)($this->request->get['extension_id'] ?? 0);
		$err_msg = ($this->registry->has('language') && $this->language->get('error_legacy_capture') !== 'error_legacy_capture')
			? $this->language->get('error_legacy_capture')
			: 'This payment flow cannot verify capture. Restart checkout and select a supported card gateway.';

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode(array(
			'error'    => $err_msg,
			'redirect' => $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id . '&purchase=1', true)
		)));
	}

	public function callback() {
		$this->response->redirect($this->url->link('marketplace/purchase/success', '', true));
	}
}

<?php
class ControllerSupportAdvertise extends Controller {
	public function index() {
		$this->load->language('support/advertise');

		$store_name = $this->config->get('config_name') ?: 'Store';

		$this->document->setTitle(str_replace('{store_name}', $store_name, $this->language->get('heading_title')));

		if ($this->member->isLogged()) {
			$data['name'] = trim($this->member->getFirstName() . ' ' . $this->member->getLastName());
			if (!$data['name']) {
				$data['name'] = $this->member->getUsername();
			}
			$data['email'] = $this->member->getEmail();
		} else {
			$data['name'] = '';
			$data['email'] = '';
		}

		$data['contact_support'] = $this->config->get('config_contact_support') ?: $this->config->get('config_email');
		$data['contact_telephone'] = $this->config->get('config_telephone');
		$data['contact_partner'] = $this->config->get('config_contact_partner') ?: $this->config->get('config_email');
		$data['contact_marketing'] = $this->config->get('config_contact_marketing') ?: $this->config->get('config_email');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/advertise', $data));
	}

	public function send() {
		$this->load->language('support/advertise');

		$json = array();

		$this->load->model('support/enquiry');

		if (!isset($this->request->post['name']) || (utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 64)) {
			$json['error']['name'] = $this->language->get('error_name');
		}

		if (!isset($this->request->post['email']) || (utf8_strlen(trim($this->request->post['email'])) > 96) || !filter_var(trim($this->request->post['email']), FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = $this->language->get('error_email');
		}

		if (!isset($this->request->post['enquiry']) || (utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
			$json['error']['enquiry'] = $this->language->get('error_enquiry');
		}

		if ($json && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$enquiry_data = $this->request->post;
			$enquiry_data['type'] = 'advertise';

			$this->model_support_enquiry->addEnquiry($enquiry_data);

			unset($this->session->data['captcha']);

			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('support/contact/success'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

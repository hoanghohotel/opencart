<?php
class ControllerSupportAdvertise extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Advertise With Us');

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

		$data['contact_support'] = 'info@opencart.com';
		$data['contact_telephone'] = '+852 2499 0996';
		$data['contact_partner'] = 'partners@opencart.com';
		$data['contact_marketing'] = 'media@opencart.com';

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/advertise', $data));
	}

	public function send() {
		$json = array();

		$this->load->model('support/enquiry');

		if (!isset($this->request->post['name']) || (utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 64)) {
			$json['error']['name'] = 'Full Name must be between 3 and 64 characters!';
		}

		if (!isset($this->request->post['email']) || (utf8_strlen(trim($this->request->post['email'])) > 96) || !filter_var(trim($this->request->post['email']), FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = 'E-Mail Address does not appear to be valid!';
		}

		if (!isset($this->request->post['enquiry']) || (utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
			$json['error']['enquiry'] = 'Message must be between 10 and 3000 characters!';
		}

		if ($json && !isset($json['error']['warning'])) {
			$json['error']['warning'] = 'Please check the form carefully for errors!';
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

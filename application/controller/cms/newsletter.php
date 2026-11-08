<?php
class ControllerCmsNewsletter extends Controller {
	public function index() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->subscribe();
			return;
		}

		$email = isset($this->request->get['email']) ? trim($this->request->get['email']) : '';

		if ($email && (utf8_strlen($email) <= 96) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->load->model('cms/newsletter');
			if (!$this->model_cms_newsletter->getTotalNewslettersByEmail($email)) {
				$this->model_cms_newsletter->addNewsletter($email);
			}
		}

		$data['email'] = $email;

		$this->response->setOutput($this->load->view('cms/newsletter', $data));
	}

	public function subscribe() {
		$json = array();

		$this->load->model('cms/newsletter');

		$email = isset($this->request->post['newsletter']) ? trim($this->request->post['newsletter']) : (isset($this->request->post['email']) ? trim($this->request->post['email']) : (isset($this->request->post['EMAIL']) ? trim($this->request->post['EMAIL']) : ''));

		if ((utf8_strlen($email) > 96) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$json['error'] = 'Please enter a valid email address!';
		} elseif ($this->model_cms_newsletter->getTotalNewslettersByEmail($email)) {
			$json['error'] = 'This email address is already subscribed to our newsletter!';
		}

		if (!$json) {
			$this->model_cms_newsletter->addNewsletter($email);

			$json['success'] = 'Thank you for subscribing to our newsletter!';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function unsubscribe() {
		$this->document->setTitle('OpenCart - Unsubscribe Newsletter');

		$this->load->model('cms/newsletter');

		if (isset($this->request->get['email'])) {
			$this->model_cms_newsletter->deleteNewsletter($this->request->get['email']);
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/unsubscribe', $data));
	}
}

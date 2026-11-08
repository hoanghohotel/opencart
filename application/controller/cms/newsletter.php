<?php
class ControllerCmsNewsletter extends Controller {
	public function index() {
		$this->load->language('cms/newsletter');

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
		$this->load->language('cms/newsletter');

		$json = array();

		$this->load->model('cms/newsletter');

		$email = isset($this->request->post['newsletter']) ? trim($this->request->post['newsletter']) : (isset($this->request->post['email']) ? trim($this->request->post['email']) : (isset($this->request->post['EMAIL']) ? trim($this->request->post['EMAIL']) : ''));

		if ((utf8_strlen($email) > 96) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$json['error'] = $this->language->get('error_email');
		} elseif ($this->model_cms_newsletter->getTotalNewslettersByEmail($email)) {
			$json['error'] = $this->language->get('error_exists');
		}

		if (!$json) {
			$this->model_cms_newsletter->addNewsletter($email);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function unsubscribe() {
		$this->load->language('cms/newsletter');

		$this->document->setTitle($this->language->get('heading_unsubscribe'));

		$this->load->model('cms/newsletter');

		if (isset($this->request->get['email'])) {
			$this->model_cms_newsletter->deleteNewsletter($this->request->get['email']);
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/unsubscribe', $data));
	}
}

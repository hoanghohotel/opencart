<?php
class ControllerSupportSeller extends Controller {
	public function index() {
		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;

		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('support/seller', ($extension_id ? 'extension_id=' . $extension_id : ''), true));

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		if (!isset($_GET['member_token']) || $_GET['member_token'] !== $this->session->data['member_token']) {
			$this->response->redirect($this->url->link('support/seller', 'member_token=' . $this->session->data['member_token'] . ($extension_id ? '&extension_id=' . $extension_id : ''), true));
		}

		$this->load->model('marketplace/extension');
		$this->load->model('cms/download');
		$this->load->model('tool/image');

		if (!$extension_id) {
			$extension_id = 38358;
		}

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		if ($extension_info) {
			$this->document->setTitle('OpenCart - Contact Seller');

			$data['extension_id'] = (int)$extension_info['extension_id'];
			$data['member_token'] = $this->session->data['member_token'];

			$name = trim($this->member->getFirstName() . ' ' . $this->member->getLastName());
			$data['name'] = $name !== '' ? $name : $this->member->getUsername();

			$data['downloads'] = $this->model_cms_download->getDownloads();
			$data['enquiry'] = '';

			if (!empty($extension_info['member_image'])) {
				$data['member_image'] = $this->model_tool_image->resize($extension_info['member_image'], 60, 60);
			} else {
				$data['member_image'] = $this->model_tool_image->resize('profile.png', 60, 60);
			}

			$data['member_username'] = $extension_info['username'];
			$data['member_date_added'] = !empty($extension_info['member_date_added']) ? date('M Y', strtotime($extension_info['member_date_added'])) : '';
			$data['filter_member'] = $this->url->link('marketplace/extension', 'filter_member=' . urlencode($extension_info['username']));
			$data['banner'] = $this->load->controller('cms/banner', 1);

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('support/seller', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function send() {
		$json = array();

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;

		if (!$this->member->isLogged() || !isset($this->request->get['member_token']) || !isset($this->session->data['member_token']) || ($this->request->get['member_token'] != $this->session->data['member_token'])) {
			$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('support/seller', ($extension_id ? 'extension_id=' . $extension_id : ''), true));

			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('account/login', '', true));
		}

		if (!$json) {
			$this->load->model('marketplace/extension');

			$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

			if (!$extension_info) {
				$json['error']['warning'] = 'Extension could not be found!';
			}
		}

		if (!$json) {
			$reason = isset($this->request->post['reason']) ? trim($this->request->post['reason']) : '';

			if (!in_array($reason, array('question', 'support', 'refund'))) {
				$json['error']['reason'] = 'Please select how we can help you!';
			}

			if (!isset($this->request->post['name']) || (utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 64)) {
				$json['error']['name'] = 'Name must be between 3 and 64 characters!';
			}

			if (!isset($this->request->post['order_id']) || trim($this->request->post['order_id']) === '') {
				$json['error']['order_id'] = 'Order ID required!';
			}

			if (empty($this->request->post['version_id'])) {
				$json['error']['version'] = 'Please select which OpenCart version you are using!';
			}

			if (!isset($this->request->post['enquiry']) || (utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
				$json['error']['enquiry'] = 'Message must be between 10 and 3000 characters!';
			}

			if ($json && !isset($json['error']['warning'])) {
				$json['error']['warning'] = 'Please check the form carefully for errors!';
			}
		}

		if (!$json) {
			$this->load->model('support/enquiry');

			$enquiry_data = array(
				'type'          => 'seller',
				'reason'        => isset($this->request->post['reason']) ? trim($this->request->post['reason']) : 'support',
				'partner_id'    => (int)$extension_info['member_id'],
				'name'          => trim($this->request->post['name']),
				'email'         => $this->member->getEmail(),
				'telephone'     => '',
				'company'       => $this->member->getCompany(),
				'website'       => isset($this->request->post['website']) ? trim($this->request->post['website']) : '',
				'country_id'    => (int)$this->member->getCountryId(),
				'order_id'      => (int)$this->request->post['order_id'],
				'version_id'    => (int)$this->request->post['version_id'],
				'extension_url' => str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true)),
				'original_url'  => '',
				'subject'       => 'Contact Seller [' . ucfirst($this->request->post['reason']) . ']: ' . $extension_info['name'] . ' (ID: ' . $extension_id . ')',
				'enquiry'       => trim($this->request->post['enquiry'])
			);

			$this->model_support_enquiry->addEnquiry($enquiry_data);

			$this->load->controller('mail/seller', array(
				'extension_id' => $extension_id,
				'reason'       => $enquiry_data['reason'],
				'name'         => $enquiry_data['name'],
				'username'     => $this->member->getUsername(),
				'email'        => $enquiry_data['email'],
				'website'      => $enquiry_data['website'],
				'order_id'     => $this->request->post['order_id'],
				'version_id'   => $enquiry_data['version_id'],
				'enquiry'      => $enquiry_data['enquiry']
			));

			unset($this->session->data['captcha']);

			$json['redirect'] = str_replace('&amp;', '&', $this->url->link('support/seller/success', 'member_token=' . $this->session->data['member_token'] . '&extension_id=' . $extension_id, true));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function success() {
		if (!$this->member->isLogged()) {
			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('OpenCart - Contact Seller');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/seller_success', $data));
	}
}

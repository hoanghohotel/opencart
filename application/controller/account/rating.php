<?php
class ControllerAccountRating extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/rating', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->document->setTitle('Rate your downloads');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 10;

		$token = 'member_token=' . $this->session->data['member_token'];

		$this->load->model('account/order');
		$this->load->model('marketplace/extension');

		$data['extensions'] = array();

		$filter_data = array(
			'member_id' => $this->member->getId(),
			'start'     => ($page - 1) * $limit,
			'limit'     => $limit
		);

		$extension_total = $this->model_account_order->getTotalPurchasedExtensions($filter_data);

		$ref = new ReflectionMethod('ModelAccountOrder', 'getPurchasedExtensions');
		if ($ref->getNumberOfParameters() >= 2) {
			$results = $this->model_account_order->getPurchasedExtensions($this->member->getId(), ($page - 1) * $limit, $limit);
		} else {
			$results = $this->model_account_order->getPurchasedExtensions($filter_data);
		}

		foreach ($results as $result) {
			$rating_info = $this->getMemberRatingInfo($this->member->getId(), $result['extension_id']);

			$data['extensions'][] = array(
				'extension_id' => $result['extension_id'],
				'extension'    => !empty($result['name']) ? $result['name'] : $result['extension'],
				'rating'       => $rating_info ? (int)$rating_info['rating'] : 0,
				'href'         => $this->url->link('account/rating/rate', $token . '&extension_id=' . $result['extension_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $extension_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/rating', $token . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['cancel'] = $this->url->link('account/account', $token, true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/rating_list', $data));
	}

	public function rate() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/rating', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 0;

		$this->load->model('marketplace/extension');

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		if (!$extension_info) {
			$this->response->redirect($this->url->link('account/rating', 'member_token=' . $this->session->data['member_token'], true));
			return;
		}

		$this->document->setTitle('Rate ' . $extension_info['name']);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$ref = new ReflectionMethod('ModelMarketplaceExtension', 'addRating');

			if ($ref->getNumberOfParameters() >= 3) {
				$this->model_marketplace_extension->addRating($this->member->getId(), $extension_id, $this->request->post);
			} else {
				$this->model_marketplace_extension->addRating($extension_id, $this->request->post);
			}

			$this->session->data['success'] = 'Success: Thank you for rating this extension!';

			$this->response->redirect($this->url->link('account/rating', 'member_token=' . $this->session->data['member_token'], true));
		}

		$fields = array('functionality', 'appearance', 'user_friendly', 'support', 'documentation', 'comment');

		foreach ($fields as $field) {
			if (isset($this->error[$field])) {
				$data['error_' . $field] = $this->error[$field];
			} else {
				$data['error_' . $field] = '';
			}
		}

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['action'] = $this->url->link('account/rating/rate', $token . '&extension_id=' . $extension_id, true);
		$data['cancel'] = $this->url->link('account/rating', $token, true);
		$data['extension'] = $extension_info['name'];

		$rating_info = $this->getMemberRatingInfo($this->member->getId(), $extension_id);

		foreach ($fields as $field) {
			if (isset($this->request->post[$field])) {
				$data[$field] = $this->request->post[$field];
			} elseif (!empty($rating_info) && isset($rating_info[$field])) {
				$data[$field] = $rating_info[$field];
			} else {
				$data[$field] = '';
			}
		}

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/rating_form', $data));
	}

	protected function getMemberRatingInfo($member_id, $extension_id) {
		if (isset($this->model_marketplace_extension->getMemberRating)) {
			return $this->model_marketplace_extension->getMemberRating($member_id, $extension_id);
		}

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension_rating` WHERE member_id = '" . (int)$member_id . "' AND extension_id = '" . (int)$extension_id . "' ORDER BY date_added DESC LIMIT 1");

		return $query->row;
	}

	protected function validate() {
		if (empty($this->request->post['functionality'])) {
			$this->error['functionality'] = 'Please select a rating for Functionality!';
		}

		if (empty($this->request->post['appearance'])) {
			$this->error['appearance'] = 'Please select a rating for Appearance!';
		}

		if (empty($this->request->post['user_friendly'])) {
			$this->error['user_friendly'] = 'Please select a rating for User friendly!';
		}

		if (empty($this->request->post['support'])) {
			$this->error['support'] = 'Please select a rating for Support!';
		}

		if (empty($this->request->post['documentation'])) {
			$this->error['documentation'] = 'Please select a rating for Documentation!';
		}

		if (!isset($this->request->post['comment']) || utf8_strlen(trim($this->request->post['comment'])) < 10) {
			$this->error['comment'] = 'Feedback comment must be at least 10 characters!';
		}

		return !$this->error;
	}
}

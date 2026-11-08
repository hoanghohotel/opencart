<?php
class ControllerAccountStore extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/store', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->document->setTitle('Your Stores');

		$this->load->model('account/store');

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

		$data['stores'] = array();

		$store_total = $this->model_account_store->getTotalStores($this->member->getId());

		$ref = new ReflectionMethod('ModelAccountStore', 'getStores');
		if ($ref->getNumberOfParameters() >= 2) {
			$results = $this->model_account_store->getStores($this->member->getId(), ($page - 1) * $limit, $limit);
		} else {
			$results = $this->model_account_store->getStores(array(
				'member_id' => $this->member->getId(),
				'start'     => ($page - 1) * $limit,
				'limit'     => $limit
			));
		}

		foreach ($results as $result) {
			$store_id = isset($result['member_store_id']) ? (int)$result['member_store_id'] : (isset($result['store_id']) ? (int)$result['store_id'] : 0);

			$data['stores'][] = array(
				'store_id'      => $store_id,
				'domain'        => $result['domain'],
				'date_added'    => date('d M Y', strtotime($result['date_added'])),
				'date_modified' => date('d M Y', strtotime($result['date_modified'])),
				'view'          => $this->url->link('account/store/info', $token . '&store_id=' . $store_id, true),
				'delete'        => $this->url->link('account/store/delete', $token . '&store_id=' . $store_id, true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $store_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/store', $token . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['cancel'] = $this->url->link('account/account', $token, true);
		$data['add'] = $this->url->link('account/store/add', $token, true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/store_list', $data));
	}

	public function add() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/store/add', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->document->setTitle('Add Store');

		$this->load->model('account/store');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$post_data = $this->request->post;
			if (empty($post_data['username'])) {
				$post_data['username'] = 'oc_api_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $this->member->getUsername());
			}

			$ref = new ReflectionMethod('ModelAccountStore', 'addStore');
			if ($ref->getNumberOfParameters() >= 2) {
				$this->model_account_store->addStore($this->member->getId(), $post_data);
			} else {
				$this->model_account_store->addStore($post_data);
			}

			$this->session->data['success'] = 'Success: Your store has been registered!';

			$this->response->redirect($this->url->link('account/store', 'member_token=' . $this->session->data['member_token'], true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['domain'])) {
			$data['error_domain'] = $this->error['domain'];
		} else {
			$data['error_domain'] = '';
		}

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['action'] = $this->url->link('account/store/add', $token, true);

		if (isset($this->request->post['domain'])) {
			$data['domain'] = $this->request->post['domain'];
		} else {
			$data['domain'] = '';
		}

		$data['cancel'] = $this->url->link('account/store', $token, true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/store_form', $data));
	}

	public function info() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/store', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$store_id = isset($this->request->get['store_id']) ? (int)$this->request->get['store_id'] : 0;

		$this->load->model('account/store');

		$store_info = $this->getStoreInfo($store_id);

		if (!$store_info) {
			$this->response->redirect($this->url->link('account/store', 'member_token=' . $this->session->data['member_token'], true));
			return;
		}

		$this->document->setTitle('Your Store API Information');

		$data['error_warning'] = '';
		$data['member_token'] = $this->session->data['member_token'];
		$data['store_id'] = $store_id;
		$data['domain'] = $store_info['domain'];
		$data['username'] = $store_info['username'] ? $store_info['username'] : $this->member->getUsername();
		$data['secret'] = $store_info['secret'];
		$data['action'] = $this->url->link('account/store/info', 'member_token=' . $this->session->data['member_token'] . '&store_id=' . $store_id, true);
		$data['cancel'] = $this->url->link('account/store', 'member_token=' . $this->session->data['member_token'], true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/store_info', $data));
	}

	public function secret() {
		$json = array();

		if (!$this->member->isLogged()) {
			$json['error'] = 'Warning: You must be logged in!';
		} else {
			$store_id = isset($this->request->get['store_id']) ? (int)$this->request->get['store_id'] : 0;

			$this->load->model('account/store');

			$store_info = $this->getStoreInfo($store_id);

			if (!$store_info) {
				$json['error'] = 'Warning: Store could not be found!';
			} else {
				if (isset($this->model_account_store->generateSecret)) {
					$secret = $this->model_account_store->generateSecret($this->member->getId(), $store_id);
				} else {
					$secret = 'sk_live_' . token(48);
					$this->model_account_store->editStore($store_id, array(
						'domain'   => $store_info['domain'],
						'username' => $store_info['username'],
						'secret'   => $secret
					));
				}

				$json['secret'] = $secret;
				$json['success'] = 'Success: You have generated a new API secret!';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/store', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		if (isset($this->request->get['store_id'])) {
			$this->load->model('account/store');

			$store_id = (int)$this->request->get['store_id'];

			$ref = new ReflectionMethod('ModelAccountStore', 'deleteStore');
			if ($ref->getNumberOfParameters() >= 2) {
				$this->model_account_store->deleteStore($this->member->getId(), $store_id);
			} else {
				$this->model_account_store->deleteStore($store_id);
			}

			$this->session->data['success'] = 'Success: Your store has been deleted!';
		}

		$this->response->redirect($this->url->link('account/store', 'member_token=' . $this->session->data['member_token'], true));
	}

	protected function getStoreInfo($store_id) {
		$ref = new ReflectionMethod('ModelAccountStore', 'getStore');
		if ($ref->getNumberOfParameters() >= 2) {
			return $this->model_account_store->getStore($this->member->getId(), $store_id);
		}

		return $this->model_account_store->getStore($store_id);
	}

	protected function validateForm() {
		if (!isset($this->request->post['domain']) || (utf8_strlen(trim($this->request->post['domain'])) < 3) || (utf8_strlen(trim($this->request->post['domain'])) > 255)) {
			$this->error['domain'] = 'Domain must be between 3 and 255 characters!';
		}

		return !$this->error;
	}
}

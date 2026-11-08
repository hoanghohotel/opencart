<?php
class ControllerAccountShowcase extends Controller {
	private $error = array();

	public function index() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/showcase', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('cms/showcase');

		$this->getList();
	}

	public function add() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/showcase/add', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/showcase');

		$this->document->setTitle($this->language->get('heading_form'));

		$this->load->model('cms/showcase');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$ref = new ReflectionMethod('ModelCmsShowcase', 'addShowcase');

			if ($ref->getNumberOfParameters() >= 2) {
				$this->model_cms_showcase->addShowcase($this->member->getId(), $this->request->post);
			} else {
				$this->model_cms_showcase->addShowcase($this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success_add');

			$this->response->redirect($this->url->link('account/showcase', 'member_token=' . $this->session->data['member_token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		if (!$this->member->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/showcase', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/showcase');

		$this->load->model('cms/showcase');

		if (isset($this->request->get['showcase_id'])) {
			$showcase_id = (int)$this->request->get['showcase_id'];

			$ref = new ReflectionMethod('ModelCmsShowcase', 'deleteShowcase');

			if ($ref->getNumberOfParameters() >= 2) {
				$this->model_cms_showcase->deleteShowcase($this->member->getId(), $showcase_id);
			} else {
				$this->model_cms_showcase->deleteShowcase($showcase_id);
			}

			$this->session->data['success'] = $this->language->get('text_success_delete');
		}

		$this->response->redirect($this->url->link('account/showcase', 'member_token=' . $this->session->data['member_token'], true));
	}

	protected function getList() {
		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 10;

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['showcases'] = array();

		$filter_data = array(
			'filter_member_id' => $this->member->getId(),
			'start'            => ($page - 1) * $limit,
			'limit'            => $limit
		);

		$showcase_total = $this->model_cms_showcase->getTotalShowcases($filter_data);

		$results = $this->model_cms_showcase->getShowcases($filter_data);

		foreach ($results as $result) {
			$data['showcases'][] = array(
				'showcase_id' => $result['showcase_id'],
				'name'        => $result['name'],
				'category'    => isset($result['category']) ? $result['category'] : '',
				'status'      => (int)$result['status'],
				'date_added'  => date('d M Y', strtotime($result['date_added'])),
				'delete'      => $this->url->link('account/showcase/delete', $token . '&showcase_id=' . $result['showcase_id'], true)
			);
		}

		$pagination = new Pagination();
		$pagination->total = $showcase_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/showcase', $token . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['cancel'] = $this->url->link('account/account', $token, true);
		$data['add'] = $this->url->link('account/showcase/add', $token, true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/showcase_list', $data));
	}

	protected function getForm() {
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = '';
		}

		if (isset($this->error['date_launch'])) {
			$data['error_date_launch'] = $this->error['date_launch'];
		} else {
			$data['error_date_launch'] = '';
		}

		if (isset($this->error['link'])) {
			$data['error_link'] = $this->error['link'];
		} else {
			$data['error_link'] = '';
		}

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['action'] = $this->url->link('account/showcase/add', $token, true);

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['showcase_category_id'])) {
			$data['showcase_category_id'] = (int)$this->request->post['showcase_category_id'];
		} else {
			$data['showcase_category_id'] = '';
		}

		$data['categories'] = $this->model_cms_showcase->getShowcaseCategories();

		if (isset($this->request->post['date_launch'])) {
			$data['date_launch'] = $this->request->post['date_launch'];
		} else {
			$data['date_launch'] = date('Y-m-d');
		}

		if (isset($this->request->post['link'])) {
			$data['link'] = $this->request->post['link'];
		} else {
			$data['link'] = '';
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if ($data['image'] && $this->model_tool_image->resize($data['image'], 100, 100)) {
			$data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['cancel'] = $this->url->link('account/showcase', $token, true);

		$data['menu'] = $this->load->controller('account/menu');
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/showcase_form', $data));
	}

	protected function validateForm() {
		if (!isset($this->request->post['name']) || (utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['showcase_category_id'])) {
			$this->error['category'] = $this->language->get('error_category');
		}

		if (empty($this->request->post['date_launch'])) {
			$this->error['date_launch'] = $this->language->get('error_date_launch');
		}

		if (empty($this->request->post['link']) || (utf8_strlen(trim($this->request->post['link'])) < 5)) {
			$this->error['link'] = $this->language->get('error_link');
		}

		return !$this->error;
	}
}

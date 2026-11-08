<?php
class ControllerCmsShowcase extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Showcase');

		$this->load->model('cms/showcase');
		$this->load->model('tool/image');

		if (isset($this->request->get['filter_showcase_category_id'])) {
			$filter_showcase_category_id = (int)$this->request->get['filter_showcase_category_id'];
		} else {
			$filter_showcase_category_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 12;

		$data['showcase_categories'] = array();

		$data['showcase_categories'][] = array(
			'showcase_category_id' => 0,
			'name'                 => 'All Stores',
			'href'                 => $this->url->link('cms/showcase')
		);

		$categories = $this->model_cms_showcase->getShowcaseCategories();

		foreach ($categories as $category) {
			$data['showcase_categories'][] = array(
				'showcase_category_id' => $category['showcase_category_id'],
				'name'                 => $category['name'],
				'href'                 => $this->url->link('cms/showcase', 'filter_showcase_category_id=' . $category['showcase_category_id'])
			);
		}

		$filter_data = array(
			'filter_showcase_category_id' => $filter_showcase_category_id,
			'start'                       => ($page - 1) * $limit,
			'limit'                       => $limit
		);

		$showcase_total = $this->model_cms_showcase->getTotalShowcases($filter_data);
		$results = $this->model_cms_showcase->getShowcases($filter_data);

		$data['showcases'] = array();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 360, 200);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 360, 200);
			}

			$data['showcases'][] = array(
				'showcase_id' => $result['showcase_id'],
				'name'        => $result['name'],
				'category'    => isset($result['category']) ? $result['category'] : '',
				'image'       => $image,
				'link'        => $result['link'],
				'date_launch' => date($this->language->get('date_format_short'), strtotime($result['date_launch']))
			);
		}

		$url = '';

		if ($filter_showcase_category_id) {
			$url .= '&filter_showcase_category_id=' . $filter_showcase_category_id;
		}

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $showcase_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('cms/showcase', $url . '&page={page}')
		));

		$data['filter_showcase_category_id'] = $filter_showcase_category_id;
		$data['page'] = (string)$page;

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/showcase', $data));
	}
}

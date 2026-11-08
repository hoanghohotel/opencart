<?php
class ControllerCmsBanner extends Controller {
	public function index($banner_id = 1) {
		$this->load->language('cms/banner');

		if (is_array($banner_id)) {
			$banner_id = isset($banner_id['banner_id']) ? (int)$banner_id['banner_id'] : 1;
		}

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$results = $this->model_design_banner->getBanner((int)$banner_id);

		$data['banners'] = array();
		$data['banner'] = array();

		foreach ($results as $result) {
			$image = $result['image'];
			if ($image && strpos($image, 'application/') !== 0 && strpos($image, 'http') !== 0 && is_file(DIR_IMAGE . $image)) {
				$image = ($this->request->server['HTTPS'] ? $this->config->get('config_ssl') : $this->config->get('config_url')) . 'image/' . $image;
			}

			$item = array(
				'title' => $result['title'],
				'href'  => $result['link'],
				'image' => $image
			);

			$data['banners'][] = $item;
		}

		if ($data['banners']) {
			$data['banner'] = $data['banners'][0];
		}

		return $this->load->view('cms/banner', $data);
	}
}

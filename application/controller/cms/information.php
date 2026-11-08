<?php
class ControllerCmsInformation extends Controller {
	public function index() {
		$this->load->language('cms/information');

		$this->load->model('cms/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 2;
		}

		$information_info = $this->model_cms_information->getInformation($information_id);

		if (!$information_info && !isset($this->request->get['information_id'])) {
			$informations = $this->model_cms_information->getInformations();
			if ($informations) {
				$information_info = $this->model_cms_information->getInformation($informations[0]['information_id']);
			}
		}

		if ($information_info) {
			$this->document->setTitle($information_info['meta_title'] ? $information_info['meta_title'] : $information_info['title']);
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['title'] = $information_info['title'];
			$data['heading_title'] = $information_info['title'];
			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('cms/information', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function agree() {
		$this->load->model('cms/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_cms_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}

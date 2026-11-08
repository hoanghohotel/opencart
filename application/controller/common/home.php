<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->load->language('common/home');

		$this->document->setTitle($this->config->get('config_meta_title') ? $this->config->get('config_meta_title') : $this->language->get('heading_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['download'] = $this->url->link('cms/download');
		$data['demo'] = $this->url->link('cms/demo');
		$data['guide'] = $this->url->link('cms/guide');
		$data['feature'] = $this->url->link('cms/feature');
		$data['marketplace'] = $this->url->link('marketplace/extension');
		$data['extension'] = $this->url->link('marketplace/extension');
		$data['support'] = $this->url->link('support/support');
		$data['partner'] = $this->url->link('support/partner');
		$data['forum'] = $this->config->get('config_forum_url') ?: $this->url->link('support/support');
		$data['dedicated_support'] = $this->config->get('config_dedicated_support_url') ?: $this->url->link('support/support');
		$data['cloud_hosting_url'] = $this->config->get('config_cloud_hosting_url') ?: $this->url->link('cloud/landing');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}

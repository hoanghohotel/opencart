<?php
class ControllerSupportSupport extends Controller {
	public function index() {
		$this->load->language('support/support');

		$store_name = $this->config->get('config_name') ?: 'Store';

		$this->document->setTitle(str_replace('{store_name}', $store_name, $this->language->get('heading_title')));

		$data['support'] = $this->url->link('support/contact');
		$data['partner'] = $this->url->link('support/partner');
		$data['marketplace'] = $this->url->link('marketplace/extension');
		$data['forum'] = $this->config->get('config_forum_url') ?: $this->url->link('support/support');
		$data['documentation'] = $this->config->get('config_docs_url') ?: $this->url->link('cms/guide');
		$data['dedicated_support'] = $this->config->get('config_dedicated_support_url') ?: $this->url->link('support/support');

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/support', $data));
	}
}

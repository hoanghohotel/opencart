<?php
class ControllerMailFooter extends Controller {
	public function index() {
		$this->load->language('mail/footer');

		$data['marketplace'] = $this->url->link('marketplace/extension', '', true);
		$data['linkedin_url'] = $this->config->get('config_linkedin_url') ?: 'https://www.linkedin.com';
		$data['twitter_url'] = $this->config->get('config_twitter_url') ?: 'https://twitter.com';
		$data['facebook_url'] = $this->config->get('config_facebook_url') ?: 'https://www.facebook.com';

		return $this->load->view('mail/footer', $data);
	}
}

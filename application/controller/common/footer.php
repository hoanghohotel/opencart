<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$this->load->model('cms/information');

		$data['company'] = $this->url->link('cms/company');
		$data['feature'] = $this->url->link('cms/feature');
		$data['cloud'] = $this->url->link('cloud/landing');
		$data['showcase'] = $this->url->link('cms/showcase');
		$data['demo'] = $this->url->link('cms/demo');
		$data['download'] = $this->url->link('cms/download');
		$data['marketplace'] = $this->url->link('marketplace/extension');
		$data['extension'] = $this->url->link('marketplace/extension');
		$data['login'] = $this->url->link('account/login', '', true);
		$data['contact'] = $this->url->link('support/contact');
		$data['partner'] = $this->url->link('support/partner');
		$data['support'] = $this->url->link('support/support');
		$data['cart2cart'] = $this->url->link('cms/cart2cart');
		$data['forum'] = $this->config->get('config_forum_url') ?: $this->url->link('support/support');
		$data['blog'] = $this->url->link('cms/blog');
		$data['documentation'] = $this->config->get('config_docs_url') ?: $this->url->link('cms/guide');
		$data['book'] = $this->config->get('config_book_url') ?: $this->url->link('cms/guide');
		$data['github'] = $this->config->get('config_github_url') ?: 'https://github.com';
		$data['bug_tracker'] = $this->config->get('config_bug_tracker_url') ?: 'https://github.com';
		$data['developer'] = $this->config->get('config_developer_url') ?: $this->url->link('cms/information', 'information_id=2');
		$data['dedicated_support'] = $this->config->get('config_dedicated_support_url') ?: $this->url->link('support/support');
		$data['linkedin_url'] = $this->config->get('config_linkedin_url') ?: 'https://www.linkedin.com/company/5224021/';
		$data['facebook_url'] = $this->config->get('config_facebook_url') ?: 'https://www.facebook.com';
		$data['twitter_url'] = $this->config->get('config_twitter_url') ?: 'https://twitter.com';
		$data['terms'] = $this->url->link('cms/terms');
		$data['privacy'] = $this->url->link('cms/privacy');
		$data['refund'] = $this->url->link('cms/refund');
		$data['gdpr'] = $this->url->link('cms/gdpr');
		$data['advertise'] = $this->url->link('support/advertise');

		$data['informations'] = array();

		foreach ($this->model_cms_information->getInformations() as $result) {
			if (!empty($result['bottom'])) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('cms/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['scripts'] = $this->document->getScripts('footer');

		return $this->load->view('common/footer', $data);
	}
}

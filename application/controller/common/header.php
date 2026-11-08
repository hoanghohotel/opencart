<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$this->load->language('common/header');

		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$data['base'] = $this->config->get('config_ssl');
		} else {
			$data['base'] = $this->config->get('config_url');
		}

		require_once(DIR_SYSTEM . 'library/payment_gateway.php');
		$payment_gateway = new PaymentGateway($this->registry);

		$route = isset($this->request->get['route']) ? (string)$this->request->get['route'] : 'common/home';
		$site_name = trim((string)$this->config->get('config_name')) ?: $this->language->get('text_site_name');

		$description = $this->document->getDescription();
		if (!$description) {
			$config_meta_desc = trim((string)$this->config->get('config_meta_description'));
			$default_descriptions = array(
				'common/home'                => $config_meta_desc ?: $this->language->get('meta_description_home'),
				'cms/feature'                => $this->language->get('meta_description_feature'),
				'cms/demo'                   => $this->language->get('meta_description_demo'),
				'marketplace/extension'      => $this->language->get('meta_description_market'),
				'marketplace/extension/info' => $this->language->get('meta_description_ext_info'),
				'cms/blog'                   => $this->language->get('meta_description_blog'),
				'cms/blog/info'              => $this->language->get('meta_description_blog_info'),
				'cms/download'               => $this->language->get('meta_description_download'),
				'cms/download/download'      => $this->language->get('meta_description_dl_start'),
				'cms/download/history'       => $this->language->get('meta_description_dl_hist'),
				'cms/showcase'               => $this->language->get('meta_description_showcase'),
				'support/partner'            => $this->language->get('meta_description_partner'),
				'support/support'            => $this->language->get('meta_description_support'),
				'support/seller'             => $this->language->get('meta_description_seller'),
				'support/contact'            => $this->language->get('meta_description_contact'),
				'cloud/landing'              => $this->language->get('meta_description_cloud'),
				'account/login'              => $this->language->get('meta_description_login'),
				'account/register'           => $this->language->get('meta_description_register')
			);

			if (isset($default_descriptions[$route])) {
				$description = $default_descriptions[$route];
			} else {
				$page_title = trim($data['title']);
				$description = ($page_title ? $page_title . ' - ' : '') . ($config_meta_desc ?: $this->language->get('meta_description_default'));
			}
		}

		$keywords = $this->document->getKeywords();
		if (!$keywords) {
			$config_meta_kw = trim((string)$this->config->get('config_meta_keyword'));
			$keywords = $config_meta_kw ?: (strtolower($site_name) . ', ' . $this->language->get('meta_keywords_default'));
		}

		$links = $this->document->getLinks();
		$has_canonical = false;
		foreach ($links as $link) {
			if (isset($link['rel']) && strtolower($link['rel']) === 'canonical') {
				$has_canonical = true;
				break;
			}
		}

		if (!$has_canonical) {
			if ($route === 'common/home') {
				$canonical_url = $data['base'];
			} else {
				$canonical_params = array();
				foreach (array('extension_id', 'blog_id', 'blog_category_id', 'partner_id', 'download_id') as $param_key) {
					if (!empty($this->request->get[$param_key])) {
						$canonical_params[] = $param_key . '=' . urlencode((string)$this->request->get[$param_key]);
					}
				}
				$canonical_url = $this->url->link($route, implode('&', $canonical_params));
			}
			$this->document->addLink($canonical_url, 'canonical');
			$links = $this->document->getLinks();
		}

		$data['description'] = $description;
		$data['keywords'] = $keywords;
		$data['robots'] = 'index, follow';
		$data['agentfy_data'] = json_encode($payment_gateway->getFrontendConfig());
		$data['links'] = $links;
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts('header');
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');
		$data['logo'] = $this->config->get('config_name');

		$data['home'] = $this->url->link('common/home');
		$data['feature'] = $this->url->link('cms/feature');
		$data['demo'] = $this->url->link('cms/demo');
		$data['marketplace'] = $this->url->link('marketplace/extension');
		$data['extension'] = $this->url->link('marketplace/extension');
		$data['blog'] = $this->url->link('cms/blog');
		$data['download'] = $this->url->link('cms/download');
		$data['forum'] = $this->config->get('config_forum_url') ?: $this->url->link('support/support');
		$data['documentation'] = $this->config->get('config_docs_url') ?: $this->url->link('cms/guide');
		$data['book'] = $this->config->get('config_book_url') ?: $this->url->link('cms/guide');
		$data['github'] = $this->config->get('config_github_url') ?: 'https://github.com';
		$data['bug_tracker'] = $this->config->get('config_bug_tracker_url') ?: 'https://github.com';
		$data['facebook_community'] = $this->config->get('config_facebook_community_url') ?: 'https://www.facebook.com';
		$data['developer'] = $this->config->get('config_developer_url') ?: $this->url->link('cms/information', 'information_id=2');
		$data['cloud'] = $this->url->link('cloud/landing');
		$data['partner'] = $this->url->link('support/partner');
		$data['support'] = $this->url->link('support/support');
		$data['cart2cart'] = $this->url->link('cms/cart2cart');
		$data['showcase'] = $this->url->link('cms/showcase');
		$data['contact'] = $this->url->link('support/contact');

		$member_token = isset($this->session->data['member_token']) ? 'member_token=' . $this->session->data['member_token'] : '';

		$data['logged'] = $this->member->isLogged();
		$data['login'] = $this->url->link('account/login', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['account'] = $this->url->link('account/account', $member_token, true);
		$data['logout'] = $this->url->link('account/logout', '', true);

		return $this->load->view('common/header', $data);
	}
}

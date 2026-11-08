<?php
class ControllerCmsSitemap extends Controller {
	public function index() {
		$base = $this->request->server['HTTPS'] ? $this->config->get('config_ssl') : $this->config->get('config_url');

		$output  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

		$core_routes = array(
			array('loc' => $base,                                           'changefreq' => 'daily',   'priority' => '1.0'),
			array('loc' => $this->url->link('cms/feature'),                 'changefreq' => 'weekly',  'priority' => '0.9'),
			array('loc' => $this->url->link('cms/demo'),                    'changefreq' => 'weekly',  'priority' => '0.9'),
			array('loc' => $this->url->link('marketplace/extension'),       'changefreq' => 'daily',   'priority' => '0.9'),
			array('loc' => $this->url->link('cms/blog'),                    'changefreq' => 'daily',   'priority' => '0.8'),
			array('loc' => $this->url->link('cms/download'),                'changefreq' => 'weekly',  'priority' => '0.9'),
			array('loc' => $this->url->link('cms/download/history'),        'changefreq' => 'monthly', 'priority' => '0.7'),
			array('loc' => $this->url->link('cms/showcase'),                'changefreq' => 'weekly',  'priority' => '0.8'),
			array('loc' => $this->url->link('cloud/landing'),               'changefreq' => 'weekly',  'priority' => '0.8'),
			array('loc' => $this->url->link('support/partner'),             'changefreq' => 'weekly',  'priority' => '0.8'),
			array('loc' => $this->url->link('support/support'),             'changefreq' => 'monthly', 'priority' => '0.7'),
			array('loc' => $this->url->link('support/contact'),             'changefreq' => 'monthly', 'priority' => '0.7'),
			array('loc' => $this->url->link('cms/company'),                 'changefreq' => 'monthly', 'priority' => '0.6'),
			array('loc' => $this->url->link('cms/policy'),                  'changefreq' => 'yearly',  'priority' => '0.5'),
			array('loc' => $this->url->link('cms/terms'),                   'changefreq' => 'yearly',  'priority' => '0.5'),
		);

		foreach ($core_routes as $item) {
			$loc = htmlspecialchars(html_entity_decode($item['loc'], ENT_QUOTES, 'UTF-8'), ENT_XML1 | ENT_QUOTES, 'UTF-8');
			$output .= "  <url>\n";
			$output .= "    <loc>" . $loc . "</loc>\n";
			$output .= "    <changefreq>" . $item['changefreq'] . "</changefreq>\n";
			$output .= "    <priority>" . $item['priority'] . "</priority>\n";
			$output .= "  </url>\n";
		}

		// Include active marketplace extensions
		$this->load->model('marketplace/extension');
		$extensions = $this->model_marketplace_extension->getExtensions(array('start' => 0, 'limit' => 100));
		foreach ($extensions as $ext) {
			if (!empty($ext['extension_id'])) {
				$loc = htmlspecialchars(html_entity_decode($this->url->link('marketplace/extension/info', 'extension_id=' . (int)$ext['extension_id']), ENT_QUOTES, 'UTF-8'), ENT_XML1 | ENT_QUOTES, 'UTF-8');
				$output .= "  <url>\n";
				$output .= "    <loc>" . $loc . "</loc>\n";
				$output .= "    <changefreq>weekly</changefreq>\n";
				$output .= "    <priority>0.8</priority>\n";
				$output .= "  </url>\n";
			}
		}

		// Include active blog articles
		$this->load->model('cms/blog');
		$blogs = $this->model_cms_blog->getBlogs(array('start' => 0, 'limit' => 100));
		foreach ($blogs as $blog) {
			if (!empty($blog['blog_id'])) {
				$loc = htmlspecialchars(html_entity_decode($this->url->link('cms/blog/info', 'blog_id=' . (int)$blog['blog_id']), ENT_QUOTES, 'UTF-8'), ENT_XML1 | ENT_QUOTES, 'UTF-8');
				$output .= "  <url>\n";
				$output .= "    <loc>" . $loc . "</loc>\n";
				$output .= "    <changefreq>monthly</changefreq>\n";
				$output .= "    <priority>0.7</priority>\n";
				$output .= "  </url>\n";
			}
		}

		$output .= '</urlset>' . "\n";

		$this->response->addHeader('Content-Type: application/xml; charset=utf-8');
		$this->response->addHeader('Cache-Control: no-cache, no-store, must-revalidate');
		$this->response->setOutput($output);
	}

	public function robots() {
		$is_https = (!empty($this->request->server['HTTPS']) && $this->request->server['HTTPS'] !== 'off')
			|| (isset($this->request->server['SERVER_PORT']) && (int)$this->request->server['SERVER_PORT'] === 443)
			|| (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && strtolower($this->request->server['HTTP_X_FORWARDED_PROTO']) === 'https');

		$base = rtrim($is_https ? $this->config->get('config_ssl') : $this->config->get('config_url'), '/') . '/';

		$lines = array(
			'User-agent: *',
			'Allow: /',
			'Disallow: /admin/',
			'Disallow: /install/',
			'Disallow: /system/',
			'',
			'Sitemap: ' . $base . 'sitemap.xml'
		);

		$this->response->addHeader('Content-Type: text/plain; charset=utf-8');
		$this->response->addHeader('Cache-Control: no-cache, no-store, must-revalidate');
		$this->response->setOutput(implode("\n", $lines) . "\n");
	}
}

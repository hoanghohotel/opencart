<?php
class ControllerCommonFooter extends Controller {
	public function index() {
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
		$data['forum'] = 'https://forum.opencart.com';
		$data['blog'] = $this->url->link('cms/blog');
		$data['documentation'] = 'https://docs.opencart.com';
		$data['book'] = 'https://docs.opencart.com/#additional-reading';
		$data['bug_tracker'] = 'https://github.com/opencart/opencart/issues';
		$data['developer'] = 'https://docs.opencart.com/developer/module/';
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

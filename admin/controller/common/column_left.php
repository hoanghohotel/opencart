<?php
class ControllerCommonColumnLeft extends Controller {
	public function index() {
		if (isset($this->request->get['user_token']) && isset($this->session->data['user_token']) && ($this->request->get['user_token'] == $this->session->data['user_token'])) {
			$this->load->language('common/column_left');

			$data['menus'] = array();

			// Dashboard
			$data['menus'][] = array(
				'id'       => 'menu-dashboard',
				'icon'	   => 'fa-dashboard',
				'name'	   => $this->language->get('text_dashboard'),
				'href'     => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
				'children' => array()
			);

			// Marketplace
			$marketplace = array();

			if ($this->user->hasPermission('access', 'marketplace/category')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_category'),
					'href'     => $this->url->link('marketplace/category', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketplace/extension')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_extension'),
					'href'     => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketplace/comment')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_comment'),
					'href'     => $this->url->link('marketplace/comment', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'marketplace/promotion')) {
				$marketplace[] = array(
					'name'	   => $this->language->get('text_promotion'),
					'href'     => $this->url->link('marketplace/promotion', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($marketplace) {
				$data['menus'][] = array(
					'id'       => 'menu-marketplace',
					'icon'	   => 'fa-puzzle-piece',
					'name'	   => $this->language->get('text_marketplace'),
					'href'     => '',
					'children' => $marketplace
				);
			}

			// CMS
			$cms = array();

			if ($this->user->hasPermission('access', 'cms/download')) {
				$cms[] = array(
					'name'	   => $this->language->get('text_download'),
					'href'     => $this->url->link('cms/download', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'cms/blog_category')) {
				$cms[] = array(
					'name'	   => $this->language->get('text_blog_category'),
					'href'     => $this->url->link('cms/blog_category', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'cms/blog')) {
				$cms[] = array(
					'name'	   => $this->language->get('text_blog'),
					'href'     => $this->url->link('cms/blog', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'cms/blog_comment')) {
				$cms[] = array(
					'name'	   => $this->language->get('text_blog_comment'),
					'href'     => $this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'cms/showcase')) {
				$cms[] = array(
					'name'	   => $this->language->get('text_showcase'),
					'href'     => $this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'cms/information')) {
				$cms[] = array(
					'name'	   => $this->language->get('text_information'),
					'href'     => $this->url->link('cms/information', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($cms) {
				$data['menus'][] = array(
					'id'       => 'menu-cms',
					'icon'	   => 'fa-newspaper-o',
					'name'	   => $this->language->get('text_cms'),
					'href'     => '',
					'children' => $cms
				);
			}

			// Members
			$members = array();

			if ($this->user->hasPermission('access', 'member/member')) {
				$members[] = array(
					'name'	   => $this->language->get('text_member'),
					'href'     => $this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'member/seller')) {
				$members[] = array(
					'name'	   => $this->language->get('text_seller'),
					'href'     => $this->url->link('member/seller', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'member/partner')) {
				$members[] = array(
					'name'	   => $this->language->get('text_partner'),
					'href'     => $this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($members) {
				$data['menus'][] = array(
					'id'       => 'menu-member',
					'icon'	   => 'fa-user',
					'name'	   => $this->language->get('text_members'),
					'href'     => '',
					'children' => $members
				);
			}

			// Sales & Cloud
			$sale = array();

			if ($this->user->hasPermission('access', 'sale/order')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_order'),
					'href'     => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'cloud/subscription')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_cloud_subscription'),
					'href'     => $this->url->link('cloud/subscription', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'support/enquiry')) {
				$sale[] = array(
					'name'	   => $this->language->get('text_enquiry'),
					'href'     => $this->url->link('support/enquiry', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($sale) {
				$data['menus'][] = array(
					'id'       => 'menu-sale',
					'icon'	   => 'fa-shopping-cart',
					'name'	   => $this->language->get('text_sale'),
					'href'     => '',
					'children' => $sale
				);
			}

			// Design
			$design = array();

			if ($this->user->hasPermission('access', 'design/banner')) {
				$design[] = array(
					'name'	   => $this->language->get('text_banner'),
					'href'     => $this->url->link('design/banner', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'design/seo_url')) {
				$design[] = array(
					'name'	   => $this->language->get('text_seo_url'),
					'href'     => $this->url->link('design/seo_url', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($design) {
				$data['menus'][] = array(
					'id'       => 'menu-design',
					'icon'	   => 'fa-television',
					'name'	   => $this->language->get('text_design'),
					'href'     => '',
					'children' => $design
				);
			}

			// System
			$system = array();

			if ($this->user->hasPermission('access', 'setting/setting')) {
				$system[] = array(
					'name'	   => $this->language->get('text_setting'),
					'href'     => $this->url->link('setting/setting', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'setting/payment')) {
				$system[] = array(
					'name'	   => $this->language->get('text_payment'),
					'href'     => $this->url->link('setting/payment', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			// Users
			$user = array();

			if ($this->user->hasPermission('access', 'user/user')) {
				$user[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => $this->url->link('user/user', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'user/user_permission')) {
				$user[] = array(
					'name'	   => $this->language->get('text_user_group'),
					'href'     => $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'user/api')) {
				$user[] = array(
					'name'	   => $this->language->get('text_api'),
					'href'     => $this->url->link('user/api', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($user) {
				$system[] = array(
					'name'	   => $this->language->get('text_users'),
					'href'     => '',
					'children' => $user
				);
			}

			// Localisation
			$localisation = array();

			if ($this->user->hasPermission('access', 'localisation/language')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_language'),
					'href'     => $this->url->link('localisation/language', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/currency')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_currency'),
					'href'     => $this->url->link('localisation/currency', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/order_status')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_order_status'),
					'href'     => $this->url->link('localisation/order_status', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/country')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_country'),
					'href'     => $this->url->link('localisation/country', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'localisation/zone')) {
				$localisation[] = array(
					'name'	   => $this->language->get('text_zone'),
					'href'     => $this->url->link('localisation/zone', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($localisation) {
				$system[] = array(
					'id'       => 'menu-localisation',
					'icon'	   => 'fa-cog',
					'name'	   => $this->language->get('text_localisation'),
					'href'     => '',
					'children' => $localisation
				);
			}

			// Maintenance
			$maintenance = array();

			if ($this->user->hasPermission('access', 'tool/backup')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_backup'),
					'href'     => $this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'tool/upload')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_upload'),
					'href'     => $this->url->link('tool/upload', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'tool/log')) {
				$maintenance[] = array(
					'name'	   => $this->language->get('text_log'),
					'href'     => $this->url->link('tool/log', 'user_token=' . $this->session->data['user_token'], true),
					'children' => array()
				);
			}

			if ($maintenance) {
				$system[] = array(
					'id'       => 'menu-maintenance',
					'icon'	   => 'fa-cog',
					'name'	   => $this->language->get('text_maintenance'),
					'href'     => '',
					'children' => $maintenance
				);
			}

			if ($system) {
				$data['menus'][] = array(
					'id'       => 'menu-system',
					'icon'	   => 'fa-cog',
					'name'	   => $this->language->get('text_system'),
					'href'     => '',
					'children' => $system
				);
			}

			// Stats from sale/order
			$this->load->model('sale/order');

			$order_total = (float)$this->model_sale_order->getTotalOrders();

			if ($order_total > 0) {
				$complete_total = (float)$this->model_sale_order->getTotalOrders(array('filter_order_status_id' => 5));
				$processing_total = (float)$this->model_sale_order->getTotalOrders(array('filter_order_status_id' => 2));
				$other_total = max(0, $order_total - $complete_total - $processing_total);

				$data['complete_status'] = round(($complete_total / $order_total) * 100);
				$data['processing_status'] = round(($processing_total / $order_total) * 100);
				$data['other_status'] = round(($other_total / $order_total) * 100);
			} else {
				$data['complete_status'] = 0;
				$data['processing_status'] = 0;
				$data['other_status'] = 0;
			}

			$data['statistics_status'] = true;

			return $this->load->view('common/column_left', $data);
		}
	}
}

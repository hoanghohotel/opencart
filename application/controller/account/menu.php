<?php
class ControllerAccountMenu extends Controller {
	public function index() {
		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

		$this->load->language('account/menu');

		$token = 'member_token=' . $this->session->data['member_token'];

		$data['account'] = $this->url->link('account/account', $token, true);

		if (isset($this->request->get['route'])) {
			$raw_route = $this->request->get['route'];
		} else {
			$raw_route = 'account/account';
		}

		if ($raw_route === 'account/extension/comment') {
			$data['route'] = 'account/extension/comment';
		} elseif (strpos($raw_route, 'account/subscription/domain') === 0 || strpos($raw_route, 'account/subscription/addDomain') === 0 || strpos($raw_route, 'account/subscription/editDomain') === 0) {
			$data['route'] = 'account/subscription/domain';
		} elseif (strpos($raw_route, 'account/subscription/invoice') === 0) {
			$data['route'] = 'account/subscription/invoice';
		} else {
			$parts = explode('/', $raw_route);
			if (count($parts) >= 2) {
				$data['route'] = $parts[0] . '/' . $parts[1];
			} else {
				$data['route'] = $raw_route;
			}
		}

		$data['menus'] = array();

		// Account
		$account_children = array(
			array(
				'value'   => 'account/edit',
				'icon'    => 'user',
				'text'    => $this->language->get('text_menu_edit'),
				'tooltip' => $this->language->get('text_menu_edit_tip'),
				'href'    => $this->url->link('account/edit', $token, true)
			),
			array(
				'value'   => 'account/password',
				'icon'    => 'key',
				'text'    => $this->language->get('text_menu_password'),
				'tooltip' => $this->language->get('text_menu_password_tip'),
				'href'    => $this->url->link('account/password', $token, true)
			),
			array(
				'value'   => 'account/payment',
				'icon'    => 'credit-card',
				'text'    => $this->language->get('text_menu_payment'),
				'tooltip' => $this->language->get('text_menu_payment_tip'),
				'href'    => $this->url->link('account/payment', $token, true)
			),
			array(
				'value'   => 'account/showcase',
				'icon'    => 'laptop',
				'text'    => $this->language->get('text_menu_showcase'),
				'tooltip' => $this->language->get('text_menu_showcase_tip'),
				'href'    => $this->url->link('account/showcase', $token, true)
			),
			array(
				'value'   => 'account/partner',
				'icon'    => 'users',
				'text'    => $this->member->isPartner() ? $this->language->get('text_menu_partner_edit') : $this->language->get('text_menu_partner_up'),
				'tooltip' => $this->member->isPartner() ? $this->language->get('text_menu_partner_edit_tip') : $this->language->get('text_menu_partner_up_tip'),
				'href'    => $this->url->link('account/partner', $token, true)
			)
		);

		$data['menus'][] = array(
			'text'     => $this->language->get('text_menu_account'),
			'children' => $account_children
		);

		// Purchases
		$purchase_children = array(
			array(
				'value'   => 'account/order',
				'icon'    => 'shopping-cart',
				'text'    => $this->language->get('text_menu_order'),
				'tooltip' => $this->language->get('text_menu_order_tip'),
				'href'    => $this->url->link('account/order', $token, true)
			),
			array(
				'value'   => 'account/download',
				'icon'    => 'cloud-download',
				'text'    => $this->language->get('text_menu_download'),
				'tooltip' => $this->language->get('text_menu_download_tip'),
				'href'    => $this->url->link('account/download', $token, true)
			),
			array(
				'value'   => 'account/store',
				'icon'    => 'globe',
				'text'    => $this->language->get('text_menu_store'),
				'tooltip' => $this->language->get('text_menu_store_tip'),
				'href'    => $this->url->link('account/store', $token, true)
			),
			array(
				'value'   => 'account/rating',
				'icon'    => 'star',
				'text'    => $this->language->get('text_menu_rating'),
				'tooltip' => $this->language->get('text_menu_rating_tip'),
				'href'    => $this->url->link('account/rating', $token, true)
			)
		);

		$data['menus'][] = array(
			'text'     => $this->language->get('text_menu_purchases'),
			'children' => $purchase_children
		);

		// Extensions
		$extension_children = array(
			array(
				'value'   => 'account/extension',
				'icon'    => 'puzzle-piece',
				'text'    => $this->language->get('text_menu_extension'),
				'tooltip' => $this->language->get('text_menu_extension_tip'),
				'href'    => $this->url->link('account/extension', $token, true)
			),
			array(
				'value'   => 'account/seller',
				'icon'    => 'briefcase',
				'text'    => $this->member->isSeller() ? $this->language->get('text_menu_seller_edit') : $this->language->get('text_menu_seller_apply'),
				'tooltip' => $this->member->isSeller() ? $this->language->get('text_menu_seller_edit_tip') : $this->language->get('text_menu_seller_apply_tip'),
				'href'    => $this->url->link('account/seller', $token, true)
			)
		);

		if ($this->member->isSeller()) {
			$extension_children[] = array(
				'value'   => 'account/sale',
				'icon'    => 'line-chart',
				'text'    => $this->language->get('text_menu_sale'),
				'tooltip' => $this->language->get('text_menu_sale_tip'),
				'href'    => $this->url->link('account/sale', $token, true)
			);

			$extension_children[] = array(
				'value'   => 'account/transaction',
				'icon'    => 'dollar',
				'text'    => $this->language->get('text_menu_transaction'),
				'tooltip' => $this->language->get('text_menu_transaction_tip'),
				'href'    => $this->url->link('account/transaction', $token, true)
			);
		}

		$extension_children[] = array(
			'value'   => 'account/extension/comment',
			'icon'    => 'comments',
			'text'    => $this->language->get('text_menu_comment'),
			'tooltip' => $this->language->get('text_menu_comment_tip'),
			'href'    => $this->url->link('account/extension/comment', $token, true)
		);

		$data['menus'][] = array(
			'text'     => $this->language->get('text_menu_extensions'),
			'children' => $extension_children
		);

		// Cloud Stores
		if ($this->member->hasCloud() || $this->member->isModerator()) {
			$cloud_children = array(
				array(
					'value'   => 'account/subscription',
					'icon'    => 'cloud',
					'text'    => $this->language->get('text_menu_cloud_stores'),
					'tooltip' => $this->language->get('text_menu_cloud_stores_tip'),
					'href'    => $this->url->link('account/subscription', $token, true)
				),
				array(
					'value'   => 'account/subscription/domain',
					'icon'    => 'globe',
					'text'    => $this->language->get('text_menu_cloud_domains'),
					'tooltip' => $this->language->get('text_menu_cloud_domains_tip'),
					'href'    => $this->url->link('account/subscription/domain', $token, true)
				),
				array(
					'value'   => 'account/subscription/invoice',
					'icon'    => 'file-text-o',
					'text'    => $this->language->get('text_menu_invoices'),
					'tooltip' => $this->language->get('text_menu_invoices_tip'),
					'href'    => $this->url->link('account/subscription/invoice', $token, true)
				)
			);

			$data['menus'][] = array(
				'text'     => $this->language->get('text_menu_cloud_section'),
				'children' => $cloud_children
			);
		}

		return $this->load->view('account/menu', $data);
	}
}

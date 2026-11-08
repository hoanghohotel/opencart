<?php
class ControllerAccountMenu extends Controller {
	public function index() {
		if (empty($this->session->data['member_token'])) {
			$this->session->data['member_token'] = token(32);
		}

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
				'text'    => 'Account Details',
				'tooltip' => 'Edit your account details',
				'href'    => $this->url->link('account/edit', $token, true)
			),
			array(
				'value'   => 'account/password',
				'icon'    => 'key',
				'text'    => 'Change Password',
				'tooltip' => 'Reset your password',
				'href'    => $this->url->link('account/password', $token, true)
			),
			array(
				'value'   => 'account/payment',
				'icon'    => 'credit-card',
				'text'    => 'Payment Methods',
				'tooltip' => 'Modify your payment methods',
				'href'    => $this->url->link('account/payment', $token, true)
			),
			array(
				'value'   => 'account/showcase',
				'icon'    => 'laptop',
				'text'    => 'Showcase',
				'tooltip' => 'Submit your store to OpenCart\'s showcase',
				'href'    => $this->url->link('account/showcase', $token, true)
			),
			array(
				'value'   => 'account/partner',
				'icon'    => 'users',
				'text'    => $this->member->isPartner() ? 'Edit Partner Information' : 'Partner Up',
				'tooltip' => $this->member->isPartner() ? 'Change your address, logo' : 'Apply to become a partner',
				'href'    => $this->url->link('account/partner', $token, true)
			)
		);

		$data['menus'][] = array(
			'text'     => ' Account',
			'children' => $account_children
		);

		// Purchases
		$purchase_children = array(
			array(
				'value'   => 'account/order',
				'icon'    => 'shopping-cart',
				'text'    => 'Your Orders',
				'tooltip' => 'View the extensions you have previously purchased',
				'href'    => $this->url->link('account/order', $token, true)
			),
			array(
				'value'   => 'account/download',
				'icon'    => 'cloud-download',
				'text'    => 'Your Downloads',
				'tooltip' => 'Your Purchased extensions',
				'href'    => $this->url->link('account/download', $token, true)
			),
			array(
				'value'   => 'account/store',
				'icon'    => 'globe',
				'text'    => 'Your Stores',
				'tooltip' => 'Register your store to access the marketplace API',
				'href'    => $this->url->link('account/store', $token, true)
			),
			array(
				'value'   => 'account/rating',
				'icon'    => 'star',
				'text'    => 'Rate your Downloads',
				'tooltip' => 'Rate your previously downloaded extensions',
				'href'    => $this->url->link('account/rating', $token, true)
			)
		);

		$data['menus'][] = array(
			'text'     => ' Purchases',
			'children' => $purchase_children
		);

		// Extensions
		$extension_children = array(
			array(
				'value'   => 'account/extension',
				'icon'    => 'puzzle-piece',
				'text'    => 'Manage your Extensions',
				'tooltip' => 'Manage the extensions you have uploaded',
				'href'    => $this->url->link('account/extension', $token, true)
			),
			array(
				'value'   => 'account/seller',
				'icon'    => 'briefcase',
				'text'    => $this->member->isSeller() ? 'Edit Seller Information' : 'Apply to become a seller',
				'tooltip' => $this->member->isSeller() ? 'Modify your current seller details' : 'Get paid by selling your work!',
				'href'    => $this->url->link('account/seller', $token, true)
			)
		);

		if ($this->member->isSeller()) {
			$extension_children[] = array(
				'value'   => 'account/sale',
				'icon'    => 'line-chart',
				'text'    => 'Sales',
				'tooltip' => 'View your Sales',
				'href'    => $this->url->link('account/sale', $token, true)
			);

			$extension_children[] = array(
				'value'   => 'account/transaction',
				'icon'    => 'dollar',
				'text'    => 'Transactions',
				'tooltip' => 'View your commission rate for sales',
				'href'    => $this->url->link('account/transaction', $token, true)
			);
		}

		$extension_children[] = array(
			'value'   => 'account/extension/comment',
			'icon'    => 'comments',
			'text'    => 'Extensions Comments',
			'tooltip' => 'Manage the comments member left under your extensions',
			'href'    => $this->url->link('account/extension/comment', $token, true)
		);

		$data['menus'][] = array(
			'text'     => ' Extensions',
			'children' => $extension_children
		);

		// Cloud Stores
		if ($this->member->hasCloud() || $this->member->isModerator()) {
			$cloud_children = array(
				array(
					'value'   => 'account/subscription',
					'icon'    => 'cloud',
					'text'    => 'Cloud Stores',
					'tooltip' => 'View all of your OpenCart Cloud Stores',
					'href'    => $this->url->link('account/subscription', $token, true)
				),
				array(
					'value'   => 'account/subscription/domain',
					'icon'    => 'globe',
					'text'    => 'Cloud Domains',
					'tooltip' => 'View all of your OpenCart Cloud Domains',
					'href'    => $this->url->link('account/subscription/domain', $token, true)
				),
				array(
					'value'   => 'account/subscription/invoice',
					'icon'    => 'file-text-o',
					'text'    => 'Invoices',
					'tooltip' => 'Check your subscription invoice(s)',
					'href'    => $this->url->link('account/subscription/invoice', $token, true)
				)
			);

			$data['menus'][] = array(
				'text'     => ' Cloud Stores',
				'children' => $cloud_children
			);
		}

		return $this->load->view('account/menu', $data);
	}
}

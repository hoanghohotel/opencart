<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['user_token'] = $this->session->data['user_token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['error_install'] = '';
		$data['security'] = '';

		// 1. KPI Summary Cards
		$ext_query = $this->db->query("SELECT COUNT(*) AS total, SUM(downloaded) AS downloads FROM `" . DB_PREFIX . "extension`");
		$data['total_extensions'] = (int)$ext_query->row['total'];
		$data['total_downloads'] = number_format((int)$ext_query->row['downloads']);
		$data['link_extensions'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

		$member_query = $this->db->query("SELECT COUNT(*) AS total, SUM(CASE WHEN seller_status = 1 THEN 1 ELSE 0 END) AS sellers FROM `" . DB_PREFIX . "member`");
		$data['total_members'] = (int)$member_query->row['total'];
		$data['total_sellers'] = (int)$member_query->row['sellers'];
		$data['link_members'] = $this->url->link('member/member', 'user_token=' . $this->session->data['user_token'], true);

		$order_query = $this->db->query("SELECT COUNT(*) AS total, COALESCE(SUM(total), 0) AS revenue FROM `" . DB_PREFIX . "order`");
		$data['total_orders'] = (int)$order_query->row['total'];
		$data['total_revenue'] = $this->currency->format((float)$order_query->row['revenue'], $this->config->get('config_currency'));
		$data['link_orders'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true);

		$partner_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "member_partner`");
		$showcase_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "showcase`");
		$data['total_partners'] = (int)$partner_query->row['total'];
		$data['total_showcases'] = (int)$showcase_query->row['total'];
		$data['link_partners'] = $this->url->link('member/partner', 'user_token=' . $this->session->data['user_token'], true);
		$data['link_showcases'] = $this->url->link('cms/showcase', 'user_token=' . $this->session->data['user_token'], true);

		// 2. Recent Marketplace Orders
		$data['orders'] = array();

		$orders_query = $this->db->query("SELECT o.*, CONCAT(m.firstname, ' ', m.lastname) AS buyer_name, m.username AS buyer_username, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` m ON (o.member_id = m.member_id) ORDER BY o.date_added DESC LIMIT 6");

		foreach ($orders_query->rows as $result) {
			$order_status = $result['order_status'] ? $result['order_status'] : 'Complete';
			$status_lower = strtolower(trim((string)$order_status));
			$status_id = isset($result['order_status_id']) ? (int)$result['order_status_id'] : 5;

			if ($status_id === 5 || strpos($status_lower, 'complete') !== false) {
				$status_class = 'label-success';
			} elseif ($status_id === 3 || strpos($status_lower, 'paid') !== false) {
				$status_class = 'label-primary';
			} elseif ($status_id === 2 || $status_id === 15 || strpos($status_lower, 'process') !== false) {
				$status_class = 'label-info';
			} elseif ($status_id === 1 || $status_id === 9 || strpos($status_lower, 'pending') !== false) {
				$status_class = 'label-warning';
			} elseif (in_array($status_id, array(7, 8, 10, 12, 13), true) || strpos($status_lower, 'cancel') !== false || strpos($status_lower, 'fail') !== false || strpos($status_lower, 'denied') !== false) {
				$status_class = 'label-danger';
			} elseif (in_array($status_id, array(11, 14, 16), true) || strpos($status_lower, 'refund') !== false || strpos($status_lower, 'void') !== false || strpos($status_lower, 'expir') !== false) {
				$status_class = 'label-default';
			} else {
				$status_class = 'label-info';
			}

			$data['orders'][] = array(
				'order_id'     => $result['order_id'],
				'buyer'        => $result['buyer_name'] ? $result['buyer_name'] . ' (' . $result['buyer_username'] . ')' : 'Member #' . $result['member_id'],
				'extension'    => $result['extension'],
				'status'       => $order_status,
				'status_class' => $status_class,
				'total'        => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'date_added'   => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'         => $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'], true)
			);
		}

		// 3. Latest Registered Members
		$data['members'] = array();

		$members_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "member` ORDER BY date_added DESC LIMIT 6");

		foreach ($members_query->rows as $result) {
			$data['members'][] = array(
				'member_id'     => $result['member_id'],
				'username'      => $result['username'],
				'name'          => $result['firstname'] . ' ' . $result['lastname'],
				'email'         => $result['email'],
				'seller_status' => $result['seller_status'],
				'status'        => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'          => $this->url->link('member/member/edit', 'user_token=' . $this->session->data['user_token'] . '&member_id=' . $result['member_id'], true)
			);
		}

		// 4. Latest Marketplace Extensions
		$data['extensions'] = array();

		$extensions_query = $this->db->query("SELECT e.*, ec.name AS category_name, m.username AS seller_username FROM `" . DB_PREFIX . "extension` e LEFT JOIN `" . DB_PREFIX . "extension_category` ec ON (e.extension_category_id = ec.extension_category_id) LEFT JOIN `" . DB_PREFIX . "member` m ON (e.member_id = m.member_id) ORDER BY e.date_modified DESC LIMIT 8");

		foreach ($extensions_query->rows as $result) {
			$data['extensions'][] = array(
				'extension_id' => $result['extension_id'],
				'name'         => $result['name'],
				'category'     => $result['category_name'],
				'seller'       => $result['seller_username'],
				'license'      => $result['license'] ? $this->language->get('text_commercial') : $this->language->get('text_free'),
				'price'        => $result['license'] ? $this->currency->format($result['price'], $this->config->get('config_currency')) : $this->language->get('text_free'),
				'stats'        => $result['license'] ? number_format((int)$result['sales']) . ' sales' : number_format((int)$result['downloaded']) . ' downloads',
				'status'       => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'         => $this->url->link('marketplace/extension/edit', 'user_token=' . $this->session->data['user_token'] . '&extension_id=' . $result['extension_id'], true)
			);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/dashboard', $data));
	}
}

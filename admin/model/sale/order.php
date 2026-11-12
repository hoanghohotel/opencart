<?php
class ModelSaleOrder extends Model {
	public function addOrder($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET member_id = '" . (int)$data['member_id'] . "', seller_id = '" . (int)$data['seller_id'] . "', extension_id = '" . (int)$data['extension_id'] . "', extension = '" . $this->db->escape($data['extension']) . "', quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', ip = '127.0.0.1', date_added = NOW(), date_modified = NOW()");

		return $this->db->getLastId();
	}

	public function editOrder($order_id, $data) {
		$old_order = $this->getOrder($order_id);

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET member_id = '" . (int)$data['member_id'] . "', seller_id = '" . (int)$data['seller_id'] . "', extension_id = '" . (int)$data['extension_id'] . "', extension = '" . $this->db->escape($data['extension']) . "', quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "', total = '" . (float)$data['total'] . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', transaction_id = '" . $this->db->escape($data['transaction_id']) . "', order_status_id = '" . (int)$data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

		if (!$old_order || (int)$old_order['order_status_id'] !== (int)$data['order_status_id']) {
			$this->sendOrderStatusEmails($order_id, (int)$data['order_status_id'], isset($data['comment']) ? $data['comment'] : '');
		}
	}

	public function updateOrderStatus($order_id, $order_status_id, $comment = '') {
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

		return $this->sendOrderStatusEmails($order_id, (int)$order_status_id, $comment);
	}

	public function sendOrderStatusEmails($order_id, $order_status_id, $comment = '') {
		$this->load->language('sale/order');

		$order_info = $this->getOrder($order_id);

		if (!$order_info) {
			return array('buyer_sent' => false, 'seller_sent' => false);
		}

		$status_name = !empty($order_info['order_status']) ? $order_info['order_status'] : 'Updated';
		$store_name = html_entity_decode($this->config->get('config_name') ?: 'OpenCart Marketplace', ENT_QUOTES, 'UTF-8');
		$catalog_url = defined('HTTP_CATALOG') ? rtrim(HTTP_CATALOG, '/') . '/' : rtrim(HTTP_SERVER, '/') . '/';
		$default_host = parse_url($catalog_url, PHP_URL_HOST) ?: 'localhost';
		$from_email = $this->config->get('config_email') ?: ('noreply@' . $default_host);
		$total_formatted = $this->currency->format($order_info['total'], $this->config->get('config_currency'));
		$comment_clean = trim((string)$comment);

		$buyer_email = !empty($order_info['buyer_email']) && filter_var($order_info['buyer_email'], FILTER_VALIDATE_EMAIL) ? $order_info['buyer_email'] : '';
		$seller_email = '';
		if (!empty($order_info['seller_support_email']) && filter_var($order_info['seller_support_email'], FILTER_VALIDATE_EMAIL)) {
			$seller_email = $order_info['seller_support_email'];
		} elseif (!empty($order_info['seller_email']) && filter_var($order_info['seller_email'], FILTER_VALIDATE_EMAIL)) {
			$seller_email = $order_info['seller_email'];
		}

		$result = array(
			'order_id'     => (int)$order_id,
			'order_status' => $status_name,
			'buyer_email'  => $buyer_email,
			'seller_email' => $seller_email,
			'buyer_sent'   => false,
			'seller_sent'  => false
		);

		$buyer_orders_url = $catalog_url . 'index.php?route=account/order';
		$buyer_downloads_url = $catalog_url . 'index.php?route=account/download';
		$seller_sales_url = $catalog_url . 'index.php?route=account/sale';
		$seller_transactions_url = $catalog_url . 'index.php?route=account/transaction';

		// 1. Send email to Buyer
		if ($buyer_email) {
			$buyer_name = trim($order_info['buyer_name']) ? trim($order_info['buyer_name']) : $order_info['buyer_username'];
			$subject = html_entity_decode(sprintf($this->language->get('text_mail_buyer_subject'), $store_name, $order_id, $status_name), ENT_QUOTES, 'UTF-8');

			$text  = sprintf($this->language->get('text_mail_greeting'), $buyer_name) . "\n\n";
			$text .= sprintf($this->language->get('text_mail_buyer_intro'), $order_id, $status_name) . "\n\n";
			$text .= $this->language->get('column_order_id') . ": #" . $order_id . "\n";
			$text .= $this->language->get('column_extension') . ": " . $order_info['extension'] . "\n";
			$text .= $this->language->get('column_total') . ": " . $total_formatted . "\n";
			$text .= $this->language->get('column_status') . ": " . $status_name . "\n";
			if ($comment_clean !== '') {
				$text .= "\n" . $this->language->get('entry_comment') . ":\n" . $comment_clean . "\n";
			}
			$text .= "\n" . $this->language->get('text_mail_buyer_links') . "\n";
			$text .= "- " . $buyer_orders_url . "\n";
			$text .= "- " . $buyer_downloads_url . "\n\n";
			$text .= sprintf($this->language->get('text_mail_footer'), $store_name) . "\n";

			$html  = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;border:1px solid #e5e5e5;border-radius:4px;">';
			$html .= '<h2 style="color:#1e91cf;margin-top:0;">' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</h2>';
			$html .= '<p>' . htmlspecialchars(sprintf($this->language->get('text_mail_greeting'), $buyer_name), ENT_QUOTES, 'UTF-8') . '</p>';
			$html .= '<p>' . htmlspecialchars(sprintf($this->language->get('text_mail_buyer_intro'), $order_id, $status_name), ENT_QUOTES, 'UTF-8') . '</p>';
			$html .= '<table style="width:100%;border-collapse:collapse;margin:15px 0;font-size:14px;">';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_order_id'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;">#' . (int)$order_id . '</td></tr>';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_extension'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($order_info['extension'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_total'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($total_formatted, ENT_QUOTES, 'UTF-8') . '</td></tr>';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_status'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($status_name, ENT_QUOTES, 'UTF-8') . '</strong></td></tr>';
			$html .= '</table>';
			if ($comment_clean !== '') {
				$html .= '<p><strong>' . htmlspecialchars($this->language->get('entry_comment'), ENT_QUOTES, 'UTF-8') . ':</strong><br/>' . nl2br(htmlspecialchars($comment_clean, ENT_QUOTES, 'UTF-8')) . '</p>';
			}
			$html .= '<p><a href="' . htmlspecialchars($buyer_orders_url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($this->language->get('text_mail_view_order'), ENT_QUOTES, 'UTF-8') . '</a> | <a href="' . htmlspecialchars($buyer_downloads_url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($this->language->get('text_mail_view_downloads'), ENT_QUOTES, 'UTF-8') . '</a></p>';
			$html .= '<hr style="border:none;border-top:1px solid #eee;margin:20px 0;"/><p style="color:#777;font-size:12px;">' . htmlspecialchars(sprintf($this->language->get('text_mail_footer'), $store_name), ENT_QUOTES, 'UTF-8') . '</p>';
			$html .= '</div>';

			$result['buyer_sent'] = $this->dispatchEmail($buyer_email, $from_email, $store_name, $subject, $html, $text);
		}

		// 2. Send email to Seller
		if ($seller_email) {
			$seller_name = trim($order_info['seller_name']) ? trim($order_info['seller_name']) : $order_info['seller_username'];
			$buyer_display = trim($order_info['buyer_name']) ? (trim($order_info['buyer_name']) . ' (' . $order_info['buyer_username'] . ')') : $order_info['buyer_username'];
			$subject = html_entity_decode(sprintf($this->language->get('text_mail_seller_subject'), $store_name, $order_id, $status_name), ENT_QUOTES, 'UTF-8');

			$text  = sprintf($this->language->get('text_mail_greeting'), $seller_name) . "\n\n";
			$text .= sprintf($this->language->get('text_mail_seller_intro'), $order_id, $status_name) . "\n\n";
			$text .= $this->language->get('column_order_id') . ": #" . $order_id . "\n";
			$text .= $this->language->get('column_extension') . ": " . $order_info['extension'] . "\n";
			$text .= $this->language->get('column_buyer') . ": " . $buyer_display . "\n";
			$text .= $this->language->get('column_total') . ": " . $total_formatted . "\n";
			$text .= $this->language->get('column_status') . ": " . $status_name . "\n";
			if ($comment_clean !== '') {
				$text .= "\n" . $this->language->get('entry_comment') . ":\n" . $comment_clean . "\n";
			}
			$text .= "\n" . $this->language->get('text_mail_seller_links') . "\n";
			$text .= "- " . $seller_sales_url . "\n";
			$text .= "- " . $seller_transactions_url . "\n\n";
			$text .= sprintf($this->language->get('text_mail_footer'), $store_name) . "\n";

			$html  = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;border:1px solid #e5e5e5;border-radius:4px;">';
			$html .= '<h2 style="color:#1e91cf;margin-top:0;">' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</h2>';
			$html .= '<p>' . htmlspecialchars(sprintf($this->language->get('text_mail_greeting'), $seller_name), ENT_QUOTES, 'UTF-8') . '</p>';
			$html .= '<p>' . htmlspecialchars(sprintf($this->language->get('text_mail_seller_intro'), $order_id, $status_name), ENT_QUOTES, 'UTF-8') . '</p>';
			$html .= '<table style="width:100%;border-collapse:collapse;margin:15px 0;font-size:14px;">';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_order_id'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;">#' . (int)$order_id . '</td></tr>';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_extension'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($order_info['extension'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_buyer'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($buyer_display, ENT_QUOTES, 'UTF-8') . '</td></tr>';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_total'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;">' . htmlspecialchars($total_formatted, ENT_QUOTES, 'UTF-8') . '</td></tr>';
			$html .= '<tr><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($this->language->get('column_status'), ENT_QUOTES, 'UTF-8') . '</strong></td><td style="padding:8px;border:1px solid #ddd;"><strong>' . htmlspecialchars($status_name, ENT_QUOTES, 'UTF-8') . '</strong></td></tr>';
			$html .= '</table>';
			if ($comment_clean !== '') {
				$html .= '<p><strong>' . htmlspecialchars($this->language->get('entry_comment'), ENT_QUOTES, 'UTF-8') . ':</strong><br/>' . nl2br(htmlspecialchars($comment_clean, ENT_QUOTES, 'UTF-8')) . '</p>';
			}
			$html .= '<p><a href="' . htmlspecialchars($seller_sales_url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($this->language->get('text_mail_view_sales'), ENT_QUOTES, 'UTF-8') . '</a> | <a href="' . htmlspecialchars($seller_transactions_url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($this->language->get('text_mail_view_transactions'), ENT_QUOTES, 'UTF-8') . '</a></p>';
			$html .= '<hr style="border:none;border-top:1px solid #eee;margin:20px 0;"/><p style="color:#777;font-size:12px;">' . htmlspecialchars(sprintf($this->language->get('text_mail_footer'), $store_name), ENT_QUOTES, 'UTF-8') . '</p>';
			$html .= '</div>';

			$result['seller_sent'] = $this->dispatchEmail($seller_email, $from_email, $store_name, $subject, $html, $text);
		}

		return $result;
	}

	protected function dispatchEmail($to, $from, $sender, $subject, $html, $text) {
		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode((string)$this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($to);
			$mail->setFrom($from);
			$mail->setSender($sender);
			$mail->setSubject($subject);
			$mail->setHtml($html);
			$mail->setText($text);
			return (bool)$mail->send();
		} catch (\Exception $e) {
			return false;
		}
	}

	public function deleteOrder($order_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
	}

	public function getOrder($order_id) {
		$query = $this->db->query("SELECT o.*, mb.username AS buyer_username, CONCAT(mb.firstname, ' ', mb.lastname) AS buyer_name, mb.email AS buyer_email, ms.username AS seller_username, CONCAT(ms.firstname, ' ', ms.lastname) AS seller_name, ms.email AS seller_email, (SELECT msl.support_email FROM `" . DB_PREFIX . "member_seller` msl WHERE msl.member_id = o.seller_id LIMIT 1) AS seller_support_email, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` mb ON (o.member_id = mb.member_id) LEFT JOIN `" . DB_PREFIX . "member` ms ON (o.seller_id = ms.member_id) WHERE o.order_id = '" . (int)$order_id . "'");

		return $query->row;
	}

	public function getOrders($data = array()) {
		$sql = "SELECT o.*, mb.username AS buyer_username, CONCAT(mb.firstname, ' ', mb.lastname) AS buyer_name, ms.username AS seller_username, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` mb ON (o.member_id = mb.member_id) LEFT JOIN `" . DB_PREFIX . "member` ms ON (o.seller_id = ms.member_id) WHERE 1=1";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_buyer'])) {
			$buyer_kw = $this->db->escape($data['filter_buyer']);
			$sql .= " AND (CONCAT(mb.firstname, ' ', mb.lastname) LIKE '%" . $buyer_kw . "%' OR mb.username LIKE '%" . $buyer_kw . "%' OR mb.email LIKE '%" . $buyer_kw . "%')";
		}

		if (!empty($data['filter_seller'])) {
			$seller_kw = $this->db->escape($data['filter_seller']);
			$sql .= " AND (CONCAT(ms.firstname, ' ', ms.lastname) LIKE '%" . $seller_kw . "%' OR ms.username LIKE '%" . $seller_kw . "%')";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'o.order_id',
			'buyer_name',
			'seller_username',
			'o.extension',
			'order_status',
			'o.total',
			'o.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "member` mb ON (o.member_id = mb.member_id) LEFT JOIN `" . DB_PREFIX . "member` ms ON (o.seller_id = ms.member_id) WHERE 1=1";

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_buyer'])) {
			$buyer_kw = $this->db->escape($data['filter_buyer']);
			$sql .= " AND (CONCAT(mb.firstname, ' ', mb.lastname) LIKE '%" . $buyer_kw . "%' OR mb.username LIKE '%" . $buyer_kw . "%' OR mb.email LIKE '%" . $buyer_kw . "%')";
		}

		if (!empty($data['filter_seller'])) {
			$seller_kw = $this->db->escape($data['filter_seller']);
			$sql .= " AND (CONCAT(ms.firstname, ' ', ms.lastname) LIKE '%" . $seller_kw . "%' OR ms.username LIKE '%" . $seller_kw . "%')";
		}

		if (!empty($data['filter_extension'])) {
			$sql .= " AND o.extension LIKE '%" . $this->db->escape($data['filter_extension']) . "%'";
		}

		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "'");

		return $query->row['total'];
	}
}

<?php
class ControllerMailSeller extends Controller {
	public function index($args = array()) {
		$this->load->language('mail/seller');

		$extension_id = isset($args['extension_id']) ? (int)$args['extension_id'] : 0;
		if (!$extension_id) {
			return;
		}

		$this->load->model('marketplace/extension');
		$this->load->model('account/member');
		$this->load->model('cms/download');

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);
		if (!$extension_info) {
			return;
		}

		$seller_info = !empty($extension_info['member_id']) ? $this->model_account_member->getMember($extension_info['member_id']) : array();

		// Priority: Seller's dedicated support_email -> Seller's member email -> Store config_email
		$seller_email = '';
		if (!empty($extension_info['support_email']) && filter_var($extension_info['support_email'], FILTER_VALIDATE_EMAIL)) {
			$seller_email = $extension_info['support_email'];
		} elseif (!empty($extension_info['member_email']) && filter_var($extension_info['member_email'], FILTER_VALIDATE_EMAIL)) {
			$seller_email = $extension_info['member_email'];
		} elseif (!empty($seller_info['email']) && filter_var($seller_info['email'], FILTER_VALIDATE_EMAIL)) {
			$seller_email = $seller_info['email'];
		} elseif ($this->config->get('config_email')) {
			$seller_email = $this->config->get('config_email');
		}

		if (!$seller_email) {
			return;
		}

		$store_name = html_entity_decode($this->config->get('config_name') ?: 'Store', ENT_QUOTES, 'UTF-8');
		$seller_username = !empty($extension_info['username']) ? $extension_info['username'] : (!empty($seller_info['username']) ? $seller_info['username'] : $this->language->get('text_default_seller'));

		$reason_code = isset($args['reason']) ? strtolower(trim($args['reason'])) : 'support';
		$reason_labels = array(
			'question' => $this->language->get('text_reason_question'),
			'support'  => $this->language->get('text_reason_support'),
			'refund'   => $this->language->get('text_reason_refund')
		);
		$reason_text = isset($reason_labels[$reason_code]) ? $reason_labels[$reason_code] : ucfirst($reason_code);

		$customer_name = !empty($args['name']) ? trim($args['name']) : ($this->member->isLogged() ? trim($this->member->getFirstName() . ' ' . $this->member->getLastName()) : $this->language->get('text_default_customer'));
		$customer_username = !empty($args['username']) ? trim($args['username']) : ($this->member->isLogged() ? $this->member->getUsername() : '');
		$customer_email = !empty($args['email']) ? trim($args['email']) : ($this->member->isLogged() ? $this->member->getEmail() : '');
		$website = !empty($args['website']) ? trim($args['website']) : $this->language->get('text_na');
		$order_id = isset($args['order_id']) ? trim((string)$args['order_id']) : '';
		$version_id = isset($args['version_id']) ? (int)$args['version_id'] : 0;
		$enquiry = isset($args['enquiry']) ? trim($args['enquiry']) : '';

		$version_name = $this->language->get('text_na');
		if ($version_id) {
			$download_info = $this->model_cms_download->getDownload($version_id);
			if ($download_info && !empty($download_info['name'])) {
				$version_name = $download_info['name'];
			}
		}

		$extension_url = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true));

		// Plain-text version
		$text  = sprintf($this->language->get('text_greeting'), $seller_username) . "\n\n";
		$text .= sprintf($this->language->get('text_enquiry_intro'), $store_name) . "\n\n";
		$text .= $this->language->get('text_label_extension') . " " . $extension_info['name'] . " (ID: " . $extension_id . ")\n";
		$text .= $this->language->get('text_label_url') . " " . $extension_url . "\n";
		$text .= $this->language->get('text_label_reason') . " " . $reason_text . "\n";
		$text .= $this->language->get('text_label_order_id') . " #" . $order_id . "\n";
		$text .= $this->language->get('text_label_version') . " " . $version_name . "\n\n";
		$text .= $this->language->get('text_customer_details') . "\n";
		$text .= $this->language->get('text_label_name') . " " . $customer_name . ($customer_username ? " (" . $customer_username . ")" : "") . "\n";
		$text .= $this->language->get('text_label_email') . " " . $customer_email . "\n";
		$text .= $this->language->get('text_label_website') . " " . $website . "\n\n";
		$text .= $this->language->get('text_label_message') . "\n";
		$text .= "----------------------------------------\n";
		$text .= $enquiry . "\n";
		$text .= "----------------------------------------\n\n";
		$text .= sprintf($this->language->get('text_reply_plain'), $customer_name, $customer_email) . "\n\n";
		$text .= $this->language->get('text_regards') . "\n";
		$text .= $this->language->get('text_team');

		// HTML version using official mail header & footer
		$header_html = $this->load->controller('mail/header');
		$footer_html = $this->load->controller('mail/footer');

		$body_html = '
<table bgcolor="#ffffff" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td width="30"></td>
    <td width="540" style="font-family: \'Open Sans\', Helvetica, Arial, sans-serif; color: #555555; font-size: 14px; line-height: 22px;">
      <h2 style="color: #23A1D1; margin: 0 0 15px 0; font-size: 20px;">' . sprintf($this->language->get('text_heading'), htmlspecialchars($extension_info['name'], ENT_QUOTES, 'UTF-8')) . '</h2>
      <p style="margin-bottom: 15px;">' . sprintf($this->language->get('text_greeting_html'), htmlspecialchars($seller_username, ENT_QUOTES, 'UTF-8')) . '</p>
      <p style="margin-bottom: 15px;">' . sprintf($this->language->get('text_enquiry_html'), htmlspecialchars($extension_url, ENT_QUOTES, 'UTF-8'), htmlspecialchars($extension_info['name'], ENT_QUOTES, 'UTF-8'), (int)$extension_id) . '</p>
      <table width="100%" cellpadding="8" cellspacing="0" border="0" style="border: 1px solid #ececec; border-radius: 4px; margin: 15px 0; background-color: #f9fbfd; font-size: 13px;">
        <tr>
          <td width="35%" style="border-bottom: 1px solid #ececec;"><strong>' . $this->language->get('text_label_reason') . '</strong></td>
          <td width="65%" style="border-bottom: 1px solid #ececec;">' . htmlspecialchars($reason_text, ENT_QUOTES, 'UTF-8') . '</td>
        </tr>
        <tr>
          <td style="border-bottom: 1px solid #ececec;"><strong>' . $this->language->get('text_label_customer') . '</strong></td>
          <td style="border-bottom: 1px solid #ececec;">' . htmlspecialchars($customer_name . ($customer_username ? ' (' . $customer_username . ')' : ''), ENT_QUOTES, 'UTF-8') . '</td>
        </tr>
        <tr>
          <td style="border-bottom: 1px solid #ececec;"><strong>' . $this->language->get('text_label_email') . '</strong></td>
          <td style="border-bottom: 1px solid #ececec;"><a href="mailto:' . htmlspecialchars($customer_email, ENT_QUOTES, 'UTF-8') . '" style="color: #23A1D1;">' . htmlspecialchars($customer_email, ENT_QUOTES, 'UTF-8') . '</a></td>
        </tr>
        <tr>
          <td style="border-bottom: 1px solid #ececec;"><strong>' . $this->language->get('text_label_website') . '</strong></td>
          <td style="border-bottom: 1px solid #ececec;">' . htmlspecialchars($website, ENT_QUOTES, 'UTF-8') . '</td>
        </tr>
        <tr>
          <td style="border-bottom: 1px solid #ececec;"><strong>' . $this->language->get('text_label_order_id') . '</strong></td>
          <td style="border-bottom: 1px solid #ececec;">#' . htmlspecialchars($order_id, ENT_QUOTES, 'UTF-8') . '</td>
        </tr>
        <tr>
          <td><strong>' . $this->language->get('text_label_version') . '</strong></td>
          <td>' . htmlspecialchars($version_name, ENT_QUOTES, 'UTF-8') . '</td>
        </tr>
      </table>
      <p style="margin: 15px 0 8px 0;"><strong>' . $this->language->get('text_label_message') . '</strong></p>
      <div style="background-color: #f5f5f5; border-left: 4px solid #23A1D1; padding: 12px 15px; margin-bottom: 20px; white-space: pre-wrap;">' . nl2br(htmlspecialchars($enquiry, ENT_QUOTES, 'UTF-8')) . '</div>
      <p style="font-size: 12px; color: #888888; margin-bottom: 25px;">' . sprintf($this->language->get('text_reply_html'), htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'), htmlspecialchars($customer_email, ENT_QUOTES, 'UTF-8')) . '</p>
    </td>
    <td width="30"></td>
  </tr>
</table>';

		$html = $header_html . $body_html . $footer_html;
		$subject = html_entity_decode(sprintf($this->language->get('text_subject'), $store_name, $reason_text, $extension_info['name'], $order_id), ENT_QUOTES, 'UTF-8');
		$from_email = $this->config->get('config_email') ?: ('noreply@' . (parse_url($this->config->get('config_url'), PHP_URL_HOST) ?: 'localhost'));

		try {
			$mail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($seller_email);
			$mail->setFrom($from_email);
			$mail->setSender(html_entity_decode($store_name . ' (' . $customer_name . ')', ENT_QUOTES, 'UTF-8'));
			if ($customer_email && filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
				$mail->setReplyTo($customer_email);
			}
			$mail->setSubject($subject);
			$mail->setHtml($html);
			$mail->setText($text);
			$mail->send();
		} catch (\Exception $e) {
			// Logged in Mail::send()
		}

		// If the customer requested a refund and store admin email differs from seller email, send a copy to store admin
		$admin_email = $this->config->get('config_email');
		if ($reason_code === 'refund' && $admin_email && strtolower($admin_email) !== strtolower($seller_email) && filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
			try {
				$amail = new Mail($this->config->get('config_mail_engine') ?: 'mail');
				$amail->parameter = $this->config->get('config_mail_parameter');
				$amail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$amail->smtp_username = $this->config->get('config_mail_smtp_username');
				$amail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$amail->smtp_port = $this->config->get('config_mail_smtp_port');
				$amail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$amail->setTo($admin_email);
				$amail->setFrom($admin_email);
				$amail->setSender($store_name);
				if ($customer_email && filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
					$amail->setReplyTo($customer_email);
				}
				$amail->setSubject($subject);
				$amail->setHtml($html);
				$amail->setText($text);
				$amail->send();
			} catch (\Exception $e) {
				// Logged in Mail::send()
			}
		}
	}
}

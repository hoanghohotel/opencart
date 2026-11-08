# OpenCart Marketplace & Cloud E-Commerce Platform Suite — Developer Guide (Core v1.0.1)

[![Version](https://img.shields.io/badge/version-1.0.1-006bb3.svg)](CHANGELOG.md)
[![Architecture](https://img.shields.io/badge/architecture-MVC--L%20%2B%20Event%20Driven-2b7a1e.svg)](README.md)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B%20%7C%208.2%20%7C%208.3-777bb4.svg)](INSTALL.md)

This document provides a comprehensive technical reference for software engineers and extension developers building new features, modules, payment gateways, cloud storage drivers, and custom workflows on the **OpenCart Marketplace & Cloud E-Commerce Platform Suite (Core v1.0.1)**.

- **[Part I: English Developer Guide](#part-i-english-developer-guide)**
- **[Phần II: Tài liệu Hướng dẫn Phát triển & Mở rộng Code (Tiếng Việt)](#phần-ii-tài-liệu-hướng-dẫn-phát-triển--mở-rộng-code-tiếng-việt)**

---

## PART I: ENGLISH DEVELOPER GUIDE

### 1. System Architecture & Request Lifecycle

#### 1.1. The MVC-L + Registry Pattern
The platform uses a lightweight, high-performance **MVC-L (Model-View-Controller-Language)** architecture backed by a central Dependency Injection / Service Locator container (`Registry`):

- **Controller (`application/controller/` & `admin/controller/`)**: Handles HTTP routing, request validation, permission/token checks, orchestrates calls to Models and Libraries, and passes view data to Twig templates.
- **Model (`application/model/` & `admin/model/`)**: Encapsulates all SQL queries and business data manipulation. Every loaded model is wrapped in a `Proxy` object (`system/engine/proxy.php`), enabling pre/post event hooks on any model method call.
- **View (`application/view/template/` & `admin/view/template/`)**: Uses the **Twig** templating engine (`system/library/template/twig.php`) for clean separation of presentation logic.
- **Language (`application/language/` & `admin/language/`)**: Stores localized text arrays (`$_['key'] = 'Value';`) that are automatically injected into `$data` before a Twig template is rendered (`event/language`).
- **Registry (`system/engine/registry.php`)**: Holds singleton services accessible via `$this->...` inside any `Controller` or `Model`:
  - `$this->config` (`Config`) — System and database settings (`oc_setting`)
  - `$this->db` (`DB`) — Database abstraction layer (`mysqli`, `mpdo`, `pgsql`)
  - `$this->request` (`Request`) — Sanitized `$_GET`, `$_POST`, `$_FILES`, `$_COOKIE`, `$_SERVER`
  - `$this->response` (`Response`) — HTTP headers, Gzip compression, and HTML post-processing (Core Web Vitals, Accessibility, SEO)
  - `$this->session` (`Session`) — Database-backed (`oc_session`) or file-backed session data
  - `$this->url` (`Url`) — Dynamic, SEO-rewritten URL generator (`$this->url->link()`)
  - `$this->load` (`Loader`) — Loads controllers, models, views, languages, libraries, and configs
  - `$this->event` (`Event`) — Pub/Sub event dispatcher (`controller/*/before`, `model/*/after`, `view/*/before`, etc.)
  - `$this->log` (`Log`) — Application logger writing to `system/storage/logs/error.log`
  - `$this->cache` (`Cache`) — Key-value caching (`file`, `apc`, `mem`, `memcached`)
  - `$this->document` (`Document`) — Page metadata (`<title>`, `<meta description>`, `<link>`, `<script>`)
  - `$this->member` (` Account\Member`) — Storefront authenticated member & seller state
  - `$this->user` (`Cart\User`) — Admin authenticated administrator & permission checker

#### 1.2. Request Lifecycle Flowchart

```text
HTTP Request (index.php / admin/index.php)
  │
  ├─► Load config.php (Dynamic Domain, SSL, and Directory Constants)
  ├─► Load system/startup.php (Autoloader, Error Reporting, Helper Functions)
  └─► Execute system/framework.php
        ├─► Initialize Registry, Config, Log, Event, Loader, Request, Response, DB, Session, Cache
        ├─► Execute Pre-Actions (action_pre_action in system/config/application.php or admin.php):
        │     1. startup/session       (Starts DB session)
        │     2. startup/startup       (Loads oc_setting into $this->config, initializes Member/Tax/Currency)
        │     3. startup/error         (Registers error/exception handlers)
        │     4. startup/event         (Loads database event hooks from oc_event)
        │     5. startup/maintenance   (Checks maintenance mode)
        │     6. startup/seo_url       (Translates friendly URLs _route_ <-> route via oc_seo_url)
        ├─► Dispatch Route (startup/router -> Controller Class & Method)
        │     ├─► Trigger Event: controller/{route}/before
        │     ├─► Execute Controller Action (loads Models, Languages, Views)
        │     │     ├─► Model calls trigger: model/{route}/before & model/{route}/after
        │     │     └─► View calls trigger:  view/{route}/before  & view/{route}/after
        │     └─► Trigger Event: controller/{route}/after
        └─► $response->output()
              └─► Runs Response::optimizeCoreWebVitals() (Storefront HTML):
                    • Injects missing image width/height, alt, lazy-loading & LCP preload
                    • Enforces WCAG 2.1 AA ARIA attributes, heading hierarchy & unique IDs
                    • Injects OpenGraph, Twitter Card & JSON-LD structured data
                    • Strips hardcoded localhost URLs for domain portability
```

#### 1.3. Naming & Routing Conventions

| Route Parameter (`?route=...`) | File Path | PHP Class Name | Method Executed | Registry Access Name (Models) |
| :--- | :--- | :--- | :--- | :--- |
| `marketplace/extension` | `application/controller/marketplace/extension.php` | `ControllerMarketplaceExtension` | `index()` | — |
| `marketplace/extension/info` | `application/controller/marketplace/extension.php` | `ControllerMarketplaceExtension` | `info()` | — |
| `account/seller/save` | `application/controller/account/seller.php` | `ControllerAccountSeller` | `save()` | — |
| `$this->load->model('marketplace/extension')` | `application/model/marketplace/extension.php` | `ModelMarketplaceExtension` | *(Any public method)* | `$this->model_marketplace_extension` |
| `$this->load->model('cms/blog_comment')` | `application/model/cms/blog_comment.php` | `ModelCmsBlogComment` | *(Any public method)* | `$this->model_cms_blog_comment` |

> **Rule for Class Names**: Remove all slashes (`/`) and underscores (`_`), then PascalCase each segment prefixed with `Controller` or `Model`. However, the Registry property name for a loaded model keeps underscores: `model_` + `str_replace('/', '_', $route)`.

---

### 2. Creating a New Storefront Feature (Step-by-Step)

Suppose you want to build a new **"Developer API Documentation & Key Manager"** module accessible at `index.php?route=support/api_docs` (and SEO URL `/api-docs`).

#### Step 1: Create the Language File
Create `application/language/en-gb/support/api_docs.php`:

```php
<?php
// Heading
$_['heading_title']     = 'OpenCart Marketplace REST API Documentation';

// Text
$_['text_description']  = 'Integrate your tools with the OpenCart Marketplace API.';
$_['text_endpoints']    = 'Available Endpoints';
$_['button_generate']   = 'Generate API Key';
```

#### Step 2: Create the Model
Create `application/model/support/api_docs.php`:

```php
<?php
class ModelSupportApiDocs extends Model {
	public function getApiEndpoints(): array {
		$cache_key = 'api.endpoints.list';
		$endpoints = $this->cache->get($cache_key);

		if (!$endpoints) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "api_endpoint` WHERE `status` = '1' ORDER BY `sort_order` ASC");
			$endpoints = $query->rows;
			$this->cache->set($cache_key, $endpoints);
		}

		return $endpoints;
	}

	public function createMemberApiKey(int $member_id, string $label): string {
		$api_key = 'oc_live_' . bin2hex(random_bytes(24));

		$this->db->query("INSERT INTO `" . DB_PREFIX . "member_api_key` SET
			`member_id` = '" . (int)$member_id . "',
			`label` = '" . $this->db->escape($label) . "',
			`api_key` = '" . $this->db->escape($api_key) . "',
			`date_added` = NOW()");

		return $api_key;
	}
}
```

> **Database Security Best Practices**:
> - Always cast integers with `(int)$var` and floats with `(float)$var`.
> - Always escape strings with `$this->db->escape($var)`.
> - Always prefix table names with `DB_PREFIX` (default `oc_`).

#### Step 3: Create the Controller
Create `application/controller/support/api_docs.php`:

```php
<?php
class ControllerSupportApiDocs extends Controller {
	public function index() {
		$this->load->language('support/api_docs');
		$this->load->model('support/api_docs');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setDescription($this->language->get('text_description'));

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('support/api_docs')
		);

		$data['is_logged'] = $this->member->isLogged();
		$data['login_url'] = $this->url->link('account/login', 'redirect=' . urlencode($this->url->link('support/api_docs')));

		// Standard layout regions
		$data['column_left']    = $this->load->controller('common/column_left');
		$data['column_right']   = $this->load->controller('common/column_right');
		$data['content_top']    = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer']         = $this->load->controller('common/footer');
		$data['header']         = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/api_docs', $data));
	}

	/**
	 * Example AJAX JSON Endpoint: index.php?route=support/api_docs/generateKey
	 */
	public function generateKey() {
		$json = array();

		if (!$this->member->isLogged()) {
			$json['error'] = 'Authentication required.';
		} elseif ($this->request->server['REQUEST_METHOD'] !== 'POST') {
			$json['error'] = 'Invalid request method.';
		} else {
			// Verify CSRF member_token
			$token = $this->request->get['member_token'] ?? ($this->request->post['member_token'] ?? '');
			if (empty($this->session->data['member_token']) || !hash_equals($this->session->data['member_token'], $token)) {
				$json['error'] = 'Invalid security token.';
			} else {
				$this->load->model('support/api_docs');
				$label = trim($this->request->post['label'] ?? 'Default Key');
				$json['api_key'] = $this->model_support_api_docs->createMemberApiKey((int)$this->member->getId(), $label);
				$json['success'] = 'API key generated successfully.';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
```

#### Step 4: Register SEO URL & Sitemap Entry
1. **SEO URL (`oc_seo_url`)**: Insert a record into `oc_seo_url` so `/api-docs` maps to `support/api_docs`:
   ```sql
   INSERT INTO `oc_seo_url` (`store_id`, `language_id`, `query`, `keyword`)
   VALUES (0, 1, 'route=support/api_docs', 'api-docs');
   ```
   Also check `application/controller/startup/seo_url.php` if your route requires custom query parameter parsing.
2. **Dynamic Sitemap (`application/controller/cms/sitemap.php`)**: Add `'support/api_docs'` to the `$static_routes` array in `ControllerCmsSitemap::index()` so search engines automatically discover the new page.

---

### 3. Developing & Extending the Admin Panel (`admin/`)

#### 3.1. Admin Route Structure & Security (`user_token` & Permissions)
Every Admin controller in `admin/controller/` automatically passes through two pre-actions defined in `system/config/admin.php`:
- `startup/login`: Ensures the administrator is logged in and validates `$this->request->get['user_token'] === $this->session->data['user_token']`.
- `startup/permission`: Checks `$this->user->hasPermission('access', $route)` against the administrator's User Group permissions (`oc_user_group.permission`).

When writing an action that modifies data (`add`, `edit`, `delete`, `save`), always check `'modify'` permission in your controller validation method:

```php
protected function validateForm(): bool {
	if (!$this->user->hasPermission('modify', 'marketplace/custom_module')) {
		$this->error['warning'] = $this->language->get('error_permission');
	}
	return !$this->error;
}
```

> **Granting Permission to a New Admin Route**:
> Navigate to **Admin -> System -> Users -> User Groups -> Edit Administrator**, check the new route under both **Access Permission** and **Modify Permission**, and click **Save**.

#### 3.2. Adding a Menu Item to the Admin Sidebar
Edit `admin/controller/common/column_left.php` and add your menu entry with a permission check:

```php
if ($this->user->hasPermission('access', 'marketplace/custom_module')) {
	$marketplace[] = array(
		'name'     => 'Custom Module',
		'href'     => $this->url->link('marketplace/custom_module', 'user_token=' . $this->session->data['user_token'], true),
		'children' => array()
	);
}
```

#### 3.3. Adding System Configuration Settings
All global settings stored in `oc_setting` with prefix `config_` are automatically saved by `ModelSettingSetting::editSetting('config', $this->request->post)` in `admin/controller/setting/setting.php` and loaded into `$this->config` at boot time (`startup/startup.php`).
To add a new setting field (e.g., `config_custom_api_endpoint`):
1. Add language labels in `admin/language/en-gb/setting/setting.php`.
2. Initialize `$data['config_custom_api_endpoint']` in `admin/controller/setting/setting.php`:
   ```php
   if (isset($this->request->post['config_custom_api_endpoint'])) {
       $data['config_custom_api_endpoint'] = $this->request->post['config_custom_api_endpoint'];
   } else {
       $data['config_custom_api_endpoint'] = $this->config->get('config_custom_api_endpoint');
   }
   ```
3. Add the `<input name="config_custom_api_endpoint" ... />` field in `admin/view/template/setting/setting.twig`.
4. Read the value anywhere in the application using `$this->config->get('config_custom_api_endpoint')`.

---

### 4. Extending Core Behavior Without Modifying Core Files (Event System)

The **Event System** (`system/engine/event.php` and `system/engine/loader.php`) allows you to intercept and modify **Controllers**, **Models**, **Views**, and **Language files** before or after they execute.

#### 4.1. Available Event Triggers

| Trigger Pattern | Arguments Passed by Reference | Description |
| :--- | :--- | :--- |
| `controller/{route}/before` | `(&$route, &$data)` | Fired before a controller executes. Can change `$route` or return an output to short-circuit execution. |
| `controller/{route}/after` | `(&$route, &$data, &$output)` | Fired after a controller executes. Can inspect or modify `$output`. |
| `model/{route}/before` | `(&$route, &$args)` | Fired before a model method runs. Can modify method input `$args`. |
| `model/{route}/after` | `(&$route, &$args, &$output)` | Fired after a model method runs. Can modify or enrich the returned `$output` array/value. |
| `view/{route}/before` | `(&$route, &$data, &$code)` | Fired right before Twig renders `$route.twig`. Ideal for injecting extra variables into `$data`! |
| `view/{route}/after` | `(&$route, &$data, &$output)` | Fired after Twig renders HTML into `$output`. |
| `language/{route}/after` | `(&$route, &$prefix)` | Fired after a language file is loaded. |

> Wildcards (`*`) are supported at any segment level, e.g., `view/*/before` or `model/marketplace/*/after`.

#### 4.2. Example: Injecting Custom Data into a View via Event Hook
Because storefront `.twig` templates in `application/view/template/` are kept clean and unmodified, you can inject or transform template variables using a `view/{route}/before` listener:

1. **Create Event Listener Controller** `application/controller/event/custom_hook.php`:
   ```php
   <?php
   class ControllerEventCustomHook extends Controller {
       /**
        * Triggered on: view/marketplace/extension_info/before
        */
       public function onExtensionInfoView(&$route, &$data, &$code) {
           // Modify or enrich $data before Twig renders marketplace/extension_info.twig
           if (!empty($data['extension_id'])) {
               $data['documentation'] .= "\n<!-- Verified by Marketplace Security Scanner -->";
           }
       }
   }
   ```
2. **Register the Event** in `system/config/application.php` under `$_['action_event']` (or insert a row into the `oc_event` database table):
   ```php
   $_['action_event'] = array(
       // ... existing events ...
       'view/marketplace/extension_info/before' => array(
           'event/custom_hook/onExtensionInfoView'
       )
   );
   ```

---

### 5. Working with Core Libraries (`system/library/`)

#### 5.1. Multi-Cloud Object Storage (`system/library/cloud_storage.php`)
The `CloudStorage` class provides a unified API for storing, serving, and deleting uploaded files across **Local Disk**, **Wasabi Hot Cloud Storage**, **Cloudflare R2**, **Amazon S3**, and **Google Cloud Storage (GCS)**.

**Usage in any Controller:**
```php
require_once(DIR_SYSTEM . 'library/cloud_storage.php');
$cloudStorage = new \CloudStorage($this->registry);

// 1. Store an uploaded file (automatically syncs to Wasabi/R2/S3/GCS if enabled)
$stored = $cloudStorage->storeUploadedFile(
	$this->request->files['file']['tmp_name'],
	DIR_DOWNLOAD . $storage_filename,
	'download',
	$storage_filename
);

if (!$stored['success']) {
	$json['error'] = $stored['error'];
}

// 2. Serve a file download (streams from local disk OR redirects to an AWS SigV4 Pre-Signed URL)
$cloudStorage->outputFile(
	DIR_DOWNLOAD . $download_info['filename'],
	$download_info['mask'],
	'download',
	$download_info['filename']
);

// 3. Delete a file from Cloud Storage and remove its .cloud.json sidecar
$cloudStorage->deleteObject('downloads/' . $download_info['filename'], DIR_DOWNLOAD . $download_info['filename']);
```

**How to Add a New Cloud Storage Driver (e.g., DigitalOcean Spaces or Backblaze B2):**
1. Open `system/library/cloud_storage.php`.
2. Add your driver code (e.g., `'backblaze'`) to `getDriver()` allowed drivers array.
3. Add its endpoint resolution case inside `resolveEndpoint()`:
   ```php
   case 'backblaze':
       $region = $this->region ?: 'us-west-004';
       return 'https://s3.' . $region . '.backblazeb2.com';
   ```
4. Because Backblaze B2 and DigitalOcean Spaces use S3 Signature V4, `putObject()`, `deleteObject()`, `getPresignedUrl()`, and `testConnection()` will work automatically!
5. Add the `<option value="backblaze">Backblaze B2 Cloud Storage</option>` option in `admin/view/template/setting/setting.twig`.

#### 5.2. Multi-Gateway Payment Processing (`system/library/payment_gateway.php`)
The `PaymentGateway` library (`system/library/payment_gateway.php`) handles card charging, tokenization, vaulted card charges, and configuration across **Stripe**, **Braintree**, and **PayPal**.

**Usage in Checkout Controllers:**
```php
$gateway = new PaymentGateway($this->config);

// Charge a saved card or new payment token
$result = $gateway->charge(array(
	'amount'        => 49.00,
	'currency'      => 'USD',
	'description'   => 'Order #1024 - OpenCart Marketplace',
	'payment_token' => $payment_token,
	'card_number'   => $raw_card_number, // Used only if tokenizing directly
	'member_id'     => $this->member->getId()
));

if ($result['success']) {
	$transaction_id = $result['transaction_id'];
	$card_last_four = $result['last_four']; // Real 4 digits extracted from gateway/card
}
```

**Adding a New Payment Gateway (e.g., VNPay, MoMo, Razorpay, Paddle):**
1. Add settings fields (`config_vnpay_tmn_code`, `config_vnpay_hash_secret`) in `admin/controller/setting/setting.php` and `admin/view/template/setting/setting.twig`.
2. Add a new driver method (e.g., `chargeVnpay(array $payload)`) in `system/library/payment_gateway.php` and return a standardized array:
   ```php
   return array(
       'success'        => true,
       'provider'       => 'vnpay',
       'transaction_id' => $txn_ref,
       'last_four'      => $last4,
       'card_type'      => 'VNPay',
       'raw_response'   => $response_data
   );
   ```
3. For redirect-based webhooks/IPNs, create a callback action in `application/controller/checkout/payment.php` (e.g., `index.php?route=checkout/payment/webhook`) that verifies the HMAC signature and updates the order status via `$this->model_checkout_order->editOrderStatus($order_id, $completed_status_id)`.

#### 5.3. Transactional Email & SMTP Engine (`system/library/mail.php`)
Always send emails using the configured `Mail` engine so your code respects the Admin's choice between PHP `mail` and `SMTP` (with TLS/SSL and diagnostics):

```php
$mail = new Mail($this->config->get('config_mail_engine'));
$mail->parameter     = $this->config->get('config_mail_parameter');
$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
$mail->smtp_username = $this->config->get('config_mail_smtp_username');
$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
$mail->smtp_port     = $this->config->get('config_mail_smtp_port');
$mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');

$mail->setTo($recipient_email);
$mail->setFrom($this->config->get('config_email'));
$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
$mail->setSubject($subject);
$mail->setHtml($this->load->view('mail/order_invoice', $data));
$mail->send();
```

---

### 6. Database Schema & Writing Upgrade Migrations

#### 6.1. Key Database Tables (`DB_PREFIX = oc_`)

| Table Name | Purpose |
| :--- | :--- |
| `oc_member` | Storefront members & sellers (credentials, PIN, 2FA, seller tax/payout info, avatar). |
| `oc_member_card` | Tokenized payment methods belonging to a specific `member_id` (card type, real last 4 digits, expiry, gateway token). |
| `oc_extension` | Marketplace extensions & themes (name, price, license, category, seller `member_id`, ratings, downloads). |
| `oc_extension_download` | Versioned `.zip` / `.ocmod.zip` packages attached to an extension. |
| `oc_extension_install` / `oc_member_download` | Tracks member license entitlements and download history. |
| `oc_order` / `oc_order_extension` / `oc_order_history` | Marketplace & Cloud subscription orders, line items, and status history. |
| `oc_order_status` | Localized order statuses (`Completed`, `Processing`, `Pending`, `Refunded`, `Canceled`). |
| `oc_blog` / `oc_blog_category` / `oc_blog_comment` | CMS Blog articles, categories, authors, and moderated comment threads. |
| `oc_partner` | Certified OpenCart Partners / Agencies (country, website, description, rating). |
| `oc_download` | Official OpenCart Core software releases (`opencart-core-v1.0.1.zip`, etc.). |
| `oc_setting` | Key-value system configuration (`config_*`, `config_storage_*`, `config_mail_*`, payment keys). |
| `oc_seo_url` | Maps internal `query` strings (e.g., `route=cms/blog` or `extension_id=15`) to SEO `keyword` slugs. |

#### 6.2. Adding a New Upgrade Migration Step
When you introduce schema changes (new tables, columns, or seed records), make them **idempotent** (safe to run multiple times) and register them in the upgrade pipeline:

1. **Installer Upgrade Step**: Create `install/controller/upgrade/upgrade_11.php` (`ControllerUpgradeUpgrade11::index()`), check if your table/column exists using `SHOW TABLES LIKE ...` or `SHOW COLUMNS FROM ... LIKE ...`, and execute `ALTER TABLE` / `CREATE TABLE`.
2. **Storefront Self-Healing Upgrade Controller**: Add the corresponding migration method in `application/controller/upgrade/upgrade.php` so administrators running `/index.php?route=upgrade/upgrade` automatically apply the new schema without data loss.
3. **Fresh Install SQL Dump**: Update `install/opencart.sql` so brand-new installations include the schema out of the box.

---

### 7. Frontend Standards: Performance, Accessibility (WCAG 2.1 AA) & SEO

To maintain the platform's **100/100 Google Lighthouse** scores across all categories, adhere to these coding standards:

1. **Zero Hardcoded Domains**:
   - **Never** hardcode `http://localhost/...` or fixed subfolder paths in PHP, Twig, CSS, or database content.
   - Always generate internal links with `$this->url->link('route/name', 'param=val', true)`.
   - Both `config.php` and `admin/config.php` dynamically resolve `HTTP_SERVER` and `HTTPS_SERVER` from the active host and reverse-proxy headers (`X-Forwarded-Proto`).
2. **Core Web Vitals & Automatic HTML Post-Processing (`system/library/response.php`)**:
   - `Response::optimizeCoreWebVitals()` automatically inspects storefront HTML responses and:
     - Resolves local image files to inject explicit `width` and `height` attributes (preventing Cumulative Layout Shift / CLS).
     - Adds `loading="lazy"` and `decoding="async"` to below-the-fold images while preloading the first hero/LCP image with `fetchpriority="high"`.
     - Ensures every `<img>` has a descriptive `alt` attribute, every icon-only `<button>`/`<a>` has an `aria-label`, and every `<input>`/`<select>`/`<textarea>` has an accessible label.
     - Normalizes heading hierarchy (`<h1>` -> `<h2>` -> `<h3>` without skipping levels) while preserving visual typography via `.h1`–`.h6` utility classes in `bootstrap.css`.
     - Deduplicates repeated HTML `id` attributes and adds `rel="noopener noreferrer"` to `target="_blank"` links.
3. **Color Contrast (WCAG 2.1 AA $\ge 4.5:1$)**:
   - When adding custom CSS to `application/view/stylesheet/stylesheet.css`, ensure normal text has a contrast ratio of at least **4.5:1** against its background (e.g., use `#0c6291` or `#1875a8` on white backgrounds, or white `#ffffff` text on `#0b588c` buttons).

---

### 8. Debugging, Testing & Packaging a Release

#### 8.1. Logging & Debugging
- Write diagnostic information to `system/storage/logs/error.log` from any Controller or Model:
  ```php
  $this->log->write('[MyCustomModule] Payload received: ' . json_encode($payload));
  ```
- View or clear the error log in **Admin -> System -> Maintenance -> Error Logs** (`admin/index.php?route=tool/log`).

#### 8.2. Pre-Commit Verification Checklist
Run the following checks from the project root (`E:\wamp\www\retail`) before packaging a release:

```powershell
# 1. Lint modified PHP files for syntax errors
php -l system/library/cloud_storage.php
php -l application/controller/common/header.php

# 2. Verify Storefront Upgrade Runner returns HTTP 200 and applies all schema steps cleanly
curl -I http://localhost/retail/index.php?route=upgrade/upgrade
```

#### 8.3. Building the Core Release Archive (`opencart-core-vX.Y.Z.zip`)
1. Update `define('VERSION', 'X.Y.Z');` in both `index.php` and `admin/index.php`.
2. Document all changes in `CHANGELOG.md`.
3. Package the workspace (excluding runtime logs, cache, and `.cloud.json` sidecar files) into `opencart-core-vX.Y.Z.zip` and copy it to `system/storage/download/` so the Download page (`index.php?route=cms/download`) serves the updated release.

---
---

## PHẦN II: TÀI LIỆU HƯỚNG DẪN PHÁT TRIỂN & MỞ RỘNG CODE (TIẾNG VIỆT)

### 1. Kiến trúc Hệ thống & Vòng đời Request (MVC-L + Event Engine)

#### 1.1. Mô hình MVC-L và Bộ chứa Dịch vụ (`Registry`)
Hệ thống được xây dựng trên kiến trúc **MVC-L (Model - View - Controller - Language)** kết hợp với **Service Locator (`Registry`)** và **Event Hooks**:

- **Controller (`application/controller/` & `admin/controller/`)**: Tiếp nhận tham số điều hướng `route`, kiểm tra phân quyền / bảo mật phiên (`member_token` hoặc `user_token`), gọi các Model / Library xử lý nghiệp vụ và truyền mảng dữ liệu `$data` sang View.
- **Model (`application/model/` & `admin/model/`)**: Thực thi các truy vấn CSDL MySQL/MariaDB. Mọi Model khi nạp qua `$this->load->model()` đều được bọc qua lớp `Proxy` (`system/engine/proxy.php`), cho phép gắn sự kiện (`before`/`after`) lên bất kỳ hàm nào của Model.
- **View (`application/view/template/` & `admin/view/template/`)**: Sử dụng **Twig Template Engine** (`system/library/template/twig.php`).
  > **Lưu ý quan trọng**: Các file giao diện `.twig` phía Storefront (`application/view/template/`) là bộ giao diện chuẩn của `opencart.com`. Khi cần bổ sung dữ liệu hoặc thay đổi hiển thị phía Storefront, hãy xử lý trong **Controller**, **Event Hook (`view/*/before`)** hoặc hậu xử lý trong **`Response`** thay vì sửa trực tiếp file `.twig` gốc. (Các file `.twig` trong `admin/view/template/` có thể chỉnh sửa tự do).
- **Language (`application/language/` & `admin/language/`)**: Chứa các mảng ngôn ngữ `$_['key'] = 'Giá trị';` và được tự động nạp vào biến Twig nhờ sự kiện `event/language`.
- **Các đối tượng cốt lõi trong `$this` (Registry)**:
  - `$this->config`: Đọc cấu hình hệ thống từ file config và bảng `oc_setting`.
  - `$this->db`: Thực thi truy vấn SQL (`$this->db->query()`, `$this->db->escape()`, `$this->db->getLastId()`).
  - `$this->request`: Truy cập dữ liệu đầu vào đã làm sạch (`$this->request->get`, `post`, `files`, `cookie`, `server`).
  - `$this->response`: Thiết lập HTTP Header, JSON output hoặc HTML output (kèm bộ tối ưu Core Web Vitals, Accessibility và SEO tự động).
  - `$this->session`: Quản lý phiên làm việc lưu trong bảng `oc_session`.
  - `$this->url`: Tạo URL động và thân thiện SEO (`$this->url->link('route', 'params', true)`).
  - `$this->member`: Quản lý trạng thái đăng nhập của Thành viên/Nhà bán hàng ngoài Storefront (`$this->member->isLogged()`, `$this->member->getId()`).
  - `$this->user`: Quản lý trạng thái đăng nhập và quyền hạn của Quản trị viên trong Admin (`$this->user->hasPermission()`).

#### 1.2. Quy tắc Đặt tên File, Class và Route

| Tham số `route` trên URL | Đường dẫn File | Tên Class PHP | Phương thức gọi | Tên gọi Model trong Controller |
| :--- | :--- | :--- | :--- | :--- |
| `cms/blog` | `application/controller/cms/blog.php` | `ControllerCmsBlog` | `index()` | — |
| `cms/blog/info` | `application/controller/cms/blog.php` | `ControllerCmsBlog` | `info()` | — |
| `account/extension/upload` | `application/controller/account/extension.php` | `ControllerAccountExtension` | `upload()` | — |
| `$this->load->model('marketplace/extension')` | `application/model/marketplace/extension.php` | `ModelMarketplaceExtension` | *(Các hàm public)* | `$this->model_marketplace_extension` |
| `$this->load->model('account/payment_method')` | `application/model/account/payment_method.php` | `ModelAccountPaymentMethod` | *(Các hàm public)* | `$this->model_account_payment_method` |

> **Quy tắc đặt tên Class**: Bỏ toàn bộ dấu gạch chéo (`/`) và dấu gạch dưới (`_`), viết hoa chữ cái đầu mỗi từ (PascalCase) và ghép tiền tố `Controller` hoặc `Model`. Riêng biến gọi Model trong Controller thì giữ nguyên dấu gạch dưới: `$this->model_ten_thu_muc_ten_file`.

---

### 2. Hướng dẫn Tạo Mới một Module / Trang Chức năng

Giả sử bạn muốn tạo một trang mới hoặc một API endpoint mới tại địa chỉ `index.php?route=support/faq` (và đường dẫn thân thiện `/faq`).

#### Bước 1: Tạo File Ngôn ngữ (`application/language/en-gb/support/faq.php`)
```php
<?php
$_['heading_title']    = 'Frequently Asked Questions';
$_['text_description'] = 'Find answers to common questions about OpenCart Marketplace & Cloud.';
```

#### Bước 2: Tạo Model Truy vấn CSDL (`application/model/support/faq.php`)
```php
<?php
class ModelSupportFaq extends Model {
	public function getFaqs(array $filter_data = array()): array {
		$sql = "SELECT * FROM `" . DB_PREFIX . "faq` WHERE `status` = '1'";

		if (!empty($filter_data['filter_category'])) {
			$sql .= " AND `category` = '" . $this->db->escape($filter_data['filter_category']) . "'";
		}

		$sql .= " ORDER BY `sort_order` ASC, `faq_id` DESC";

		if (isset($filter_data['start']) || isset($filter_data['limit'])) {
			$start = max(0, (int)($filter_data['start'] ?? 0));
			$limit = max(1, (int)($filter_data['limit'] ?? 20));
			$sql .= " LIMIT " . $start . "," . $limit;
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}
}
```

#### Bước 3: Tạo Controller (`application/controller/support/faq.php`)
```php
<?php
class ControllerSupportFaq extends Controller {
	public function index() {
		$this->load->language('support/faq');
		$this->load->model('support/faq');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setDescription($this->language->get('text_description'));

		$data['faqs'] = $this->model_support_faq->getFaqs();

		$data['column_left']    = $this->load->controller('common/column_left');
		$data['column_right']   = $this->load->controller('common/column_right');
		$data['content_top']    = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer']         = $this->load->controller('common/footer');
		$data['header']         = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('support/faq', $data));
	}
}
```

#### Bước 4: Đăng ký SEO URL & Sitemap Động
1. **Thêm SEO URL vào bảng `oc_seo_url`**:
   ```sql
   INSERT INTO `oc_seo_url` (`store_id`, `language_id`, `query`, `keyword`)
   VALUES (0, 1, 'route=support/faq', 'faq');
   ```
2. **Thêm vào Sitemap động (`application/controller/cms/sitemap.php`)**:
   Mở `ControllerCmsSitemap::index()` và thêm `'support/faq'` vào mảng `$static_routes` để `/sitemap.xml` tự động cập nhật đường dẫn mới.

---

### 3. Phát triển & Mở rộng Trang Quản trị (`admin/`)

#### 3.1. Bảo mật `user_token` và Phân quyền (`access` / `modify`)
Trong `admin/`, mọi URL đều phải đính kèm `user_token`:
```php
$url = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true);
```
Khi viết hàm thêm/sửa/xóa dữ liệu trong Admin Controller, luôn kiểm tra quyền `modify`:
```php
protected function validate() {
	if (!$this->user->hasPermission('modify', 'catalog/my_feature')) {
		$this->error['warning'] = $this->language->get('error_permission');
	}
	return !$this->error;
}
```
> **Cấp quyền cho trang Admin mới**: Vào **Admin -> System -> Users -> User Groups -> Edit Administrator**, tích chọn route mới ở cả 2 mục **Access Permission** và **Modify Permission** rồi nhấn **Save**.

#### 3.2. Thêm Mục Menu vào Thanh Bên Trái Admin (`column_left.php`)
Mở file `admin/controller/common/column_left.php` và thêm mục menu mới vào nhóm tương ứng (ví dụ nhóm `$marketplace`, `$sale`, `$cms`, hoặc `$system`):
```php
if ($this->user->hasPermission('access', 'catalog/my_feature')) {
	$cms[] = array(
		'name'     => 'Quản lý FAQ',
		'href'     => $this->url->link('catalog/my_feature', 'user_token=' . $this->session->data['user_token'], true),
		'children' => array()
	);
}
```

#### 3.3. Thêm Biến Cấu hình Hệ thống Mới (`System -> Settings`)
Tất cả các trường input có tên bắt đầu bằng `config_` trong trang `admin/controller/setting/setting.php` sẽ được lưu tự động vào bảng `oc_setting` khi nhấn Save và tự động nạp vào `$this->config->get('config_ten_bien')` ở mọi nơi trên hệ thống.

---

### 4. Mở rộng Hệ thống Không Chỉnh sửa Core bằng Event Hooks

Cơ chế **Event** (`system/engine/event.php` & `system/engine/loader.php`) cho phép bạn can thiệp vào trước (`before`) hoặc sau (`after`) bất kỳ Controller, Model, View hay Language nào.

**Ví dụ: Thêm dữ liệu vào trang Chi tiết Extension mà không cần sửa Controller hay file Twig gốc:**
1. Tạo file `application/controller/event/custom_extension.php`:
   ```php
   <?php
   class ControllerEventCustomExtension extends Controller {
       public function beforeViewExtensionInfo(&$route, &$data, &$code) {
           // Tự động thêm huy hiệu bảo mật vào biến $data trước khi render Twig
           $data['security_verified_badge'] = true;
       }
   }
   ```
2. Đăng ký sự kiện trong `system/config/application.php` (mảng `$_['action_event']`) hoặc thêm vào bảng `oc_event`:
   ```php
   'view/marketplace/extension_info/before' => array(
       'event/custom_extension/beforeViewExtensionInfo'
   )
   ```

---

### 5. Hướng dẫn Mở rộng Các Thư viện Cốt lõi (`system/library/`)

#### 5.1. Mở rộng Hệ thống Lưu trữ Đám mây (`system/library/cloud_storage.php`)
Thư viện [`CloudStorage`](file:///e:/wamp/www/retail/system/library/cloud_storage.php) hỗ trợ sẵn 5 driver:
- `local` (Ổ cứng máy chủ)
- `wasabi` (Wasabi Hot Cloud Storage)
- `cloudflare` (Cloudflare R2)
- `s3` (Amazon S3)
- `google` (Google Cloud Storage — hỗ trợ cả S3 Interop HMAC và Service Account JSON OAuth2)

**Cách gọi trong Controller bất kỳ khi xử lý upload/download file:**
```php
require_once(DIR_SYSTEM . 'library/cloud_storage.php');
$cloudStorage = new \CloudStorage($this->registry);

// 1. Lưu file upload và tự động đẩy lên Cloud Bucket (Wasabi / R2 / S3 / GCS)
$stored = $cloudStorage->storeUploadedFile(
	$this->request->files['file']['tmp_name'],
	DIR_UPLOAD . $filename,
	'upload',
	$filename
);

// 2. Cho phép người dùng tải file (Stream từ ổ đĩa hoặc Redirect sang link Pre-Signed URL trên Cloud)
$cloudStorage->outputFile(
	DIR_UPLOAD . $upload_info['filename'],
	$upload_info['name'],
	'upload',
	$upload_info['filename']
);

// 3. Xóa file đồng bộ trên Cloud Bucket
$cloudStorage->deleteObject('uploads/' . $upload_info['filename'], DIR_UPLOAD . $upload_info['filename']);
```

**Cách thêm một nhà cung cấp Cloud Storage mới (ví dụ: DigitalOcean Spaces, MinIO, Backblaze B2):**
- Mở `system/library/cloud_storage.php`, thêm mã driver vào hàm `getDriver()` và thêm cấu trúc URL endpoint vào hàm `resolveEndpoint()`. Vì hầu hết các dịch vụ Object Storage hiện đại đều tương thích chuẩn **AWS Signature V4 (`AWS4-HMAC-SHA256`)**, toàn bộ các hàm `putObject()`, `deleteObject()`, `getPresignedUrl()` và `testConnection()` sẽ hoạt động ngay lập tức.

#### 5.2. Tích hợp Cổng Thanh toán Mới (`system/library/payment_gateway.php`)
Thư viện [`PaymentGateway`](file:///e:/wamp/www/retail/system/library/payment_gateway.php) quản lý thanh toán qua **Stripe**, **Braintree**, và **PayPal**:
- Để tích hợp thêm cổng thanh toán nội địa hoặc quốc tế (ví dụ: **VNPay**, **MoMo**, **ZaloPay**, **SePay**, **Paddle**):
  1. Bổ sung trường cấu hình API Key / Secret Key trong `admin/controller/setting/setting.php` và `admin/view/template/setting/setting.twig`.
  2. Thêm phương thức xử lý giao dịch trong `system/library/payment_gateway.php` trả về mảng chuẩn gồm `success`, `provider`, `transaction_id`, `last_four`, `card_type`.
  3. Nếu cổng thanh toán sử dụng luồng Redirect / IPN Webhook, thêm hàm nhận kết quả trả về trong `application/controller/checkout/payment.php`, xác thực chữ ký số (`HMAC-SHA256` / `SHA512`) và cập nhật trạng thái đơn hàng qua `$this->model_checkout_order->editOrderStatus($order_id, $status_id)`.

---

### 6. Quản lý CSDL & Viết Kịch bản Nâng cấp (`Upgrade Migration`)

Khi bạn thêm bảng mới hoặc cột mới vào CSDL:
1. Tạo bước nâng cấp mới trong `install/controller/upgrade/` (ví dụ `upgrade_11.php`) và bổ sung hàm kiểm tra tương ứng vào `application/controller/upgrade/upgrade.php`.
2. **Luôn viết câu lệnh SQL an toàn (Idempotent)**: Kiểm tra sự tồn tại của bảng/cột trước khi chạy `CREATE TABLE` hoặc `ALTER TABLE`:
   ```php
   $check = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "extension` LIKE 'custom_field'");
   if (!$check->num_rows) {
       $this->db->query("ALTER TABLE `" . DB_PREFIX . "extension` ADD `custom_field` VARCHAR(255) NOT NULL DEFAULT ''");
   }
   ```
3. Sau khi thêm migration, truy cập `/index.php?route=upgrade/upgrade` trên trình duyệt để hệ thống tự động cập nhật cấu trúc bảng mà không làm mất dữ liệu hiện có.

---

### 7. Quy chuẩn Tối ưu Hiệu năng, Accessibility (WCAG 2.1 AA) & SEO

Để giữ vững điểm số **100/100 Google Lighthouse** trên mọi trang:
1. **Tuyệt đối không dùng link cứng (`http://localhost/...`)**:
   - Luôn dùng `$this->url->link('route', 'params', true)` trong PHP.
   - Hệ thống đã tự động nhận diện domain, giao thức `http`/`https` (kể cả qua Cloudflare / Reverse Proxy `X-Forwarded-Proto`) trong `config.php` và `admin/config.php`.
2. **Tối ưu HTML tự động qua `Response::optimizeCoreWebVitals()` (`system/library/response.php`)**:
   - Mọi trang HTML trả về từ Storefront đều được lớp `Response` tự động hậu xử lý:
     - Tự động đo kích thước ảnh và chèn `width`/`height` chống nhảy bố cục (`CLS = 0`).
     - Tự động thêm `loading="lazy"` cho ảnh phía dưới và `preload` cho ảnh Banner chính (`LCP`).
     - Tự động bổ sung `alt` cho ảnh, `aria-label` cho các nút chỉ có icon, chuẩn hóa thứ tự thẻ tiêu đề `<h1>` -> `<h2>` -> `<h3>` và chèn dữ liệu có cấu trúc OpenGraph / JSON-LD.
3. **Độ tương phản màu sắc (Contrast Ratio $\ge 4.5:1$)**:
   - Khi viết thêm CSS trong `application/view/stylesheet/stylesheet.css`, đảm bảo tỷ lệ tương phản giữa chữ và nền đạt tối thiểu **4.5:1** theo chuẩn WCAG 2.1 AA.

---

### 8. Kiểm thử, Ghi Log và Đóng gói Bản phát hành

1. **Ghi Log Debug**:
   - Sử dụng `$this->log->write('Nội dung debug');` để ghi vào file `system/storage/logs/error.log` hoặc xem trực tiếp trong **Admin -> System -> Maintenance -> Error Logs**.
2. **Kiểm tra cú pháp PHP (`php -l`)**:
   ```powershell
   php -l application/controller/marketplace/extension.php
   ```
3. **Đóng gói Bản phát hành (`opencart-core-vX.Y.Z.zip`)**:
   - Cập nhật hằng số `VERSION` trong `index.php` và `admin/index.php`.
   - Ghi nhận thay đổi vào `CHANGELOG.md`.
   - Nén toàn bộ mã nguồn (loại trừ file log và cache tạm) thành file `opencart-core-vX.Y.Z.zip` và cập nhật vào `system/storage/download/` để phân phối trên trang Download.

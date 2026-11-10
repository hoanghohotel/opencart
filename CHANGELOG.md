# Changelog — OpenCart Marketplace & Cloud Platform Suite

All notable changes, new features, security enhancements, and performance optimizations are documented in this file.
This project adheres to [Semantic Versioning](https://semver.org/).

---

## [v1.0.2] — 2026-11-10 (P0 Security Hardening: Payment Verification Boundary & Frontend CSRF Protection)

### Highlights (English)

#### 1. Verified Payment Completion Boundary (`PAY-01`, `PAY-02`, `SEC-02`)
- **Read-Only Checkout Result Pages (`ControllerCheckoutCheckout::success()`)**:
  - Removed order creation side effects (`addOrder()`) and session `pending_extension_order` consumption from `checkout/checkout/success`. Visiting or refreshing result pages can never grant paid extension entitlements.
  - Updated `checkout/confirm.twig` and `checkout/paypal.twig` AJAX callbacks so network errors redirect to `checkout/checkout/failure` and only responses containing both `success` and `order_id` navigate to `success`.
- **Fail-Closed Gateway Proof Validation (`ControllerCheckoutPayment::confirm()`, `PaymentGateway`)**:
  - Enforced `POST`, authenticated member session, timing-safe `hash_equals` on `member_token`, and strict verification of `pending_extension_order` (`member_id`, `extension_id`, `currency` snapshot, integer `quantity`, exact `price * quantity == total`, and supported gateway).
  - Removed all simulated/fallback transaction generation in `PaymentGateway::chargeStripe()`, `PaymentGateway::chargeBraintree()`, `ControllerCheckoutPayment::confirm()`, `marketplace/braintree/payment`, and `marketplace/paypal/send`.
  - Enabled strict TLS verification (`CURLOPT_SSL_VERIFYPEER = true`, `CURLOPT_SSL_VERIFYHOST = 2`) across Stripe, Braintree, and PayPal cURL adapters.
  - Added strict provider response schema & monetary precision validation (including zero-decimal currencies such as `VND`, `JPY`, `KRW`), rejecting malformed payloads, non-final statuses, manual-capture-only intents, and environment/merchant mismatches.

#### 2. Frontend CSRF Protection & Immutable Request Tokens (`SEC-01`)
- **Eliminated Startup Token Overwrite (`ControllerStartupStartup`)**:
  - Removed `$this->request->get['member_token'] = $this->session->data['member_token'];` so inbound client tokens are never overwritten by session state before controller validation.
- **Pre-Action CSRF & HTTP Method Policy (`ControllerStartupCsrf`, `ControllerErrorCsrf`)**:
  - Added `startup/csrf` pre-action after `startup/seo_url` with `Action`-equivalent route/method resolution.
  - Enforced `POST`-only execution (`405 Method Not Allowed`) across all 34 reviewed mutating routes (`csrf_post_routes`, including `support/seller/send`) and required timing-safe `hash_equals` `member_token` verification (`403 Forbidden` with `Cache-Control: no-store`) on all state-changing member requests.
  - Added safe canonical redirects for read-only account deep links (`csrf_read_routes`) without mutating inbound request parameters.
- **Same-Origin Client Helper & Full i18n Compatibility (`csrf.js`, `common/header`, `Response::optimizeCoreWebVitals()`)**:
  - Added `application/view/javascript/csrf.js` to upgrade legacy same-origin `index.php` AJAX/navigation mutations to `POST` with scoped `member_token` attachment while never leaking tokens to external or admin URLs.
  - Synchronized `defer` loading of `csrf.js` with `jquery` in `system/library/response.php` and localized all new security/checkout messages in `application/language/en-gb/`.
- **Regression Test Suite (`tests/regression/*`)**:
  - Added 145 automated regression test cases across `checkout_result_pages.php` (15), `payment_confirmation.php` (65), `frontend_csrf.php` (43), `payment_template_callbacks.js` (8), and `frontend_csrf_client.js` (14).

---

### Tóm tắt Phiên bản [v1.0.2] — 2026-11-10 (Tiếng Việt)

1. **Siết chặt ranh giới xác nhận Thanh toán & Tạo đơn hàng (`PAY-01`, `PAY-02`, `SEC-02`)**:
   - Loại bỏ hoàn toàn hành vi tạo đơn hàng từ trang hiển thị kết quả `checkout/checkout/success` và sửa lỗi điều hướng khi mất mạng về đúng `checkout/checkout/failure`.
   - Khóa toàn bộ các đường tạo đơn hàng giả lập không có bằng chứng thu tiền thật trong `checkout/payment/confirm`, `PaymentGateway` (`chargeStripe`, `chargeBraintree`) và các route cũ `marketplace/braintree/payment`, `marketplace/paypal/send`.
   - Bật xác thực chứng chỉ SSL/TLS (`CURLOPT_SSL_VERIFYPEER = true`, `CURLOPT_SSL_VERIFYHOST = 2`), kiểm tra nghiêm ngặt kiểu dữ liệu phản hồi từ cổng thanh toán, khớp số tiền, mã tiền tệ (hỗ trợ chuẩn tiền tệ 0 chữ số thập phân như `VND`), môi trường (`test`/`live`) và tài khoản merchant.
2. **Bảo vệ chống giả mạo yêu cầu CSRF ở Frontend (`SEC-01`)**:
   - Xóa dòng ghi đè `$this->request->get['member_token']` tại `startup/startup.php`.
   - Bổ sung middleware `startup/csrf` và `error/csrf` chặn mọi thao tác ghi bằng `GET`/`HEAD` (`405 Method Not Allowed`) trên 34 route thay đổi dữ liệu (bao gồm cả `support/seller/send`) và bắt buộc đối chiếu `hash_equals` `member_token` (`403 Forbidden`) với mọi thao tác ghi của thành viên.
   - Tích hợp `application/view/javascript/csrf.js` tương thích hoàn toàn với hệ thống đa ngôn ngữ i18n và cơ chế tối ưu `defer` của `Response::optimizeCoreWebVitals()`.
   - Đính kèm bộ 145 kịch bản kiểm thử tự động trong `tests/regression/` đạt **100% PASS**.

---

## [v1.0.1] — 2026-11-08 (Full Internationalization, Config-Driven Branding & Marketplace Enhancements)

### Highlights (English)

#### 1. Full Internationalization (i18n) & Multi-Language Architecture
- **100% Language-File-Driven UI (`application/language/en-gb/**`, `admin/language/en-gb/**`)**:
  - Created and structured **120 Frontend Language Files** (`account/`, `checkout/`, `cloud/`, `cms/`, `common/`, `error/`, `mail/`, `marketplace/`, `support/`) and **55 Admin Language Files**.
  - Eliminated hardcoded English strings across all PHP controllers (`application/controller/**`, `admin/controller/**`) and Twig templates (`application/view/template/**`, `admin/view/template/**`), enabling effortless translation into any target language.
- **Automatic View Language & Config Injection (`Loader::view()`, `Language::getTokenMap()`)**:
  - `Loader::view()` automatically loads both base controller language files and view-specific language files, merges all language keys into `$data`, and injects dynamic store configuration variables (`store_name`, `store_owner`, `store_domain`, `store_url`, `store_email`, `store_telephone`, `store_address`, `store_logo_url`, `contact_support`, `contact_partner`, `contact_marketing`, `forum`, `documentation`, `book`, `developer`, `dedicated_support`, `demo_store_url`, `demo_admin_url`).
  - Built-in dynamic placeholder interpolation (`{store_name}`, `{store_owner}`, `{store_domain}`, `{store_url}`, `{contact_support}`, etc.) inside language strings.

#### 2. 100% Config-Driven Contact Details, Domains & Local Assets
- **Zero Hardcoded Branding, Emails, Addresses, or Phone Numbers**:
  - Removed all hardcoded `@opencart.com` email addresses (`support@opencart.com`, `info@opencart.com`, `partners@opencart.com`, `media@opencart.com`, `noreply@opencart.com`), hardcoded `opencart.com` URLs, `OpenCart Limited` legal names, Hong Kong physical addresses, and `+852 2499 0996` phone numbers from controllers, templates, invoices (`account/order_info`, `account/promotion_info`, `account/subscription_invoice_info`), legal pages, and email templates (`mail/*`).
  - Added configurable Resource & Demo URLs (`config_forum_url`, `config_docs_url`, `config_book_url`, `config_developer_url`, `config_dedicated_support_url`, `config_demo_store_url`, `config_demo_admin_url`) in `Admin -> System -> Settings -> Store`.
  - Localized all external `image.opencart.com` assets into `application/view/image/cms/`.

#### 3. Marketplace Contact Seller, Official Release Sync & Admin Rich-Text Editor
- **Authenticated Contact Seller Workflow (`support/seller`, `mail/seller`)**:
  - Added `support/seller` controller, language file, and templates (`support/seller.twig`, `support/seller_success.twig`) requiring member login + PIN/IP security verification (`marketplace/extension/info` -> `Get Support`), storing enquiries in `oc_support_enquiry` (`type = 'seller'`) and dispatching formatted HTML + Plaintext email notifications (`ControllerMailSeller`) with `Reply-To` set to the buyer.
- **Official GitHub Releases Integration (`cms/download`, `cms/download/download`, `cms/download/history`)**:
  - Mapped official GitHub release archive URLs (`download_url`) across all 53 OpenCart releases (`1.4.8` through `4.1.0.4`) and added the Thank-You auto-download page (`cms/download/download`) with dynamic latest version resolution.
- **Admin Rich-Text Editor (Summernote + CodeMirror) & PHP 8.5 Compatibility**:
  - Restored Summernote WYSIWYG editor and CodeMirror syntax highlighting across all Admin CMS, Marketplace, and Partner forms (`admin/view/javascript/summernote/opencart.js`) with jQuery 3.7 compatibility.
  - Added strict null-safe casting in `system/engine/action.php` and `system/helper/utf8.php` for PHP 8.1+ / 8.5 `preg_replace()` compliance.

---

### Tóm tắt Phiên bản [v1.0.1] — 2026-11-08 (Tiếng Việt)

1. **Đa ngôn ngữ hóa (i18n) toàn diện (120 file ngôn ngữ Frontend & 55 file ngôn ngữ Admin)**:
   - Tách toàn bộ văn bản tiếng Anh cứng trong PHP Controller và giao diện `.twig` sang hệ thống file ngôn ngữ `application/language/en-gb/**` và `admin/language/en-gb/**`.
   - Nâng cấp `Loader::view()` và `Language::getTokenMap()` tự động nạp file ngôn ngữ theo route và tự động nội suy các biến cấu hình (`{store_name}`, `{store_owner}`, `{store_domain}`, `{contact_support}`...) ngay trong chuỗi dịch.
2. **Loại bỏ 100% Email, Tên miền, Địa chỉ, Điện thoại cứng — Động hóa hoàn toàn theo `Settings`**:
   - Xóa bỏ hoàn toàn các email `@opencart.com`, tên miền `opencart.com`, tên công ty `OpenCart Limited`, địa chỉ Hong Kong và số điện thoại `+852 2499 0996` trên mọi trang (Liên hệ, Quảng cáo, Điều khoản, Chính sách, Hóa đơn `order_info`/`promotion_info`/`subscription_invoice_info`, và Email `mail/*`).
   - Bổ sung cấu hình URL Diễn đàn, Tài liệu, Sách, Nhà phát triển, Hỗ trợ chuyên sâu và Link Demo trực tiếp trong `Admin -> System -> Settings -> Store`.
   - Tải toàn bộ hình ảnh từ `image.opencart.com` về thư mục nội bộ `application/view/image/cms/`.
3. **Tính năng Liên hệ Seller (`support/seller`), Trình soạn thảo Admin & Tương thích PHP 8.5**:
   - Bổ sung trang Liên hệ Nhà bán hàng (`support/seller`) bắt buộc đăng nhập từ trang chi tiết Extension, lưu lịch sử vào `oc_support_enquiry` và gửi email thông báo tự động (`mail/seller`) tới email của Seller.
   - Đồng bộ toàn bộ 53 bản phát hành OpenCart chính thức từ GitHub (`1.4.8` – `4.1.0.4`) kèm trang Thank You tự động tải xuống (`cms/download/download`).
   - Khôi phục trình soạn thảo văn bản phong phú Summernote + CodeMirror trong Admin (tương thích jQuery 3.7) và xử lý triệt để cảnh báo `preg_replace()` trên PHP 8.1+ / 8.5.

---

## [v1.0.0] — 2026-11-07 (Initial Commercial Core Release)

### Highlights (English)

#### 1. Storefront, Digital Marketplace & Cloud Ecosystem
- **Marketplace Extension & Theme Store (`marketplace/extension`, `marketplace/extension/info`)**:
  - Full extension directory with search, category navigation, license filter (Free / Commercial), OpenCart version filter, star rating filter, and sorting.
  - Enforced member authentication (`account/login` redirect with post-login return URL) before purchasing or downloading marketplace extensions.
  - Lightbox screenshot gallery, release changelog table, documentation tab, verified buyer reviews, and multi-level AJAX comment system.
- **Software Release Center & Paginated History (`cms/download`, `cms/download/history`)**:
  - Main download portal featuring top recommended extensions and themes alongside the latest core package.
  - Paginated Previous Releases archive (`cms/download/history`) displaying **10 releases per page** with full release notes and direct package downloads.
- **CMS, E-Commerce Blog, Showcase & Partner Directory (`cms/*`, `support/*`)**:
  - E-Commerce Blog (`cms/blog`, `cms/blog/info`) with category filtering, author archives, trending articles, and AJAX comment/reply threads.
  - Certified Partner Directory (`support/partner`, `support/partner/info`), Storefront Showcase (`cms/showcase`), Features Tour (`cms/feature`), Live Demo (`cms/demo`), Cloud Landing (`cloud/landing`), Support Center (`support/support`), and Contact Form (`support/contact`).

#### 2. Member Account, Security & Seller Portal (`account/*`)
- **Authentication & Multi-Layer Security**:
  - Member registration, email verification, password recovery, security PIN setup/confirmation (`account/security`), Two-Factor Authentication (`account/twofactor`), and automatic `member_token` propagation across authenticated URLs and AJAX requests.
- **Seller & Partner Management**:
  - Seller profile & payout configuration (`account/seller`) with strict null-safe array key handling (eliminating undefined index warnings on `website` and all profile fields).
  - Extension publishing & version management (`account/extension`), Seller Orders (`account/sale`), Partner profile management (`account/partner`), and Extension Promotion bidding (`account/promotion`).
- **Payment Methods & Tokenized Card Vault (`account/payment`, `checkout/*`, `PaymentGateway`)**:
  - Integrated Stripe, Braintree, and PayPal checkout flows.
  - Removed all hardcoded fallback/demo card numbers (`4242`) from `PaymentGateway`, checkout controllers, models, JavaScript, and database seed tables—only genuine last-4 digits returned by the gateway or entered by the user are stored.

#### 3. Administration Back-Office Enhancements (`admin/`)
- **Advanced Order Management (`admin/index.php?route=sale/order`)**:
  - Added multi-criteria filtering by **Order ID**, **Customer / Member**, **Order Status**, **Total Amount**, **Date Added**, and **Date Modified** (with integrated datepickers and Enter-key submission).
  - Added bi-directional column sorting (`ASC` / `DESC`) across all order list columns.
  - Implemented distinct, semantic color-coded status badges (`label-success` for Complete/Paid/Active, `label-info` for Processing/Shipped, `label-warning` for Pending, `label-primary` for Refunded/Reversed, `label-danger` for Cancelled/Failed/Expired/Denied/Voided) across the Order List, Order Info (`sale/order/info`), and Admin Dashboard (`common/dashboard`).
- **Built-in SMTP Diagnostics (`admin/controller/setting/setting.php`)**:
  - One-click SMTP test email sender and TLS/Authentication diagnostics inside System Settings.
- **Multi-Cloud Object Storage (`Wasabi`, `Cloudflare R2`, `Amazon S3`, `Google Cloud Storage`)**:
  - Added unified [`CloudStorage`](system/library/cloud_storage.php) library supporting AWS Signature Version 4 (`AWS4-HMAC-SHA256`), pre-signed download URLs, and native Google Service Account JSON OAuth2.
  - Integrated cloud storage across all upload/download/delete flows (`account/extension/upload`, `common/image`, `account/download`, `marketplace/download`, `cms/download`, `admin/controller/tool/upload`, `admin/controller/common/filemanager`) and added a dedicated **Cloud Storage** tab with live connection testing in `Admin -> System -> Settings`.

#### 4. Core Web Vitals, Accessibility (WCAG 2.1 AA), Best Practices & Dynamic SEO
- **Zero Hardcoded Localhost Links & Full Domain Portability**:
  - Automatic `HTTP_HOST`, `HTTPS` (including port `443` and reverse-proxy `X-Forwarded-Proto`), and `__DIR__` path detection in `config.php`, `admin/config.php`, and the web installer (`install/controller/install/step_3.php`).
  - Dynamic `/sitemap.xml` and `/robots.txt` generation (`ControllerCmsSitemap`) routed via `.htaccess` without any hardcoded `RewriteBase` or `localhost` URLs.
- **Lighthouse 100/100 Optimization (`Response::optimizeCoreWebVitals()`)**:
  - Automatic route-aware `<meta name="description">`, `<meta name="keywords">`, `<link rel="canonical">`, OpenGraph (`og:*`), Twitter Cards, and JSON-LD `Organization` structured data.
  - Persistent image dimension resolution (`cache.cwv_img_dims.json`) injecting explicit `width` and `height` attributes on every `<img>` to guarantee `CLS = 0`, `fetchpriority="high"` for LCP hero images, and `loading="lazy"` for below-the-fold images.
  - Automatic ARIA labeling (`aria-label`) for icon-only buttons, search/newsletter inputs, and select controls; automatic non-empty `alt` generation; duplicate DOM `id` deduplication; and sequential heading hierarchy normalization (`<h1>`–`<h6>`).
  - Updated `bootstrap.css` and `stylesheet.css` color palette to meet **WCAG 2.1 AA ($\ge 4.5:1$)** contrast ratios across all buttons, badges, links, and muted text.
  - Added HTTP security headers (`X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy`) and `rel="noopener noreferrer"` on external links.

---

### Tóm tắt Phiên bản [v1.0.0] — 2026-11-07 (Tiếng Việt)

1. **Hoàn thiện Hệ sinh thái Frontend & Marketplace**:
   - Đầy đủ các phân hệ Trang chủ, Tính năng, Demo, Chợ Extension (`marketplace/extension`), Chi tiết Extension (`marketplace/extension/info` bắt buộc đăng nhập khi mua), Tải xuống (`cms/download`), Lịch sử phiên bản (`cms/download/history` phân trang 10 bản phát hành/trang), Blog, Showcase, Cloud và Đối tác.
2. **Hệ thống Tài khoản, Bảo mật & Thanh toán**:
   - Đăng nhập/Đăng ký, xác thực 2FA, mã PIN bảo mật, cổng Nhà bán hàng (`account/seller` đã xử lý triệt để lỗi `Undefined array key`), quản lý thẻ thanh toán thực tế (loại bỏ hoàn toàn thẻ mặc định `4242`).
3. **Nâng cấp Trang Quản trị Admin (`admin/`)**:
   - Bổ sung bộ lọc đơn hàng đầy đủ (Mã đơn, Khách hàng, Trạng thái, Tổng tiền, Ngày tạo, Ngày sửa), sắp xếp theo cột và đồng bộ màu sắc nhãn trạng thái đơn hàng trên toàn bộ Admin.
   - Bổ sung trình nâng cấp CSDL tự động 10 bước (`/index.php?route=upgrade/upgrade`).
4. **Chuẩn hóa SEO Động, Accessibility, Best Practices & Core Web Vitals**:
   - Loại bỏ 100% đường dẫn tĩnh `http://localhost/retail/`; tự động nhận diện tên miền, SSL và đường dẫn thư mục khi cài đặt lên bất kỳ Hosting/VPS nào.
   - Tự động sinh `/sitemap.xml` và `/robots.txt` theo tên miền thực tế.
   - Đạt chuẩn tương phản màu sắc WCAG 2.1 AA ($\ge 4.5:1$), đầy đủ nhãn `aria-label`, thứ tự thẻ `H1`–`H6`, thẻ Meta SEO, OpenGraph, JSON-LD và HTTP Security Headers.

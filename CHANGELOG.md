# Changelog — OpenCart Marketplace & Cloud Platform Suite

All notable changes, new features, security enhancements, and performance optimizations are documented in this file.
This project adheres to [Semantic Versioning](https://semver.org/).

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

# OpenCart Marketplace & Cloud E-Commerce Platform Suite (Core v1.0.0)

[![Version](https://img.shields.io/badge/version-1.0.0-006bb3.svg)](CHANGELOG.md)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B%20%7C%208.2%20%7C%208.3-777bb4.svg)](INSTALL.md)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B%20%7C%20MariaDB%2010.4%2B-00758f.svg)](INSTALL.md)
[![License](https://img.shields.io/badge/license-Commercial%20Split%20%2F%20GPLv3-2b7a1e.svg)](LICENSE.md)

---

## PART I: ENGLISH DOCUMENTATION

### 1. Overview
**OpenCart Marketplace & Cloud E-Commerce Platform Suite (v1.0.0)** is a complete, production-ready digital marketplace, cloud store provisioning portal, developer ecosystem, and content management platform modeled on the official `opencart.com` architecture.

Built on a lightweight, high-performance MVC-L (Model-View-Controller-Language) PHP core with Twig templating, it is engineered for zero-configuration domain portability, enterprise security, and **100/100 Google Lighthouse** scores across Performance, Accessibility (WCAG 2.1 AA), Best Practices, and SEO.

---

### 2. Key Platform Modules & Features

- **Digital Extension & Theme Marketplace (`marketplace/extension`)**
  - Full catalog browsing with category filtering, license type (Free / Commercial), OpenCart version compatibility, rating filters, keyword search, and sorting.
  - Detailed extension product pages (`marketplace/extension/info`) with image galleries, documentation tabs, release changelogs, verified customer reviews, comment threads, and authenticated one-click download/purchase flows.
- **Member & Seller Account Ecosystem (`account/*`)**
  - Complete member registration, email verification, PIN security confirmation, Two-Factor Authentication (2FA), and session-bound `member_token` protection.
  - **Seller Portal**: Extension submission & management (`account/extension`), payout & tax profile configuration (`account/seller`), sales orders (`account/sale`), invoice generation, and promotional banner bidding (`account/promotion`).
  - **Buyer Dashboard**: Purchased orders (`account/order`), extension downloads (`account/download`), license subscriptions (`account/subscription`), vaulted payment methods (`account/payment`), showcase submissions (`account/showcase`), and Partner Directory applications (`account/partner`).
- **Multi-Gateway Checkout & Subscription Billing (`checkout/*`)**
  - Integrated payment processing supporting **Stripe**, **Braintree**, and **PayPal** with PCI-safe tokenized card vaulting (`PaymentGateway` library).
- **Cloud Hosting & Store Provisioning (`cloud/landing`)**
  - Interactive cloud plan showcase, server region map, and automated trial/subscription onboarding.
- **CMS, Release Downloads, Blog & Partner Directory (`cms/*`, `support/*`)**
  - Software release center (`cms/download`) and paginated release history (`cms/download/history` with 10 releases per page).
  - E-commerce Blog (`cms/blog`) with category tabs, trending posts, author filtering, and nested AJAX comments.
  - Certified Partner Directory (`support/partner`) with country filtering and detailed agency profiles (`support/partner/info`).
  - Storefront Showcase (`cms/showcase`), Live Demo launcher (`cms/demo`), Features tour (`cms/feature`), and Support/Contact center (`support/support`, `support/contact`).
- **Comprehensive Administration Panel (`admin/`)**
  - Full back-office management for Orders (with multi-criteria filtering, column sorting, and color-coded status badges), Marketplace Extensions, Members, Sellers, Blog Articles, Releases, Banners, System Settings, and built-in SMTP Diagnostics.
- **Multi-Cloud Object Storage Engine (`system/library/cloud_storage.php`)**
  - Native support for storing and serving uploaded files (Marketplace extension packages, user uploads, releases, and catalog images) on **Wasabi Hot Cloud Storage**, **Cloudflare R2**, **Amazon S3**, and **Google Cloud Storage (GCS)** (both S3-compatible HMAC and native Service Account JSON OAuth2), with AWS Signature V4 Pre-Signed Download URLs and one-click connection testing in `Admin -> System -> Settings -> Cloud Storage`.
- **Core Web Vitals, Accessibility (A11y) & Dynamic SEO Engine**
  - Automatic image dimension resolution (zero CLS), LCP preloading, deferred non-critical assets, WCAG 2.1 AA contrast compliance, automatic ARIA labeling, heading hierarchy normalization, OpenGraph/Twitter Cards, JSON-LD `Organization` schema, and dynamic domain-aware `/sitemap.xml` & `/robots.txt`.

---

### 3. System Requirements

| Component | Minimum | Recommended |
| :--- | :--- | :--- |
| **PHP Version** | PHP 8.0+ | **PHP 8.1 / 8.2 / 8.3** |
| **Database** | MySQL 5.7+ / MariaDB 10.3+ | **MySQL 8.0+ / MariaDB 10.6+** |
| **Web Server** | Apache 2.4+ (`mod_rewrite`, `mod_deflate`, `mod_expires`) or Nginx | Apache 2.4+ / LiteSpeed / Nginx |
| **PHP Extensions** | `mysqli`, `gd`, `curl`, `zip`, `zlib`, `openssl`, `mbstring`, `json` | + `opcache` enabled |
| **SSL / HTTPS** | Optional on `localhost` | **Required in Production** (Supports Reverse Proxy / Cloudflare `X-Forwarded-Proto`) |

---

### 4. Directory Structure

```text
├── admin/                  # Back-office Administration Panel (Controllers, Models, Views, Languages)
├── application/            # Storefront & Marketplace Application (MVC-L + Twig Templates)
├── image/                  # Media Assets, Catalog Images, Resized Cache & Watermarks
├── install/                # Web & CLI Installer, 10-Step Upgrade Engine & Database Seed (opencart.sql)
├── system/                 # Core Framework Engine, Libraries (Response, Mail/SMTP, PaymentGateway), Storage
├── .htaccess               # Apache Rewrite Rules, Dynamic Sitemap/Robots Routing, Gzip & Caching Headers
├── config.php              # Storefront Configuration (Auto-detects Domain, SSL & Directory Paths)
├── index.php               # Storefront Front Controller (Defines VERSION = '1.0.0')
├── INSTALL.md              # Step-by-Step Installation Guide
├── UPGRADE.md              # Step-by-Step Upgrade & Migration Guide
├── DEVELOPER-GUIDE.md      # Architecture & Developer Extension Guide
├── CHANGELOG.md            # Version Release History & Detailed Changes
└── LICENSE.md              # Commercial Split-License & GNU GPLv3 Agreement
```

---

### 5. Quick Documentation Links

- **[Installation Guide (`INSTALL.md`)](INSTALL.md)** — Fresh installation via Web Installer, Manual SQL Import, or CLI.
- **[Upgrade Guide (`UPGRADE.md`)](UPGRADE.md)** — Upgrading existing installations and running the 10-step schema migration.
- **[Developer Guide (`DEVELOPER-GUIDE.md`)](DEVELOPER-GUIDE.md)** — MVC-L architecture, creating modules, Event hooks, extending Cloud Storage & Payment Gateways.
- **[Release Changelog (`CHANGELOG.md`)](CHANGELOG.md)** — Full list of features, fixes, and optimizations in **Core v1.0.0**.
- **[License Agreement (`LICENSE.md`)](LICENSE.md)** — Commercial Split-License and GNU GPLv3 terms.

---
---

## PHẦN II: TÀI LIỆU HƯỚNG DẪN TIẾNG VIỆT

### 1. Giới thiệu tổng quan
**OpenCart Marketplace & Cloud E-Commerce Platform Suite (Core v1.0.0)** là bộ mã nguồn nền tảng chợ ứng dụng số (Digital Marketplace), cổng dịch vụ Cloud E-Commerce, cộng đồng nhà phát triển và hệ thống quản trị nội dung (CMS/Blog) hoàn chỉnh theo chuẩn kiến trúc `opencart.com`.

Hệ thống được tối ưu hóa sẵn cho **PHP 8.1 / 8.2 / 8.3** và **MySQL 8.0+**, tự động nhận diện tên miền/SSL/thư mục cài đặt mà không cần cấu hình đường dẫn cứng, đồng thời đạt điểm tuyệt đối **100/100 Google Lighthouse** về Hiệu năng (Core Web Vitals), Khả năng truy cập (Accessibility WCAG 2.1 AA), Best Practices và SEO.

---

### 2. Các phân hệ chức năng chính

1. **Chợ Ứng dụng & Giao diện (`marketplace/extension`)**:
   - Tìm kiếm, lọc theo danh mục, giấy phép (Miễn phí / Thương mại), phiên bản tương thích, điểm đánh giá.
   - Trang chi tiết sản phẩm số (`marketplace/extension/info`) với trình xem ảnh Lightbox, tài liệu hướng dẫn, lịch sử phát hành, đánh giá thực tế, bình luận và luồng bắt buộc đăng nhập trước khi mua/tải xuống.
2. **Hệ sinh thái Tài khoản Thành viên & Nhà bán hàng (`account/*`)**:
   - Đăng ký, xác thực email, mã bảo mật PIN, xác thực 2 lớp (2FA), bảo vệ phiên làm việc bằng `member_token`.
   - **Cổng Nhà bán hàng (Seller Portal)**: Đăng tải và quản lý Extension (`account/extension`), cấu hình thông tin nhà bán & thuế (`account/seller`), quản lý đơn hàng bán ra (`account/sale`), quảng cáo từ khóa (`account/promotion`).
   - **Bảng điều khiển Người mua**: Quản lý đơn hàng (`account/order`), tải về bản quyền (`account/download`), gói thuê bao (`account/subscription`), quản lý thẻ thanh toán lưu trữ an toàn (`account/payment`), gửi dự án (`account/showcase`) và đăng ký Đối tác (`account/partner`).
3. **Thanh toán Đa cổng & Thuê bao định kỳ (`checkout/*`)**:
   - Tích hợp **Stripe**, **Braintree**, **PayPal** thông qua thư viện `PaymentGateway` chuẩn hóa (lưu trữ4 số cuối thực tế từ cổng thanh toán, loại bỏ hoàn toàn dữ liệu thẻ mẫu).
4. **Hệ thống Quản trị Admin toàn diện (`admin/`)**:
   - Quản lý Đơn hàng với bộ lọc đa tiêu chí (Order ID, Khách hàng, Trạng thái, Tổng tiền, Ngày tạo/sửa), sắp xếp theo cột, nhãn màu trạng thái trực quan (Hoàn thành, Đang xử lý, Chờ duyệt, Hoàn tiền, Đã hủy).
   - Quản lý Extension, Thành viên, Đối tác, Bài viết Blog, Bản phát hành (Downloads), Cấu hình hệ thống và công cụ kiểm tra gửi thư SMTP trực tiếp.
5. **Tự động hóa SEO, Sitemap & Core Web Vitals**:
   - Tự động sinh `/sitemap.xml` và `/robots.txt` động theo đúng tên miền thực tế thông qua `ControllerCmsSitemap`.
   - Tự động chèn Canonical URL, OpenGraph, Twitter Card, JSON-LD Schema, thuộc tính `width`/`height` chống nhảy bố cục (CLS = 0) và chuẩn hóa khả năng truy cập WCAG 2.1 AA.

---

### 3. Tài liệu đi kèm

- **[Hướng dẫn Cài đặt (`INSTALL.md`)](INSTALL.md)**: Hướng dẫn cài đặt mới trên Hosting (cPanel/DirectAdmin/VPS) và Localhost.
- **[Hướng dẫn Nâng cấp (`UPGRADE.md`)](UPGRADE.md)**: Hướng dẫn cập nhật phiên bản và chạy trình nâng cấp CSDL tự động.
- **[Hướng dẫn Phát triển & Mở rộng Code (`DEVELOPER-GUIDE.md`)](DEVELOPER-GUIDE.md)**: Kiến trúc MVC-L, cách viết module mới, Event hooks, tích hợp cổng thanh toán và Cloud Storage.
- **[Lịch sử Phiên bản (`CHANGELOG.md`)](CHANGELOG.md)**: Chi tiết các tính năng và bản vá trong phiên bản **Core v1.0.0**.
- **[Điều khoản Bản quyền (`LICENSE.md`)](LICENSE.md)**: Quy định về Giấy phép Thương mại & GNU GPLv3.

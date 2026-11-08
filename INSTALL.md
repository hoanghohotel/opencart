# Installation Guide — Core v1.0.1 (Hướng dẫn Cài đặt)

This document provides step-by-step instructions for installing **OpenCart Marketplace & Cloud E-Commerce Platform Suite v1.0.1** on production web hosting (cPanel, DirectAdmin, Plesk, CyberPanel, VPS) or local development environments (WAMP, XAMPP, Laragon, Docker).

> Looking to upgrade an existing installation? Please read **[UPGRADE.md](UPGRADE.md)** instead.

---

## PART I: ENGLISH INSTALLATION INSTRUCTIONS

### 1. Pre-Installation Requirements

Ensure your server meets the following requirements before starting:
- **PHP**: `8.1`, `8.2`, or `8.3` (Minimum: PHP `8.0`)
- **Database**: MySQL `8.0+` or MariaDB `10.4+`
- **Web Server**: Apache `2.4+` (with `mod_rewrite` enabled) or Nginx
- **Required PHP Extensions**: `mysqli`, `gd`, `curl`, `zip`, `zlib`, `openssl`, `mbstring`
- **PHP Settings**: `file_uploads = On`, `session.auto_start = Off`, `memory_limit >= 128M`

---

### 2. Method A: Quick Installation (Pre-Seeded Database Import — Recommended)

Because `config.php` and `admin/config.php` in **Core v1.0.1** automatically detect your domain (`HTTP_HOST`), SSL/HTTPS protocol (including Cloudflare / Reverse Proxy headers), and server filesystem paths (`__DIR__`), deploying to any live domain or subfolder takes only 3 steps:

1. **Upload Source Files**:
   - Extract the release archive (`opencart-core-v1.0.1.zip`) and upload all files to your web root (e.g., `public_html/`, `httpdocs/`, or a subdirectory).
2. **Create & Import the Database**:
   - Create a new MySQL/MariaDB database and user in your hosting control panel (cPanel / phpMyAdmin).
   - Import the full database schema and seed file located at:
     ```text
     install/opencart.sql
     ```
3. **Configure Database Credentials**:
   - Open **`config.php`** and **`admin/config.php`** and update ONLY the database connection constants at the bottom of both files:
     ```php
     // DB
     define('DB_DRIVER', 'mysqli');
     define('DB_HOSTNAME', 'localhost');
     define('DB_USERNAME', 'your_db_user');
     define('DB_PASSWORD', 'your_db_password');
     define('DB_DATABASE', 'your_db_name');
     define('DB_PORT', '3306');
     define('DB_PREFIX', 'oc_');
     ```
   - *Note*: You do **not** need to edit `HTTP_SERVER`, `HTTPS_SERVER`, or `DIR_*` constants—they adapt automatically to your live domain and directory!

---

### 3. Method B: Interactive Web Installer (`/install`)

If you prefer using the graphical step-by-step web wizard:

1. Upload all files to your server web root.
2. Replace `config.php` and `admin/config.php` with empty writable files (or copy `config-dist.php` to `config.php` and `admin/config-dist.php` to `admin/config.php`).
3. Ensure the following files and directories are writable (`chmod 0755` or `0775` on Linux):
   - `config.php`
   - `admin/config.php`
   - `image/` and `image/cache/`, `image/catalog/`
   - `system/storage/cache/`
   - `system/storage/logs/`
   - `system/storage/download/`
   - `system/storage/upload/`
   - `system/storage/modification/`
   - `system/storage/session/`
4. Open your browser and navigate to `https://yourdomain.com/install/`.
5. Follow the 4-step on-screen wizard:
   - **Step 1**: License Agreement acceptance.
   - **Step 2**: Pre-installation environment & permissions check.
   - **Step 3**: Database credentials and primary Administrator account creation.
   - **Step 4**: Installation complete.

---

### 4. Method C: Command-Line (CLI) Installation

For automated CI/CD or VPS terminal deployments:

```bash
php install/cli_install.php install \
  --db_hostname localhost \
  --db_username your_db_user \
  --db_password your_db_password \
  --db_database your_db_name \
  --db_driver mysqli \
  --db_port 3306 \
  --db_prefix oc_ \
  --username admin \
  --password YourStrongPassword123! \
  --email admin@yourdomain.com \
  --http_server https://yourdomain.com/
```

---

### 5. Post-Installation Production Checklist

1. **Secure or Remove `/install/`**:
   - Once installation and any database upgrades are complete, delete or restrict access to the `/install/` directory on production servers.
2. **Verify Dynamic SEO Endpoints**:
   - Visit `https://yourdomain.com/robots.txt` and `https://yourdomain.com/sitemap.xml` to confirm they automatically reflect your live domain.
3. **Configure Store, Mail (SMTP) & Payment Gateways**:
   - Log in to `https://yourdomain.com/admin/` (`System -> Settings`).
   - Configure your Store Name, Owner, Email, and SMTP Mail settings (use the built-in **Send Test Email** button in the Mail tab to verify SMTP connectivity).
   - Configure your live/sandbox API keys for Stripe, Braintree, or PayPal.
4. **Disable Error Display in Production**:
   - In `Admin -> System -> Settings -> Server`, set **Display Errors** to `No` (keep **Log Errors** set to `Yes`).

---
---

## PHẦN II: HƯỚNG DẪN CÀI ĐẶT (TIẾNG VIỆT)

### 1. Yêu cầu Hệ thống

- **PHP**: Khuyên dùng **PHP 8.1, 8.2 hoặc 8.3** (Tối thiểu PHP 8.0).
- **Cơ sở dữ liệu**: **MySQL 8.0+** hoặc **MariaDB 10.4+**.
- **Web Server**: Apache 2.4+ (bật `mod_rewrite`) hoặc Nginx / LiteSpeed.
- **PHP Extensions bắt buộc**: `mysqli`, `gd`, `curl`, `zip`, `zlib`, `openssl`, `mbstring`.

---

### 2. Cách 1: Cài đặt Nhanh bằng Import SQL (Khuyên dùng cho Hosting & Localhost)

Nhờ cơ chế tự động nhận diện tên miền (`HTTP_HOST`), giao thức `HTTPS`/Cloudflare và đường dẫn thư mục (`__DIR__`) được tích hợp sẵn trong `config.php` và `admin/config.php` của bản **Core v1.0.1**, bạn không cần sửa bất kỳ đường dẫn URL hay thư mục nào khi đưa lên Hosting thật:

1. **Tải mã nguồn lên Hosting**:
   - Giải nén gói `opencart-core-v1.0.1.zip` vào thư mục gốc của tên miền (ví dụ `public_html/` trên cPanel/DirectAdmin hoặc thư mục bất kỳ trên WAMP/XAMPP).
2. **Tạo Database & Import dữ liệu**:
   - Tạo một Database MySQL mới trên Hosting.
   - Mở **phpMyAdmin** (hoặc MySQL CLI) và import file dữ liệu chuẩn:
     ```text
     install/opencart.sql
     ```
3. **Khai báo thông tin Database**:
   - Mở 2 file **`config.php`** và **`admin/config.php`**, chỉ cần điền thông tin kết nối Database của bạn ở cuối file:
     ```php
     // DB
     define('DB_DRIVER', 'mysqli');
     define('DB_HOSTNAME', 'localhost');
     define('DB_USERNAME', 'ten_user_db');
     define('DB_PASSWORD', 'mat_khau_db');
     define('DB_DATABASE', 'ten_database');
     define('DB_PORT', '3306');
     define('DB_PREFIX', 'oc_');
     ```
   - Truy cập ngay trang chủ `https://ten-mien-cua-ban.com/` và trang quản trị `https://ten-mien-cua-ban.com/admin/`!

---

### 3. Cách 2: Cài đặt qua Trình cài đặt Web (`/install`)

1. Tải toàn bộ mã nguồn lên Hosting.
2. Làm rỗng nội dung 2 file `config.php` và `admin/config.php` (hoặc chép đè từ `config-dist.php` và `admin/config-dist.php`).
3. Cấp quyền ghi (`chmod 755` hoặc `775`) cho `config.php`, `admin/config.php`, thư mục `image/` và `system/storage/`.
4. Truy cập `https://ten-mien-cua-ban.com/install/` và làm theo 4 bước hướng dẫn trên màn hình.

---

### 4. Các bước kiểm tra sau khi cài đặt lên Production

1. **Bảo mật thư mục `/install/`**: Xóa hoặc đổi tên thư mục `/install/` sau khi đã cài đặt và nâng cấp xong.
2. **Kiểm tra Sitemap & Robots tự động**: Truy cập `https://ten-mien-cua-ban.com/sitemap.xml` và `/robots.txt` để xác nhận hệ thống đã tự động nhận tên miền mới.
3. **Cấu hình SMTP & Cổng thanh toán**: Vào `Admin -> System -> Settings -> Mail` để cấu hình SMTP và bấm nút kiểm tra gửi mail trực tiếp; cập nhật khóa API thực tế cho Stripe / Braintree / PayPal trước khi mở bán chính thức.

# Upgrade & Migration Guide — Core v1.0.0 (Hướng dẫn Nâng cấp)

This guide explains how to safely upgrade an existing OpenCart installation or an earlier build of the platform to **OpenCart Marketplace & Cloud E-Commerce Platform Suite Core v1.0.0**.

---

## PART I: ENGLISH UPGRADE INSTRUCTIONS

### 1. Pre-Upgrade Backup Checklist (Mandatory)

Before uploading any files or running database migrations, always create a full backup:

1. **Database Backup**:
   - Export a complete SQL dump of your existing database using **phpMyAdmin**, `mysqldump`, or `Admin -> System -> Maintenance -> Backup / Restore`.
2. **Configuration & Media Backup**:
   - Create a backup copy of your existing:
     - `config.php`
     - `admin/config.php`
     - `image/` directory
     - `system/storage/download/` and `system/storage/upload/` directories

---

### 2. Step-by-Step Upgrade Procedure

#### Step 1: Upload Core v1.0.0 Files
1. Extract the `opencart-core-v1.0.0.zip` package.
2. Upload all files to your server, overwriting existing core files **except** your database credentials in `config.php` and `admin/config.php` (and your custom uploads in `image/` and `system/storage/download/`).
3. **Important — Upgrade `config.php` & `admin/config.php` to Dynamic Domain Detection**:
   - Ensure the top of your `config.php` and `admin/config.php` uses the dynamic `HTTP_SERVER` / `HTTPS_SERVER` and `__DIR__` resolution introduced in **v1.0.0** while keeping your existing `DB_*` constants at the bottom.

#### Step 2: Run the Automated 10-Step Database Upgrade Wizard
1. Make sure the `/install/` directory is present on your server.
2. Open your browser and navigate to either:
   - `https://yourdomain.com/index.php?route=upgrade/upgrade`
   - or `https://yourdomain.com/install/index.php?route=upgrade/upgrade`
3. Click the **Continue** button.
4. The upgrade engine will automatically execute all 10 migration patches (`install/model/upgrade/1000.php` through `1009.php`):
   - Normalizes table character sets and collations (`utf8mb4` / `utf8_general_ci`).
   - Adds missing columns, primary keys, and indexes across core, marketplace, member, subscription, and blog tables.
   - Migrates legacy serialized settings to JSON format.
   - Synchronizes event hooks, session handlers, and configuration defaults.
5. Wait until the progress bar reaches **100%** and displays:
   > `Congratulations! You have successfully upgraded your OpenCart installation!`

#### Step 3: Clear System, Image Dimension & Browser Caches
1. Delete cached files inside:
   - `system/storage/cache/*` (including `cache.cwv_img_dims.json` if image assets changed)
   - `system/storage/modification/*`
2. In your browser, press `Ctrl + F5` (Windows/Linux) or `Cmd + Shift + R` (macOS) to reload updated CSS (`bootstrap.css`, `stylesheet.css`) and JavaScript (`common.js`).

#### Step 4: Verify Administrator Permissions & System Settings
1. Log in to the Administration Panel (`/admin/`) as the Top Administrator.
2. Navigate to **`System -> Users -> User Groups`**, edit **Top Administrator**, click **Select All** for both *Access Permission* and *Modify Permission*, and click **Save**.
3. Navigate to **`System -> Settings`**, edit your Store, verify all tabs, and click **Save**.
4. Remove or restrict web access to the `/install/` directory once the upgrade is verified.

---

### 3. Troubleshooting Common Upgrade Issues

| Symptom | Cause | Solution |
| :--- | :--- | :--- |
| Visiting `/install/` opens the **New Installation** wizard instead of **Upgrade** | `config.php` is empty or missing `DIR_APPLICATION` | Restore your `config.php` and `admin/config.php`, or navigate directly to `/index.php?route=upgrade/upgrade`. |
| Layout or button colors appear unstyled after upgrade | Browser cached an older version of `stylesheet.css` or `bootstrap.css` | Perform a hard refresh (`Ctrl + F5`) or clear CDN/Cloudflare cache. |
| "Permission Denied!" inside Admin panel on newly added routes | User Group permissions have not been refreshed | Go to `Admin -> System -> Users -> User Groups -> Top Administrator`, select all checkboxes, and save. |
| Broken links after migrating from `localhost` to a live domain | Hardcoded `RewriteBase` or static `HTTP_SERVER` in an old config file | Use the v1.0.0 `.htaccess` (which omits hardcoded `RewriteBase`) and v1.0.0 dynamic `config.php` / `admin/config.php`. |

---
---

## PHẦN II: HƯỚNG DẪN NÂNG CẤP (TIẾNG VIỆT)

### 1. Sao lưu Dữ liệu trước khi Nâng cấp (Bắt buộc)

Trước khi thực hiện nâng cấp lên **Core v1.0.0**, hãy đảm bảo bạn đã sao lưu:
1. **Cơ sở dữ liệu (Database)**: Xuất file `.sql` qua phpMyAdmin hoặc công cụ `Admin -> System -> Maintenance -> Backup / Restore`.
2. **Tệp cấu hình & Tài nguyên**: Sao lưu `config.php`, `admin/config.php`, thư mục `image/` và `system/storage/download/`.

---

### 2. Quy trình Nâng cấp từng bước

#### Bước 1: Tải lên mã nguồn Core v1.0.0
1. Giải nén gói `opencart-core-v1.0.0.zip` và tải đè các tệp hệ thống lên máy chủ (giữ nguyên thông số kết nối `DB_*` trong `config.php` và `admin/config.php`).
2. Khuyến nghị sử dụng cấu trúc `config.php` và `admin/config.php` mới của bản **v1.0.0** để hệ thống tự động nhận diện Domain, HTTPS và đường dẫn thư mục bằng `__DIR__`.

#### Bước 2: Chạy Trình Nâng cấp CSDL Tự động (`/index.php?route=upgrade/upgrade`)
1. Đảm bảo thư mục `/install/` đang tồn tại trên máy chủ.
2. Mở trình duyệt và truy cập:
   ```text
   https://ten-mien-cua-ban.com/index.php?route=upgrade/upgrade
   ```
   *(Hệ thống sẽ tự động chuyển hướng sang `install/index.php?route=upgrade/upgrade`)*.
3. Nhấn nút **Continue** để chạy tuần tự 10 bước cập nhật cấu trúc bảng dữ liệu (`1000.php` → `1009.php`).
4. Đợi thanh tiến trình đạt **100%** và hiển thị thông báo nâng cấp thành công.

#### Bước 3: Xóa Cache & Cập nhật Quyền Quản trị (Admin Permissions)
1. Xóa các file đệm trong `system/storage/cache/` và nhấn tổ hợp phím `Ctrl + F5` trên trình duyệt để tải lại bộ CSS/JS mới nhất.
2. Đăng nhập vào trang Quản trị (`/admin/`), truy cập **`System -> Users -> User Groups -> Top Administrator`**, tích chọn tất cả các quyền (*Access Permission* & *Modify Permission*) rồi nhấn **Save**.
3. Truy cập **`System -> Settings`**, kiểm tra lại cấu hình cửa hàng và nhấn **Save**.
4. Xóa hoặc khóa quyền truy cập thư mục `/install/` để đảm bảo an toàn bảo mật trên môi trường Production.

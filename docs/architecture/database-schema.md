# Schema và quan hệ dữ liệu

Nguồn chuẩn: [install/opencart.sql:1](../../install/opencart.sql#L1). 58/59 bảng dùng MyISAM; riêng oc_session dùng InnoDB; không có FOREIGN KEY hoặc UNIQUE KEY ngoài PRIMARY KEY. Các index KEY thường không bảo đảm duy nhất. Dữ liệu seed không chứng minh quan hệ bắt buộc hoặc toàn vẹn tham chiếu.

## Quy tắc đọc ER

- Đường quan hệ nét đứt trong `07-database-er.drawio` là lookup/join/ghi dữ liệu có bằng chứng trong code; không phải constraint SQL.
- `1:N`: bảng cha lookup bằng PK, nhiều dòng bảng con có thể mang cùng ID. Không khẳng định mọi dòng con có cha hợp lệ; nhiều cột dùng 0 như giá trị không liên kết.
- Không có cơ sở để khẳng định quan hệ 1:1 được database cưỡng chế giữa member và seller/partner/payment. `member_seller.member_id` không UNIQUE.
- Quan hệ N:N có bằng chứng: extension download ↔ release version (`oc_download`) qua `oc_extension_download_path`, PK kép `(extension_download_id,download_id)`, được ghi trong `admin/model/marketplace/extension.php::editExtension()` và dùng trong bộ lọc version.
- `oc_information_description` có PK kép `(information_id,language_id)`; `oc_information_to_store` có PK kép `(information_id,store_id)`. Bảng nối tồn tại trong DDL; không coi mọi bảng nối đều đang được frontend dùng. `getInformation()` không join information_to_store.
- `oc_order` lưu một extension_id, quantity, giá snapshot, seller_id và member_id; không có order_product/cart/shipping trong schema này.
- Payment vault là `oc_member_payment`; transaction gateway nằm trong `oc_order.transaction_id` hoặc subscription transaction. Không có bảng payment chung riêng biệt.
- Không tự nối `oc_session.session_id` với API session chỉ vì cùng tên: API startup có query riêng, không có FK.

## Quan hệ có bằng chứng cụ thể

| Cha | Con | Quan hệ | Bằng chứng |
|---|---|---|---|
| `oc_member` | `oc_extension` | member_id = member_id · 1:N | [application/model/marketplace/extension.php:15](../../application/model/marketplace/extension.php#L15) |
| `oc_extension_category` | `oc_extension` | extension_category_id · 1:N | [application/model/marketplace/extension.php:15](../../application/model/marketplace/extension.php#L15) |
| `oc_extension` | `oc_extension_download` | extension_id · 1:N | [admin/model/marketplace/extension.php:33](../../admin/model/marketplace/extension.php#L33) |
| `oc_extension_download` | `oc_extension_download_path` | extension_download_id · 1:N | [admin/model/marketplace/extension.php:33](../../admin/model/marketplace/extension.php#L33) |
| `oc_download` | `oc_extension_download_path` | download_id · 1:N (bảng nối version) | [admin/model/marketplace/extension.php:33](../../admin/model/marketplace/extension.php#L33) |
| `oc_member` | `oc_order` | member_id (buyer) · 1:N | [application/model/account/order.php:67](../../application/model/account/order.php#L67) |
| `oc_member` | `oc_order` | seller_id (seller) · 1:N | [application/model/account/order.php:67](../../application/model/account/order.php#L67) |
| `oc_extension` | `oc_order` | extension_id · 1:N | [application/model/account/order.php:67](../../application/model/account/order.php#L67) |
| `oc_member` | `oc_member_transaction` | member_id · 1:N | [application/model/account/order.php:3](../../application/model/account/order.php#L3) |
| `oc_order` | `oc_member_transaction` | order_id · 1:N | [application/model/account/order.php:3](../../application/model/account/order.php#L3) |
| `oc_member` | `oc_member_seller` | member_id · N tối đa chưa khóa UNIQUE | [application/model/account/order.php:3](../../application/model/account/order.php#L3) |
| `oc_member` | `oc_subscription` | member_id · 1:N | [application/model/account/subscription.php:27](../../application/model/account/subscription.php#L27) |
| `oc_subscription_plan` | `oc_subscription` | subscription_plan_id · 1:N | [application/model/account/subscription.php:27](../../application/model/account/subscription.php#L27) |
| `oc_member_payment` | `oc_subscription` | member_payment_id · 1:N, có thể 0 | [application/model/account/subscription.php:27](../../application/model/account/subscription.php#L27) |
| `oc_subscription` | `oc_subscription_history` | subscription_id · 1:N | [application/model/account/subscription.php:241](../../application/model/account/subscription.php#L241) |
| `oc_user_group` | `oc_user` | user_group_id · 1:N | [system/library/cart/user.php:12](../../system/library/cart/user.php#L12) |
| `oc_extension` | `oc_extension_image` | extension_id · 1:N | [admin/model/marketplace/extension.php:33](../../admin/model/marketplace/extension.php#L33) |
| `oc_extension` | `oc_extension_comment` | extension_id · 1:N | [application/model/marketplace/extension.php:15](../../application/model/marketplace/extension.php#L15) |
| `oc_member` | `oc_member_payment` | member_id · 1:N | [application/model/account/payment.php:101](../../application/model/account/payment.php#L101) |
| `oc_member` | `oc_member_partner` | member_id · 1:N, không UNIQUE | [application/model/account/partner.php:3](../../application/model/account/partner.php#L3) |
| `oc_member_partner_type` | `oc_member_partner` | member_partner_type_id · 1:N | [application/model/account/partner.php:3](../../application/model/account/partner.php#L3) |
| `oc_member_partner_status` | `oc_member_partner` | member_partner_status_id · 1:N | [application/model/account/partner.php:3](../../application/model/account/partner.php#L3) |
| `oc_country` | `oc_member_partner` | country_id · 1:N | [application/model/account/partner.php:3](../../application/model/account/partner.php#L3) |
| `oc_zone` | `oc_member_partner` | zone_id · 1:N | [application/model/account/partner.php:3](../../application/model/account/partner.php#L3) |
| `oc_information` | `oc_information_description` | information_id · 1:N theo language | [application/model/cms/information.php:3](../../application/model/cms/information.php#L3) |
| `oc_banner` | `oc_banner_image` | banner_id · 1:N | [application/model/design/banner.php:3](../../application/model/design/banner.php#L3) |
| `oc_member` | `oc_blog_comment` | member_id · 1:N | [application/model/cms/blog.php:119](../../application/model/cms/blog.php#L119) |
| `oc_blog` | `oc_blog_comment` | blog_id · 1:N | [application/model/cms/blog.php:125](../../application/model/cms/blog.php#L125) |
| `oc_showcase_category` | `oc_showcase` | showcase_category_id · 1:N | [application/model/cms/showcase.php:15](../../application/model/cms/showcase.php#L15) |
| `oc_subscription` | `oc_subscription_domain` | subscription_id · 1:N | [application/model/account/subscription.php:221](../../application/model/account/subscription.php#L221) |
| `oc_subscription` | `oc_subscription_backup` | subscription_id · 1:N metadata | [application/model/account/subscription.php:343](../../application/model/account/subscription.php#L343) |
| `oc_subscription` | `oc_subscription_transaction` | subscription_id · 1:N | [application/model/account/subscription.php:281](../../application/model/account/subscription.php#L281) |

## oc_api

[install/opencart.sql:13](../../install/opencart.sql#L13) · PK: `api_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `api_id` | `int NOT NULL AUTO_INCREMENT` |
| `username` | `varchar(64) NOT NULL` |
| `key` | `text NOT NULL` |
| `status` | `tinyint(1) NOT NULL` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_api_ip

[install/opencart.sql:28](../../install/opencart.sql#L28) · PK: `api_ip_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `api_ip_id` | `int NOT NULL AUTO_INCREMENT` |
| `api_id` | `int NOT NULL` |
| `ip` | `varchar(40) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_api_session

[install/opencart.sql:40](../../install/opencart.sql#L40) · PK: `api_session_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `api_session_id` | `int NOT NULL AUTO_INCREMENT` |
| `api_id` | `int NOT NULL` |
| `session_id` | `varchar(32) NOT NULL` |
| `ip` | `varchar(40) NOT NULL` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_banner

[install/opencart.sql:55](../../install/opencart.sql#L55) · PK: `banner_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `banner_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `status` | `tinyint(1) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_banner_image

[install/opencart.sql:70](../../install/opencart.sql#L70) · PK: `banner_image_id` · MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `banner_image_id` | `int NOT NULL AUTO_INCREMENT` |
| `banner_id` | `int NOT NULL` |
| `language_id` | `int NOT NULL` |
| `title` | `varchar(64) NOT NULL` |
| `link` | `varchar(255) NOT NULL` |
| `image` | `varchar(255) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |

Index thường: không có. FK khai báo: không có.

## oc_blog

[install/opencart.sql:89](../../install/opencart.sql#L89) · PK: `blog_id` · MyISAM AUTO_INCREMENT=311 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `blog_id` | `int NOT NULL AUTO_INCREMENT` |
| `blog_category_id` | `int NOT NULL` |
| `title` | `varchar(255) NOT NULL` |
| `description` | `mediumtext NOT NULL` |
| `author` | `varchar(64) NOT NULL` |
| `image` | `varchar(255) NOT NULL DEFAULT ''` |
| `image_status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `trending` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `viewed` | `int NOT NULL DEFAULT '0'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: blog_category_id(blog_category_id). FK khai báo: không có.

## oc_blog_category

[install/opencart.sql:131](../../install/opencart.sql#L131) · PK: `blog_category_id` · MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `blog_category_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |

Index thường: không có. FK khai báo: không có.

## oc_blog_comment

[install/opencart.sql:151](../../install/opencart.sql#L151) · PK: `blog_comment_id` · MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `blog_comment_id` | `int NOT NULL AUTO_INCREMENT` |
| `blog_id` | `int NOT NULL` |
| `parent_id` | `int NOT NULL DEFAULT '0'` |
| `member_id` | `int NOT NULL` |
| `comment` | `text NOT NULL` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |

Index thường: blog_id(blog_id); parent_id(parent_id). FK khai báo: không có.

## oc_country

[install/opencart.sql:173](../../install/opencart.sql#L173) · PK: `country_id` · MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `country_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(128) NOT NULL` |
| `iso_code_2` | `varchar(2) NOT NULL` |
| `iso_code_3` | `varchar(3) NOT NULL` |
| `address_format` | `text NOT NULL` |
| `postcode_required` | `tinyint(1) NOT NULL` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |

Index thường: không có. FK khai báo: không có.

## oc_currency

[install/opencart.sql:446](../../install/opencart.sql#L446) · PK: `currency_id` · MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `currency_id` | `int NOT NULL AUTO_INCREMENT` |
| `title` | `varchar(32) NOT NULL` |
| `code` | `varchar(3) NOT NULL` |
| `symbol_left` | `varchar(12) NOT NULL` |
| `symbol_right` | `varchar(12) NOT NULL` |
| `decimal_place` | `char(1) NOT NULL` |
| `value` | `double(15,8) NOT NULL` |
| `status` | `tinyint(1) NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_download

[install/opencart.sql:469](../../install/opencart.sql#L469) · PK: `download_id` · MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `download_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `description` | `mediumtext NOT NULL` |
| `filename` | `varchar(160) NOT NULL` |
| `mask` | `varchar(128) NOT NULL` |
| `href` | `varchar(255) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_event

[install/opencart.sql:563](../../install/opencart.sql#L563) · PK: `event_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `event_id` | `int NOT NULL AUTO_INCREMENT` |
| `code` | `varchar(64) NOT NULL` |
| `trigger` | `text NOT NULL` |
| `action` | `text NOT NULL` |
| `status` | `tinyint(1) NOT NULL` |
| `sort_order` | `int NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_extension

[install/opencart.sql:578](../../install/opencart.sql#L578) · PK: `extension_id` · MyISAM AUTO_INCREMENT=49867 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `extension_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `extension_category_id` | `int NOT NULL` |
| `name` | `varchar(128) NOT NULL` |
| `description` | `mediumtext NOT NULL` |
| `documentation` | `mediumtext NOT NULL` |
| `history` | `text NOT NULL` |
| `license` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `license_period` | `int NOT NULL DEFAULT '12'` |
| `price` | `decimal(15,4) NOT NULL DEFAULT '0.0000'` |
| `image` | `varchar(255) NOT NULL DEFAULT ''` |
| `banner` | `varchar(255) NOT NULL DEFAULT ''` |
| `tag` | `text NOT NULL` |
| `cloud` | `varchar(255) NOT NULL DEFAULT ''` |
| `recommended` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `featured` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `publish` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `notify` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `alert` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `sales` | `int NOT NULL DEFAULT '0'` |
| `downloaded` | `int NOT NULL DEFAULT '0'` |
| `rating` | `int NOT NULL DEFAULT '5'` |
| `rating_total` | `int NOT NULL DEFAULT '0'` |
| `reviews_enabled` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `comments_enabled` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: extension_category_id(extension_category_id); member_id(member_id). FK khai báo: không có.

## oc_extension_category

[install/opencart.sql:655](../../install/opencart.sql#L655) · PK: `extension_category_id` · MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `extension_category_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |

Index thường: không có. FK khai báo: không có.

## oc_extension_comment

[install/opencart.sql:684](../../install/opencart.sql#L684) · PK: `extension_comment_id` · MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `extension_comment_id` | `int NOT NULL AUTO_INCREMENT` |
| `extension_id` | `int NOT NULL` |
| `parent_id` | `int NOT NULL DEFAULT '0'` |
| `member_id` | `int NOT NULL` |
| `comment` | `text NOT NULL` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |

Index thường: extension_id(extension_id); parent_id(parent_id). FK khai báo: không có.

## oc_extension_download

[install/opencart.sql:708](../../install/opencart.sql#L708) · PK: `extension_download_id` · MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `extension_download_id` | `int NOT NULL AUTO_INCREMENT` |
| `extension_id` | `int NOT NULL` |
| `name` | `varchar(128) NOT NULL` |
| `filename` | `varchar(160) NOT NULL` |
| `mask` | `varchar(128) NOT NULL` |
| `cloud` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `approved` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `downloaded` | `int NOT NULL DEFAULT '0'` |
| `date_added` | `datetime NOT NULL` |

Index thường: extension_id(extension_id). FK khai báo: không có.

## oc_extension_download_path

[install/opencart.sql:765](../../install/opencart.sql#L765) · PK: `extension_download_id, download_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `extension_download_id` | `int NOT NULL` |
| `download_id` | `int NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_extension_image

[install/opencart.sql:1250](../../install/opencart.sql#L1250) · PK: `extension_image_id` · MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `extension_image_id` | `int NOT NULL AUTO_INCREMENT` |
| `extension_id` | `int NOT NULL` |
| `image` | `varchar(255) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |

Index thường: extension_id(extension_id). FK khai báo: không có.

## oc_extension_promotion

[install/opencart.sql:1302](../../install/opencart.sql#L1302) · PK: `promotion_id` · MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `promotion_id` | `int NOT NULL AUTO_INCREMENT` |
| `extension_id` | `int NOT NULL` |
| `member_id` | `int NOT NULL` |
| `days` | `int NOT NULL DEFAULT '30'` |
| `total` | `decimal(15,4) NOT NULL DEFAULT '0.0000'` |
| `payment_method` | `varchar(64) NOT NULL DEFAULT 'PayPal'` |
| `transaction_id` | `varchar(128) NOT NULL DEFAULT ''` |
| `order_status_id` | `int NOT NULL DEFAULT '5'` |
| `date_start` | `date NOT NULL` |
| `date_end` | `date NOT NULL` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |

Index thường: extension_id(extension_id). FK khai báo: không có.

## oc_extension_rating

[install/opencart.sql:1329](../../install/opencart.sql#L1329) · PK: `extension_rating_id` · MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `extension_rating_id` | `int NOT NULL AUTO_INCREMENT` |
| `extension_id` | `int NOT NULL` |
| `member_id` | `int NOT NULL` |
| `order_id` | `int NOT NULL DEFAULT '0'` |
| `functionality` | `int NOT NULL DEFAULT '5'` |
| `appearance` | `int NOT NULL DEFAULT '5'` |
| `user_friendly` | `int NOT NULL DEFAULT '5'` |
| `support` | `int NOT NULL DEFAULT '5'` |
| `documentation` | `int NOT NULL DEFAULT '5'` |
| `rating` | `int NOT NULL DEFAULT '5'` |
| `comment` | `text NOT NULL` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |

Index thường: extension_id(extension_id). FK khai báo: không có.

## oc_information

[install/opencart.sql:1357](../../install/opencart.sql#L1357) · PK: `information_id` · MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `information_id` | `int NOT NULL AUTO_INCREMENT` |
| `bottom` | `int NOT NULL DEFAULT '0'` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |

Index thường: không có. FK khai báo: không có.

## oc_information_description

[install/opencart.sql:1374](../../install/opencart.sql#L1374) · PK: `information_id, language_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `information_id` | `int NOT NULL` |
| `language_id` | `int NOT NULL` |
| `title` | `varchar(64) NOT NULL` |
| `description` | `mediumtext NOT NULL` |
| `meta_title` | `varchar(255) NOT NULL` |
| `meta_description` | `varchar(255) NOT NULL` |
| `meta_keyword` | `varchar(255) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_information_to_store

[install/opencart.sql:1394](../../install/opencart.sql#L1394) · PK: `information_id, store_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `information_id` | `int NOT NULL` |
| `store_id` | `int NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_language

[install/opencart.sql:1409](../../install/opencart.sql#L1409) · PK: `language_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `language_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(32) NOT NULL` |
| `code` | `varchar(5) NOT NULL` |
| `locale` | `varchar(255) NOT NULL` |
| `image` | `varchar(64) NOT NULL` |
| `directory` | `varchar(32) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |
| `status` | `tinyint(1) NOT NULL` |

Index thường: name(name). FK khai báo: không có.

## oc_mail_log

[install/opencart.sql:1430](../../install/opencart.sql#L1430) · PK: `mail_log_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `mail_log_id` | `int NOT NULL AUTO_INCREMENT` |
| `recipient` | `varchar(255) NOT NULL` |
| `sender` | `varchar(255) NOT NULL` |
| `subject` | `varchar(255) NOT NULL` |
| `engine` | `varchar(32) NOT NULL DEFAULT 'mail'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `error` | `text NOT NULL` |
| `body` | `mediumtext NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_member

[install/opencart.sql:1448](../../install/opencart.sql#L1448) · PK: `member_id` · MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_id` | `int NOT NULL AUTO_INCREMENT` |
| `username` | `varchar(64) NOT NULL` |
| `firstname` | `varchar(32) NOT NULL` |
| `lastname` | `varchar(32) NOT NULL` |
| `company` | `varchar(128) NOT NULL DEFAULT ''` |
| `tax_id` | `varchar(64) NOT NULL DEFAULT ''` |
| `email` | `varchar(96) NOT NULL` |
| `telephone` | `varchar(32) NOT NULL DEFAULT ''` |
| `image` | `varchar(255) NOT NULL DEFAULT ''` |
| `country_id` | `int NOT NULL DEFAULT '222'` |
| `password` | `varchar(40) NOT NULL` |
| `salt` | `varchar(9) NOT NULL` |
| `code` | `varchar(40) NOT NULL DEFAULT ''` |
| `pin` | `varchar(10) NOT NULL DEFAULT ''` |
| `pin_attempts` | `int NOT NULL DEFAULT '0'` |
| `notify` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `verified` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `seller_status` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `partner_status` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `moderator` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `cloud` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `ip` | `varchar(40) NOT NULL DEFAULT ''` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: email(email); username(username). FK khai báo: không có.

## oc_member_ip

[install/opencart.sql:1491](../../install/opencart.sql#L1491) · PK: `member_ip_id` · MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_ip_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `ip` | `varchar(40) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_member_login

[install/opencart.sql:1510](../../install/opencart.sql#L1510) · PK: `member_login_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_login_id` | `int NOT NULL AUTO_INCREMENT` |
| `email` | `varchar(96) NOT NULL` |
| `ip` | `varchar(40) NOT NULL` |
| `total` | `int NOT NULL` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: email(email); ip(ip). FK khai báo: không có.

## oc_member_partner

[install/opencart.sql:1527](../../install/opencart.sql#L1527) · PK: `member_partner_id` · MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_partner_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `member_partner_type_id` | `int NOT NULL DEFAULT '1'` |
| `member_partner_status_id` | `int NOT NULL DEFAULT '1'` |
| `firstname` | `varchar(32) NOT NULL` |
| `lastname` | `varchar(32) NOT NULL` |
| `company` | `varchar(128) NOT NULL` |
| `website` | `varchar(255) NOT NULL` |
| `email` | `varchar(96) NOT NULL` |
| `telephone` | `varchar(32) NOT NULL` |
| `description_short` | `text NOT NULL` |
| `description_long` | `text NOT NULL` |
| `address_1` | `varchar(128) NOT NULL` |
| `address_2` | `varchar(128) NOT NULL DEFAULT ''` |
| `city` | `varchar(128) NOT NULL` |
| `postcode` | `varchar(16) NOT NULL DEFAULT ''` |
| `country_id` | `int NOT NULL` |
| `zone_id` | `int NOT NULL` |
| `image` | `varchar(255) NOT NULL DEFAULT ''` |
| `facebook` | `varchar(255) NOT NULL DEFAULT ''` |
| `twitter` | `varchar(255) NOT NULL DEFAULT ''` |
| `linkedin` | `varchar(255) NOT NULL DEFAULT ''` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_member_partner_status

[install/opencart.sql:1572](../../install/opencart.sql#L1572) · PK: `member_partner_status_id` · MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_partner_status_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `image` | `varchar(255) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |

Index thường: không có. FK khai báo: không có.

## oc_member_partner_type

[install/opencart.sql:1590](../../install/opencart.sql#L1590) · PK: `member_partner_type_id` · MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_partner_type_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |

Index thường: không có. FK khai báo: không có.

## oc_member_payment

[install/opencart.sql:1607](../../install/opencart.sql#L1607) · PK: `member_payment_id` · MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_payment_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `type` | `varchar(32) NOT NULL DEFAULT 'card'` |
| `name` | `varchar(128) NOT NULL` |
| `token` | `varchar(128) NOT NULL` |
| `image` | `varchar(255) NOT NULL` |
| `date_expire` | `varchar(32) NOT NULL DEFAULT ''` |
| `default` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `date_added` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_member_seller

[install/opencart.sql:1626](../../install/opencart.sql#L1626) · PK: `member_seller_id` · MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_seller_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `firstname` | `varchar(32) NOT NULL` |
| `lastname` | `varchar(32) NOT NULL` |
| `email` | `varchar(96) NOT NULL` |
| `support_email` | `varchar(96) NOT NULL` |
| `telephone` | `varchar(32) NOT NULL` |
| `website` | `varchar(255) NOT NULL DEFAULT ''` |
| `payment_method` | `varchar(32) NOT NULL DEFAULT 'paypal'` |
| `payoneer_token` | `varchar(128) NOT NULL DEFAULT ''` |
| `payment_email` | `varchar(96) NOT NULL` |
| `company` | `varchar(128) NOT NULL DEFAULT ''` |
| `address_1` | `varchar(128) NOT NULL` |
| `address_2` | `varchar(128) NOT NULL DEFAULT ''` |
| `city` | `varchar(128) NOT NULL` |
| `postcode` | `varchar(16) NOT NULL DEFAULT ''` |
| `country_id` | `int NOT NULL` |
| `zone_id` | `int NOT NULL` |
| `notify` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `api_status` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `api_url` | `varchar(255) NOT NULL DEFAULT ''` |
| `commission` | `int NOT NULL DEFAULT '20'` |
| `seller_group` | `varchar(64) NOT NULL DEFAULT 'Standard Seller (80%)'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_member_store

[install/opencart.sql:1667](../../install/opencart.sql#L1667) · PK: `member_store_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_store_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `domain` | `varchar(255) NOT NULL` |
| `username` | `varchar(128) NOT NULL` |
| `secret` | `text NOT NULL` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_member_transaction

[install/opencart.sql:1687](../../install/opencart.sql#L1687) · PK: `member_transaction_id` · MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `member_transaction_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `order_id` | `int NOT NULL DEFAULT '0'` |
| `description` | `varchar(255) NOT NULL` |
| `amount` | `decimal(15,4) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_modification

[install/opencart.sql:1707](../../install/opencart.sql#L1707) · PK: `modification_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `modification_id` | `int NOT NULL AUTO_INCREMENT` |
| `extension_install_id` | `int NOT NULL` |
| `name` | `varchar(64) NOT NULL` |
| `code` | `varchar(64) NOT NULL` |
| `author` | `varchar(64) NOT NULL` |
| `version` | `varchar(32) NOT NULL` |
| `link` | `varchar(255) NOT NULL` |
| `xml` | `mediumtext NOT NULL` |
| `status` | `tinyint(1) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_newsletter

[install/opencart.sql:1726](../../install/opencart.sql#L1726) · PK: `newsletter_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `newsletter_id` | `int NOT NULL AUTO_INCREMENT` |
| `email` | `varchar(96) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_order

[install/opencart.sql:1738](../../install/opencart.sql#L1738) · PK: `order_id` · MyISAM AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `order_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `seller_id` | `int NOT NULL` |
| `extension_id` | `int NOT NULL` |
| `extension` | `varchar(128) NOT NULL` |
| `quantity` | `int NOT NULL DEFAULT '1'` |
| `price` | `decimal(15,4) NOT NULL DEFAULT '0.0000'` |
| `total` | `decimal(15,4) NOT NULL DEFAULT '0.0000'` |
| `payment_method` | `varchar(64) NOT NULL DEFAULT 'PayPal'` |
| `transaction_id` | `varchar(128) NOT NULL DEFAULT ''` |
| `order_status_id` | `int NOT NULL DEFAULT '5'` |
| `ip` | `varchar(40) NOT NULL DEFAULT ''` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: member_id(member_id); seller_id(seller_id); extension_id(extension_id). FK khai báo: không có.

## oc_order_status

[install/opencart.sql:1768](../../install/opencart.sql#L1768) · PK: `order_status_id, language_id` · MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `order_status_id` | `int NOT NULL AUTO_INCREMENT` |
| `language_id` | `int NOT NULL` |
| `name` | `varchar(32) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_seo_url

[install/opencart.sql:1789](../../install/opencart.sql#L1789) · PK: `seo_url_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `seo_url_id` | `int NOT NULL AUTO_INCREMENT` |
| `store_id` | `int NOT NULL` |
| `language_id` | `int NOT NULL` |
| `query` | `varchar(255) NOT NULL` |
| `keyword` | `varchar(255) NOT NULL` |

Index thường: query(query); keyword(keyword). FK khai báo: không có.

## oc_session

[install/opencart.sql:1805](../../install/opencart.sql#L1805) · PK: `session_id` · InnoDB DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `session_id` | `varchar(32) NOT NULL` |
| `data` | `text NOT NULL` |
| `expire` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_setting

[install/opencart.sql:1817](../../install/opencart.sql#L1817) · PK: `setting_id` · MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `setting_id` | `int NOT NULL AUTO_INCREMENT` |
| `store_id` | `int NOT NULL DEFAULT '0'` |
| `code` | `varchar(128) NOT NULL` |
| `key` | `varchar(128) NOT NULL` |
| `value` | `text NOT NULL` |
| `serialized` | `tinyint(1) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_showcase

[install/opencart.sql:1913](../../install/opencart.sql#L1913) · PK: `showcase_id` · MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `showcase_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `showcase_category_id` | `int NOT NULL` |
| `name` | `varchar(128) NOT NULL` |
| `link` | `varchar(255) NOT NULL` |
| `image` | `varchar(255) NOT NULL` |
| `date_launch` | `date NOT NULL` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |

Index thường: showcase_category_id(showcase_category_id); member_id(member_id). FK khai báo: không có.

## oc_showcase_category

[install/opencart.sql:1953](../../install/opencart.sql#L1953) · PK: `showcase_category_id` · MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `showcase_category_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |

Index thường: không có. FK khai báo: không có.

## oc_statistics

[install/opencart.sql:1975](../../install/opencart.sql#L1975) · PK: `statistics_id` · MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `statistics_id` | `int NOT NULL AUTO_INCREMENT` |
| `code` | `varchar(64) NOT NULL` |
| `value` | `decimal(15,4) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_store

[install/opencart.sql:1993](../../install/opencart.sql#L1993) · PK: `store_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `store_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `url` | `varchar(255) NOT NULL` |
| `ssl` | `varchar(255) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_subscription

[install/opencart.sql:2006](../../install/opencart.sql#L2006) · PK: `subscription_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `subscription_id` | `int NOT NULL AUTO_INCREMENT` |
| `member_id` | `int NOT NULL` |
| `subscription_plan_id` | `int NOT NULL` |
| `member_payment_id` | `int NOT NULL DEFAULT '1'` |
| `subscription_status_id` | `int NOT NULL DEFAULT '1'` |
| `name` | `varchar(128) NOT NULL` |
| `admin_email` | `varchar(96) NOT NULL` |
| `admin_username` | `varchar(64) NOT NULL` |
| `store_status` | `varchar(32) NOT NULL DEFAULT 'running'` |
| `date_added` | `datetime NOT NULL` |
| `date_modified` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_subscription_backup

[install/opencart.sql:2030](../../install/opencart.sql#L2030) · PK: `backup_id` · MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `backup_id` | `int NOT NULL AUTO_INCREMENT` |
| `subscription_id` | `int NOT NULL` |
| `type` | `varchar(32) NOT NULL DEFAULT 'file'` |
| `status` | `varchar(32) NOT NULL DEFAULT 'complete'` |
| `created` | `datetime NOT NULL` |

Index thường: subscription_id(subscription_id). FK khai báo: không có.

## oc_subscription_domain

[install/opencart.sql:2049](../../install/opencart.sql#L2049) · PK: `subscription_domain_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `subscription_domain_id` | `int NOT NULL AUTO_INCREMENT` |
| `subscription_id` | `int NOT NULL DEFAULT '0'` |
| `member_id` | `int NOT NULL` |
| `name` | `varchar(255) NOT NULL` |
| `status` | `varchar(32) NOT NULL DEFAULT 'active'` |
| `pointed` | `tinyint(1) NOT NULL DEFAULT '1'` |
| `date_added` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_subscription_history

[install/opencart.sql:2069](../../install/opencart.sql#L2069) · PK: `subscription_history_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `subscription_history_id` | `int NOT NULL AUTO_INCREMENT` |
| `subscription_id` | `int NOT NULL` |
| `status` | `varchar(64) NOT NULL` |
| `comment` | `text NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: subscription_id(subscription_id). FK khai báo: không có.

## oc_subscription_plan

[install/opencart.sql:2087](../../install/opencart.sql#L2087) · PK: `subscription_plan_id` · MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `subscription_plan_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `description` | `text NOT NULL` |
| `price` | `decimal(15,2) NOT NULL DEFAULT '0.00'` |
| `label_active` | `tinyint(1) NOT NULL DEFAULT '0'` |
| `sort_order` | `int NOT NULL DEFAULT '0'` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |

Index thường: không có. FK khai báo: không có.

## oc_subscription_status

[install/opencart.sql:2108](../../install/opencart.sql#L2108) · PK: `subscription_status_id` · MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `subscription_status_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_subscription_transaction

[install/opencart.sql:2125](../../install/opencart.sql#L2125) · PK: `subscription_transaction_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `subscription_transaction_id` | `int NOT NULL AUTO_INCREMENT` |
| `subscription_id` | `int NOT NULL` |
| `member_id` | `int NOT NULL` |
| `transaction_id` | `varchar(128) NOT NULL` |
| `amount` | `decimal(15,2) NOT NULL` |
| `store_name` | `varchar(128) NOT NULL` |
| `transaction_card` | `varchar(128) NOT NULL` |
| `transaction_card_image` | `varchar(255) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: member_id(member_id). FK khai báo: không có.

## oc_support_enquiry

[install/opencart.sql:2147](../../install/opencart.sql#L2147) · PK: `enquiry_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `enquiry_id` | `int NOT NULL AUTO_INCREMENT` |
| `type` | `varchar(32) NOT NULL DEFAULT 'contact'` |
| `reason` | `varchar(64) NOT NULL DEFAULT ''` |
| `partner_id` | `int NOT NULL DEFAULT '0'` |
| `name` | `varchar(128) NOT NULL` |
| `email` | `varchar(96) NOT NULL` |
| `telephone` | `varchar(64) NOT NULL DEFAULT ''` |
| `company` | `varchar(128) NOT NULL DEFAULT ''` |
| `website` | `varchar(255) NOT NULL DEFAULT ''` |
| `country_id` | `int NOT NULL DEFAULT '0'` |
| `order_id` | `varchar(64) NOT NULL DEFAULT ''` |
| `version_id` | `int NOT NULL DEFAULT '0'` |
| `extension_url` | `varchar(255) NOT NULL DEFAULT ''` |
| `original_url` | `varchar(255) NOT NULL DEFAULT ''` |
| `subject` | `varchar(255) NOT NULL DEFAULT ''` |
| `enquiry` | `text NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_translation

[install/opencart.sql:2176](../../install/opencart.sql#L2176) · PK: `translation_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `translation_id` | `int NOT NULL AUTO_INCREMENT` |
| `store_id` | `int NOT NULL` |
| `language_id` | `int NOT NULL` |
| `route` | `varchar(64) NOT NULL` |
| `key` | `varchar(64) NOT NULL` |
| `value` | `text NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_upload

[install/opencart.sql:2192](../../install/opencart.sql#L2192) · PK: `upload_id` · MyISAM DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `upload_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(255) NOT NULL` |
| `filename` | `varchar(255) NOT NULL` |
| `code` | `varchar(255) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_user

[install/opencart.sql:2206](../../install/opencart.sql#L2206) · PK: `user_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `user_id` | `int NOT NULL AUTO_INCREMENT` |
| `user_group_id` | `int NOT NULL` |
| `username` | `varchar(20) NOT NULL` |
| `password` | `varchar(40) NOT NULL` |
| `salt` | `varchar(9) NOT NULL` |
| `firstname` | `varchar(32) NOT NULL` |
| `lastname` | `varchar(32) NOT NULL` |
| `email` | `varchar(96) NOT NULL` |
| `image` | `varchar(255) NOT NULL` |
| `code` | `varchar(40) NOT NULL` |
| `ip` | `varchar(40) NOT NULL` |
| `status` | `tinyint(1) NOT NULL` |
| `date_added` | `datetime NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_user_group

[install/opencart.sql:2231](../../install/opencart.sql#L2231) · PK: `user_group_id` · MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `user_group_id` | `int NOT NULL AUTO_INCREMENT` |
| `name` | `varchar(64) NOT NULL` |
| `permission` | `text NOT NULL` |

Index thường: không có. FK khai báo: không có.

## oc_zone

[install/opencart.sql:2246](../../install/opencart.sql#L2246) · PK: `zone_id` · MyISAM AUTO_INCREMENT=4239 DEFAULT CHARSET=utf8mb3

| Cột | Định nghĩa trong DDL |
|---|---|
| `zone_id` | `int NOT NULL AUTO_INCREMENT` |
| `country_id` | `int NOT NULL` |
| `name` | `varchar(128) NOT NULL` |
| `code` | `varchar(32) NOT NULL` |
| `status` | `tinyint(1) NOT NULL DEFAULT '1'` |

Index thường: không có. FK khai báo: không có.

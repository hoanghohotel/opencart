# Thư viện bên thứ ba

Dữ liệu lấy từ composer.lock và yêu cầu composer.json, không suy ra mọi package đều được gọi trong workflow. Dependency bundled được load qua system/storage/vendor/autoload.php; manifest hiện dùng upload/system/storage/vendor khác layout thực tế. Không chạy Composer update trong tác vụ này.

| Package | Phiên bản lock | Direct require | Phụ thuộc package trong lock |
|---|---|---|---|
| `braintree/braintree_php` | `3.40.0` | Có |  |
| `cardinity/cardinity-sdk-php` | `v2.1.0` | Có | `guzzlehttp/guzzle`, `guzzlehttp/oauth-subscriber`, `symfony/validator` |
| `divido/divido-php` | `v1.15-stable` | Có |  |
| `guzzlehttp/guzzle` | `6.5.8` | Bắc cầu | `guzzlehttp/promises`, `guzzlehttp/psr7`, `symfony/polyfill-intl-idn` |
| `guzzlehttp/oauth-subscriber` | `0.3.0` | Bắc cầu | `guzzlehttp/guzzle` |
| `guzzlehttp/promises` | `1.5.3` | Bắc cầu |  |
| `guzzlehttp/psr7` | `1.9.1` | Bắc cầu | `psr/http-message`, `ralouphie/getallheaders` |
| `psr/http-message` | `1.1` | Bắc cầu |  |
| `ralouphie/getallheaders` | `3.0.3` | Bắc cầu |  |
| `scssphp/scssphp` | `v1.11.0` | Có |  |
| `symfony/polyfill-ctype` | `v1.27.0` | Bắc cầu |  |
| `symfony/polyfill-intl-idn` | `v1.27.0` | Bắc cầu | `symfony/polyfill-intl-normalizer`, `symfony/polyfill-php72` |
| `symfony/polyfill-intl-normalizer` | `v1.27.0` | Bắc cầu |  |
| `symfony/polyfill-mbstring` | `v1.27.0` | Bắc cầu |  |
| `symfony/polyfill-php72` | `v1.27.0` | Bắc cầu |  |
| `symfony/polyfill-php80` | `v1.27.0` | Bắc cầu |  |
| `symfony/translation-contracts` | `v2.5.2` | Bắc cầu |  |
| `symfony/validator` | `v4.4.48` | Bắc cầu | `symfony/polyfill-ctype`, `symfony/polyfill-mbstring`, `symfony/polyfill-php80`, `symfony/translation-contracts` |
| `twig/twig` | `v3.6.1` | Có | `symfony/polyfill-ctype`, `symfony/polyfill-mbstring` |
| `zoujingli/wechat-developer` | `v1.2.17` | Có |  |

Các integration riêng PaymentGateway/CloudStorage không phải bằng chứng package tương ứng được dùng: PaymentGateway triển khai HTTP cURL trực tiếp cho một số gateway. Braintree SDK bundled và Braintree GraphQL custom cần phân biệt. Tham chiếu JS SDK nằm trong template; không đồng nhất chúng với dependency PHP lock.

## Lock và bản bundled

Bản bundled được khai báo trong `system/storage/vendor/composer/installed.json`.

| Package | Lock | Installed metadata |
|---|---|---|
| braintree/braintree_php | 3.40.0 | 3.40.0 |
| cardinity/cardinity-sdk-php | v2.1.0 | v2.1.0 |
| divido/divido-php | v1.15-stable | v1.15-stable |
| guzzlehttp/guzzle | 6.5.8 | 6.5.8 |
| guzzlehttp/oauth-subscriber | 0.3.0 | 0.3.0 |
| guzzlehttp/promises | 1.5.3 | 1.5.3 |
| guzzlehttp/psr7 | 1.9.1 | 1.9.1 |
| psr/http-message | 1.1 | 1.1 |
| ralouphie/getallheaders | 3.0.3 | 3.0.3 |
| scssphp/scssphp | v1.11.0 | v1.11.0 |
| symfony/polyfill-ctype | v1.27.0 | v1.27.0 |
| symfony/polyfill-intl-idn | v1.27.0 | v1.27.0 |
| symfony/polyfill-intl-normalizer | v1.27.0 | v1.27.0 |
| symfony/polyfill-mbstring | v1.27.0 | v1.27.0 |
| symfony/polyfill-php72 | v1.27.0 | v1.27.0 |
| symfony/polyfill-php80 | v1.27.0 | v1.27.0 |
| symfony/translation-contracts | v2.5.2 | v2.5.2 |
| symfony/validator | v4.4.48 | v4.4.48 |
| twig/twig | v3.6.1 | v3.6.1 |
| zoujingli/wechat-developer | v1.2.17 | v1.2.17 |

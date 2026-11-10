# Security & Payment Regression Test Suite (P0-A, P0-B, P0-C)

Run from repository root:

## 1. Checkout Result Pages (PAY-02 / P0-A)
```sh
php tests/regression/checkout_result_pages.php
```

## 2. Payment Completion Boundary & Malformed Proof Rejection (PAY-01 / P0-B)
```sh
php -d disable_functions=curl_init,curl_exec tests/regression/payment_confirmation.php
php tests/regression/render_payment_templates.php | node tests/regression/payment_template_callbacks.js
```

## 3. Frontend CSRF Middleware & Client Policy Helper (SEC-01 / P0-C)
```sh
php tests/regression/frontend_csrf.php
node tests/regression/frontend_csrf_client.js
```

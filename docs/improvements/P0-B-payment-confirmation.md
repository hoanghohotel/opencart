# P0-B — PAY-01: từ chối hoàn tất đơn khi chưa xác minh gateway

Trạng thái: **đã triển khai và kiểm tra local, chờ review/nghiệm thu; chưa nghiệm thu sandbox hoặc production**. Yêu cầu “tiếp tục” của người dùng cho phép chuyển từ P0-A sang nhóm này. Chưa bắt đầu nhóm P0-C/SEC-01. Không deploy, commit hoặc migration; model/SQL/dữ liệu đơn cũ không bị sửa.

## Phạm vi và thay đổi

- `application/controller/checkout/payment.php`: confirm chỉ POST + member/token hiện hành + pending thuộc member/extension; total/quantity/price/currency phải nhất quán. Pending mới ghi snapshot currency từ config, không lấy giá/total/currency từ POST. Pending cũ thiếu snapshot phải mở checkout lại. Không có fallback tạo Complete khi thiếu pending/provider. Chỉ gọi addOrder sau adapter trả `success`, `verified=true`, transaction ID và không lỗi. Unset pending sau khi model trả ID hợp lệ. Exception trả thông báo generic, log không chứa payload/secret.
- `system/library/payment_gateway.php`: Stripe/Braintree charge thiếu config, response sai/rỗng hoặc status chưa đạt không còn trả success/transaction giả. Không thay local/test token bằng thẻ mặc định trong charge. Stripe yêu cầu captured/succeeded, exact amount/amount_received/currency và live/test. Braintree yêu cầu explicit merchant_account_id, amount/currency/merchantAccountId khớp, status trong SUBMITTED_FOR_SETTLEMENT/SETTLING/SETTLED/SETTLEMENT_PENDING. Các HTTP client payment bật TLS peer/host verification; Stripe chặn HTTP ngoài 2xx. CloudStorage TLS chưa thuộc nhóm này (SEC-02 vẫn chưa đóng toàn bộ).
- `application/controller/marketplace/braintree.php::payment()`: giữ endpoint nhưng redirect về extension/info?purchase=1 để dùng prepared checkout; không tạo đơn từ nonce/form legacy không có binding server.
- `application/controller/marketplace/paypal.php::send()`: giữ JSON endpoint nhưng trả error + redirect gợi ý, không tạo invoice/custom/đơn giả. Callback hiển thị cũ vẫn không ghi đơn.
- `application/controller/checkout/payment.php::paypal()` và `application/view/template/checkout/paypal.twig`: route được giữ, trả thông báo PayPal chưa khả dụng cho tới khi có server-side capture verification. Không chuẩn bị pending hoặc chạy SDK để khách trả tiền qua browser rồi server không xác minh được. Không tuyên bố đã triển khai PayPal REST capture.
- `application/view/template/checkout/confirm.twig`: AJAX error đi failure; response không có success/order_id không được báo success. Cả nhánh thường/3DS được test. Nhánh JS PayPal còn lưu trong template cũng nhận cùng guard/error navigation, nhưng bị chặn bởi unavailable state hiện tại.

Model `account/order::addOrder()` giữ nguyên; không sửa DB contract hoặc thêm layer/service mới. `paymentGateway()` protected là điểm tạo dependency có thể thay bằng provider fixture trong test, không phải public endpoint mới.

## Kiểm thử và bằng chứng

### Test trước sửa

Suite gốc 37 case được viết/chạy trước sửa. Với `curl_init,curl_exec` bị vô hiệu hóa để ngăn mọi transport thật, baseline có **34 failures**. Một số failure thể hiện controller cũ không dùng seam fake và cố dùng cURL; các case gateway thiếu keys, non-final status và legacy order writes tái hiện trực tiếp đường lỗi. Baseline không phải 34 lỗ hổng độc lập.

Sau đó bổ sung các case amount/currency/token/environment/PayPal unavailable. Case VND bắt đầu FAIL trước thay đổi currency scaling; case AJAX response rỗng bắt đầu FAIL trước sửa callback.

### Kết quả local

- `payment_confirmation.php`: **51 case PASS**, provider transport override + cURL bị disable. Không DB/mail/gateway thật. Bao gồm Stripe/Braintree success hợp lệ → controller ghi đúng một order spy, sequential replay không charge lại; thiếu pending, guest, GET, token sai, binding sai, missing config, declined/malformed/nonfinal, amount/currency/merchant mismatch đều không tạo đơn.
- `checkout_result_pages.php`: **15 case PASS**, regression P0-A, Twig/controller thật với services giả.
- Render Twig confirm thường/3DS thật rồi evaluate JS bằng Node VM/provider fakes: **8 callback scenario PASS**, gồm HTTP error/decline/empty response/valid success. PayPal unavailable render có message và không có script.
- HTTP smoke hiện hữu: home/admin login/marketplace/sitemap/CSS: **5 PASS**.
- HTTP POST guest confirm và legacy PayPal send trả JSON error không order/invoice; legacy Braintree POST trả redirect restart: **3 PASS**.
- PHP lint các file PHP thay đổi/test: PASS; `git diff --check`: PASS.

Đây không phải E2E giao dịch hoặc full startup member/CSRF test. Không benchmark, không dùng PAN/credentials thật, không cấp đơn trong DB để kiểm thử. Sequential replay không chứng minh idempotency concurrent hoặc crash recovery.

### Cách chạy

```sh
docker exec -u 1000 -w /var/www/html opencartvn-web php -d disable_functions=curl_init,curl_exec tests/regression/payment_confirmation.php
docker exec -u 1000 -w /var/www/html opencartvn-web php tests/regression/checkout_result_pages.php
set -o pipefail
docker exec -u 1000 -w /var/www/html opencartvn-web php tests/regression/render_payment_templates.php | node tests/regression/payment_template_callbacks.js
```

Runner provider chủ động từ chối chạy nếu cURL chưa disable. PHP thường có bundled Twig + Node cũng chạy được theo README tests, không cần container nếu host đã có runtime.

## Đối chiếu protocol

Schema public chính thức `braintree/graphql-api` commit `b131626006b93a4ba1215b461b5e3e8437526c10` được đọc, không thực thi code bên ngoài. Đã đối chiếu ChargePaymentMethodInput/TransactionInput, Transaction.amount/merchantAccountId/status, MonetaryAmount.value/currencyCode và các enum status dùng trong query/validator. Nguồn: https://github.com/braintree/graphql-api/blob/b131626006b93a4ba1215b461b5e3e8437526c10/schema.graphql . Schema phù hợp không thay thế credential/sandbox contract test; API version header hiện giữ `2023-05-01` và cần staging xác nhận khả năng field thực tế.

Stripe response fixture dùng amount đơn vị nhỏ nhất, amount_received, currency, livemode, succeeded. Không query advisory hoặc thực hiện live API. Credential Stripe dùng cho request chính là account binding hiện tại; không nhận transaction ID do client tự khai để cấp đơn. Chưa có durable checkout reference/merchant ledger hay webhook proof store mới.

## Tương thích và giới hạn có chủ đích

- Route/class và success JSON `order_id`/`success` của prepared card checkout được giữ; các nhánh không có proof giờ trả error thay vì cấp đơn. Không coi hành vi cấp đơn giả là contract phải giữ.
- Legacy Braintree form phải restart/re-enter trong checkout mới; không tự replay nonce hoặc charge lại. Legacy PayPal form nhận error rõ; PayPal hiện không dùng để trả tiền trên nền tảng cho đến khi triển khai server create/capture + order binding và test sandbox. Đây là thay đổi capability có chủ đích, cần PO/support review trước release.
- Stripe manual capture không được coi là paid. `requires_action`/`requires_capture` hiện trả error; chưa bổ sung SCA challenge/resume UI hoặc manual-capture lifecycle. Có thể gateway giữ authorization trong một số trạng thái; phải kiểm tra provider trước retry.
- Braintree cần merchant_account_id explicit thay vì ngầm dùng default. Status submitted/pending settlement được chấp nhận theo mô hình charge hiện tại, **không bảo đảm ngân hàng đã quyết toán cuối cùng**; reconciliation/settlement failure policy còn mở.
- VND/JPY và currency zero-decimal trong mapping dùng whole units; không nhân 100 sai. Stripe ISK dùng whole-unit validation nhưng wire amount ×100 theo quy ước API. Currencies 3-decimal BHD/JOD/KWD/OMR/TND bị từ chối vì order price schema 2-decimal chưa có accounting contract phù hợp. Không currency conversion hay repricing ngầm; sandbox từng currency/merchant cần nghiệm thu.
- TLS verified có thể làm hosting/proxy thiếu CA bị lỗi. Cần cài trust bundle đúng trên staging, không bật lại insecure để chạy qua.
- Đơn cũ và invoice/history không được sửa. Pending cũ thiếu currency phải restart; chưa tự reconcile/thu hồi quyền cấp sai trước đây.

## Rủi ro còn mở / cổng nghiệm thu

1. SEC-01: startup vẫn ghi đè member_token của request. Check trong confirm không sửa được toàn pipeline CSRF; cần nhóm P0-C với test startup thật.
2. PAY-03/DB-01: hai request song song có thể charge/write lặp; DB/mail có thể lỗi sau charge hoặc sau một phần write. Không tự retry khi outcome không rõ; đối soát provider/order/ledger trước. Pending/session không phải durable intent/lock.
3. Provider verification mismatch có thể được phát hiện **sau khi provider đã nhận charge**; phải cấu hình merchant/currency đúng, thử sandbox và đối soát/recovery. Không tuyên bố fail-closed nghĩa là provider chưa từng giữ/thu tiền trong mọi error.
4. Account/payment vault còn đường demo/local token ngoài charge boundary; frontend shim/3DS thực cần integration audit tiếp. Patch không chứng nhận PCI hoặc 3DS/SCA.
5. Cần Sandbox acceptance với merchant thật (test keys qua cấu hình bảo mật), gateway success/decline/action/timeout + amount/currency, browser end-to-end và recovery trước release. Không yêu cầu gửi secret trong chat.

Nhóm này chặn các đường hoàn tất đơn không proof đã tìm thấy tại checkout/legacy; **chưa đóng PAY-01 như một integration hoàn chỉnh cho mọi provider**. Sau review/nghiệm thu mới chuyển nhóm; chưa tự động sửa CSRF/P1.

## Bổ sung review — kiểm tra kiểu dữ liệu của proof

Sau commit `b633f46`, thêm **14 case trước sửa** và tái hiện **65 test / 14 failures** trên validator cũ. Stripe ép `(int)` có thể biến `2000.9` hoặc chuỗi `2000junk` thành `2000`; ID dạng array/số/whitespace cũng từng được coi là có transaction ID. Currency dạng array làm validator ném lỗi thay vì trả kết quả từ chối có cấu trúc. Braintree cũng chấp nhận ID sai kiểu và chuỗi số tiền dạng scientific notation. Đây là robustness của hợp đồng phản hồi provider, **không phải bằng chứng người ngoài có thể sửa phản hồi TLS hoặc đã khai thác production**.

Sửa trong `system/library/payment_gateway.php`: Stripe yêu cầu amount/amount_received là integer đúng theo hợp đồng PaymentIntent; transaction ID phải là chuỗi có nội dung, không whitespace/control characters; currency phải là chuỗi trước normalize. Braintree yêu cầu Amount là số thập phân đúng định dạng, tối đa hai chữ số lẻ trong phạm vi đang hỗ trợ, và currency đúng kiểu; provider zero-decimal vẫn có thể serialize whole units thành `20.00`. Không đổi các response hợp lệ, route, schema, gateway status policy hoặc lifecycle thanh toán.

File bổ sung thay đổi: gateway, `tests/regression/payment_confirmation.php`, README test, tài liệu trạng thái P0-B và mô tả kiến trúc hiện hành. Sau sửa **65/65 test provider/controller pass**; các suite result-page và template callback được kiểm tra lại theo biên bản. Chưa sửa SEC-01/PAY-03/DB-01.

Đã kiểm tra metadata cấu hình môi trường và trạng thái có/không của credential trong instance phát triển: không có binding/runtime variable gateway; Stripe test secret, Braintree sandbox keys/merchant account và PayPal sandbox client/secret đều rỗng trong app settings. Chỉ đọc tên và trạng thái, không xuất giá trị. Vì vậy **sandbox acceptance chưa chạy do thiếu cấu hình test credentials**, ngoài cổng review/nghiệm thu P0-B còn chờ. Cần cung cấp qua kênh cấu hình bảo mật, không gửi secret trong chat. Không dùng placeholder/test fixture làm credential để gọi provider thật.

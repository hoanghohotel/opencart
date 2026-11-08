# P0-A — PAY-02: result page không tạo đơn

Trạng thái: **đã sửa và kiểm tra local, chờ nghiệm thu**. Không deploy, không commit; chưa chuyển nhóm tiếp theo. Phạm vi được thu hẹp sau khi đọc source: chỉ PAY-02, chưa giải quyết PAY-01 hoặc SEC-01.

## Vấn đề và giải pháp

`application/controller/checkout/checkout.php::success()` trước đây lấy `pending_extension_order`, unset rồi gọi `ModelAccountOrder::addOrder()` chỉ dựa member đã đăng nhập. GET/refresh của một trang thông báo không phải proof thanh toán. Bỏ riêng block này; giữ title, route, template, thứ tự header/footer và URL account/history/contact. Không thêm service, không sửa schema/model, không đổi giá, commission hoặc status đơn cũ.

Pending không bị trang result tiêu thụ: việc xác nhận/ghi đơn phải thuộc payment flow. Điều này không làm pending trở thành bằng chứng Paid và không bảo đảm flow confirm hiện tại đã an toàn.

## File thay đổi và lý do

- `application/controller/checkout/checkout.php`: loại bỏ order write và session pending consumption trong success.
- `tests/regression/checkout_result_pages.php`: harness chạy controller thật và Twig template thật, spies cho persistence/services; không DB/network/mail/gateway; 15 case.
- `tests/regression/README.md`: cách chạy và giới hạn test.
- `docs/improvements/README.md`, tài liệu này: thứ tự nhóm, cổng nghiệm thu, kết quả và compatibility.
- `docs/architecture/current-payment-result.md`: trạng thái logic sau sửa; README kiến trúc dẫn sang cập nhật, giữ diagram/inventory baseline phục vụ audit.
- `docs/audit/README.md`, `findings/PAY-02.md`: ghi triển khai chờ nghiệm thu, không sửa lại kết luận lịch sử hoặc đóng toàn bộ P0.

## Kiểm thử đã chạy

Môi trường PHP 8.3 trong container `opencartvn-web`, dependency Twig bundled của repository.

1. **Trước sửa:** 15 case, 1 FAIL ở `success logged=1 pending=1`, thông báo `result page created an order`. 14 case còn lại PASS. Test viết và chạy trước thay logic.
2. **Sau sửa:** cùng 15 case, 0 failures. Ma trận success/failure/terms × guest/member × pending/không pending, gọi lặp hai lần; kiểm không gọi addOrder, không load model persistence, session/pending giữ nguyên; template/header/footer/title/account/history/contact giữ contract. Hai case success legacy và một case checkout guest 401/login.
3. `php -l` controller và test: PASS; `git diff --check`: PASS.
4. Smoke HTTP hiện hữu: home, admin login, marketplace, sitemap, stylesheet: 5 PASS.
5. HTTP result pages success/failure/terms: 3 PASS, 200, có nội dung mong đợi, không PHP error được probe phát hiện.

Test harness không chạy middleware startup, provider sandbox hoặc ghi đơn thật. HTTP probe là guest, không phải browser/PIN/member E2E. Không coi mock/HTML pass là payment proof pass. Common header/footer được stub trong harness; smoke HTTP dùng header/footer thật. Lịch sử/invoice chưa được kiểm thử bằng tài khoản thật; model/template order history không bị sửa, link contract được assert.

## Tương thích và ảnh hưởng đã đánh giá

- Luồng card hiện gọi confirm tạo đơn rồi chuyển success; trang result không còn tạo thêm đơn hoặc consume session. Test local kiểm hợp đồng trang, chưa test charge sandbox.
- PayPal template có callback AJAX error cũng chuyển success. Đường fallback cũ dựa vào trang success để tạo đơn khi callback lỗi **sẽ không tạo đơn nữa**. Đây là loại bỏ hành vi cấp đơn không chứng minh thu tiền, không phải xóa route/method PayPal. Không giữ hành vi lỗi chỉ để tương thích. Cần đối soát gateway nếu tiền thực đã thu nhưng confirm lỗi; chưa có cơ chế recovery trong nhóm này.
- Nội dung template vẫn nói “success” khi mở URL trực tiếp; không dùng thông báo đó làm chứng cứ cấp entitlement. Binding hiển thị với order đã xác nhận thuộc member là phần nghiệm thu mở rộng của PAY-02/PAY-01, chưa có trong patch tối thiểu này.
- Không sửa/xóa đơn, entitlement, sales/commission cũ; không migration và không gọi gateway thật.

## Rủi ro còn tồn tại và công việc tiếp theo

PAY-01 vẫn OPEN: confirm fallback/legacy và gateway verification cần sửa riêng. Đọc thêm phát hiện `chargeStripe()` có nhánh không secret trả transaction ID tự sinh; `chargeBraintree()` cũng có fallback thành công. Source: `system/library/payment_gateway.php::chargeStripe/chargeBraintree`. Vì vậy chỉ chặn nhánh không pending là chưa đủ; nhóm tiếp phải test credentials missing, status pending/requires_action, amount/currency/merchant/intent binding, rồi thống nhất completion boundary.

SEC-01 token overwrite, PAY-03 retry/idempotency và DB-01 atomicity vẫn OPEN. Bản sửa này không đạt điều kiện tuyên bố sẵn sàng paid production. Không triển khai P0-B trước khi nhóm này được review/nghiệm thu.

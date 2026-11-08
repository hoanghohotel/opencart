# PAY-01 — Có đường tạo đơn Complete không xác nhận thanh toán

**Sau audit — P0-B:** đã chặn fallback/legacy tạo Complete không proof và fallback transaction giả; 51 provider/controller case pass local. PayPal bị chặn an toàn, chưa có server capture integration/sandbox acceptance; finding chưa đóng như tích hợp hoàn chỉnh. Xem [biên bản](../../improvements/P0-B-payment-confirmation.md).

- Ưu tiên: **P0**; mức độ tác động: **Critical** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application.

## Bằng chứng

- [application/controller/checkout/payment.php:217](../../../application/controller/checkout/payment.php#L217) — `public function confirm`
- [application/controller/marketplace/paypal.php:30](../../../application/controller/marketplace/paypal.php#L30) — `public function send`
- [application/controller/marketplace/braintree.php:33](../../../application/controller/marketplace/braintree.php#L33) — `public function payment`
- [application/model/account/order.php:3](../../../application/model/account/order.php#L3) — `public function addOrder`

## Mô tả và nguyên nhân

confirm() nhánh không pending gọi addOrder với status=5 và transaction token tự tạo; các endpoint legacy cũng tạo đơn trực tiếp. Source đủ chứng minh thiếu bước xác nhận gateway trong các nhánh này; chưa gửi request tạo đơn.

## Hậu quả và điều kiện

Nếu endpoint được mở và account vượt gate, đơn hoàn tất và sales/commission có thể phát sinh trước khi nhận tiền.

## Phương án khắc phục (chưa thực hiện)

Tập trung create/complete tại OrderService. Chỉ chuyển Paid sau verify server-side transaction ID, amount, currency, merchant và order binding. Endpoint legacy dùng cùng service; nếu cần khóa tạm phải có kế hoạch hỗ trợ khách đang checkout.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Gateway mock từ chối/thiếu proof/amount sai không tạo Paid, không tăng sales/commission; hợp lệ tạo đúng một order. Characterization cho tất cả route legacy.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

8–12 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

# PAY-03 — Chưa có idempotency bền vững cho charge và tạo đơn

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application, install.

## Bằng chứng

- [application/controller/checkout/payment.php:217](../../../application/controller/checkout/payment.php#L217) — `public function confirm`
- [application/model/account/order.php:3](../../../application/model/account/order.php#L3) — `public function addOrder`
- [install/opencart.sql:1738](../../../install/opencart.sql#L1738) — `CREATE TABLE oc_order`

## Mô tả và nguyên nhân

confirm dựa trên pending session rồi unset; addOrder INSERT mới, transaction_id không có UNIQUE trong DDL; chưa có durable checkout attempt key ở boundary này.

## Hậu quả và điều kiện

Retry/concurrent requests hoặc timeout sau charge có thể charge/ghi đơn lặp; chưa mô phỏng race.

## Phương án khắc phục (chưa thực hiện)

Checkout intent ID + unique gateway event/payment reference có scope provider/merchant; gateway idempotency key, lock/atomic transition và reconciliation, không dùng session làm lock.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Không UNIQUE transaction_id mù quáng: dữ liệu lịch sử có token tự tạo/giá trị rỗng; cần inventory và dedup theo quy tắc kinh doanh.

## Kiểm thử và tiêu chí nghiệm thu

Hai confirm song song/replay webhook/timeout trả cùng order và tối đa một charge/ledger entry; legitimate renewals không bị chặn.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

6–10 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

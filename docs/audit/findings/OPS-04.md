# OPS-04 — Cần telemetry tài chính và diễn tập restore

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Đề xuất cải tiến**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: admin, application, system.

## Bằng chứng

- [system/framework.php:46](../../../system/framework.php#L46) — `$log->write('PHP '`
- [admin/controller/tool/backup.php:136](../../../admin/controller/tool/backup.php#L136) — `public function export`
- [application/model/account/order.php:3](../../../application/model/account/order.php#L3) — `public function addOrder`

## Mô tả và nguyên nhân

Framework log PHP error; có endpoint backup; chưa có bằng chứng tracing checkout, alert reconciliation, retention/offsite restore drill tự động trong repo.

## Hậu quả và điều kiện

Khó phân biệt charge thành công/order lỗi hoặc phục hồi khi mất DB; quy trình vận hành ngoài repo chưa được cung cấp.

## Phương án khắc phục (chưa thực hiện)

Correlation ID không chứa token/PII; audit event charge/order/status/ledger; dashboard errors/reconciliation; backup encrypted offsite + restore staging theo RPO/RTO đã chốt.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Không ghi PAN, payment token, password, secret hoặc member_token vào logs.

## Kiểm thử và tiêu chí nghiệm thu

Mô phỏng gateway timeout, mail fail có correlation; backup restore kiểm checksum và financial invariants; alert trong SLO đã thống nhất.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

5–8 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

# SEC-04 — Member login ghi attempt nhưng không chặn theo attempt

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: admin, application.

## Bằng chứng

- [application/controller/account/login.php:123](../../../application/controller/account/login.php#L123) — `protected function validate`
- [admin/controller/common/login.php:94](../../../admin/controller/common/login.php#L94) — `getLoginAttempts`

## Mô tả và nguyên nhân

validate member gọi addLoginAttempt/deleteLoginAttempts nhưng không đọc ngưỡng; admin có kiểm tra ngưỡng/time window.

## Hậu quả và điều kiện

Thiếu rate limit ở lớp ứng dụng của member; edge limiter production chưa biết.

## Phương án khắc phục (chưa thực hiện)

Giới hạn theo account + IP, backoff và telemetry; tránh khóa vĩnh viễn/cho phép DoS vào account. Áp dụng cả magic link/PIN/email resend.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Vượt ngưỡng bị throttle, hết TTL hồi phục; không tiết lộ tồn tại email; proxy IP lấy từ danh sách trust.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

3–5 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

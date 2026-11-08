# BIZ-01 — Thông báo cloud provision vượt quá bằng chứng trong model

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application.

## Bằng chứng

- [application/controller/account/subscription.php:142](../../../application/controller/account/subscription.php#L142) — `has been provisioned and is ready`
- [application/model/account/subscription.php:27](../../../application/model/account/subscription.php#L27) — `public function addSubscription`

## Mô tả và nguyên nhân

Controller thông báo provision ready; addSubscription tạo subscription/metadata/history/payment records. Chưa thấy gọi provisioning infrastructure trong chuỗi method được trace.

## Hậu quả và điều kiện

Người dùng có thể hiểu store sẵn sàng trong khi code chỉ ghi nhận subscription; worker/control plane ngoài repo chưa xác minh.

## Phương án khắc phục (chưa thực hiện)

Chốt integration contract với hạ tầng; dùng Requested/Provisioning/Ready/Failed, chỉ Ready sau probe/control-plane acknowledgement. Nếu chỉ portal demo, đổi thông báo theo capability thật.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Cần xác nhận integration ngoài repository trước khi kết luận production không provision được.

## Kiểm thử và tiêu chí nghiệm thu

Provision fail không báo ready; retry idempotent; existing subscriptions mapping được duyệt; fake provider mô phỏng lifecycle.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

5–10 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

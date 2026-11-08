# QUAL-03 — Controller lớn và validation/gateway logic lặp giữa các route

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application.

## Bằng chứng

- [application/controller/marketplace/extension.php:3](../../../application/controller/marketplace/extension.php#L3) — `public function index`
- [application/controller/checkout/payment.php:89](../../../application/controller/checkout/payment.php#L89) — `public function prepare`
- [application/controller/account/extension.php:494](../../../application/controller/account/extension.php#L494) — `public function upload`

## Mô tả và nguyên nhân

index marketplace kéo dài tới declaration info ở dòng 308; controller account/extension gồm CRUD/upload/comments; token gate lặp nhiều endpoint.

## Hậu quả và điều kiện

Đổi auth/payment phải sửa nhiều nơi; dependency Registry động làm khó inject fake và unit test.

## Phương án khắc phục (chưa thực hiện)

Giữ controllers như adapters; trích Checkout/Entitlement/UploadPolicy nhỏ, inject qua Registry factory để tương thích framework. Viết characterization trước thay route.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Không kết luận mọi vi phạm SOLID từ LOC; nhận xét SRP/DIP dựa trên trách nhiệm và dependency trực tiếp đã chỉ ra.

## Kiểm thử và tiêu chí nghiệm thu

Output/status/redirect public API giữ contract; unit test policies không cần DB/network; gate đúng ở mọi route.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

12–20 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

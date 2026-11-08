# QUAL-02 — Khóa action_event admin bị khai báo trùng

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: system.

## Bằng chứng

- [system/config/admin.php:42](../../../system/config/admin.php#L42) — `'view/*/before'`

## Mô tả và nguyên nhân

action_event có hai khóa view/*/before; PHP giữ khóa sau, entry event/theme trong khóa trước bị ghi đè.

## Hậu quả và điều kiện

Theme hook dự kiến không được đăng ký từ config này; hook DB khác vẫn có thể tồn tại.

## Phương án khắc phục (chưa thực hiện)

Gộp một array theo priority, xác định event/theme có nên hoạt động bằng snapshot output hiện tại trước khi bật.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Test effective config có một khóa và callbacks đúng thứ tự; visual regression admin; không kích hoạt hook obsolete ngoài ý muốn.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

1–2 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

# SEC-03 — Mật khẩu dùng SHA1 lặp và chấp nhận MD5

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application, system.

## Bằng chứng

- [system/library/cart/member.php:92](../../../system/library/cart/member.php#L92) — `SHA1(CONCAT`
- [system/library/cart/user.php:43](../../../system/library/cart/user.php#L43) — `md5($password)`
- [application/model/account/member.php:7](../../../application/model/account/member.php#L7) — `sha1($salt`

## Mô tả và nguyên nhân

Login xác thực SHA1 salt hoặc MD5; addMember lưu SHA1. Không dùng password_hash trong các nhánh này.

## Hậu quả và điều kiện

Hash bị lộ có chi phí đoán thấp hơn Argon2id/bcrypt; đây là điểm yếu lưu mật khẩu, không phải bằng chứng DB đã lộ.

## Phương án khắc phục (chưa thực hiện)

Verifier hỗ trợ đọc legacy rồi rehash sau login hợp lệ bằng password_hash/password_needs_rehash; kiểm tra độ dài cột trước mở rộng; reset cho account rủi ro.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Không rehash hàng loạt từ hash cũ; phải giữ validator legacy trong giai đoạn chuyển đổi.

## Kiểm thử và tiêu chí nghiệm thu

Login legacy/current đúng sai, rehash chỉ sau thành công, reset và admin tạo user; rollback đọc hash mới.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

4–6 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

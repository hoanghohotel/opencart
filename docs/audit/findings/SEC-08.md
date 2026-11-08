# SEC-08 — Config tracked mặc định DB root và mật khẩu rỗng

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: admin, config.php.

## Bằng chứng

- [config.php:40](../../../config.php#L40) — `define('DB_USERNAME', 'root')`
- [admin/config.php:45](../../../admin/config.php#L45) — `define('DB_PASSWORD', '')`

## Mô tả và nguyên nhân

Hai config chứa root/empty password/retail. Runtime dev trước đó dùng overlay ngoài checkout, không chứng minh production dùng mặc định.

## Hậu quả và điều kiện

Nếu triển khai nguyên trạng: quyền DB quá rộng hoặc kết nối lỗi; secret/config khó quản lý.

## Phương án khắc phục (chưa thực hiện)

Nạp config qua env/secret file ngoài webroot, user least privilege; guard môi trường production từ chối default; migration user DB riêng ngoài audit.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Missing config fail rõ ràng; không in secret; user app không có DROP/GRANT; CLI và admin cùng binding.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

2–4 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

# SEC-07 — Upload archive thiếu giới hạn kích thước ở controller

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application, php.ini.

## Bằng chứng

- [application/controller/account/extension.php:509](../../../application/controller/account/extension.php#L509) — `$allowed = array('zip'`
- [php.ini:6](../../../php.ini#L6) — `upload_max_filesize = 999M`

## Mô tả và nguyên nhân

upload kiểm tra basename, độ dài, extension zip/rar và error; không thấy quota/size/signature scan ở method. Có token hóa tên và storage path riêng, không kết luận RCE/path traversal.

## Hậu quả và điều kiện

Nếu cấu hình upload lớn có hiệu lực: tiêu tốn disk/bandwidth, phát tán archive nguy hiểm; server thực chưa biết.

## Phương án khắc phục (chưa thực hiện)

Bổ sung size/quota, MIME/signature archive, quarantine và scan async trước publish; chặn zip bomb nếu có bước giải nén; không tự động giải nén file người dùng.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Oversize/extension giả/signature sai từ chối; basename xử lý tên path; quota concurrency; package hợp lệ vẫn tải được.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

4–7 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

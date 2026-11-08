# OPS-03 — php.ini chứa giá trị legacy và giới hạn mâu thuẫn tài liệu

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: INSTALL.md, php.ini.

## Bằng chứng

- [php.ini:4](../../../php.ini#L4) — `memory_limit = 64M`
- [php.ini:5](../../../php.ini#L5) — `max_execution_time = 36000`
- [INSTALL.md:18](../../../INSTALL.md#L18) — `memory_limit >= 128M`

## Mô tả và nguyên nhân

php.ini memory 64M, timeout 36000, upload 999M và directive PHP cũ; INSTALL yêu cầu >=128M. Chưa xác minh file này thực sự được SAPI nạp.

## Hậu quả và điều kiện

Environment drift, timeout dài hoặc lỗi xử lý ảnh nếu áp dụng; không khẳng định runtime đang dùng các số này.

## Phương án khắc phục (chưa thực hiện)

Cung cấp SAPI config versioned ngoài source, kiểm tra php --ini/phpinfo nội bộ được bảo vệ; align request/body/time limits theo quota và proxy.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

CI/staging assert effective limits/extensions; request quá lớn/time out bị xử lý kiểm soát, không lộ phpinfo.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

2–3 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

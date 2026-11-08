# SEC-06 — Output encoding dựa vào input cleaning, Twig autoescape tắt

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application, system.

## Bằng chứng

- [system/library/template/twig.php:61](../../../system/library/template/twig.php#L61) — `'autoescape'  => false`
- [system/library/request.php:47](../../../system/library/request.php#L47) — `htmlspecialchars`
- [application/controller/marketplace/extension.php:543](../../../application/controller/marketplace/extension.php#L543) — `nl2br($result['comment'])`

## Mô tả và nguyên nhân

Request clean encode HTML ENT_COMPAT; Twig tắt autoescape; comment truyền nl2br vào template. Có xử lý input nên không kết luận stored XSS chỉ từ autoescape=false.

## Hậu quả và điều kiện

Dữ liệu từ SQL/import/rich text và ngữ cảnh JS/attribute có thể thiếu escaping đúng; phải trace từng source→sink.

## Phương án khắc phục (chưa thực hiện)

Phân loại plain/rich text; escape tại sink theo HTML/attr/JS, dùng JSON_HEX_* cho data script; sanitize allowlist cho rich content; bật autoescape từng template sau compatibility test.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Không bật autoescape toàn cục một lần vì nhiều template dựa vào HTML đã encode/nl2br.

## Kiểm thử và tiêu chí nghiệm thu

Fixture ký tự quote/tag vào HTML, attr, JS; rich text hợp lệ không bị double escape; không thực thi script.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

8–15 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

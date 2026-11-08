# PERF-04 — Cache file quét và xử lý ảnh trong request

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application, system.

## Bằng chứng

- [system/library/cache/file.php:9](../../../system/library/cache/file.php#L9) — `glob(DIR_CACHE . 'cache.*')`
- [application/model/tool/image.php:66](../../../application/model/tool/image.php#L66) — `$image = new Image`

## Mô tả và nguyên nhân

Cache constructor glob+unlink hết hạn; resize ảnh tạo file cache trong request khi miss. Đây là work đồng bộ, chưa đo tải.

## Hậu quả và điều kiện

Cold cache hoặc cache directory lớn có thể tăng IO/CPU, stampede ảnh cùng kích thước.

## Phương án khắc phục (chưa thực hiện)

Đo hit/miss/IO; job warm image variants, atomic temp+rename/lock nhẹ; GC cache theo scheduler; Redis chỉ khi multi-instance cần shared cache.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Cache cold/warm và 20 miss đồng thời; ảnh hợp lệ, không file một phần; cache isolation và invalidation đúng.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

4–7 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

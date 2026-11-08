# PERF-03 — DB session read-modify-write không có lock bao phủ request

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: system.

## Bằng chứng

- [system/library/session/db.php:16](../../../system/library/session/db.php#L16) — `public function read`
- [system/library/session/db.php:28](../../../system/library/session/db.php#L28) — `REPLACE INTO`
- [system/library/session.php:34](../../../system/library/session.php#L34) — `register_shutdown_function`

## Mô tả và nguyên nhân

read dữ liệu JSON lúc start, write REPLACE lúc shutdown; không có version/compare-and-swap/lock xuyên request trong adapter.

## Hậu quả và điều kiện

Các AJAX request cùng session có thể last-write-wins mất pending/token changes; chưa benchmark concurrent.

## Phương án khắc phục (chưa thực hiện)

Tách checkout intent khỏi session; session lock/versioned updates có TTL, đo ảnh hưởng chờ; shared store chỉ khi cần nhiều app instance.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Hai requests thay keys khác nhau không làm mất dữ liệu; crash lock tự hết hạn; đo p95 chờ session.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

4–7 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

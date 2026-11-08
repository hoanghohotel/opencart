# PERF-02 — Search LIKE leading wildcard và count tương quan cần đo query plan

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application.

## Bằng chứng

- [application/model/marketplace/extension.php:45](../../../application/model/marketplace/extension.php#L45) — `e.name LIKE '%`
- [application/model/marketplace/extension.php:16](../../../application/model/marketplace/extension.php#L16) — `AS comment_total`

## Mô tả và nguyên nhân

Search name/tag/description dùng %term%; listing có correlated count. B-tree thường không tối ưu được leading wildcard; optimizer/volume thực chưa đo.

## Hậu quả và điều kiện

Có thể full scan/CPU cao khi catalog tăng; không khẳng định hiện tại chậm.

## Phương án khắc phục (chưa thực hiện)

Capture query digest và EXPLAIN ANALYZE trên bản sao; đánh giá FULLTEXT theo tiếng Việt/tokenization, composite index theo filter/selectivity, precompute counts nếu cần.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Dataset 10k/100k với query mix thật; so p50/p95, rows examined, freshness/relevance; không thêm index không có plan.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

4–8 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

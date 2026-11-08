# PERF-01 — N+1 query trong danh sách comment

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application.

## Bằng chứng

- [application/controller/marketplace/extension.php:262](../../../application/controller/marketplace/extension.php#L262) — `foreach ($results as $result)`
- [application/controller/marketplace/extension.php:506](../../../application/controller/marketplace/extension.php#L506) — `getTotalRepliesByCommentId`
- [application/model/marketplace/extension.php:426](../../../application/model/marketplace/extension.php#L426) — `public function getRepliesByCommentId`

## Mô tả và nguyên nhân

Trong loop comment gọi count và getReplies cho mỗi parent; pattern 2N truy vấn thêm hiện hữu trong source, chưa đo latency.

## Hậu quả và điều kiện

Chi phí DB tăng theo page size, cộng resize ảnh và correlated subquery.

## Phương án khắc phục (chưa thực hiện)

Batch parent IDs, group reply counts và lấy tối đa 5 replies/parent theo query tương thích DB pin; giữ paging/ordering.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Query counter trên fixture 1/10/50 parent không tăng tuyến tính vì fetch replies; output identical và EXPLAIN trên staging.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

3–5 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

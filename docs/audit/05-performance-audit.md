# Hiệu năng

Không benchmark hoặc chạy EXPLAIN trên production; không khẳng định thông lượng, latency hoặc full scan thực tế. Pattern N+1 được xác minh tĩnh, impact định lượng chưa đo.

Đo baseline staging: p50/p95/p99 cho home/search/detail/comment/checkout, query count/rows examined, PHP CPU/RSS, DB lock wait, session conflicts, cache hit/miss, image cold/warm, gateway timeout. Dataset/mix/lượng đồng thời phải dựa access logs được cung cấp, không chọn SLA tùy ý. Dashboard SQL count/revenue trực tiếp ở admin/controller/common/dashboard.php là work đồng bộ, có thể snapshot/materialized counters sau khi đo.

Index ứng viên: extension_comment(extension_id,parent_id,status,date_added) và reply(parent_id,status,date_added); dùng EXPLAIN/index cardinality để chọn, tránh thêm cả hai mù quáng. LIKE %term% không được giải quyết chỉ bằng B-tree name. Cache ưu tiên public catalog/category theo language/store/filter, invalidation khi publish/price/status đổi; không cache payment/member-sensitive response chung. CDN chỉ cho asset/public images, không checkout/user_token URLs. Kiểm tra asset URLs và version hash trước immutable một năm trong .htaccess; chưa đo waterfall/Lighthouse/JS bundle.

Background jobs phù hợp mail, scan archive, resize warmup, provisioning và reconciliation. Payment interaction cần trả trạng thái bounded, không đẩy charge vào queue mà thiếu idempotency. Partitioning chỉ khi row volume/retention và measured maintenance cost chứng minh cần.

| ID | Ưu tiên | Phân loại | Phát hiện |
|---|---|---|---|
| [QUAL-04](findings/QUAL-04.md) | P2 | Đã xác minh bằng source | Model order gọi mail controller đồng bộ sau ghi dữ liệu |
| [PERF-01](findings/PERF-01.md) | P2 | Đã xác minh bằng source | N+1 query trong danh sách comment |
| [PERF-02](findings/PERF-02.md) | P2 | Nguy cơ tiềm ẩn | Search LIKE leading wildcard và count tương quan cần đo query plan |
| [PERF-03](findings/PERF-03.md) | P2 | Nguy cơ tiềm ẩn | DB session read-modify-write không có lock bao phủ request |
| [PERF-04](findings/PERF-04.md) | P2 | Nguy cơ tiềm ẩn | Cache file quét và xử lý ảnh trong request |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

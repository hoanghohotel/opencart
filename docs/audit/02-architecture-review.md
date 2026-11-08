# Kiến trúc và thang điểm

Điểm số là đánh giá định tính trên artifact có trong repository, 0 = không có nền tảng, 5 = dùng được nhưng debt rõ, 10 = có contract/test/operational evidence mạnh. Không phải benchmark, chứng nhận bảo mật hoặc điểm sản phẩm trên thị trường.

| Tiêu chí yêu cầu | /10 | Cơ sở |
|---|---|---|
| Công nghệ/framework | 6 | PHP MVC-L/Twig/SQL đơn giản, hooks rõ; Loader dynamic + Registry làm mờ dependencies (QUAL-03) |
| PHP/dependency | 4 | composer yêu cầu >=7.3 trong khi INSTALL 8.1–8.3; layout vendor sai và chưa scan advisory (OPS-01/SEC-09) |
| Kiến trúc tổng thể | 5 | Front/admin tách, shared kernel; nhiều entry completion thanh toán (PAY-01/02) |
| Tổ chức source | 6 | Controller/model/view/language theo domain; file legacy tham chiếu target vắng (QUAL-01) |
| Phân tách tầng | 4 | Model gọi mail controller, dashboard query SQL, controller chứa checkout policy (QUAL-03/04) |
| Coupling module | 4 | Registry magic access, mail/order và checkout chia sẻ session pending, hook global (QUAL-03, PERF-03) |
| Nguyên tắc thiết kế | 4 | Có adapter DB/Template/Storage; SRP/DIP yếu ở checkout/controller, không gán mọi SOLID rule là vi phạm (QUAL-03) |
| Khả năng mở rộng | 4 | File cache/shared session, đồng bộ HTTP và MyISAM; chưa test tải (DB-01/PERF-03/04) |
| Bảo trì | 4 | Route/config cũ, thiếu regression/CI artifact (QUAL-01/OPS-02) |
| Phù hợp commerce hiện đại | 4 | Có marketplace/entitlement/seller; payment proof/idempotency chưa bảo đảm (PAY-01/03) |

Trung bình số học 4,5/10, không dùng thay severity gate: một payment P0 không thể bù bằng điểm module khác. Bằng chứng từng tiêu chí nằm trong finding tương ứng và docs/architecture.

Kiến trúc mục tiêu: modular monolith, giữ front/admin routes. Controller adapters → use-case Checkout/Order/Entitlement/Member/Upload → repository hiện có qua adapter → transaction DB + outbox. PaymentGateway/CloudStorage là ports với test doubles. Không cần microservices nếu chưa có nhu cầu độc lập ownership/deployment/scale.

Mở rộng API: adapter API riêng dùng cùng use-case, schema versioned, validation/authz/idempotency/rate limit. Multi-store: phân biệt config_store_id/store_id với seller member_id; cần test tenant isolation từng query trước tuyên bố hỗ trợ SaaS đa tenant. Chưa đủ dữ liệu để đưa mọi entity vào tenant scope bằng migration hàng loạt.

| ID | Ưu tiên | Phân loại | Phát hiện |
|---|---|---|---|
| [DB-01](findings/DB-01.md) | P1 | Đã xác minh bằng source | Chuỗi ghi tài chính không có atomic transaction trên schema MyISAM |
| [PAY-03](findings/PAY-03.md) | P1 | Nguy cơ tiềm ẩn | Chưa có idempotency bền vững cho charge và tạo đơn |
| [QUAL-03](findings/QUAL-03.md) | P2 | Đã xác minh bằng source | Controller lớn và validation/gateway logic lặp giữa các route |
| [QUAL-04](findings/QUAL-04.md) | P2 | Đã xác minh bằng source | Model order gọi mail controller đồng bộ sau ghi dữ liệu |
| [PERF-03](findings/PERF-03.md) | P2 | Nguy cơ tiềm ẩn | DB session read-modify-write không có lock bao phủ request |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

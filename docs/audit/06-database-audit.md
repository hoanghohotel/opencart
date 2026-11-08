# Database

DDL gốc: 59 bảng (58 MyISAM, oc_session InnoDB), 0 FK, không unique key ngoài PK; đầy đủ cột/index ở ../architecture/database-schema.md và schema.json. Đây là schema seed, không phải introspection production. Không chạy query/migration/cleanup dữ liệu thực tế. Không khẳng định duplicate/orphan đã có.

Mô hình số: order chứa một extension và snapshot price/total; member_id buyer, seller_id seller; seller ledger member_transaction, payment vault member_payment. Bảng release path và information description/store có PK kép. Trường tiền decimal(15,2) trong SQL trong khi PHP dùng float ở ModelAccountOrder::addOrder: nguy cơ rounding cho commission/currency nhiều đơn vị; cần fixture rounding và decimal minor-unit policy trước đổi kiểu. Status ID=5 hardcode rải rác (PAY-01/02); cần transition policy riêng khỏi label localization. Một số bảng utf8mb3: nếu hỗ trợ emoji/4-byte, rehearsal utf8mb4 + index/collation compatibility, không đổi toàn cục chưa đo.

Index theo query plan, không theo mọi cột _id. Lưu transaction/status history append-only, không đổi giá/commission đơn cũ khi sửa catalog; audit hiện chưa chứng minh đủ immutable lịch sử/reconciliation. FK chỉ cân nhắc sau map quan hệ thực, orphan report, giải quyết sentinel 0 và thống nhất delete behavior. Không chuẩn hóa quá mức các snapshot lịch sử có chủ ý.

Migration an toàn đề xuất: inventory schema/data read-only trên bản sao → backup verified restore → dry-run DDL/data conversions → compatibility reads/writes → staged cutover/canary → invariant checks → rollback plan không làm mất các giao dịch mới. RPO/RTO phải do nghiệp vụ chốt; không hứa zero downtime/zero loss khi chưa rehearsal.

| ID | Ưu tiên | Phân loại | Phát hiện |
|---|---|---|---|
| [PAY-01](findings/PAY-01.md) | P0 | Đã xác minh bằng source | Có đường tạo đơn Complete không xác nhận thanh toán |
| [DB-01](findings/DB-01.md) | P1 | Đã xác minh bằng source | Chuỗi ghi tài chính không có atomic transaction trên schema MyISAM |
| [PAY-03](findings/PAY-03.md) | P1 | Nguy cơ tiềm ẩn | Chưa có idempotency bền vững cho charge và tạo đơn |
| [DB-02](findings/DB-02.md) | P2 | Nguy cơ tiềm ẩn | Quan hệ profile không được DB bảo đảm duy nhất |
| [OPS-04](findings/OPS-04.md) | P2 | Đề xuất cải tiến | Cần telemetry tài chính và diễn tập restore |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

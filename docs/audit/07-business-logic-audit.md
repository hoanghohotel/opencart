# Nghiệp vụ commerce

| Quy trình | Đánh giá có căn cứ |
|---|---|
| Product/category | Marketplace extension/category, admin CRUD và seller CRUD có code; QUAL-03/DB-01 về cross-write; không nhầm với sản phẩm vật lý |
| Customer | Member + seller/partner, login/PIN/IP; SEC-01/03/04 |
| Shopping cart | Không thấy cart controller/library/table; mua trực tiếp một extension. Đây là capability không có, không phải bug nếu scope marketplace |
| Checkout/payment | Có nhiều route hiện hành/legacy; PAY-01/02/03 là blocker đối soát/cấp quyền |
| Order | addOrder ghi sales/commission và mail, DB-01; cần state transition & history tests, refund/reversal reconciliation chưa xác minh end-to-end |
| Shipping/inventory | Không thấy module physical shipping/stock ledger trong schema/controller; không đề xuất xây nếu chưa mở sang hàng vật lý |
| Promotion | marketplace/promotion/account/promotion + extension_promotion có code; chưa test bidding/expiry/duplicate charge; phải đưa qua payment boundary trước mở rộng |
| Coupon | Có nhãn coupon ở marketplace/purchase controller; chưa thấy engine coupon áp discount trong chuỗi checkout trace; không kết luận functional coupon đã hoàn thiện |
| Tax | Member có company/tax_id; chưa thấy tax calculation engine trong order totals trace; cần chốt jurisdiction/digital-goods requirements trước phát triển |
| Admin | Có login/access/modify, QUAL-01/02; thiếu test reachability/role matrix |
| Cloud | BIZ-01, cần contract control plane ngoài repo |

Các khoảng trống capability dựa inventory controllers/models/schema tại commit được ghi trong architecture, không suy ra tên extension được bán (ví dụ shipping/tax plugin) là chức năng đã cài trên chính nền tảng.

| ID | Ưu tiên | Phân loại | Phát hiện |
|---|---|---|---|
| [PAY-01](findings/PAY-01.md) | P0 | Đã xác minh bằng source | Có đường tạo đơn Complete không xác nhận thanh toán |
| [PAY-02](findings/PAY-02.md) | P0 | Đã xác minh bằng source | Trang success có side effect tạo đơn từ session |
| [DB-01](findings/DB-01.md) | P1 | Đã xác minh bằng source | Chuỗi ghi tài chính không có atomic transaction trên schema MyISAM |
| [PAY-03](findings/PAY-03.md) | P1 | Nguy cơ tiềm ẩn | Chưa có idempotency bền vững cho charge và tạo đơn |
| [QUAL-01](findings/QUAL-01.md) | P1 | Đã xác minh bằng source | Tham chiếu model literal không có file đích |
| [BIZ-01](findings/BIZ-01.md) | P1 | Đã xác minh bằng source | Thông báo cloud provision vượt quá bằng chứng trong model |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

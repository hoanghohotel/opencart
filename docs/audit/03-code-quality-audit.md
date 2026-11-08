# Chất lượng mã

Rà soát inventory toàn bộ file first-party đã có trong docs/architecture/evidence; phân tích sâu tập trung trust/money boundaries. Không khẳng định semantic coverage mọi branch/vendor. Marketplace index có hơn 300 dòng tính theo khoảng tới declaration tiếp, account/extension gom CRUD/upload/comments, PaymentGateway gom nhiều provider. Đây là dấu hiệu cần tách trách nhiệm, không phải LOC tự động chứng minh bug.

Token gates và getList/getForm/validation lặp trong controllers có thể gom policy/helper sau characterization. Thiếu abstraction rõ nhất ở direct registry access và DB→mail, trong khi Cache/DB/Template đã có abstraction; tránh rewrite toàn bộ framework. Convention tab/array cũ không tự gây lỗi và chỉ nên chuẩn hóa file khi sửa chức năng. Loader exception missing model và error handler PHP tồn tại; không kết luận “không xử lý exception/logging ở toàn dự án”. File tồn tại nhưng chưa thấy caller không đủ chứng minh dead code do dynamic Action/Event; đánh dấu orphan candidate rồi xác minh access logs/DB events trước xóa.

| ID | Ưu tiên | Phân loại | Phát hiện |
|---|---|---|---|
| [QUAL-01](findings/QUAL-01.md) | P1 | Đã xác minh bằng source | Tham chiếu model literal không có file đích |
| [QUAL-02](findings/QUAL-02.md) | P2 | Đã xác minh bằng source | Khóa action_event admin bị khai báo trùng |
| [QUAL-03](findings/QUAL-03.md) | P2 | Đã xác minh bằng source | Controller lớn và validation/gateway logic lặp giữa các route |
| [QUAL-04](findings/QUAL-04.md) | P2 | Đã xác minh bằng source | Model order gọi mail controller đồng bộ sau ghi dữ liệu |
| [OPS-01](findings/OPS-01.md) | P1 | Đã xác minh bằng source | Build/dependency config không khớp layout source |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

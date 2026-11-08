# Đánh giá điều hành

Kết luận: nền tảng marketplace số có module hữu ích, nhưng chưa đủ cơ sở để nghiệm thu thu tiền/cấp quyền tự động an toàn. Ba P0 tập trung hoàn tất đơn không có proof và token gate bị ghi đè. Đây là kết luận source, chưa xác nhận production exposure. Không xếp thiếu cart/shipping là defect khi sản phẩm là marketplace extension.

Điểm mạnh: MVC-L nhất quán ở đa số module, registry/hooks, mô hình buyer/seller và catalog số, SQL seed, admin access/modify gate, cloud storage abstraction. Điểm yếu: nhiều đường ghi tài chính, thiếu atomicity/idempotency, debt cấu hình và regression. Hoãn mở rộng paid automation cho đến khi chốt nghiệm thu PAY/SEC và reconciliation. Quyết định production cần chủ hệ thống xác nhận exposure, không tự tắt dịch vụ trong audit.

| ID | Ưu tiên | Phân loại | Phát hiện |
|---|---|---|---|
| [PAY-01](findings/PAY-01.md) | P0 | Đã xác minh bằng source | Có đường tạo đơn Complete không xác nhận thanh toán |
| [PAY-02](findings/PAY-02.md) | P0 | Đã xác minh bằng source | Trang success có side effect tạo đơn từ session |
| [SEC-01](findings/SEC-01.md) | P0 | Đã xác minh bằng source | Startup ghi đè token request bằng token session |
| [SEC-02](findings/SEC-02.md) | P1 | Đã xác minh bằng source | Các HTTP client gateway/storage tắt xác minh TLS |
| [SEC-03](findings/SEC-03.md) | P1 | Đã xác minh bằng source | Mật khẩu dùng SHA1 lặp và chấp nhận MD5 |
| [SEC-04](findings/SEC-04.md) | P1 | Đã xác minh bằng source | Member login ghi attempt nhưng không chặn theo attempt |
| [SEC-05](findings/SEC-05.md) | P1 | Nguy cơ tiềm ẩn | Session ID không được xoay khi đăng nhập trong custom session |
| [SEC-06](findings/SEC-06.md) | P1 | Nguy cơ tiềm ẩn | Output encoding dựa vào input cleaning, Twig autoescape tắt |
| [SEC-07](findings/SEC-07.md) | P1 | Nguy cơ tiềm ẩn | Upload archive thiếu giới hạn kích thước ở controller |
| [SEC-08](findings/SEC-08.md) | P1 | Nguy cơ tiềm ẩn | Config tracked mặc định DB root và mật khẩu rỗng |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

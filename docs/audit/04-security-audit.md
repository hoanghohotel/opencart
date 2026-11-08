# Bảo mật và giới hạn chứng cứ

Phân loại: Đã xác minh bằng source = thiếu/sai control quan sát trực tiếp; Nguy cơ tiềm ẩn = còn phụ thuộc entry/sink/deployment; Hardening = cải tiến phòng vệ chưa chứng minh exploit. Không khai thác live, không gửi giao dịch, không cung cấp PoC gây ghi dữ liệu.

| Nhóm | Kết luận phạm vi |
|---|---|
| SQL injection | Chưa xác minh SQLi: đường search được đọc có db->escape và ID cast; SQL ghép string là debt. Cần trace tất cả raw identifiers/sort/backup query trước kết luận an toàn (system/library/db/mysqli.php::query/escape; marketplace model) |
| XSS / input / output | SEC-06 potential; Request::clean có encode nên không được kết luận comment stored XSS từ nl2br đơn lẻ |
| CSRF / authorization / API | SEC-01 đã xác minh token overwrite; PAY controls thiếu. Admin startup có access và một số controller modify; không nói toàn admin thiếu authz |
| Authentication / password | SEC-03/04; magic link/email code cần thêm TTL/rate/replay review, chưa kết luận takeover |
| Session | SEC-05/PERF-03, cookie effective settings chưa biết; custom session không tự được bảo vệ bởi PHP native regenerate |
| Upload | SEC-07; basename/random suffix hiện có. Chưa xác minh RCE hoặc archive extraction |
| Inclusion / traversal | Action loại ký tự route ngoài allowlist và Loader tìm file; chưa xác minh LFI. Image/path inputs cần review nguồn có thể điều khiển trước kết luận traversal |
| Sensitive data / server | SEC-08 và error_display trong system/config/default.php; production effective unknown; không đưa secret values vào báo cáo |
| TLS / external API | SEC-02 confirmed insecure client config, chưa có sự kiện MITM |
| Dependency CVE | SEC-09: không có scan advisory hiện hành; không liệt kê CVE chưa đối chiếu range/version/reachability |

Ưu tiên ngăn hoàn tất đơn thiếu proof và khôi phục CSRF gate; sau đó TLS/password/throttle/session/upload. Mọi test attack simulation chỉ thực hiện trên fixture disposable sau coding task riêng.

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
| [PAY-03](findings/PAY-03.md) | P1 | Nguy cơ tiềm ẩn | Chưa có idempotency bền vững cho charge và tạo đơn |
| [SEC-09](findings/SEC-09.md) | P2 | Đề xuất cải tiến | Dependency version pin chưa có kiểm chứng advisory hiện hành |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

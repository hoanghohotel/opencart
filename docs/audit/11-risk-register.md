# Risk register

Priority P0 = xử lý ngay trước cho phép paid automation; P1 = ảnh hưởng vận hành; P2 = trung hạn; P3 = dài hạn. Không có finding P3 chỉ để lấp đủ nhóm. Likelihood không có số liệu production nên ghi theo điều kiện, không bịa xác suất. Status toàn bộ: OPEN, chưa sửa.

| ID | Priority | Trạng thái chứng cứ | Điều kiện / rủi ro | Owner | Trạng thái |
|---|---|---|---|---|
| [PAY-01](findings/PAY-01.md) | P0 | Đã xác minh bằng source | Nếu endpoint được mở và account vượt gate, đơn hoàn tất và sales/commission có thể phát sinh trước khi nhận tiền. | PHP + reviewer theo domain | OPEN |
| [PAY-02](findings/PAY-02.md) | P0 | Đã xác minh bằng source | Điều hướng hiển thị thành công có thể cấp đơn/entitlement mà chưa có bằng chứng thu tiền. | PHP + reviewer theo domain | OPEN |
| [SEC-01](findings/SEC-01.md) | P0 | Đã xác minh bằng source | Cơ chế token chống CSRF ở frontend mất tác dụng phân biệt token thiếu/sai. Khả năng tấn công ngoài browser còn phụ thuộc cookie/SameSite/deployment. | PHP + reviewer theo domain | OPEN |
| [SEC-02](findings/SEC-02.md) | P1 | Đã xác minh bằng source | Mất xác thực server TLS khi thực sự gọi network; nguy cơ lộ credentials, sửa response qua MITM. Không khẳng định đã xảy ra. | PHP + reviewer theo domain | OPEN |
| [SEC-03](findings/SEC-03.md) | P1 | Đã xác minh bằng source | Hash bị lộ có chi phí đoán thấp hơn Argon2id/bcrypt; đây là điểm yếu lưu mật khẩu, không phải bằng chứng DB đã lộ. | PHP + reviewer theo domain | OPEN |
| [SEC-04](findings/SEC-04.md) | P1 | Đã xác minh bằng source | Thiếu rate limit ở lớp ứng dụng của member; edge limiter production chưa biết. | PHP + reviewer theo domain | OPEN |
| [SEC-05](findings/SEC-05.md) | P1 | Nguy cơ tiềm ẩn | Nguy cơ fixation nếu kẻ khác có cách đặt/biết cookie trước login; chưa chứng minh được điều kiện đặt cookie ngoài production. | PHP + reviewer theo domain | OPEN |
| [SEC-06](findings/SEC-06.md) | P1 | Nguy cơ tiềm ẩn | Dữ liệu từ SQL/import/rich text và ngữ cảnh JS/attribute có thể thiếu escaping đúng; phải trace từng source→sink. | PHP + reviewer theo domain | OPEN |
| [SEC-07](findings/SEC-07.md) | P1 | Nguy cơ tiềm ẩn | Nếu cấu hình upload lớn có hiệu lực: tiêu tốn disk/bandwidth, phát tán archive nguy hiểm; server thực chưa biết. | PHP + reviewer theo domain | OPEN |
| [SEC-08](findings/SEC-08.md) | P1 | Nguy cơ tiềm ẩn | Nếu triển khai nguyên trạng: quyền DB quá rộng hoặc kết nối lỗi; secret/config khó quản lý. | PHP + reviewer theo domain | OPEN |
| [DB-01](findings/DB-01.md) | P1 | Đã xác minh bằng source | Lỗi giữa chừng có thể để đơn, doanh số và commission không khớp; chưa đo tỷ lệ lỗi thực tế. | PHP + reviewer theo domain | OPEN |
| [PAY-03](findings/PAY-03.md) | P1 | Nguy cơ tiềm ẩn | Retry/concurrent requests hoặc timeout sau charge có thể charge/ghi đơn lặp; chưa mô phỏng race. | PHP + reviewer theo domain | OPEN |
| [DB-02](findings/DB-02.md) | P2 | Nguy cơ tiềm ẩn | Nếu duplicate profile xuất hiện, commission có thể không nhất quán; chưa kiểm tra dữ liệu production hoặc khẳng định seed có duplicate. | PHP + reviewer theo domain | OPEN |
| [QUAL-01](findings/QUAL-01.md) | P1 | Đã xác minh bằng source | Nhánh được thực thi có thể fatal; cấu hình store/localisation/admin chưa đủ kiểm thử. | PHP + reviewer theo domain | OPEN |
| [QUAL-02](findings/QUAL-02.md) | P2 | Đã xác minh bằng source | Theme hook dự kiến không được đăng ký từ config này; hook DB khác vẫn có thể tồn tại. | PHP + reviewer theo domain | OPEN |
| [QUAL-03](findings/QUAL-03.md) | P2 | Đã xác minh bằng source | Đổi auth/payment phải sửa nhiều nơi; dependency Registry động làm khó inject fake và unit test. | PHP + reviewer theo domain | OPEN |
| [QUAL-04](findings/QUAL-04.md) | P2 | Đã xác minh bằng source | Mail chậm/lỗi kéo dài request hoặc tạo trạng thái ghi xong nhưng response lỗi; coupling ngược model→controller. | PHP + reviewer theo domain | OPEN |
| [PERF-01](findings/PERF-01.md) | P2 | Đã xác minh bằng source | Chi phí DB tăng theo page size, cộng resize ảnh và correlated subquery. | PHP + reviewer theo domain | OPEN |
| [PERF-02](findings/PERF-02.md) | P2 | Nguy cơ tiềm ẩn | Có thể full scan/CPU cao khi catalog tăng; không khẳng định hiện tại chậm. | PHP + reviewer theo domain | OPEN |
| [PERF-03](findings/PERF-03.md) | P2 | Nguy cơ tiềm ẩn | Các AJAX request cùng session có thể last-write-wins mất pending/token changes; chưa benchmark concurrent. | PHP + reviewer theo domain | OPEN |
| [PERF-04](findings/PERF-04.md) | P2 | Nguy cơ tiềm ẩn | Cold cache hoặc cache directory lớn có thể tăng IO/CPU, stampede ảnh cùng kích thước. | PHP + reviewer theo domain | OPEN |
| [OPS-01](findings/OPS-01.md) | P1 | Đã xác minh bằng source | Install/build mới có thể ghi sai directory hoặc không kiểm tra đúng source; chưa chạy các command gây thay đổi dependency. | PHP + reviewer theo domain | OPEN |
| [OPS-02](findings/OPS-02.md) | P1 | Đã xác minh bằng source | Thanh toán/auth thay đổi không có regression guard; coverage ứng dụng chưa đo, không báo 0% khi chưa chạy coverage. | PHP + reviewer theo domain | OPEN |
| [OPS-03](findings/OPS-03.md) | P2 | Nguy cơ tiềm ẩn | Environment drift, timeout dài hoặc lỗi xử lý ảnh nếu áp dụng; không khẳng định runtime đang dùng các số này. | PHP + reviewer theo domain | OPEN |
| [OPS-04](findings/OPS-04.md) | P2 | Đề xuất cải tiến | Khó phân biệt charge thành công/order lỗi hoặc phục hồi khi mất DB; quy trình vận hành ngoài repo chưa được cung cấp. | PHP + reviewer theo domain | OPEN |
| [BIZ-01](findings/BIZ-01.md) | P1 | Đã xác minh bằng source | Người dùng có thể hiểu store sẵn sàng trong khi code chỉ ghi nhận subscription; worker/control plane ngoài repo chưa xác minh. | PHP + reviewer theo domain | OPEN |
| [SEC-09](findings/SEC-09.md) | P2 | Đề xuất cải tiến | Có thể giữ package không còn hỗ trợ hoặc có advisory, nhưng chưa có chứng cứ lỗ hổng package cụ thể. | PHP + reviewer theo domain | OPEN |

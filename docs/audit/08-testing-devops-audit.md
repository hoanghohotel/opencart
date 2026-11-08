# Testing và DevOps

Audit hiện tại chỉ chạy kiểm tra source/DDL/hash/location offline; không chạy unit/integration/API/functional/regression hoặc coverage cho ứng dụng. Các smoke môi trường ở giai đoạn onboarding là bằng chứng readiness cơ bản của phiên trước, không phải regression chứng minh nghiệp vụ an toàn. Vendor tests không thay thế test app. Không khẳng định không có CI/deployment/backup bên ngoài repository.

Bộ kiểm thử tối thiểu đề xuất:

1. Unit: order transition, money rounding, entitlement, upload policy, token policy, legacy password upgrade.
2. Integration MariaDB disposable: create paid order/ledger/outbox atomic, failure rollback, idempotent replay/concurrency, ownership getPayment/order/download; migration rehearsal trên restore copy.
3. API/contract: invalid/missing token → 403, unauthenticated → 401/login theo contract, gateway amount/currency mismatch, timeout, webhook signature/replay; legacy endpoints cùng policy.
4. Functional: register verify/login/PIN/security, browse/search/detail, purchase card/PayPal mocks, admin extension/category/order/settings theo role.
5. Regression: nhiều tab/session AJAX, refresh success không ghi, refund không cấp quyền mới, language/theme hooks, rich text escaping.
6. DevOps: fresh checkout frozen install → autoload/lint → tests >0 → artifacts → staging canary → rollback smoke; restore drill + financial invariant check trước publish.

Test data hoàn toàn giả, không token/PAN thật; fake gateway không fallback sang real. Coverage baseline riêng cho critical boundaries, chưa ấn định tỷ lệ phần trăm tùy ý. Logging correlation/status/duration với redaction; alert payment/order mismatch, queue backlog, auth throttles, TLS failures. Backup endpoint admin không đủ chứng minh offsite retention hoặc DR.

| ID | Ưu tiên | Phân loại | Phát hiện |
|---|---|---|---|
| [OPS-01](findings/OPS-01.md) | P1 | Đã xác minh bằng source | Build/dependency config không khớp layout source |
| [OPS-02](findings/OPS-02.md) | P1 | Đã xác minh bằng source | Thiếu test suite first-party và CI definition trong checkout |
| [OPS-03](findings/OPS-03.md) | P2 | Nguy cơ tiềm ẩn | php.ini chứa giá trị legacy và giới hạn mâu thuẫn tài liệu |
| [OPS-04](findings/OPS-04.md) | P2 | Đề xuất cải tiến | Cần telemetry tài chính và diễn tập restore |
| [SEC-09](findings/SEC-09.md) | P2 | Đề xuất cải tiến | Dependency version pin chưa có kiểm chứng advisory hiện hành |

Chi tiết từng phát hiện gồm source và dòng, nguyên nhân, hậu quả/điều kiện, phương án, tương thích, test/nghiệm thu và ngày công. Không triển khai sửa chữa trong audit.

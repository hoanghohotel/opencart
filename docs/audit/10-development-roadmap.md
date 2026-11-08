# Roadmap 6–12 tháng

Các mốc là kế hoạch có điều kiện, chưa phải cam kết delivery. Ưu tiên marketplace hàng hóa số; không xây cart/shipping/inventory vật lý chỉ vì một checklist commerce. Không microservices ở giai đoạn này.

| Giai đoạn | Thời gian đề xuất | Deliverables | Điều kiện qua cổng |
|---|---|---|---|
| 1 — Stabilization | Tuần 1–6 | PAY-01/02 + SEC-01 trước; TLS, auth throttling, dependency-route fixes; test payment proofs; reconciliation report, logs redacted, restore rehearsal | Mọi đường paid completion cần proof server; success không ghi; token sai bị từ chối; duplicate/retry có guard tạm; owner xác nhận production exposure |
| 2 — Modernization | Tháng 2–4 | PAY-03/DB-01: intent/idempotency/InnoDB tài chính/outbox; password transition; session concurrency; test CI fresh checkout; measured query/cache improvements | Fault injection rollback đúng; gateway và DB reconcile; restore copy thành công; legacy contracts pass; p95/query count đo và không regression |
| 3 — Expansion | Tháng 5–8 | API versioned dùng chung use-case; cloud lifecycle có provider contract; UI quản trị/payment status; multi-store isolation nếu có hợp đồng kinh doanh | Boundary authz tenant/member có test; API contract/SLO; provisioning thật xác minh; roadmap expansion được PO phê duyệt |
| 4 — Intelligent Commerce | Tháng 9–12, tùy ROI | Chỉ chọn các thử nghiệm có dữ liệu và chủ sở hữu bên dưới | Data governance/consent, baseline/control group, cost cap và kill criteria; không ảnh hưởng đường charge/entitlement |

Ước lượng: 2 PHP full-time + QA automation 0,5–1 FTE; DevOps 0,25–0,5; DBA và Security 0,1–0,25 mỗi vai trò theo sprint; PO 0,25. Giai đoạn đầu cần reviewer PHP có kinh nghiệm payment. Đây là phân bổ năng lực, không phải yêu cầu tuyển từng vị trí. Effort từng finding có chồng lấn (OrderService/transaction/test), không cộng cơ học. Lập lại estimate sau 1–2 tuần characterization; dành khoảng 20–30% năng lực cho regression/rollout, không tự ấn định ngân sách tiền khi chưa có đơn giá.

## Tính khả thi và giá trị kinh doanh

| Đề xuất | Giá trị kiểm chứng được | Chi phí thử nghiệm sơ bộ | Điều kiện / cách quyết định |
|---|---|---|---|
| AI hỗ trợ admin | Tóm tắt support/extension draft, giảm thời gian xử lý | 2–4 tuần kỹ sư + review nghiệp vụ + chi phí model theo request | Chỉ gợi ý, người duyệt; không gửi secret/payment PII; đo phút/ticket, lỗi nội dung và tỷ lệ chấp nhận |
| Search semantic/hybrid | Tăng tìm đúng extension khi keyword mơ hồ/đa ngôn ngữ | 3–6 tuần, embeddings/index vận hành | Sửa LIKE/search baseline trước; có corpus + relevance judgments, A/B search success/conversion với cost cap |
| Recommendations | Cross-sell extension tương thích phiên bản và giấy phép | 3–6 tuần cho rules/co-occurrence trước AI | Cần đủ sự kiện đã consent, lọc compatibility/entitlement; cold-start dùng curated, đo click→purchase tăng thêm |
| Automation | Mail, archive scan, reconciliation, provisioning bền vững | 2–4 tuần hạ tầng queue/outbox, chia sẻ với phase 2 | Giá trị độ tin cậy rõ hơn AI; worker retry/idempotency/alert trước tự động hóa tài chính |
| Analytics dashboard | Paid revenue/net seller ledger, refund/charge discrepancy | 2–4 tuần | Chốt định nghĩa Paid/refund và sửa PAY/DB trước; count order Complete cũ chưa đủ là revenue đã nhận tiền |
| CRM integration | Đồng bộ member/support có consent, giảm thao tác | 2–4 tuần/connector | Có hệ CRM đích và chủ data, mapping/version contract, deletion/opt-out; không sync secrets/payment tokens |
| ERP integration | Đối soát invoice, seller settlement và tài khoản kế toán | 4–8 tuần/connector | Chốt ledger/tax/legal và canonical IDs; đối soát, retry và audit; chưa có vendor đích nên estimate thấp tin cậy |
| Omnichannel | Cổng bán nhiều kênh cho catalog số | Discovery 2–3 tuần trước build | Chỉ làm khi có kênh/volume/doanh thu cụ thể; không thêm stock/shipping nếu vẫn chỉ extension |
| Kết nối commerce platform khác | License/download entitlement adapter, bán extension nhiều nền tảng | 3–6 tuần/adapter sau discovery | Chốt API, compatibility/platform terms; test customer mapping và signed downloads; không fork core theo mỗi platform |

Các ước lượng thử nghiệm không bao gồm vận hành dài hạn, chi phí vendor hay migration dữ liệu. Không triển khai AI auto-refund/auto-charge; mọi quyết định tiền/quyền phải qua policy xác định và audit trail.

## Rủi ro thực thi kế hoạch

Ràng buộc quan trọng: credential sandbox, dữ liệu restore đã ẩn danh, ownership quyết định trạng thái đơn, xác nhận integration provisioning ngoài repo, cửa sổ DDL và dữ liệu legacy. Nếu thiếu, tiếp tục test mocks và read-only analysis; không lấy “chưa trả lời” làm quyền thay dữ liệu. Mỗi phase có canary, rollback và kiểm tra invariant; phase 3/4 không thay thế việc đóng PAY/SEC P0.

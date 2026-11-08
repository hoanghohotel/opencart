# SEC-05 — Session ID không được xoay khi đăng nhập trong custom session

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Nguy cơ tiềm ẩn**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: system.

## Bằng chứng

- [system/library/session.php:57](../../../system/library/session.php#L57) — `public function start`
- [system/library/cart/member.php:96](../../../system/library/cart/member.php#L96) — `$this->session->data['member_id'] =`
- [system/library/cart/user.php:46](../../../system/library/cart/user.php#L46) — `$this->session->data['user_id'] =`

## Mô tả và nguyên nhân

start nhận ID hợp lệ từ cookie và login đặt identity; chưa thấy rotate custom session ID trong hai login. Member token có xoay, khác session ID.

## Hậu quả và điều kiện

Nguy cơ fixation nếu kẻ khác có cách đặt/biết cookie trước login; chưa chứng minh được điều kiện đặt cookie ngoài production.

## Phương án khắc phục (chưa thực hiện)

Thêm rotate cho custom Session/adapter, invalidate ID cũ sau authentication/privilege change; set secure, httponly, samesite bằng cookie options.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

ID cũ không truy cập identity sau login, tab đồng thời và API session không hỏng; kiểm tra cookie thực trên HTTPS staging.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

4–6 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

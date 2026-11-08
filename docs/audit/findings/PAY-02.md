# PAY-02 — Trang success có side effect tạo đơn từ session

**Sau audit — P0-A:** đã loại bỏ write/consume pending trong success; 15 regression case pass local, chờ nghiệm thu. Chưa triển khai binding trang hiển thị với order đã xác nhận thuộc member; chưa chứng nhận end-to-end payment. Chi tiết tại [biên bản triển khai](../../improvements/P0-A-result-pages.md). Bằng chứng bên dưới là baseline trước sửa.

- Ưu tiên: **P0**; mức độ tác động: **Critical** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application.

## Bằng chứng

- [application/controller/checkout/checkout.php:83](../../../application/controller/checkout/checkout.php#L83) — `public function success`
- [application/controller/checkout/payment.php:36](../../../application/controller/checkout/payment.php#L36) — `public function paypal`

## Mô tả và nguyên nhân

success() dùng pending_extension_order và isLogged để addOrder; paypal() có thể đặt pending trước capture. Không thấy verify gateway trong success.

## Hậu quả và điều kiện

Điều hướng hiển thị thành công có thể cấp đơn/entitlement mà chưa có bằng chứng thu tiền.

## Phương án khắc phục (chưa thực hiện)

success chỉ đọc order thuộc member và render; pending phải có order intent ID, server verification độc lập. Không dựa vào callback UI hoặc tồn tại session.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

GET success không ghi order dù pending tồn tại; failure/cancel/refresh không cấp quyền mua; dữ liệu cũ vẫn xem invoice được.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

3–5 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

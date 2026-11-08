# QUAL-04 — Model order gọi mail controller đồng bộ sau ghi dữ liệu

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: application.

## Bằng chứng

- [application/model/account/order.php:48](../../../application/model/account/order.php#L48) — `controller('mail/order'`
- [application/controller/mail/order.php:3](../../../application/controller/mail/order.php#L3) — `public function index`

## Mô tả và nguyên nhân

addOrder/editOrderStatus gọi Loader controller mail/order, trộn persistence với presentation/notification.

## Hậu quả và điều kiện

Mail chậm/lỗi kéo dài request hoặc tạo trạng thái ghi xong nhưng response lỗi; coupling ngược model→controller.

## Phương án khắc phục (chưa thực hiện)

Trong boundary transaction mới ghi outbox; worker gửi mail theo order event. Transitional adapter giữ nội dung mail hiện tại.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Mail service ngừng vẫn trả order đã commit; worker retry không gửi trùng; template/invoice snapshot không đổi.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

4–7 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

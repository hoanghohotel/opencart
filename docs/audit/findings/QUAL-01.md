# QUAL-01 — Tham chiếu model literal không có file đích

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: admin, system.

## Bằng chứng

- [admin/controller/event/statistics.php:5](../../../admin/controller/event/statistics.php#L5) — `model('setting/statistics')`
- [admin/controller/setting/store.php:314](../../../admin/controller/setting/store.php#L314) — `model('setting/extension')`
- [admin/controller/localisation/country.php:376](../../../admin/controller/localisation/country.php#L376) — `model('customer/customer')`
- [system/engine/loader.php:99](../../../system/engine/loader.php#L99) — `Error: Could not load model`

## Mô tả và nguyên nhân

Inventory literal-loads chỉ ra thiếu các model trên và một số model legacy khác; Loader ném exception khi load model vắng. Chưa khẳng định tất cả endpoint đang được UI dùng.

## Hậu quả và điều kiện

Nhánh được thực thi có thể fatal; cấu hình store/localisation/admin chưa đủ kiểm thử.

## Phương án khắc phục (chưa thực hiện)

Lập route reachability matrix; khôi phục model đúng domain member hoặc loại đường gọi obsolete sau kiểm tra data contract; không tạo stub luôn trả success.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Characterization các route lỗi với role/fixture đủ điều kiện; dependency resolver không còn thiếu target literal ngoài prefix động được giải thích.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

5–10 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

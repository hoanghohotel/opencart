# OPS-01 — Build/dependency config không khớp layout source

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: build.xml, composer.json, system.

## Bằng chứng

- [composer.json:9](../../../composer.json#L9) — `./upload/system/storage/vendor/`
- [build.xml:3](../../../build.xml#L3) — `value="upload"`
- [system/startup.php:70](../../../system/startup.php#L70) — `vendor/autoload.php`

## Mô tả và nguyên nhân

Composer vendor-dir upload/... và build targets upload/tests khác actual system/storage/vendor và thiếu upload/tests; runtime dùng vendor bundled.

## Hậu quả và điều kiện

Install/build mới có thể ghi sai directory hoặc không kiểm tra đúng source; chưa chạy các command gây thay đổi dependency.

## Phương án khắc phục (chưa thực hiện)

Trong coding task riêng sửa config sau baseline vendor manifest/lock; frozen install vào layout thật trên clean checkout; test build độc lập snapshot hiện tại.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

Fresh clone CI install theo lock + autoload + smoke + lint đúng target; không thay lock ngoài update đã review.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

3–5 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

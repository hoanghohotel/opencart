# SEC-02 — Các HTTP client gateway/storage tắt xác minh TLS

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: system.

## Bằng chứng

- [system/library/payment_gateway.php:234](../../../system/library/payment_gateway.php#L234) — `CURLOPT_SSL_VERIFYPEER, false`
- [system/library/cloud_storage.php:612](../../../system/library/cloud_storage.php#L612) — `CURLOPT_SSL_VERIFYHOST, 0`

## Mô tả và nguyên nhân

stripeRequest, Braintree/PayPal HTTP và S3/GCS chứa CURLOPT_SSL_VERIFYPEER=false; S3 còn VERIFYHOST=0.

## Hậu quả và điều kiện

Mất xác thực server TLS khi thực sự gọi network; nguy cơ lộ credentials, sửa response qua MITM. Không khẳng định đã xảy ra.

## Phương án khắc phục (chưa thực hiện)

Bật peer/hostname verification mặc định; cấu hình CA bundle đáng tin cho proxy/hosting; fail closed và log mã lỗi không kèm secret.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Hosting dùng CA tùy chỉnh phải cấu hình trust trước rollout; không fallback insecure.

## Kiểm thử và tiêu chí nghiệm thu

CA hợp lệ thành công; cert sai hostname/hết hạn/untrusted thất bại; smoke sandbox gateway trên staging.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

2–4 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

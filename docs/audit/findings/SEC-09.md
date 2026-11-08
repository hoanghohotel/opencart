# SEC-09 — Dependency version pin chưa có kiểm chứng advisory hiện hành

- Ưu tiên: **P2**; mức độ tác động: **Medium** (đánh giá audit, không phải CVSS).
- Phân loại: **Đề xuất cải tiến**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: composer.json, composer.lock.

## Bằng chứng

- [composer.lock:8](../../../composer.lock#L8) — `"packages"`
- [composer.json:12](../../../composer.json#L12) — `3.40.0`

## Mô tả và nguyên nhân

Dependency lock/bundled có package version cụ thể; audit này chưa query advisory database, không gán CVE từ tuổi version.

## Hậu quả và điều kiện

Có thể giữ package không còn hỗ trợ hoặc có advisory, nhưng chưa có chứng cứ lỗ hổng package cụ thể.

## Phương án khắc phục (chưa thực hiện)

Xuất SBOM từ lock và installed metadata; scan composer audit/OSV từ mạng được phép trong CI, xác minh advisory/range/reachability; update một nhóm/lần với contract tests.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Không composer update hàng loạt; package SDK mới có thể đổi API/PHP baseline.

## Kiểm thử và tiêu chí nghiệm thu

Archive advisory timestamp/source + dependency version installed; trường hợp không có network ghi unavailable; gateway/Twig regression trước merge.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

2–4 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

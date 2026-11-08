# OPS-02 — Thiếu test suite first-party và CI definition trong checkout

- Ưu tiên: **P1**; mức độ tác động: **High** (đánh giá audit, không phải CVSS).
- Phân loại: **Đã xác minh bằng source**. “Đã xác minh” = chứng minh đường code/cấu hình, không đồng nghĩa đã khai thác runtime.
- Module: build.xml, composer.json.

## Bằng chứng

- [build.xml:47](../../../build.xml#L47) — `tests/phpcs/OpenCart/ruleset.xml`
- [composer.json:11](../../../composer.json#L11) — `"require"`

## Mô tả và nguyên nhân

git ls-files không có .github workflow hay first-party unit/integration suite; vendor có tests riêng không kiểm chứng business app. Không chứng minh CI ngoài repo không tồn tại.

## Hậu quả và điều kiện

Thanh toán/auth thay đổi không có regression guard; coverage ứng dụng chưa đo, không báo 0% khi chưa chạy coverage.

## Phương án khắc phục (chưa thực hiện)

Pipeline lint + isolated MariaDB + characterization checkout/auth/admin + gateway mocks; contract tests API; thêm coverage baseline cho critical code trước ngưỡng tổng.

Các file trong bằng chứng là điểm thay đổi dự kiến; service/policy/outbox mới chỉ là thiết kế đề xuất. Thay đổi bổ sung ở controller caller, model hoặc schema phải có review boundary riêng.

## Tương thích và rollout

Giữ route/data contract; rollout sau regression, không sửa source trong audit.

## Kiểm thử và tiêu chí nghiệm thu

CI fail khi bỏ gate hoặc hoàn tất order chưa paid; schema fixture disposable; test count >0, artifact report và secret-free logs.

Đây là các test đề xuất, **chưa được thực thi** trong audit. Nghiệm thu khi assertions nêu trên đạt trên staging disposable và regression legacy được reviewer duyệt.

## Công sức / chủ trì

10–18 ngày công gồm triển khai + kiểm thử cục bộ; chưa gồm chờ stakeholder, kiểm thử toàn hệ thống hoặc cutover production. Chủ trì PHP; Security review SEC/PAY; DBA review DB/PAY; DevOps review OPS/PERF. Ước lượng sơ bộ, sẽ chỉnh sau characterization.

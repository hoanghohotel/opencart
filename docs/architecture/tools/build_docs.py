from pathlib import Path
import json,csv,collections,re
R=Path(__file__).resolve().parents[3]; O=R/'docs/architecture';E=O/'evidence'
s=json.loads((E/'summary.json').read_text());syms=json.loads((E/'symbols.json').read_text());schema=json.loads((E/'schema.json').read_text());manifest=json.loads((E/'diagram-manifest.json').read_text());loads=list(csv.DictReader((E/'literal-loads.csv').open()))
def link(path,line=1):return f'[{path}:{line}](../../{path}#L{line})'
lines=['# Bản đồ source code','',f'Commit khảo sát: `{s["commit"]}`. Đây là inventory tĩnh theo declaration/literal, không phải call graph runtime.','', '## Phạm vi','',f'{s["files"]} file tracked được đọc và băm SHA-256; {s["php_files"]} file PHP được quét declaration/reference, trong đó {s["first_party_php"]} file không nằm trong vendor. Phân tích thủ công sâu tập trung entrypoint, engine, startup, auth, marketplace, checkout/payment, order, admin CRUD và SQL. Không khẳng định đã kiểm chứng ngữ nghĩa từng nhánh của toàn bộ thư viện bên thứ ba.','', '## Class và method ngoài vendor','', '| File | Class / namespace | Method khai báo |','|---|---|---|']
for r in syms:
 if r['vendor']:continue
 lines.append('| '+link(r['path'])+' | '+r['namespace']+' '+r['cls']+' | '+', '.join('`'+x+'()`' for x in r['methods'])+' |')
lines+=['','## Tham chiếu model chưa giải quyết','','Các dòng dưới đây là lời gọi literal có file đích không tồn tại; không kết luận endpoint đã được thực thi hoặc đang được dùng. `install/upgrade/` chứa tham chiếu ghép động nên target literal có thể chỉ là prefix.','','| Nguồn | load->model target |','|---|---|']
for l in loads:
 if l['kind']=='model' and l['exact_file_exists']=='False':lines.append('| '+link(l['path'],l['line'])+' | `'+l['target']+'` |')
lines+=['','## Các dữ liệu máy đọc được','','- `evidence/files.csv`: toàn bộ file gốc và hash trước khi thêm docs.','- `evidence/methods.csv`: declarations + vị trí dòng; trích xuất tĩnh, không bao gồm method kế thừa.','- `evidence/literal-loads.csv`: model/controller/view/language/library/helper/config literal. `exact_file_exists=false` chưa đồng nghĩa dependency mất: controller route có hậu tố method và một số load dùng prefix động.','- `evidence/model-calls.csv`: lời gọi `$this->model_*->method()` theo method nguồn.','- `evidence/sql-table-access.csv`: bảng tại vị trí FROM/JOIN/UPDATE/INTO/TABLE; token FROM không đồng nghĩa thao tác SELECT thuần, DELETE cũng có FROM. Không phân loại read/write chỉ từ token này.','- Các extractor dùng regex, không phải PHP AST hoặc phân tích data-flow; tên class trong comment/vendor và tham chiếu động cần đối chiếu thủ công trước khi dùng làm kết luận mới.']
(O/'source-map.md').write_text('\n'.join(lines)+'\n')
lines=['# Schema và quan hệ dữ liệu','', 'Nguồn chuẩn: '+link('install/opencart.sql')+'. 58/59 bảng dùng MyISAM; riêng oc_session dùng InnoDB; không có FOREIGN KEY hoặc UNIQUE KEY ngoài PRIMARY KEY. Các index KEY thường không bảo đảm duy nhất. Dữ liệu seed không chứng minh quan hệ bắt buộc hoặc toàn vẹn tham chiếu.','', '## Quy tắc đọc ER','', '- Đường quan hệ nét đứt trong `07-database-er.drawio` là lookup/join/ghi dữ liệu có bằng chứng trong code; không phải constraint SQL.','- `1:N`: bảng cha lookup bằng PK, nhiều dòng bảng con có thể mang cùng ID. Không khẳng định mọi dòng con có cha hợp lệ; nhiều cột dùng 0 như giá trị không liên kết.','- Không có cơ sở để khẳng định quan hệ 1:1 được database cưỡng chế giữa member và seller/partner/payment. `member_seller.member_id` không UNIQUE.','- Quan hệ N:N có bằng chứng: extension download ↔ release version (`oc_download`) qua `oc_extension_download_path`, PK kép `(extension_download_id,download_id)`, được ghi trong `admin/model/marketplace/extension.php::editExtension()` và dùng trong bộ lọc version.','- `oc_information_description` có PK kép `(information_id,language_id)`; `oc_information_to_store` có PK kép `(information_id,store_id)`. Bảng nối tồn tại trong DDL; không coi mọi bảng nối đều đang được frontend dùng. `getInformation()` không join information_to_store.','- `oc_order` lưu một extension_id, quantity, giá snapshot, seller_id và member_id; không có order_product/cart/shipping trong schema này.','- Payment vault là `oc_member_payment`; transaction gateway nằm trong `oc_order.transaction_id` hoặc subscription transaction. Không có bảng payment chung riêng biệt.','- Không tự nối `oc_session.session_id` với API session chỉ vì cùng tên: API startup có query riêng, không có FK.','', '## Quan hệ có bằng chứng cụ thể','', '| Cha | Con | Quan hệ | Bằng chứng |','|---|---|---|---|']
for r in json.loads((E/'logical-relations.json').read_text()):
 p,l=r['source'].rsplit(':',1);lines.append('| `'+r['parent']+'` | `'+r['child']+'` | '+r['relation']+' | '+link(p,l)+' |')
for t in schema:
 lines+=['', '## '+t['name'],'',link('install/opencart.sql',t['line'])+' · PK: `'+', '.join(t['pk'])+'` · '+t['engine'],'','| Cột | Định nghĩa trong DDL |','|---|---|']
 for c in t['columns']:lines.append('| `'+c['name']+'` | `'+c['definition'].replace('|','&#124;')+'` |')
 lines+=['','Index thường: '+('; '.join(x['name']+'('+','.join(x['columns'])+')' for x in t['indexes']) or 'không có')+'. FK khai báo: không có.']
(O/'database-schema.md').write_text('\n'.join(lines)+'\n')
lines=['# Danh mục trang sơ đồ','', 'Trang đầu mỗi file có PNG trùng tên file. Trang tiếp theo dùng hậu tố `-page-NN`; Mermaid tương ứng theo cùng quy ước. Các contact sheet phục vụ rà soát bố cục, không thay PNG đầy đủ.','', '| File / trang | Tên trang | PNG | Mermaid |','|---|---|---|---|']
for f,pages in manifest.items():
 for i,p in enumerate(pages):
  suf='' if i==0 else f'-page-{i+1:02d}';name=f+suf
  lines.append(f'| [{f}.drawio]({f}.drawio) / {i+1} | {p["name"]} | [PNG](exports/{name}.png) | [Nguồn](mermaid/{name}.mmd) |')
(O/'diagram-index.md').write_text('\n'.join(lines)+'\n')
# Candidate route table: path + method only, never an assertion of reachability or authorization.
lines=['# Route candidate từ controller','', 'Action tách route theo file controller tồn tại, phần đuôi là method, mặc định index. Bảng dưới chỉ gồm method public được khai báo; không chứng minh endpoint có thể đi qua pre-action, có đủ tham số hoặc đang được UI gọi. Không chạy endpoint ghi dữ liệu để kiểm thử tài liệu.','', '| App | Route candidate | Class::method | Source |','|---|---|---|---|']
for row in csv.DictReader((E/'methods.csv').open()):
 if '/controller/' not in row['path'] or row['vendor']=='True' or row['visibility']!='public' or row['method'].startswith('__'):continue
 app,route=row['path'].split('/controller/',1);route=route[:-4]+('' if row['method']=='index' else '/'+row['method'])
 lines.append('| '+app+' | `'+route+'` | `'+row['cls']+'::'+row['method']+'()` | '+link(row['path'],row['line'])+' |')
(O/'routes.md').write_text('\n'.join(lines)+'\n')
print('Documentation indexes written')

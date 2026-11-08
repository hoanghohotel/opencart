from pathlib import Path
import xml.etree.ElementTree as E,json,re
R=Path(__file__).resolve().parents[3];O=R/'docs/audit';F=json.loads((O/'evidence/findings.json').read_text())
def draw(name,title,nodes,edges):
 root=E.Element('mxfile',host='app.diagrams.net',type='device');d=E.SubElement(root,'diagram',id=name,name=title);g=E.SubElement(d,'mxGraphModel',grid='1',page='1',pageWidth='1550',pageHeight='1250');r=E.SubElement(g,'root');E.SubElement(r,'mxCell',id='0');E.SubElement(r,'mxCell',id='1',parent='0')
 for i,(label,kind,source) in enumerate(nodes):
  x=60+(i%3)*500;y=170+(i//3)*230
  color={'actual':'#dcf4ec','risk':'#ffe4e4','proposed':'#e5edff','plan':'#fff0d3'}[kind]
  c=E.SubElement(r,'mxCell',id='n'+str(i),value=label+('\n'+source if source else ''),vertex='1',parent='1',style=f'rounded=1;whiteSpace=wrap;html=0;fillColor={color};fontSize=16;align=left;spacing=16;strokeColor=#64748b;')
  E.SubElement(c,'mxGeometry',x=str(x),y=str(y),width='420',height='155',attrib={'as':'geometry'})
 heading=E.SubElement(r,'mxCell',id='title',value=title+'\nXanh: hiện tại; đỏ: finding; xanh lam: đề xuất; vàng: kế hoạch. Source audit, không benchmark.',vertex='1',parent='1',style='text;whiteSpace=wrap;html=0;fontSize=22;align=left;')
 E.SubElement(heading,'mxGeometry',x='60',y='30',width='1420',height='100',attrib={'as':'geometry'})
 for k,(a,b,label) in enumerate(edges):
  assert 0<=a<len(nodes) and 0<=b<len(nodes)
  c=E.SubElement(r,'mxCell',id='e'+str(k),edge='1',parent='1',source='n'+str(a),target='n'+str(b),value=label,style='edgeStyle=orthogonalEdgeStyle;endArrow=block;html=0;fontSize=13;labelBackgroundColor=#ffffff;')
  E.SubElement(c,'mxGeometry',relative='1',attrib={'as':'geometry'})
 E.indent(root);E.ElementTree(root).write(O/'diagrams'/f'{name}.drawio',encoding='utf-8',xml_declaration=True)
draw('current-architecture','Kiến trúc hiện tại · source verified',[
 ('Browser → index.php/admin/index.php','actual','index.php:1; admin/index.php:1'),('Bootstrap / Registry / pre-actions / Action','actual','system/framework.php:1; system/engine/action.php:1'),('Controller / Model / Library','actual','system/engine/loader.php:1'),('Payment completion phân tán','risk','PAY-01, PAY-02; checkout/payment.php::confirm'),('SQL order/sales/commission; mail đồng bộ','actual','application/model/account/order.php:3'),('58 MyISAM; session InnoDB','actual','install/opencart.sql; DB-01')],[(0,1,'HTTP/PHP'),(1,2,'dispatch'),(2,3,'checkout routes'),(3,4,'addOrder'),(4,5,'DB::query')])
draw('proposed-architecture','Kiến trúc mục tiêu ĐỀ XUẤT · modular monolith',[
 ('Front/admin/API adapters giữ route contract','proposed','QUAL-03; OPS-02'),('Auth/CSRF/ownership policy','proposed','SEC-01/04/05'),('Checkout / Order / Entitlement use-cases','proposed','PAY-01/02/03'),('Payment provider port + verified event','proposed','SEC-02; PAY-01/03'),('Repository + InnoDB transaction + outbox','proposed','DB-01; cần rehearsal migration'),('Worker mail/provision/scan + observability','proposed','QUAL-04; BIZ-01; OPS-04')],[(0,1,'validate'),(1,2,'authorized intent'),(2,3,'proof / idempotency'),(2,4,'atomic state'),(4,5,'committed outbox')])
draw('dependency-problems','Các điểm phụ thuộc có bằng chứng',[
 ('CheckoutPayment và legacy endpoints','risk','PAY-01: nhiều đường addOrder'),('ModelAccountOrder → mail/order Controller','risk','QUAL-04: IO notification đồng bộ'),('Registry / magic model proxies','actual','QUAL-03; system/engine/loader.php'),('Frontend startup ghi token request','risk','SEC-01; startup/startup.php:137'),('Controller token gate','actual','account/extension.php::delete'),('Admin missing model targets','risk','QUAL-01: setting/statistics, setting/extension')],[(0,1,'order/notification'),(2,0,'shared mutable services'),(3,4,'ghi đè trước kiểm tra')])
draw('improvement-roadmap','Roadmap ĐỀ XUẤT · phụ thuộc nghiệm thu',[
 ('1. Stabilization · tuần 1–6\nPAY-01/02, SEC-01/02, proof tests','plan','10-development-roadmap.md'),('2. Modernization · tháng 2–4\nAtomic order, idempotency, CI, measured perf','plan','DB-01/PAY-03/OPS-02'),('3. Expansion · tháng 5–8\nAPI contracts, cloud lifecycle, admin UX','plan','BIZ-01; tenant isolation tests'),('4. Intelligent Commerce · tháng 9–12\nChỉ pilot có ROI/data/cost cap','plan','10-development-roadmap.md; không auto-charge AI')],[(0,1,'đóng P0 + staging'),(1,2,'reconcile/restore pass'),(2,3,'data governance + business case')])
counts={p:[f['id'] for f in F if f['priority']==p] for p in ['P0','P1','P2','P3']}
draw('risk-priority','Ưu tiên audit · không phải ma trận xác suất đã đo',[(p+' · '+str(len(ids))+' finding\n'+', '.join(ids),'risk' if p in ['P0','P1'] else 'plan','11-risk-register.md; tất cả OPEN') for p,ids in counts.items()],[])
checked=0
for f in O.rglob('*.md'):
 for dest in re.findall(r'\]\(([^)]+)\)',f.read_text()):
  if dest.startswith(('http:','https:','#')):continue
  # validation file below is created at the end.
  if dest=='evidence/artifact-validation.json':continue
  assert (f.parent/dest.split('#')[0]).exists(),(f,dest)
  checked+=1
for f in (O/'diagrams').glob('*.drawio'):
 t=E.parse(f);cells=t.findall('.//mxCell');ids=[c.get('id') for c in cells];assert len(ids)==len(set(ids))
 for c in cells:
  if c.get('edge')=='1':assert c.get('source') in ids and c.get('target') in ids
json_out={'markdown_links_checked':checked,'drawio_xml':5,'xml_ids_edges':'PASS','source_findings':len(F),'drawio_plugin_editor_roundtrip':'NOT VERIFIED: tool unavailable','runtime_security_business_tests':'NOT RUN','source_writes':'NONE; only docs and architecture documentation correction'}
(O/'evidence/artifact-validation.json').write_text(json.dumps(json_out,ensure_ascii=False,indent=2));print(json.dumps(json_out,ensure_ascii=False,indent=2))

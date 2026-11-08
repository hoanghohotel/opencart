"""Generate editable mxGraph XML and a shared-geometry SVG rendering. No plugin API used."""
from pathlib import Path
import csv,json,re,html,textwrap,xml.etree.ElementTree as ET
ROOT=Path(__file__).resolve().parents[3]; OUT=ROOT/'docs/architecture'; EV=OUT/'evidence'
S=json.loads((EV/'summary.json').read_text()); schema=json.loads((EV/'schema.json').read_text()); symbols=json.loads((EV/'symbols.json').read_text())
loads=list(csv.DictReader((EV/'literal-loads.csv').open())); sqlrefs=list(csv.DictReader((EV/'sql-table-access.csv').open()))
COLORS={'core':'#e5edff','front':'#dcf4ec','admin':'#f1e5fc','data':'#fff0d3','external':'#dff3ff','note':'#fff7d6','missing':'#ffe4e4'}
PAGES={}; TRACE=[]
def ref(path,method=None):
 p=ROOT/path
 assert p.exists(),path
 s=p.read_text(errors='replace')
 if method:
  m=re.search(r'function\s+'+re.escape(method)+r'\s*\(',s); assert m,(path,method)
  return path+':'+str(s.count('\n',0,m.start())+1)
 return path+':1'
def evidence(r):
 if not r:return
 path,line=r.rsplit(':',1); assert (ROOT/path).is_file(),r
 assert 1<=int(line)<=len((ROOT/path).read_text(errors='replace').splitlines()),r
class Page:
 def __init__(self,file,name,subtitle=''):
  self.file=file; self.name=name; self.subtitle=subtitle; self.nodes=[]; self.edges=[]; self.w=1440; self.h=360; PAGES.setdefault(file,[]).append(self)
 def node(self,label,x,y,w=390,h=112,kind='core',source='',shape='box'):
  evidence(source); i='n'+str(len(self.nodes)+1); self.nodes.append(dict(id=i,label=label,x=x,y=y,w=w,h=h,kind=kind,source=source,shape=shape)); self.w=max(self.w,x+w+50); self.h=max(self.h,y+h+80)
  if source:TRACE.append(dict(file=self.file,page=self.name,node=i,label=label,source=source))
  return i
 def edge(self,a,b,label='',dashed=False,points=None):self.edges.append(dict(a=a,b=b,label=label,dashed=dashed,points=points or []))
 def chain(self,items):
  prev=None
  for idx,item in enumerate(items):
   label,kind,source=item; n=self.node(label,60,150+idx*155,1180,108,kind,source)
   if prev:self.edge(prev,n)
   prev=n
  return self
 def note(self,label,y):return self.node(label,60,y,1260,110,'note')
def page(file,name,sub=''):return Page(file,name,sub)
def chain(file,name,items,sub=''):return page(file,name,sub).chain(items)
F=['01-project-structure','02-system-architecture','03-application-logic','04-frontend-flow','05-admin-flow','06-sequence-diagrams','07-database-er','08-module-dependencies']
# 01: hierarchy, source-backed directory membership.
p=page(F[0],'01 · Gốc repository','Quan hệ chứa thành phần; không phải luồng gọi hàm')
r=p.node('opencartvn · '+S['commit'][:12],490,130,400,75,source=ref('index.php'))
entries=[('index.php + config.php','front','index.php'),('admin/ · backend MVC-L','admin','admin/index.php'),('application/ · frontend MVC-L','front','application/controller/common/home.php'),('system/ · engine, library, config, storage','core','system/framework.php'),('install/ · CLI, web, schema + seed','data','install/opencart.sql'),('image/ · catalog, cache, assets','front','application/model/tool/image.php'),('composer.json + composer.lock','external','composer.json'),('.htaccess + php.ini + robots.txt','core','.htaccess')]
for i,(label,k,s) in enumerate(entries):
 n=p.node(label,60+(i%2)*680,270+(i//2)*150,590,95,k,ref(s));p.edge(r,n,'',True,points=[(30 if i%2==0 else 1400,167),(30 if i%2==0 else 1400,270+(i//2)*150+47)])
for app,k in [('application','front'),('admin','admin')]:
 p=page(F[0],app+' · MVC-L và module','Tên module lấy từ controller/model thực tế; chi tiết class/method trong evidence/methods.csv')
 root=p.node(app+'/',500,130,390,70,k,ref(app+'/controller/startup/router.php'))
 paths=['controller','model','view/template','language/en-gb']
 for i,path in enumerate(paths):
  names=sorted({str(x.relative_to(ROOT/app/path)).split('/')[0] for x in (ROOT/app/path).rglob('*') if x.is_file()})
  n=p.node(path+'/\n'+', '.join(names),60+(i%2)*680,280+(i//2)*220,600,170,k);p.edge(root,n,'chứa',True)
p=page(F[0],'system · kernel và thư viện','Mỗi khối là thành phần có trên đĩa; bundled vendor khác đường dẫn composer.json')
for i,(label,k,s) in enumerate([
 ('engine/\nAction, Controller, Event, Loader, Model, Proxy, Registry, Router','core','system/engine/loader.php'),
 ('config/\ndefault.php, application.php, admin.php, install.php','core','system/config/default.php'),
 ('library/\nDB, Cache, Session, Template, Language, Request, Response, Url','core','system/library/db.php'),
 ('library/cart/\nMember, User, Currency; không có class Cart giỏ hàng','front','system/library/cart/member.php'),
 ('helper/\ngeneral.php, utf8.php, bbcode.php','core','system/helper/general.php'),
 ('library/\nPaymentGateway, CloudStorage, Mail','external','system/library/payment_gateway.php'),
 ('storage/\ncache, logs, download, upload, session, modification, vendor','data','system/startup.php'),
 ('vendor/\nTwig, Braintree, Cardinity, Divido, SCSSPHP, WeChat\n+ phụ thuộc bắc cầu theo composer.lock','external','composer.lock')]):p.node(label,60+(i%2)*680,150+(i//2)*190,600,145,k,ref(s))
# 02 layers + actual departures from pure layering.
p=page(F[1],'Kiến trúc phân lớp','Đường liền: lời gọi/phụ thuộc; đường đứt: điều kiện hoặc đăng ký hook. Không áp đặt tầng service không tồn tại.')
a=p.node('Client / Browser\nHTML, AJAX, SDK thanh toán JS',60,140,390,100,'external',ref('application/view/template/marketplace/extension_info.twig'))
b=p.node('Web Server\n.htaccess rewrite / static assets',520,140,390,100,'core',ref('.htaccess'));p.edge(a,b,'HTTP')
c=p.node('Entry + Bootstrap\nindex.php / admin/index.php → start()',980,140,390,100,'core',ref('system/startup.php','start'));p.edge(b,c,'PHP request')
d=p.node('Registry + Config + DB + Session\nframework.php',980,340,390,110,'core',ref('system/framework.php'));p.edge(c,d)
e=p.node('Router → pre-actions → startup/router\nAction::execute()',520,340,390,110,'core',ref('system/engine/router.php','dispatch'));p.edge(d,e)
f=p.node('Controller frontend / admin\nBusiness logic nằm cả trong controller',60,340,390,110,'front',ref('application/controller/checkout/payment.php','confirm'));p.edge(e,f)
g=p.node('Loader → Proxy → Model\nSQL trực tiếp, không ORM',60,560,390,110,'data',ref('system/engine/loader.php','callback'));p.edge(f,g,'model_* method')
h=p.node('MySQL / MariaDB\n59 bảng trong SQL seed; không FK khai báo',520,560,390,110,'data',ref('install/opencart.sql'));p.edge(g,h);p.edge(f,h,'SQL trực tiếp',True,points=[(470,395),(470,510),(715,510)])
i=p.node('Cache\nCache\\File mặc định',980,560,390,110,'data',ref('system/config/default.php'));p.edge(d,i,'khởi tạo',True)
j=p.node('Session\\DB\noc_session; close() lúc shutdown',980,780,390,110,'data',ref('system/library/session.php'));p.edge(d,j,'',True,points=[(1410,395),(1410,835)])
k=p.node('Event + Loader hooks\ncontroller/model/view/language/config',520,780,390,110,'core',ref('system/engine/event.php'));p.edge(e,k,'',True,points=[(930,395),(930,835)])
l=p.node('Template → Twig → Response\nsetOutput() → output()',60,780,390,110,'front',ref('system/library/template/twig.php'));p.edge(f,l,'',True,points=[(25,395),(25,835)])
p=chain(F[1],'Dịch vụ ngoài và ranh giới chứng cứ',[
 ('PaymentGateway → Stripe HTTP API / Braintree GraphQL / PayPal OAuth\nĐược triển khai trong PHP; cấu hình bật/tắt lấy từ settings','external',ref('system/library/payment_gateway.php')),
 ('Browser JS → Braintree / PayPal SDK\nKhông suy ra capture server thành công từ callback trình duyệt','external',ref('application/view/template/checkout/paypal.twig')),
 ('CloudStorage → Wasabi / R2 / S3 / GCS\nHMAC S3-compatible hoặc OAuth service account; tùy driver','external',ref('system/library/cloud_storage.php')),
 ('Mail → mail hoặc smtp adapter\nMail controller dựng nội dung; gateway không được kiểm thử live','external',ref('system/library/mail.php')),
 ('Cloud subscription → SQL records / history / transaction / backup metadata\nChưa xác minh có provision hạ tầng thật trong repository','note',ref('application/model/account/subscription.php','addSubscription'))])
# 03 full real order.
chain(F[2],'Frontend · thứ tự khởi tạo',[
 ('index.php → config.php → system/startup.php → start(application)','front',ref('index.php')),
 ('startup.php: vendor autoload, library autoloader, engine classes, helpers\nframework.php: Registry → Config(default, application) → Log → Event → Loader','core',ref('system/startup.php')),
 ('framework.php: Request → Response → DB (+ SET time_zone) → Session object\nSession chưa start vì application.session_autostart=false','core',ref('system/framework.php')),
 ('Cache → Language → Document → autoload → Router::dispatch()','core',ref('system/framework.php')),
 ('pre-actions: startup/session → startup/startup → startup/error\n→ startup/event → startup/maintenance → startup/seo_url','front',ref('system/config/application.php')),
 ('startup/startup: settings + store URL, language, Cart\\Member, PIN/IP gate, currency\nGán member_token từ session vào request khi đã đăng nhập','front',ref('application/controller/startup/startup.php','index')),
 ('startup/router::index() → controller before → Action::execute()\n→ controller after → framework Response::output()','core',ref('application/controller/startup/router.php','index')),
 ('Shutdown: Session::close() → Session\\DB::write() → oc_session','data',ref('system/library/session.php','close'))])
chain(F[2],'Admin · thứ tự và chặn truy cập',[
 ('admin/index.php → admin/config.php → start(admin) → framework.php','admin',ref('admin/index.php')),
 ('framework.php khởi tạo DB; Session::start() + cookie OCSESSID\nAdmin kế thừa session_autostart=true, engine=db','admin',ref('system/config/admin.php')),
 ('pre-actions: startup/startup → error → event → sass → login → permission','admin',ref('system/config/admin.php')),
 ('startup/login: Cart\\User → isLogged() → user_token\nNếu không hợp lệ: trả Action(common/login), dừng vòng pre-action','admin',ref('admin/controller/startup/login.php','index')),
 ('startup/permission: hasPermission(access, route)\nNếu bị từ chối: Action(error/permission); dashboard thuộc ignore','admin',ref('admin/controller/startup/permission.php','index')),
 ('startup/router → Action → admin controller/model/view\nMặc định common/dashboard; từng write controller kiểm tra modify','admin',ref('admin/controller/marketplace/extension.php','validateForm')),
 ('Response::output() → HTTP; shutdown ghi oc_session','core',ref('system/framework.php'))])
chain(F[2],'Event, localization và modification',[
 ('framework.php đăng ký action_event từ config; Event::register() sắp theo priority','core',ref('system/engine/event.php','register')),
 ('startup/event → setting/event::getEvents() → oc_event\nFrontend lọc application/*; admin lọc admin/*; bỏ prefix trước register','data',ref('application/model/setting/event.php','getEvents')),
 ('Loader::controller/model/view/language/config phát before/after\nEvent::trigger() gọi Action; kết quả non-null có thể thay thế xử lý','core',ref('system/engine/loader.php')),
 ('Frontend event/language before/after backup/restore; view inject language\nlanguage/*/after → event/translation → design/translation → oc_translation','front',ref('application/controller/event/translation.php','index')),
 ('Admin config có 2 khóa view/*/before: PHP giữ khóa sau\nVì vậy event/theme ở khóa trước không được kích hoạt qua config này','note',ref('system/config/admin.php')),
 ('startup.php::modification() tìm file thay thế trong DIR_MODIFICATION\nCó oc_modification; chưa xác minh pipeline cài đặt/refresh OCMOD đầy đủ','note',ref('system/startup.php','modification'))])
# 04 functional flow.
chain(F[3],'Trang chủ, danh mục, tìm kiếm, chi tiết',[
 ('common/home::index() → common/footer + common/header → common/home.twig\nController trang chủ không load model riêng','front',ref('application/controller/common/home.php','index')),
 ('Danh mục / search dùng cùng marketplace/extension::index()\nGET filter_category_id, filter_search, filter_download_id, license, rating, sort','front',ref('application/controller/marketplace/extension.php','index')),
 ('ModelMarketplaceExtension::getTotalExtensions() → getExtensions()\nSQL oc_extension + category + member; EXISTS download_path theo version','data',ref('application/model/marketplace/extension.php','getExtensions')),
 ('load->view(marketplace/extension_list) → Response::setOutput()','front',ref('application/controller/marketplace/extension.php','index')),
 ('Chi tiết: marketplace/extension/info → getExtension() + ảnh/download/rating\nload->view(marketplace/extension_info); comments AJAX là request riêng','front',ref('application/controller/marketplace/extension.php','info')),
 ('Không có checkout/cart hoặc class Cart quản lý giỏ hàng trong checkout này\nNút Buy mở AJAX checkout/checkout cho 1 extension_id + quantity','note',ref('application/view/template/marketplace/extension_info.twig'))])
chain(F[3],'Đăng ký, đăng nhập, tài khoản và đơn đã mua',[
 ('account/register::index() POST → validate() → account/member::addMember()\noc_member verified=0; tùy notify cập nhật oc_newsletter','front',ref('application/controller/account/register.php','index')),
 ('getMember() → mail/register → redirect account/success\nXác minh email xử lý riêng tại account/verify','front',ref('application/controller/account/verify.php','index')),
 ('account/login::validate() → getMemberByLogin() → Cart\\Member::login()\nKiểm tra status/verified; sai → addLoginAttempt; đúng → deleteLoginAttempts','front',ref('application/controller/account/login.php','validate')),
 ('Cart\\Member::login(): query oc_member, tạo member_id/member_token trong session\nCập nhật IP → query oc_member_ip; controller kiểm tra hasPin()/isIpVerified()','core',ref('system/library/cart/member.php','login')),
 ('account/account → menu và các trang profile, seller, extension, payment, subscription\nKhông gọi đây là oc_customer: identity thực là oc_member','front',ref('application/controller/account/account.php','index')),
 ('account/order::index()/info() → account/order getOrders/getOrder\nHistory hóa đơn số và trạng thái; không tìm thấy tracking vận chuyển','front',ref('application/controller/account/order.php','index'))])
chain(F[3],'Checkout hiện hành · mua trực tiếp extension',[
 ('extension_info.twig #button-purchase AJAX → checkout/checkout::index()','front',ref('application/view/template/marketplace/extension_info.twig')),
 ('Gate isLogged + member_token; sai → HTTP 401 + Location login\nLưu redirect về marketplace/extension/info?purchase=1','front',ref('application/controller/checkout/checkout.php','index')),
 ('getExtension() → getPayments() → PaymentGateway enable/config\nRender checkout/checkout; chọn vaulted/card/paypal','data',ref('application/controller/checkout/checkout.php','index')),
 ('Card: checkout/payment/card → prepare()\ngetPayment() hoặc vaultStripeCard/vaultBraintreeCard → pending_extension_order','front',ref('application/controller/checkout/payment.php','prepare')),
 ('confirm(): nếu pending stripe/braintree → chargeStripe/chargeBraintree\nNếu không lỗi → unset pending → account/order::addOrder() → JSON','front',ref('application/controller/checkout/payment.php','confirm')),
 ('Nhánh khác: confirm không có pending → addOrder trực tiếp, transaction token\nPayPal pending không đi qua nhánh chargeStripe/chargeBraintree','note',ref('application/controller/checkout/payment.php','confirm')),
 ('checkout/checkout/success cũng addOrder nếu còn pending + đã đăng nhập\nKhông có gọi xác minh gateway trong method success() này','note',ref('application/controller/checkout/checkout.php','success'))])
chain(F[3],'Nhánh legacy và các module khác',[
 ('marketplace/purchase::index() → purchase.twig\nmarketplace/braintree::payment() → addOrder trực tiếp','note',ref('application/controller/marketplace/braintree.php','payment')),
 ('marketplace/paypal::send() → addOrder; callback() chỉ redirect success\nKhông gộp các nhánh này với charge server trong checkout/payment','note',ref('application/controller/marketplace/paypal.php','send')),
 ('CMS: blog, download, information, showcase, sitemap\nSupport: enquiry/contact, partner, guide và các trang thông tin','front',ref('application/controller/cms/blog.php','index')),
 ('Seller: account/extension CRUD + upload → CloudStorage\nBuyer download: marketplace/download → kiểm tra quyền mua → outputFile()','front',ref('application/controller/marketplace/download.php','download')),
 ('Cloud: account/subscription → account/subscription model → SQL, history, transaction\ncloud/store hiển thị subscription; provision hạ tầng chưa xác minh','note',ref('application/model/account/subscription.php','addSubscription'))])
# 05 module workflows.
chain(F[4],'Đăng nhập quản trị và phân quyền',[
 ('GET /admin → pre-action startup/login → common/login::index()','admin',ref('admin/controller/startup/login.php','index')),
 ('POST common/login → validate() → user/user::getLoginAttempts()\nChặn nếu vượt max_attempts trong một giờ','admin',ref('admin/controller/common/login.php','validate')),
 ('Cart\\User::login() → oc_user; lưu session user_id\nRequest kế tiếp: User::__construct() đọc oc_user_group.permission JSON','admin',ref('system/library/cart/user.php','login')),
 ('Request kế tiếp: startup/login kiểm tra session + user_token\nstartup/permission kiểm tra access; write controller kiểm tra modify','admin',ref('admin/controller/startup/permission.php','index')),
 ('common/dashboard::index() query trực tiếp extension/member/order/partner/showcase\nKPI + recent orders/members/extensions → common/dashboard.twig','data',ref('admin/controller/common/dashboard.php','index'))])
chain(F[4],'Quản lý extension, category, member và order',[
 ('marketplace/extension index/add/edit/delete → ModelMarketplaceExtension\nvalidateForm/validateDelete kiểm tra modify + dữ liệu','admin',ref('admin/controller/marketplace/extension.php','edit')),
 ('editExtension(): UPDATE oc_extension → thay ảnh → thay downloads + version paths\nĐây là sản phẩm số; không có admin/catalog/product trong checkout','data',ref('admin/model/marketplace/extension.php','editExtension')),
 ('marketplace/category → marketplace/category model → oc_extension_category\nmember/member, member/seller, member/partner quản lý identity/profile','admin',ref('admin/controller/marketplace/category.php','index')),
 ('sale/order::index()/info() → sale/order model\nThông tin đơn / update trạng thái; xem method inventory cho endpoint chính xác','admin',ref('admin/controller/sale/order.php','index')),
 ('setting/payment + setting/setting: gateway, SMTP, cloud storage settings\nKhông tìm thấy controller shipping; không dựng quy trình vận chuyển','note',ref('admin/controller/setting/payment.php','index'))])
# Inventory-backed admin routes split into pages, exact classes/methods.
admin=[r for r in symbols if r['path'].startswith('admin/controller/')]
for offset in range(0,len(admin),12):
 p=page(F[4],f'Admin · danh mục controller {offset//12+1}','Danh sách từ mã nguồn; có file không đồng nghĩa đã được kích hoạt hoặc route an toàn để gọi')
 for j,r in enumerate(admin[offset:offset+12]):
  label=r['path'].removeprefix('admin/controller/')+'\n'+r['cls']+'\n'+', '.join(r['methods'])
  p.node(label,60+(j%3)*460,150+(j//3)*200,420,160,'admin',ref(r['path']))
# 06 actual sequence using editable lifelines/messages.
def sequence(name,actors,msgs,note):
 p=page(F[5],name,note); xs=[]; ids=[]
 for i,(label,source) in enumerate(actors):
  x=50+i*265;xs.append(x+112);ids.append(p.node(label,x,145,225,85,'core',source))
 p.sequence=(actors,msgs); height=320+len(msgs)*90; p.h=height+80;p.w=max(p.w,80+len(actors)*265)
 for x,id in zip(xs,ids):
  n=p.node('',x-1,height,2,2,'core',shape='point'); p.edge(id,n,'',True)
 for k,(a,b,label,source) in enumerate(msgs):
  y=285+k*90; n1=p.node('',xs[a]-1,y,2,2,'core',source,shape='point');n2=p.node('',xs[b]-1,y+(30 if a==b else 0),2,2,'core',shape='point');p.edge(n1,n2,f'{k+1}. '+label,points=[(xs[a]+75,y+1),(xs[a]+75,y+31)] if a==b else [])
 return p
sequence('Request frontend → response',[
 ('Client', ''),('index / framework',ref('system/framework.php')),('Router / Action',ref('system/engine/action.php')),('Controller / Loader',ref('application/controller/startup/router.php')),('Model / DB',ref('application/model/marketplace/extension.php')),('Template / Response',ref('system/library/template/twig.php'))],[
 (0,1,'GET route=marketplace/extension',ref('index.php')),
 (1,2,'pre-actions rồi dispatch startup/router',ref('system/framework.php')),
 (2,3,'before → Action::execute(index)',ref('application/controller/startup/router.php','index')),
 (3,4,'getTotalExtensions rồi getExtensions',ref('application/controller/marketplace/extension.php','index')),
 (4,3,'SQL rows qua DB::query()',ref('application/model/marketplace/extension.php','getExtensions')),
 (3,5,'load->view(extension_list) → setOutput',ref('application/controller/marketplace/extension.php','index')),
 (3,2,'return → controller after',ref('application/controller/startup/router.php','index')),
 (1,5,'Response::output()',ref('system/framework.php')),
 (5,0,'HTTP HTML',ref('system/library/response.php','output'))], 'Trình tự rút gọn; pre-actions chi tiết ở 03; session close là shutdown sau xử lý.')
sequence('Đăng nhập member · nhánh thành công',[
 ('Browser',''),('AccountLogin',ref('application/controller/account/login.php')),('ModelAccountMember',ref('application/model/account/member.php')),('Cart\\Member',ref('system/library/cart/member.php')),('DB / Session',ref('system/library/session/db.php'))],[
 (0,1,'POST email + password → validate()',ref('application/controller/account/login.php','index')),
 (1,2,'getMemberByLogin(email)',ref('application/controller/account/login.php','validate')),
 (2,4,'SELECT oc_member',ref('application/model/account/member.php','getMemberByLogin')),
 (1,3,'login(email,password) nếu active + verified',ref('application/controller/account/login.php','validate')),
 (3,4,'SELECT member; set session token; UPDATE ip; SELECT member_ip',ref('system/library/cart/member.php','login')),
 (1,2,'deleteLoginAttempts(email)',ref('application/controller/account/login.php','validate')),
 (1,3,'hasPin() rồi isIpVerified()',ref('application/controller/account/login.php','index')),
 (1,0,'redirect PIN / security / saved redirect / account',ref('application/controller/account/login.php','index'))], 'Sai mật khẩu → addLoginAttempt; chưa verified → mail/register. Magic-link là nhánh riêng trong index().')
chain(F[5],'Yêu cầu thêm giỏ hàng · không có triển khai',[
 ('Không tìm thấy checkout/cart controller, Cart\\Cart library hay oc_cart trong schema\nKhông có bằng chứng để vẽ sequence add-to-cart','missing',''),
 ('Hành vi có thật: extension_info.twig Buy → AJAX checkout/checkout\nTruyền extension_id và quantity trực tiếp, không lưu basket','front',ref('application/view/template/marketplace/extension_info.twig'))])
sequence('Checkout · chọn phương thức thanh toán',[
 ('Browser / modal',ref('application/view/template/marketplace/extension_info.twig')),('CheckoutCheckout',ref('application/controller/checkout/checkout.php')),('Extension model',ref('application/model/marketplace/extension.php')),('Payment model',ref('application/model/account/payment.php')),('PaymentGateway',ref('system/library/payment_gateway.php'))],[
 (0,1,'AJAX checkout/checkout + extension_id',ref('application/view/template/marketplace/extension_info.twig')),
 (1,1,'isLogged / member_token gate',ref('application/controller/checkout/checkout.php','index')),
 (1,2,'getExtension(extension_id)',ref('application/controller/checkout/checkout.php','index')),
 (1,3,'getPayments(member_id)',ref('application/controller/checkout/checkout.php','index')),
 (1,4,'isStripeEnabled / isBraintreeEnabled / isPayPalEnabled',ref('application/controller/checkout/checkout.php','index')),
 (1,0,'view checkout/checkout → modal HTML',ref('application/controller/checkout/checkout.php','index'))], 'Gate sai trả 401 + Location login; đây là mua trực tiếp một extension.')
sequence('Tạo đơn · ModelAccountOrder::addOrder',[
 ('Caller',ref('application/controller/checkout/payment.php','confirm')),('ModelAccountOrder',ref('application/model/account/order.php')),('DB',ref('system/library/db/mysqli.php')),('Mail controller',ref('application/controller/mail/order.php'))],[
 (0,1,'addOrder(data)',ref('application/controller/checkout/payment.php','confirm')),
 (1,2,'SELECT extension nếu thiếu seller/name',ref('application/model/account/order.php','addOrder')),
 (1,2,'INSERT oc_order; getLastId()',ref('application/model/account/order.php','addOrder')),
 (1,2,'Nếu complete: UPDATE extension.sales',ref('application/model/account/order.php','addOrder')),
 (1,2,'Nếu seller + total>0: SELECT commission; INSERT member_transaction',ref('application/model/account/order.php','addOrder')),
 (1,3,'load->controller(mail/order, order_id,status=true)',ref('application/model/account/order.php','addOrder')),
 (1,0,'return order_id',ref('application/model/account/order.php','addOrder'))], 'SQL seed dùng MyISAM; method không mở transaction bao phủ chuỗi ghi này.')
sequence('Thanh toán thẻ · confirm pending stripe/braintree',[
 ('Browser',ref('application/view/template/checkout/confirm.twig')),('CheckoutPayment',ref('application/controller/checkout/payment.php')),('PaymentGateway',ref('system/library/payment_gateway.php')),('Gateway HTTP',''),('ModelAccountOrder',ref('application/model/account/order.php'))],[
 (0,1,'POST confirm → check isLogged + pending',ref('application/controller/checkout/payment.php','confirm')),
 (1,2,'chargeStripe(...) hoặc chargeBraintree(...)',ref('application/controller/checkout/payment.php','confirm')),
 (2,3,'Stripe API hoặc Braintree GraphQL',ref('system/library/payment_gateway.php')),
 (3,2,'error / transaction_id',''),
 (1,1,'Nếu không lỗi: unset pending; gắn transaction_id nếu có',ref('application/controller/checkout/payment.php','confirm')),
 (1,4,'addOrder(order_data)',ref('application/controller/checkout/payment.php','confirm')),
 (1,0,'JSON error hoặc order_id + success',ref('application/controller/checkout/payment.php','confirm'))], 'Chỉ nhánh thẻ pending; nhánh fallback/PayPal không được mô tả là charge thành công.')
sequence('Admin cập nhật “sản phẩm” = extension',[
 ('Admin browser',''),('Pre-actions',ref('system/config/admin.php')),('MarketplaceExtension',ref('admin/controller/marketplace/extension.php')),('ModelMarketplaceExtension',ref('admin/model/marketplace/extension.php')),('DB',ref('install/opencart.sql'))],[
 (0,1,'POST marketplace/extension/edit + user_token',ref('admin/controller/marketplace/extension.php','edit')),
 (1,2,'login + access gate → edit()',ref('admin/controller/startup/permission.php','index')),
 (2,2,'load language/model → validateForm() [modify]',ref('admin/controller/marketplace/extension.php','edit')),
 (2,3,'editExtension(extension_id,post)',ref('admin/controller/marketplace/extension.php','edit')),
 (3,4,'UPDATE extension; DELETE/INSERT extension_image',ref('admin/model/marketplace/extension.php','editExtension')),
 (3,4,'SELECT old downloads; DELETE paths/downloads; INSERT new rows',ref('admin/model/marketplace/extension.php','editExtension')),
 (2,0,'session success → redirect list',ref('admin/controller/marketplace/extension.php','edit'))], 'Không có catalog/product controller. Request không hợp lệ quay về form hoặc permission/login action.')
# 07 schema dictionary and verified logical relations.
relations=[
 ('oc_member','oc_extension','member_id = member_id · 1:N','application/model/marketplace/extension.php','getExtension'),
 ('oc_extension_category','oc_extension','extension_category_id · 1:N','application/model/marketplace/extension.php','getExtension'),
 ('oc_extension','oc_extension_download','extension_id · 1:N','admin/model/marketplace/extension.php','editExtension'),
 ('oc_extension_download','oc_extension_download_path','extension_download_id · 1:N','admin/model/marketplace/extension.php','editExtension'),
 ('oc_download','oc_extension_download_path','download_id · 1:N (bảng nối version)','admin/model/marketplace/extension.php','editExtension'),
 ('oc_member','oc_order','member_id (buyer) · 1:N','application/model/account/order.php','getOrder'),
 ('oc_member','oc_order','seller_id (seller) · 1:N','application/model/account/order.php','getOrder'),
 ('oc_extension','oc_order','extension_id · 1:N','application/model/account/order.php','getOrder'),
 ('oc_member','oc_member_transaction','member_id · 1:N','application/model/account/order.php','addOrder'),
 ('oc_order','oc_member_transaction','order_id · 1:N','application/model/account/order.php','addOrder'),
 ('oc_member','oc_member_seller','member_id · N tối đa chưa khóa UNIQUE','application/model/account/order.php','addOrder'),
 ('oc_member','oc_subscription','member_id · 1:N','application/model/account/subscription.php','addSubscription'),
 ('oc_subscription_plan','oc_subscription','subscription_plan_id · 1:N','application/model/account/subscription.php','addSubscription'),
 ('oc_member_payment','oc_subscription','member_payment_id · 1:N, có thể 0','application/model/account/subscription.php','addSubscription'),
 ('oc_subscription','oc_subscription_history','subscription_id · 1:N','application/model/account/subscription.php','addSubscriptionHistory'),
 ('oc_user_group','oc_user','user_group_id · 1:N','system/library/cart/user.php','__construct')]

relations += [
 ('oc_extension','oc_extension_image','extension_id · 1:N','admin/model/marketplace/extension.php','editExtension'),
 ('oc_extension','oc_extension_comment','extension_id · 1:N','application/model/marketplace/extension.php','getExtension'),
 ('oc_member','oc_member_payment','member_id · 1:N','application/model/account/payment.php','getPayments'),
 ('oc_member','oc_member_partner','member_id · 1:N, không UNIQUE','application/model/account/partner.php','getPartner'),
 ('oc_member_partner_type','oc_member_partner','member_partner_type_id · 1:N','application/model/account/partner.php','getPartner'),
 ('oc_member_partner_status','oc_member_partner','member_partner_status_id · 1:N','application/model/account/partner.php','getPartner'),
 ('oc_country','oc_member_partner','country_id · 1:N','application/model/account/partner.php','getPartner'),
 ('oc_zone','oc_member_partner','zone_id · 1:N','application/model/account/partner.php','getPartner'),
 ('oc_information','oc_information_description','information_id · 1:N theo language','application/model/cms/information.php','getInformation'),
 ('oc_banner','oc_banner_image','banner_id · 1:N','application/model/design/banner.php','getBanner'),
 ('oc_member','oc_blog_comment','member_id · 1:N','application/model/cms/blog.php','getComment'),
 ('oc_blog','oc_blog_comment','blog_id · 1:N','application/model/cms/blog.php','getCommentsByBlogId'),
 ('oc_showcase_category','oc_showcase','showcase_category_id · 1:N','application/model/cms/showcase.php','getShowcase'),
 ('oc_subscription','oc_subscription_domain','subscription_id · 1:N','application/model/account/subscription.php','getSubscriptionDomains'),
 ('oc_subscription','oc_subscription_backup','subscription_id · 1:N metadata','application/model/account/subscription.php','getSubscriptionBackups'),
 ('oc_subscription','oc_subscription_transaction','subscription_id · 1:N','application/model/account/subscription.php','getSubscriptionTransactions')]
(EV/'logical-relations.json').write_text(json.dumps([dict(parent=a,child=b,relation=label,source=ref(path,meth),kind='logical_not_FK') for a,b,label,path,meth in relations],ensure_ascii=False,indent=2))

for offset in range(0,len(relations),4):
 p=page(F[6],f'Quan hệ logic đã có bằng chứng {offset//4+1}','Nét đứt = quan hệ ứng dụng, KHÔNG phải FK. 1:N mô tả lookup theo PK; orphan vẫn có thể tồn tại.')
 for j,(a,b,label,path,meth) in enumerate(relations[offset:offset+4]):
  y=160+j*210
  ta=next(t for t in schema if t['name']==a);tb=next(t for t in schema if t['name']==b)
  na=p.node(a+'\nPK '+', '.join(ta['pk']),60,y,400,100,'data','install/opencart.sql:'+str(ta['line']))
  nb=p.node(b+'\nPK '+', '.join(tb['pk']),920,y,400,100,'data','install/opencart.sql:'+str(tb['line']))
  p.edge(na,nb,label,True);p.node(path+'::'+meth+'()',60,y+120,1260,52,'note',ref(path,meth))
for offset in range(0,len(schema),6):
 p=page(F[6],f'Từ điển bảng {offset//6+1:02d}','Tất cả 59 bảng được liệt kê; PK đúng theo DDL. Các cột còn lại xem evidence/schema.json và database-schema.md.')
 for j,t in enumerate(schema[offset:offset+6]):
  keys=[c['name'] for c in t['columns'] if c['name'] in t['pk'] or c['name'].endswith('_id')]
  label=t['name']+'\nPK: '+', '.join(t['pk'])+'\n'+ '\n'.join(keys)+'\n'+str(len(t['columns']))+' cột · '+t['engine'].split()[0]+'\nFK: không khai báo'
  p.node(label,60+(j%3)*460,150+(j//3)*440,420,385,'data','install/opencart.sql:'+str(t['line']))
# 08 explicit literal loads at module scale; each row is one concrete controller/model dependency.
groups={}
for l in loads:
 if l['kind']!='model' or not (l['path'].startswith('application/controller/') or l['path'].startswith('admin/controller/')):continue
 app=l['path'].split('/')[0];domain=l['path'].split('/')[2];groups.setdefault((app,domain),[]).append(l)
for (app,domain),ls in sorted(groups.items()):
 unique={}
 for l in ls:unique.setdefault((l['path'],l['target']),l)
 ls=list(unique.values())
 for offset in range(0,len(ls),7):
  p=page(F[7],f'{app}/{domain} · phụ thuộc {offset//7+1}','Mỗi hàng là load->model literal có thật. Truy cập bảng là tham chiếu SQL tĩnh ở cấp file model, không phải mọi method đều query mọi bảng.')
  for j,l in enumerate(ls[offset:offset+7]):
   y=145+j*155
   a=p.node(l['path'].split('/controller/')[1]+'\n'+l['method']+'() · L'+l['line'],50,y,380,100,'front' if app=='application' else 'admin',l['path']+':'+l['line'])
   target=f"{app}/model/{l['target']}.php"; exists=(ROOT/target).exists()
   b=p.node('model/'+l['target']+'\n'+('đã có file' if exists else 'chưa có file đích'),500,y,360,100,'data' if exists else 'missing',ref(target) if exists else '')
   p.edge(a,b,'load->model')
   ts=sorted({x['table'] for x in sqlrefs if x['path']==target})
   c=p.node('\n'.join(textwrap.wrap(', '.join(ts) if ts else 'Không có SQL literal được trích xuất',49)),950,y,440,100,'data')
   if ts:p.edge(b,c,'SQL cấp file',True)

chain(F[7],'Phụ thuộc dùng chung và hook',[
 ('checkout/payment + checkout/checkout → PaymentGateway\nSettings quyết định gateway; HTTP Stripe/Braintree, PayPal frontend SDK','external',ref('application/controller/checkout/payment.php','confirm')),
 ('account/extension::upload + marketplace/download::download → CloudStorage\nFile local hoặc object storage theo settings','external',ref('application/controller/marketplace/download.php','download')),
 ('ModelAccountOrder::addOrder → Loader::controller(mail/order) → Mail\nModel cũng có thể gọi controller; không phải phân lớp một chiều tuyệt đối','core',ref('application/model/account/order.php','addOrder')),
 ('Loader::model → Proxy::__call → callback → Model + Event before/after\nRegistry cung cấp DB, Cache, Session, Config cho cả Controller và Model','core',ref('system/engine/proxy.php','__call')),
 ('startup/event → model setting/event → oc_event → Event::register\nSeed không có INSERT event: chưa có bằng chứng hook DB nào được bật mặc định','note',ref('install/opencart.sql')),
 ('modification() → DIR_MODIFICATION override; bundled packages → vendor/autoload.php\nMarketplace extension là hàng hóa số, không đồng nghĩa plugin đã cài vào runtime','note',ref('system/startup.php','modification'))])

# These are catalogs of independent mechanisms/branches, not execution chains.
independent={'Dịch vụ ngoài và ranh giới chứng cứ','Event, localization và modification','Nhánh legacy và các module khác','Quản lý extension, category, member và order','Phụ thuộc dùng chung và hook','Yêu cầu thêm giỏ hàng · không có triển khai'}
for ps in PAGES.values():
 for p in ps:
  if p.name in independent:
   p.edges=[]
   p.subtitle='Các cơ chế/nhánh độc lập; không có thứ tự gọi giữa các khối. Luồng cụ thể xem sequence và dẫn chiếu source.'
# XML + SVG share explicit geometry, retain all pages.
def wrap(label,width):
 result=[]
 for line in label.split('\n'):
  result.extend(textwrap.wrap(line,width=width,break_long_words=True,break_on_hyphens=False) or [''])
 return result
for file,pages in PAGES.items():
 mx=ET.Element('mxfile',host='app.diagrams.net',agent='source-evidence-generator',version='24.7.17',type='device')
 for index,p in enumerate(pages):
  d=ET.SubElement(mx,'diagram',id=f'{file}-{index+1}',name=p.name)
  model=ET.SubElement(d,'mxGraphModel',dx=str(p.w),dy=str(p.h),grid='1',gridSize='10',guides='1',tooltips='1',connect='1',arrows='1',fold='1',page='1',pageScale='1',pageWidth=str(p.w),pageHeight=str(p.h),math='0',shadow='0')
  root=ET.SubElement(model,'root');ET.SubElement(root,'mxCell',id='0');ET.SubElement(root,'mxCell',id='1',parent='0')
  svg=[f'<svg xmlns="http://www.w3.org/2000/svg" width="{p.w}" height="{p.h}" viewBox="0 0 {p.w} {p.h}">', '<defs><marker id="arrow" markerWidth="10" markerHeight="8" refX="9" refY="4" orient="auto"><path d="M0,0 L10,4 L0,8 Z" fill="#64748b"/></marker></defs>',f'<rect width="{p.w}" height="{p.h}" fill="#f8fafc"/>']
  def txt(x,y,s,size=15,fill='#1e293b',weight='normal'):
   svg.append(f'<text x="{x}" y="{y}" font-family="DejaVu Sans,Arial,sans-serif" font-size="{size}" font-weight="{weight}" fill="{fill}">{html.escape(s)}</text>')
  # Editable heading/footer cells.
  for id,label,x,y,w,h,size in [('title',p.name,50,25,p.w-100,45,27),('subtitle',p.subtitle,50,78,p.w-100,50,14),('footer',file+' · '+S['commit'][:12]+' · Chứng cứ: evidence/diagram-trace.csv',50,p.h-42,p.w-100,30,13)]:
   cell=ET.SubElement(root,'mxCell',id=id,value=label,vertex='1',parent='1',style=f'text;html=0;align=left;verticalAlign=middle;whiteSpace=wrap;overflow=hidden;fontSize={size};fontFamily=DejaVu Sans;fontColor=#334155;')
   ET.SubElement(cell,'mxGeometry',x=str(x),y=str(y),width=str(w),height=str(h),attrib={'as':'geometry'})
   for lineidx,line in enumerate(wrap(label,int(w/(size*.57)))):txt(x,y+size+lineidx*(size+4),line,size,'#334155','bold' if id=='title' else 'normal')
  lookup={n['id']:n for n in p.nodes}
  for n in p.nodes:
   style=f'rounded=1;whiteSpace=wrap;html=0;fillColor={COLORS[n["kind"]]};strokeColor=#94a3b8;fontColor=#0f172a;fontSize=15;fontFamily=DejaVu Sans;align=left;verticalAlign=middle;spacingLeft=14;spacingRight=14;'
   if n['shape']=='point':style='ellipse;fillColor=none;strokeColor=none;'
   value=n['label']+ ('\n['+n['source']+']' if n['source'] and n['shape']!='point' else '')
   cell=ET.SubElement(root,'mxCell',id=n['id'],value=value,vertex='1',parent='1',style=style)
   ET.SubElement(cell,'mxGeometry',x=str(n['x']),y=str(n['y']),width=str(n['w']),height=str(n['h']),attrib={'as':'geometry'})
   if n['shape']=='point':continue
   svg.append(f'<rect x="{n["x"]}" y="{n["y"]}" width="{n["w"]}" height="{n["h"]}" rx="10" fill="{COLORS[n["kind"]]}" stroke="#94a3b8"/>')
   lines=wrap(n['label'],max(20,int((n['w']-28)/8.0)));fs=15
   if len(lines)*21+(28 if n['source'] else 0)>n['h']-16:fs=12;lines=wrap(n['label'],max(20,int((n['w']-28)/6.4)))
   assert len(lines)*(fs+5)+(24 if n['source'] else 0)<=n['h']-8,(file,p.name,n['label'])
   for i,line in enumerate(lines):txt(n['x']+14,n['y']+22+i*(fs+5),line,fs)
   if n['source']:
    source_lines=wrap(n['source'],int((n['w']-28)/6))
    for i,line in enumerate(source_lines):txt(n['x']+14,n['y']+n['h']-12-(len(source_lines)-1-i)*13,line,10,'#475569')
  for i,e in enumerate(p.edges):
   a,b=lookup[e['a']],lookup[e['b']]
   ac=(a['x']+a['w']/2,a['y']+a['h']/2);bc=(b['x']+b['w']/2,b['y']+b['h']/2)
   if a['shape']=='point' and b['shape']=='point':start,end=ac,bc
   elif abs(ac[0]-bc[0])<50:start=(ac[0],a['y']+a['h']);end=(bc[0],b['y'])
   elif abs(ac[1]-bc[1])<50:
    start=(a['x']+a['w'] if bc[0]>ac[0] else a['x'],ac[1]);end=(b['x'] if bc[0]>ac[0] else b['x']+b['w'],bc[1])
   else:start=(ac[0],a['y']+a['h']);end=(bc[0],b['y'])
   if e['points'] and not (a['shape']=='point' and b['shape']=='point'):
    first,last=e['points'][0],e['points'][-1]
    start=(a['x']+a['w'],ac[1]) if first[0]>a['x']+a['w'] else ((a['x'],ac[1]) if first[0]<a['x'] else (ac[0],a['y']+a['h']))
    end=(b['x']+b['w'],bc[1]) if last[0]>b['x']+b['w'] else ((b['x'],bc[1]) if last[0]<b['x'] else (bc[0],b['y']))
   pts=[start,*e['points'],end]
   style='edgeStyle=orthogonalEdgeStyle;rounded=0;html=0;endArrow=block;fontSize=12;fontFamily=DejaVu Sans;labelBackgroundColor=#f8fafc;strokeColor=#64748b;'+('dashed=1;' if e['dashed'] else '')
   if a['shape']=='point' and b['shape']=='point':style=style.replace('edgeStyle=orthogonalEdgeStyle;','edgeStyle=none;')
   cell=ET.SubElement(root,'mxCell',id='e'+str(i),value=e['label'],edge='1',parent='1',source=e['a'],target=e['b'],style=style)
   geo=ET.SubElement(cell,'mxGeometry',relative='1',attrib={'as':'geometry'})
   if e['points']:
    arr=ET.SubElement(geo,'Array',attrib={'as':'points'})
    for x,y in e['points']:ET.SubElement(arr,'mxPoint',x=str(x),y=str(y))
   dash='stroke-dasharray="6 5"' if e['dashed'] else ''
   svg.append('<polyline points="'+' '.join(f'{x},{y}' for x,y in pts)+f'" fill="none" stroke="#64748b" stroke-width="1.5" {dash} marker-end="url(#arrow)"/>')
   if e['label']:
    midx=(start[0]+end[0])/2;midy=(start[1]+end[1])/2
    for z,line in enumerate(wrap(e['label'],64)):txt(min(start[0],end[0])+12 if a['shape']=='point' else midx-len(line)*2.8,midy-8+z*16,line,12 if a['shape']=='point' else 10,'#334155')
  svg.append('</svg>');suffix='' if index==0 else f'-page-{index+1:02d}'
  def ml(s):return s.replace('&','&amp;').replace('"','&quot;').replace('<','&lt;').replace('>','&gt;').replace('\n','<br/>')
  mer=['---', 'title: '+p.name, '---']
  if hasattr(p,'sequence'):
   mer.append('sequenceDiagram');actors,msgs=p.sequence
   for i,(label,source) in enumerate(actors):mer.append('    participant A'+str(i)+' as '+ml(label))
   for a,b,label,source in msgs:mer.append(f'    A{a}->>A{b}: '+ml(label))
  else:
   mer.append('flowchart TB')
   for n in p.nodes:
    if n['shape']!='point':mer.append('    '+n['id']+'["'+ml(n['label'])+'"]')
   for e in p.edges:mer.append('    '+e['a']+(' -.-> ' if e['dashed'] else ' --> ')+e['b'])
  (OUT/'mermaid'/f'{file}{suffix}.mmd').write_text('\n'.join(mer)+'\n')
  (OUT/'exports'/f'{file}{suffix}.svg').write_text('\n'.join(svg))
 ET.indent(mx);ET.ElementTree(mx).write(OUT/f'{file}.drawio',encoding='utf-8',xml_declaration=True)
with (EV/'diagram-trace.csv').open('w') as f:
 w=csv.DictWriter(f,['file','page','node','label','source']);w.writeheader();w.writerows(TRACE)
(EV/'diagram-manifest.json').write_text(json.dumps({k:[dict(name=p.name,width=p.w,height=p.h,nodes=len(p.nodes),edges=len(p.edges)) for p in ps] for k,ps in PAGES.items()},ensure_ascii=False,indent=2))
print('Generated',len(PAGES),'drawio files;',sum(map(len,PAGES.values())),'pages;',len(TRACE),'source references')

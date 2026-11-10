<?php
// Deterministic provider fixtures only. Never calls cURL, DB or real gateways.
error_reporting(E_ALL & ~E_DEPRECATED);
if (function_exists('curl_init') || function_exists('curl_exec')) {
    fwrite(STDERR, "Run with -d disable_functions=curl_init,curl_exec to prohibit provider network access.\n");
    exit(2);
}
$root = dirname(__DIR__, 2);
define('DIR_SYSTEM', $root . '/system/');
define('DIR_APPLICATION', $root . '/application/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('HTTP_SERVER', 'http://localhost/');
define('HTTPS_SERVER', 'http://localhost/');

require DIR_SYSTEM . 'engine/registry.php';
require DIR_SYSTEM . 'engine/controller.php';
require DIR_SYSTEM . 'library/language.php';
require DIR_SYSTEM . 'library/payment_gateway.php';
require $root . '/application/controller/checkout/payment.php';
require $root . '/application/controller/marketplace/braintree.php';
require $root . '/application/controller/marketplace/paypal.php';
function token($n) { return str_repeat('x', $n); }
class ConfirmationConfig {
    public $values = array('config_currency'=>'USD');
    public function get($key) { return isset($this->values[$key]) ? $this->values[$key] : null; }
}
class ConfirmationGateway extends PaymentGateway {
    public $stripe = array(); public $bt = array(); public $calls = array();
    public function stripeRequest($method, $endpoint, $params=array(), $key=null) {
        $this->calls[] = array($endpoint,$params); return $this->stripe;
    }
    public function braintreeGraphQL($query, $variables=array(), $cfg=null) {
        $this->calls[] = array($query,$variables); return $this->bt;
    }
}
class ConfirmationController extends ControllerCheckoutPayment {
    public $gateway;
    protected function paymentGateway() { return $this->gateway; }
}
class ConfirmationLoader {
    public $views=array();
    private $lang;
    public function __construct($lang) { $this->lang = $lang; }
    public function language($route) { return $this->lang->load($route); }
    public function model($route) {}
    public function view($route,$data=array()) { $this->views[]=array($route,$data); return $route; }
}
class ConfirmationMember {
    public $logged=true;
    public function isLogged() { return $this->logged; }
    public function getId() { return 7; }
    public function getEmail() { return 'fixture@example.invalid'; }
    public function getFirstName() { return 'Fixture'; }
    public function getLastName() { return 'Member'; }
}
class ConfirmationOrder { public $writes=array(); public function addOrder($d) { $this->writes[]=$d; return 123; } }
class ConfirmationExtension { public function getExtension($id) { return array('member_id'=>9,'name'=>'Fixture','price'=>20); } }
class ConfirmationResponse {
    public $output=''; public $redirect='';
    public function addHeader($s) {}
    public function setOutput($s) { $this->output=$s; }
    public function redirect($s) { $this->redirect=$s; }
}
class ConfirmationUrl { public function link($r,$args='',$ssl=false) { return $r . ($args ? '?'.$args : ''); } }
function fixture() {
    $r=new Registry(); $cfg=new ConfirmationConfig();
    $lang=new Language('en-gb'); $lang->load('en-gb');
    $req=(object)array('get'=>array('extension_id'=>10,'quantity'=>1,'member_token'=>'member'), 'post'=>array('nonce'=>'pm_Fixture123','agree'=>1), 'server'=>array('REQUEST_METHOD'=>'POST'));
    $session=(object)array('data'=>array('member_token'=>'member'));
    foreach (array('config'=>$cfg,'language'=>$lang,'request'=>$req,'session'=>$session,'load'=>new ConfirmationLoader($lang),'member'=>new ConfirmationMember(),'model_account_order'=>new ConfirmationOrder(),'model_marketplace_extension'=>new ConfirmationExtension(),'response'=>new ConfirmationResponse(),'url'=>new ConfirmationUrl()) as $k=>$v) $r->set($k,$v);
    return $r;
}
function pending($gateway='stripe') {
    return array('member_id'=>7,'seller_id'=>9,'extension_id'=>10,'extension'=>'Fixture','quantity'=>1,'price'=>20,'total'=>20,'payment_gateway'=>$gateway,'payment_token'=>'pm_Fixture123','transaction_id'=>'LOCAL-DO-NOT-TRUST','order_status_id'=>5,'currency'=>'USD');
}
function keys($r) {
    $r->get('config')->values += array('payment_stripe_test_secret_key'=>'fixture-key','payment_braintree_sandbox_public_key'=>'fixture-public','payment_braintree_sandbox_private_key'=>'fixture-private','payment_braintree_sandbox_merchant_account_id'=>'fixture-merchant');
}
function stripeResult() { return array('id'=>'pi_real_fixture','status'=>'succeeded','amount'=>2000,'amount_received'=>2000,'currency'=>'usd','livemode'=>false); }
function btResult() { return array('data'=>array('chargePaymentMethod'=>array('transaction'=>array('id'=>'bt_real_fixture','status'=>'SUBMITTED_FOR_SETTLEMENT','amount'=>array('value'=>'20.00','currencyCode'=>'USD'),'merchantAccountId'=>'fixture-merchant')))); }
function check($ok,$msg) { if (!$ok) throw new Exception($msg); }
$tests=0;$failures=0;
function runCase($name,$fn) {
    global $tests,$failures;$tests++;
    try { $fn(); echo "PASS $name\n"; } catch (Throwable $e) { $failures++;echo "FAIL $name: ".$e->getMessage()."\n"; }
}
foreach (array('stripe','braintree') as $provider) {
    runCase("$provider missing keys must fail without transport",function() use($provider) {
        $r=fixture();$g=new ConfirmationGateway($r);
        $out=$provider==='stripe'?$g->chargeStripe('pm_Fixture123',20,'USD'):$g->chargeBraintree('payment-fixture',20,'USD');
        check(!empty($out['error']) && empty($out['success']) && !$g->calls,'missing keys generated success or transport');
    });
}
foreach (array('requires_action','requires_capture','processing','canceled','') as $status) {
    runCase('Stripe nonfinal status '.$status,function() use($status) {
        $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();$g->stripe['status']=$status;
        check(!empty($g->chargeStripe('pm_Fixture123',20,'USD')['error']),'nonfinal status accepted');
    });
}
foreach (array('amount'=>1000,'amount_received'=>1000,'currency'=>'eur','id'=>'') as $field=>$value) {
    runCase('Stripe mismatched '.$field,function() use($field,$value) {
        $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();$g->stripe[$field]=$value;
        check(!empty($g->chargeStripe('pm_Fixture123',20,'USD')['error']),'invalid proof accepted');
    });
}
foreach (array(array(),array('error'=>array('message'=>'Declined'))) as $reply) {
    runCase('Stripe malformed/declined',function() use($reply) {
        $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=$reply;
        check(!empty($g->chargeStripe('pm_Fixture123',20,'USD')['error']),'missing/failed proof accepted');
    });
}
runCase('Stripe exact successful server response',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();$out=$g->chargeStripe('pm_Fixture123',20,'USD');
    check(!empty($out['verified']) && $out['transaction_id']==='pi_real_fixture','verified result missing');
    check($g->calls[0][1]['amount']===2000 && $g->calls[0][1]['currency']==='usd','wrong charge request');
});
foreach (array('status','amount','currency','merchant','missing','error') as $variant) {
    runCase('Braintree rejects '.$variant,function() use($variant) {
        $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->bt=btResult();
        $t=&$g->bt['data']['chargePaymentMethod']['transaction'];
        if ($variant==='status') $t['status']='AUTHORIZED';
        if ($variant==='amount') $t['amount']['value']='10.00';
        if ($variant==='currency') $t['amount']['currencyCode']='EUR';
        if ($variant==='merchant') $t['merchantAccountId']='other';
        if ($variant==='missing') $g->bt=array();
        if ($variant==='error') $g->bt=array('error'=>'Declined');
        check(!empty($g->chargeBraintree('payment-fixture',20,'USD')['error']),'invalid transaction accepted');
    });
}
runCase('Braintree exact successful server response',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->bt=btResult();$out=$g->chargeBraintree('payment-fixture',20,'USD');
    check(!empty($out['verified']) && $out['transaction_id']==='bt_real_fixture','verified result missing');
});
foreach (array('missing','paypal','unknown','foreign-member','wrong-extension','wrong-currency','invalid-total','invalid-quantity','GET','guest','bad-token','gateway-error','requires-action') as $variant) {
    runCase('confirm denies '.$variant,function() use($variant) {
        $r=fixture();$p=pending();
        if ($variant==='paypal') $p['payment_gateway']='paypal';
        if ($variant==='unknown') $p['payment_gateway']='unknown';
        if ($variant==='foreign-member') $p['member_id']=8;
        if ($variant==='wrong-extension') $p['extension_id']=11;
        if ($variant==='wrong-currency') $p['currency']='EUR';
        if ($variant==='invalid-total') $p['total']=1;
        if ($variant==='invalid-quantity') $p['quantity']=0;
        if ($variant!=='missing') $r->get('session')->data['pending_extension_order']=$p;
        if ($variant==='GET') $r->get('request')->server['REQUEST_METHOD']='GET';
        if ($variant==='guest') $r->get('member')->logged=false;
        if ($variant==='bad-token') $r->get('request')->get['member_token']='wrong';
        $c=new ConfirmationController($r);$g=new ConfirmationGateway($r);keys($r);$g->stripe=stripeResult();
        if ($variant==='gateway-error') $g->stripe=array('error'=>array('message'=>'Declined'));
        if ($variant==='requires-action') $g->stripe['status']='requires_action';
        $c->gateway=$g;$c->confirm();$out=json_decode($r->get('response')->output,true);
        check(!empty($out['error']) && empty($out['success']) && !$r->get('model_account_order')->writes,'unverified order written');
        if (!in_array($variant,array('gateway-error','requires-action'))) check(!$g->calls,'charged before input binding');
    });
}
runCase('verified pending completes once sequentially and preserves contract',function() {
    $r=fixture();keys($r);$r->get('session')->data['pending_extension_order']=pending();
    $c=new ConfirmationController($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();$c->gateway=$g;$c->confirm();
    $out=json_decode($r->get('response')->output,true);
    check($out['order_id']===123 && !empty($out['success']),'JSON success contract changed');
    $rows=$r->get('model_account_order')->writes;
    check(count($rows)===1 && $rows[0]['transaction_id']==='pi_real_fixture','order not bound to server transaction');
    check(!isset($r->get('session')->data['pending_extension_order']),'pending not consumed');
    $c->confirm();check(count($r->get('model_account_order')->writes)===1 && count($g->calls)===1,'sequential replay charged/wrote again');
});
runCase('legacy Braintree payment cannot write order',function() {
    $r=fixture();(new ControllerMarketplaceBraintree($r))->payment();
    check(!$r->get('model_account_order')->writes,'legacy order write');
    check(strpos($r->get('response')->redirect,'marketplace/extension/info')===0,'restart checkout redirect missing');
});
runCase('legacy PayPal send cannot write order',function() {
    $r=fixture();(new ControllerMarketplacePaypal($r))->send();
    check(!$r->get('model_account_order')->writes,'legacy order write');
    check(!empty(json_decode($r->get('response')->output,true)['error']),'must not fabricate invoice');
});
runCase('PayPal route shows an explicit unavailable state without preparing or writing',function() {
    $r=fixture();$before=$r->get('session')->data;
    (new ConfirmationController($r))->paypal();
    check($r->get('session')->data===$before && !$r->get('model_account_order')->writes,'unsupported PayPal changed checkout/order');
    check(!empty($r->get('load')->views[0][1]['error_warning']),'unavailable message missing');
});
foreach (array('zero'=>0,'negative'=>-1,'fraction'=>20.001,'infinite'=>INF) as $name=>$amount) {
    runCase('invalid amount '.$name,function() use($amount) {
        $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();
        check(!empty($g->chargeStripe('pm_Fixture123',$amount,'USD')['error']) && !$g->calls,'invalid amount reached provider');
    });
}
runCase('VND is charged in whole units, never as cents',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();
    $g->stripe['amount']=20;$g->stripe['amount_received']=20;$g->stripe['currency']='vnd';
    $out=$g->chargeStripe('pm_Fixture123',20,'VND');
    check(!empty($out['verified']) && $g->calls[0][1]['amount']===20,'VND multiplied or rejected');
});
runCase('fractional VND must not be rounded into a different price',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);
    check(!empty($g->chargeStripe('pm_Fixture123',20.5,'VND')['error']) && !$g->calls,'fractional VND rounded or charged');
});
runCase('manual capture mode is not treated as paid',function() {
    $r=fixture();keys($r);$r->get('config')->values['payment_stripe_capture_method']='manual';$g=new ConfirmationGateway($r);
    check(!empty($g->chargeStripe('pm_Fixture123',20,'USD')['error']) && !$g->calls,'manual capture accepted');
});
runCase('Stripe live/test response mismatch fails',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();$g->stripe['livemode']=true;
    check(!empty($g->chargeStripe('pm_Fixture123',20,'USD')['error']),'environment mismatch accepted');
});
runCase('Braintree payment-method environment mismatch cannot charge',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);
    check(!empty($g->chargeBraintree('braintree|production|fixture',20,'USD')['error']) && !$g->calls,'wrong environment charged');
});
runCase('simulated payment tokens never charge',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);
    check(!empty($g->chargeStripe('pm_local_fixture',20,'USD')['error']),'local Stripe token accepted');
    check(!empty($g->chargeBraintree('bt_card|Visa|1234',20,'USD')['error']) && !$g->calls,'local Braintree token accepted');
});
runCase('verified Braintree pending completes through controller',function() {
    $r=fixture();keys($r);$p=pending('braintree');$p['payment_token']='payment-fixture';$r->get('session')->data['pending_extension_order']=$p;
    $c=new ConfirmationController($r);$g=new ConfirmationGateway($r);$g->bt=btResult();$c->gateway=$g;$c->confirm();
    $rows=$r->get('model_account_order')->writes;
    check(count($rows)===1 && $rows[0]['transaction_id']==='bt_real_fixture','Braintree order not verified/bound');
});
runCase('old pending without currency snapshot must restart before charge',function() {
    $r=fixture();keys($r);$p=pending();unset($p['currency']);$r->get('session')->data['pending_extension_order']=$p;
    $c=new ConfirmationController($r);$g=new ConfirmationGateway($r);$c->gateway=$g;$c->confirm();
    check(!$g->calls && !$r->get('model_account_order')->writes && !empty(json_decode($r->get('response')->output,true)['error']),'old pending charged');
});
runCase('Braintree malformed fractional response fails',function() {
    $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->bt=btResult();$g->bt['data']['chargePaymentMethod']['transaction']['amount']['value']='20.001';
    check(!empty($g->chargeBraintree('payment-fixture',20,'USD')['error']),'fraction rounded into matching proof');
});
// Provider payloads must match the API types, not merely cast to the quote.
foreach (array(
    array('amount', 2000.9), array('amount', '2000junk'), array('amount', 2000.0),
    array('amount_received', 2000.9), array('amount_received', '2e3'),
    array('id', array('pi_bad')), array('id', 123), array('id', '   '),
    array('currency', array('usd'))
) as $i=>$case) {
    runCase('Stripe malformed proof type '.$i,function() use($case) {
        $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->stripe=stripeResult();$g->stripe[$case[0]]=$case[1];
        $out=$g->chargeStripe('pm_Fixture123',20,'USD');
        check(!empty($out['error']) && empty($out['verified']),'malformed proof accepted');
    });
}
foreach (array(
    array('id', array('bt_bad')), array('id', 123), array('id', '   '),
    array('amount', array('value'=>'2e1','currencyCode'=>'USD')),
    array('amount', array('value'=>'20.00','currencyCode'=>array('USD')))
) as $i=>$case) {
    runCase('Braintree malformed proof type '.$i,function() use($case) {
        $r=fixture();keys($r);$g=new ConfirmationGateway($r);$g->bt=btResult();$g->bt['data']['chargePaymentMethod']['transaction'][$case[0]]=$case[1];
        $out=$g->chargeBraintree('payment-fixture',20,'USD');
        check(!empty($out['error']) && empty($out['verified']),'malformed proof accepted');
    });
}
echo "$tests tests, $failures failures\n";exit($failures?1:0);

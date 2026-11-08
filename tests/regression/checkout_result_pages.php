<?php
// Run from the checkout: php tests/regression/checkout_result_pages.php
// Real controllers and Twig templates; no database, mail, network or gateway.
$root = dirname(__DIR__, 2);
require $root . '/system/engine/registry.php';
require $root . '/system/engine/controller.php';
require $root . '/system/storage/vendor/autoload.php';
require $root . '/application/controller/checkout/checkout.php';
require $root . '/application/controller/marketplace/purchase.php';

class ResultPageOrderSpy {
    public $writes = array();
    public function addOrder($data) { $this->writes[] = $data; return 123; }
}
class ResultPageLoader {
    public $models = array();
    public $views = array();
    private $twig;
    public function __construct($root) {
        $this->twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader($root . '/application/view/template'), array('cache' => false, 'autoescape' => false));
    }
    public function model($route) { $this->models[] = $route; }
    public function controller($route) {
        if (!in_array($route, array('common/header', 'common/footer'), true)) {
            throw new Exception('Unexpected nested controller: ' . $route);
        }
        return '<!-- ' . $route . ' -->';
    }
    public function view($route, $data = array()) {
        $this->views[] = array($route, $data);
        return $this->twig->render($route . '.twig', $data);
    }
}
class ResultPageResponse {
    public $output = '';
    public $headers = array();
    public function setOutput($value) { $this->output = $value; }
    public function addHeader($value) { $this->headers[] = $value; }
}
class ResultPageDocument {
    public $title = '';
    public function setTitle($title) { $this->title = $title; }
}
class ResultPageUrl {
    public function link($route, $args = '', $secure = false) {
        return '/index.php?route=' . $route . ($args !== '' ? '&' . $args : '');
    }
}
class ResultPageMember {
    private $logged;
    public function __construct($logged) { $this->logged = $logged; }
    public function isLogged() { return $this->logged; }
}
function check($condition, $message) {
    if (!$condition) { throw new Exception($message); }
}
function fixture($root, $logged, $pending) {
    $registry = new Registry();
    $data = array('unrelated' => 'keep', 'existing_order_id' => 900);
    if ($logged) { $data['member_token'] = 'test-member-token'; }
    if ($pending) {
        $data['pending_extension_order'] = array('member_id' => 7, 'extension_id' => 10, 'quantity' => 2, 'total' => 40, 'payment_method' => 'PayPal', 'order_status_id' => 5);
    }
    $session = new stdClass(); $session->data = $data;
    $request = new stdClass(); $request->get = array('extension_id' => 10);
    $request->server = array('SERVER_PROTOCOL' => 'HTTP/1.1', 'REQUEST_METHOD' => 'GET');
    foreach (array('load' => new ResultPageLoader($root), 'session' => $session, 'request' => $request, 'member' => new ResultPageMember($logged), 'response' => new ResultPageResponse(), 'document' => new ResultPageDocument(), 'url' => new ResultPageUrl(), 'model_account_order' => new ResultPageOrderSpy()) as $key => $value) {
        $registry->set($key, $value);
    }
    return $registry;
}
$failures = 0; $tests = 0;
function runCase($name, $fn) {
    global $tests, $failures;
    $tests++;
    try { $fn(); echo "PASS $name\n"; }
    catch (Throwable $e) { $failures++; echo "FAIL $name: " . $e->getMessage() . "\n"; }
}
foreach (array('success', 'failure', 'terms') as $method) {
    foreach (array(false, true) as $logged) {
        foreach (array(false, true) as $pending) {
            runCase("checkout/$method logged=" . (int)$logged . ' pending=' . (int)$pending, function() use ($root, $method, $logged, $pending) {
                $r = fixture($root, $logged, $pending);
                $before = $r->get('session')->data;
                $controller = new ControllerCheckoutCheckout($r);
                // Refresh/back/repeated success must also remain read-only.
                for ($i = 0; $i < 2; $i++) { $controller->$method(); }
                check(count($r->get('model_account_order')->writes) === 0, 'result page created an order');
                check($r->get('session')->data === $before, 'result page mutated pending/session');
                check($r->get('load')->models === array(), 'result page loaded a persistence model');
                $view = $r->get('load')->views[0];
                check($view[0] === 'checkout/' . $method, 'template contract changed');
                check(strpos($r->get('response')->output, '<!-- common/header -->') !== false, 'header missing');
                check(strpos($r->get('response')->output, '<!-- common/footer -->') !== false, 'footer missing');
                check(strpos($r->get('document')->title, 'Extension Purchase') === 0, 'document title missing');
                if ($method === 'success') {
                    check(strpos($r->get('response')->output, 'Extension Purchase Success') !== false, 'success HTML missing');
                    $token = $logged ? '&member_token=test-member-token' : '';
                    check($view[1]['history'] === '/index.php?route=account/order' . $token, 'order history link changed');
                    check($view[1]['account'] === '/index.php?route=account/account' . $token, 'account link changed');
                    check($view[1]['contact'] === '/index.php?route=support/contact', 'contact link changed');
                }
            });
        }
    }
}
foreach (array(false, true) as $logged) {
    runCase('legacy marketplace success logged=' . (int)$logged, function() use ($root, $logged) {
        $r = fixture($root, $logged, true); $before = $r->get('session')->data;
        (new ControllerMarketplacePurchase($r))->success();
        check($r->get('model_account_order')->writes === array(), 'legacy success wrote order');
        check($r->get('session')->data === $before, 'legacy success changed session');
        check($r->get('load')->views[0][0] === 'marketplace/success', 'legacy template changed');
    });
}
runCase('unauthenticated checkout retains 401/login redirect', function() use ($root) {
    $r = fixture($root, false, true);
    (new ControllerCheckoutCheckout($r))->index();
    check(in_array('HTTP/1.1 401 Unauthorized', $r->get('response')->headers, true), '401 missing');
    check(in_array('Location: /index.php?route=account/login', $r->get('response')->headers, true), 'login redirect missing');
    check($r->get('model_account_order')->writes === array(), 'unauthenticated checkout wrote order');
});
echo "$tests tests, $failures failures\n";
exit($failures ? 1 : 0);

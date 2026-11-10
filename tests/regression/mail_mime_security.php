<?php
// Verify Mail MIME generation never attaches index.php / PHP files as inline CID parts
// and properly embeds only real images inside image/ or application/view/image/.
error_reporting(E_ALL & ~E_DEPRECATED);
$root = dirname(__DIR__, 2);
define('DIR_SYSTEM', $root . '/system/');
define('HTTP_SERVER', 'https://localhost/');
define('HTTPS_SERVER', 'https://localhost/');

require_once DIR_SYSTEM . 'library/mail/smtp.php';
require_once DIR_SYSTEM . 'library/mail/mail.php';

class InspectableSmtp extends \Mail\Smtp {
    public function inspectMime() {
        return $this->buildMimeMessage();
    }
}

$smtp = new InspectableSmtp();
$smtp->to = 'buyer@example.invalid';
$smtp->from = 'noreply@localhost';
$smtp->sender = 'Test Store';
$smtp->subject = 'Order Confirmation';
$smtp->text = 'Plain text fallback';
$smtp->html = '<html><body>'
    . '<img src="https://localhost/index.php?route=common/homeapplication/view/image/cms/591985cbf36e6.jpg" />'
    . '<img src="https://localhost/index.php?route=common/image" />'
    . '<img src="index.php" />'
    . '<img src="config.php" />'
    . '<img src="https://localhost/application/view/image/icon/opencart-logo.png" />'
    . '<img src="https://localhost/application/view/image/cms/591985cbf36e6.jpg" />'
    . '</body></html>';

$mime = $smtp->inspectMime();
$raw = $mime['header'] . $mime['message'];

if (strpos($raw, 'filename="index.php"') !== false || strpos($raw, 'name="index.php"') !== false) {
    throw new Exception('FAIL: index.php was attached to email!');
}
if (strpos($raw, 'filename="config.php"') !== false || strpos($raw, 'application/octet-stream') !== false) {
    throw new Exception('FAIL: non-image or config.php was attached to email!');
}
if (strpos($mime['header'], 'Content-Type: multipart/alternative;') === false) {
    throw new Exception('FAIL: top-level Content-Type should be multipart/alternative when there are no file attachments!');
}
if (strpos($raw, 'filename="opencart-logo.png"') === false || strpos($raw, 'filename="591985cbf36e6.jpg"') === false) {
    throw new Exception('FAIL: legitimate store images in application/view/image/ were not embedded inline!');
}
if (strpos($raw, '@opencart.com') !== false) {
    throw new Exception('FAIL: hardcoded @opencart.com still present in MIME Content-ID!');
}

echo "PASS Mail MIME security & inline CID check (zero index.php/octet-stream attachments, valid images embedded cleanly)\n";

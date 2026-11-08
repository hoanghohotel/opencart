<?php
$root = dirname(__DIR__, 2);
require $root . '/system/storage/vendor/autoload.php';
$twig = new Twig\Environment(new Twig\Loader\FilesystemLoader($root . '/application/view/template'), array('cache' => false, 'autoescape' => false));
$base = array('extension'=>'Fixture','quantity'=>1,'total'=>'20.00','payment_image'=>'fixture.png','payment_name'=>'Fixture','member_token'=>'member','extension_id'=>10,'member_payment_id'=>0,'order_id'=>0,'payment_nonce'=>'fixture','payment_bin'=>'123456','member_email'=>'fixture@example.invalid','member_firstname'=>'Test','member_lastname'=>'Member','client_token'=>'fixture');
$out=array();
foreach (array(false,true) as $threeDS) {
    $out[$threeDS ? '3ds' : 'standard']=$twig->render('checkout/confirm.twig', $base + array('three_d_secure'=>$threeDS));
}
$html=$twig->render('checkout/paypal.twig', array('error_warning'=>'PayPal unavailable'));
if (strpos($html,'PayPal unavailable')===false || strpos($html,'<script')!==false) { throw new Exception('Unsupported PayPal page must not execute payment SDK'); }
echo json_encode($out);

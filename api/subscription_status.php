<?php
require_once '../src/common.php';
$res = [];

$res['status'] = 0;

if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
	$res['status'] = '1';
	$res['error'] = 'لطفا آدرس وارد شده را بررسی کرده و دوباره امتحان کنید';
}

$captcha = recaptcha_verify($_GET['token']);
if(!$captcha->success){
    $res['status'] = '1';
    $res['error'] = 'ری‌کپچا (reCAPTCHA) نتوانست هویت شما را تایید کند';
}

if($res['status'] != '1'){
    $res = get_subscription_status($_GET['email']);
}

header('Content-Type: application/json');
echo json_encode($res);

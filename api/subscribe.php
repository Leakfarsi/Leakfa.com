<?php
require_once '../src/common.php';
$res = [];

$res['status'] = 0;
if(!is_sha1($_GET['hash'])){
	$res['status'] = '1';
	$res['error'] = 'مقدار هش دریافتی صحیح نمی باشد';
}

if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
	$res['status'] = '1';
	$res['error'] = 'خطای قالب ایمیل، لطفا آدرس وارد شده را دوباره بررسی کنید';
}

$captcha = recaptcha_verify($_GET['token']);
if(!$captcha->success){
    $res['status'] = '1';
    $res['error'] = 'ری‌کپچا (reCAPTCHA) نتوانست هویت شما را تایید کند';
}

if($res['status'] != '1'){
    $res = subscribe($_GET['name'], $_GET['email'], $_GET['hash']);
}

header('Content-Type: application/json');
echo json_encode($res);

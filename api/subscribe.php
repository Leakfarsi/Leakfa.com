<?php
require_once '../src/common.php';

$res = [];
$res['status'] = 0;

if (!isset($_GET['hash']) || !isset($_GET['email']) || !isset($_GET['token'])) {
    $res['status'] = '1';
    $res['error'] = 'پارامترهای ضروری ارسال نشده‌اند';
    header('Content-Type: application/json');
    echo json_encode($res);
    exit;
}

if (!is_sha1($_GET['hash'])) {
    $res['status'] = '1';
    $res['error'] = 'مقدار هش دریافتی صحیح نمی باشد';
}

if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    $res['status'] = '1';
    $res['error'] = 'خطای قالب ایمیل، لطفا آدرس وارد شده را دوباره بررسی کنید';
}

if ($res['status'] != '1') {
    $captcha = turnstile_verify($_GET['token']);
    if (!$captcha->success) {
        $res['status'] = '1';
        $res['error'] = 'تأیید امنیتی نتوانست هویت شما را تایید کند';
    }
}

if ($res['status'] != '1') {
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $res = subscribe($name, $_GET['email'], $_GET['hash']);
}

header('Content-Type: application/json');
echo json_encode($res);

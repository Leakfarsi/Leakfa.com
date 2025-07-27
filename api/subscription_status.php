<?php
require_once '../src/common.php';

$res = [];
$res['status'] = 0;

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    $res['status'] = '1';
    $res['error'] = 'پارامترهای ضروری ارسال نشده‌اند';
    header('Content-Type: application/json');
    echo json_encode($res);
    exit;
}

if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    $res['status'] = '1';
    $res['error'] = 'لطفا آدرس وارد شده را بررسی کرده و دوباره امتحان کنید';
}

if ($res['status'] != '1') {
    $captcha = turnstile_verify($_GET['token']);
    if (!$captcha->success) {
        $res['status'] = '1';
        $res['error'] = 'تأیید امنیتی نتوانست هویت شما را تایید کند';
    }
}

if ($res['status'] != '1') {
    $res = get_subscription_status($_GET['email']);
}

header('Content-Type: application/json');
echo json_encode($res);

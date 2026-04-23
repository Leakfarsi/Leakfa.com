<?php
require_once '../src/common.php';

$res = [];
$res['status'] = 0;

$input = array_merge($_GET, $_POST);

if (!isset($input['hash']) || !isset($input['email']) || !isset($input['token'])) {
    $res['status'] = '1';
    $res['error'] = 'پارامترهای ضروری ارسال نشده‌اند';
    header('Content-Type: application/json');
    echo json_encode($res);
    exit;
}

if (!is_sha1($input['hash'])) {
    $res['status'] = '1';
    $res['error'] = 'مقدار هش دریافتی صحیح نمی باشد';
}

if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    $res['status'] = '1';
    $res['error'] = 'لطفا آدرس وارد شده را بررسی کرده و دوباره امتحان کنید';
}

if ($res['status'] != '1') {
    $captcha = turnstile_verify($input['token']);
    if (!$captcha->success) {
        $res['status'] = '1';
        $res['error'] = 'تأیید امنیتی نتوانست هویت شما را تایید کند';
    }
}

if ($res['status'] != '1') {
    $res = unsubscribe($input['email'], $input['hash']);
}

header('Content-Type: application/json');
echo json_encode($res);

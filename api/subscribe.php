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
    $res['error'] = 'خطای قالب ایمیل، لطفا آدرس وارد شده را دوباره بررسی کنید';
}

if ($res['status'] != '1') {
    $captcha = turnstile_verify($input['token']);
    if (!$captcha->success) {
        $res['status'] = '1';
        $res['error'] = 'تأیید امنیتی نتوانست هویت شما را تایید کند';
    }
}

if ($res['status'] != '1') {
    $name = isset($input['name']) ? htmlspecialchars($input['name'], ENT_QUOTES, 'UTF-8') : '';
    $res = subscribe($name, $input['email'], $input['hash']);
}

header('Content-Type: application/json');
echo json_encode($res);

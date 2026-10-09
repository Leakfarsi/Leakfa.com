<?php
require_once '../src/common.php';

$res = [];
$res['status'] = '1';
$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $res['error'] = 'Method not allowed';
} elseif ($action === 'send_link') {
    $email = normalize_email($_POST['email'] ?? '');
    if (!is_valid_email($email)) {
        $res['error'] = 'لطفا آدرس وارد شده را بررسی کرده و دوباره امتحان کنید';
    } else {
        $captcha = turnstile_verify($_POST['token'] ?? '');
        if (!$captcha->success) {
            $res['error'] = 'تأیید امنیتی نتوانست هویت شما را تایید کند';
        } else {
            $res = send_notify_link($email);
        }
    }
} else {
    delete_stale_registrations();
    $row = get_subscriber_by_token($_POST['t'] ?? '');
    if (!$row) {
        $res['error'] = 'این لینک نامعتبر یا منقضی شده است، لطفا ایمیل خود را دوباره در صفحه باخبرم کن وارد کنید.';
    } else {
        $res = manage_subscription($row, $action, $_POST);
    }
}

respond_then_send_mail($res);

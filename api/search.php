<?php
require_once '../src/common.php';
$res = [];
$res['status'] = 0;

$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
$token = isset($_POST['token']) ? $_POST['token'] : '';

if(!is_sha1($hash)){
	$res['status'] = '1';
	$res['error'] = 'Input format error';
} else {
    $captcha = turnstile_verify($token);
    if(!$captcha->success){
        $res['status'] = '1';
        $res['error'] = 'Turnstile verification failed';
    }
}

if($res['status'] != '1'){
    $res = search($hash);
}

header('Content-Type: application/json');
echo json_encode($res);

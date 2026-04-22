<?php
require_once '../src/common.php';
$res = [];
$res['status'] = 0;

$hash = isset($_GET['hash']) ? $_GET['hash'] : '';
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$nonce = isset($_GET['nonce']) ? $_GET['nonce'] : '';

if(!is_sha1($hash)){
	$res['status'] = '1';
	$res['error'] = 'Input format error';
} elseif($mode == 'turnstile'){
    $captcha = turnstile_verify($token);
    if(!$captcha->success){
        $res['status'] = '1';
        $res['error'] = 'Turnstile verification failed';
    }
} elseif($mode == 'pow'){
    if (substr(sha1($hash . $nonce), 0, POW_DIFF) != str_repeat('a', POW_DIFF)){
        $res['status'] = '1';
        $res['error'] = 'Nonce error: Nonce must meet the sha1 (request hash + nonce)' . POW_DIFF . ' Bit equal ' . str_repeat('a', POW_DIFF); 
    }
} else {
    $res['status'] = '1';
    $res['error'] = 'Verification mode error';
}

if($res['status'] != '1'){
    $res = search($hash);
}

header('Content-Type: application/json');
echo json_encode($res);

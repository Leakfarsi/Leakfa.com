<?php
require_once '../src/common.php';
$res = [];

$res['status'] = 0;
if(!is_sha1($_GET['hash'])){
	$res['status'] = '1';
	$res['error'] = 'Input format error';
}

if($_GET['mode'] == 'recaptcha'){
    $captcha = recaptcha_verify($_GET['token']);
    if(!$captcha->success){
        $res['status'] = '1';
        $res['error'] = 'reCAPTCHA failed';
    }
}else if($_GET['mode'] == 'pow'){
    if (substr(sha1($_GET['hash'] . $_GET['nonce']), 0, POW_DIFF) != str_repeat('a', POW_DIFF)){
        $res['status'] = '1';
        $res['error'] = 'Nonce error: Nonce must meet the sha1 (request hash + nonce)' . POW_DIFF . ' Bit equal ' . str_repeat('a', POW_DIFF); 
    }
}else{
    $res['status'] = '1';
    $res['error'] = 'Verification mode error';
}

if($res['status'] != '1'){
    $res = search($_GET['hash']);
}

header('Content-Type: application/json');
echo json_encode($res);

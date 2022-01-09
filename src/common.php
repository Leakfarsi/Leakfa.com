<?php
require_once 'config.php';

function get_ip(){
    return $_SERVER['HTTP_CF_CONNECTING_IP'] ?: $_SERVER['REMOTE_ADDR'];
}

function get_breach_type_count($major){
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM `breach_source` WHERE `major`=:major");
    $stmt->execute([
        'major' => $major ? 1 : 0
    ]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['count'];
}

function get_major_breaches(){
    global $db;
    $stmt = $db->prepare("SELECT `id`,`name`,`description`,`round_k` FROM `breach_source` WHERE `major`=1 ORDER BY `round_k` DESC");
	$stmt->execute();
    $res = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $res;
}

function get_tag_details(){
    global $db;
    $stmt = $db->prepare("SELECT `id`,`name`,`description` FROM `tag`");
	$stmt->execute();
    $res = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $res;
}

function get_leaked_items($source){
    global $db;
    $stmt = $db->prepare("SELECT `name` FROM `source_item` INNER JOIN `breach_item` `s` on `s`.`id` = `source_item`.`item` WHERE `source`=:source_id");
    $stmt->execute([
        'source_id' => $source
    ]);
    $items = $stmt->fetchall(PDO::FETCH_ASSOC);
    $items = reduce_items($items);
    return $items;
}

function get_tags($source){
    global $db;
    $stmt = $db->prepare("SELECT `source_tag`.`tag`,`name`,`class` FROM `source_tag` INNER JOIN `tag` `s` on `s`.`id` = `source_tag`.`tag` WHERE `source`=:source_id");
    $stmt->execute([
        'source_id' => $source
    ]);
    $tags = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $tags;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function simple_email($to, $name, $subject, $content, $code){
    require 'vendor/autoload.php';
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = SMTP_SEME;
    $mail->Host = SMTP_HOST;
    $mail->Port = SMTP_PORT;
    $mail->Username = SMTP_USER;
    $mail->Password = SMTP_PASS;
    $mail->CharSet = "utf-8";
    $mail->isHTML(true);
    $mail->WordWrap = 50;
    $mail->setFrom(SMTP_EMAIL, SMTP_NICK);
    $mail->AddAddress($to, $name);
    $mail->AddReplyTo(SMTP_EMAIL,SMTP_NICK);
    $mail->Subject = $subject;
    $mail->Body = str_replace("§code§", $code, $content);
    return $mail->Send();
}

function mail_verify($email, $name, $hash, $code){
    $content = EMAIL_VERIFICATION_CONTENT;
    $content = str_replace("§name§", $name, $content);
    $content = str_replace("§hash§", $hash, $content);
    $content = str_replace("§code§", $code, $content);
    return simple_email($email, $name, EMAIL_VERIFICATION_SUBJECT, $content, $code);
}

function is_account_verify($email){
    global $db2;
    $stmt = $db2->prepare("SELECT `id` FROM `subscribers` WHERE email=:email AND `disabled`=0 AND `email_verify`=1");
	$stmt->execute([
        'email' => $email
	]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
    if ($res == ""){
        return 0;
    }else{
        return 1;
    }
}

function is_account_exist($email){
    global $db2;
    $stmt = $db2->prepare("SELECT `id` FROM `subscribers` WHERE email=:email AND `disabled`=0");
	$stmt->execute([
        'email' => $email
	]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
    if ($res == ""){
        return 0;
    }else{
        return 1;
    }
}

function reduce_items($items){
    $res = [];
    foreach($items as $key => $val){
        array_push($res, $val['name']);
    }
    return $res;
}

function search($hash){
    $res = [];
    $res['status'] = '0';
    $res['result'] = [];

    global $db;
    $stmt = $db->prepare("SELECT `source` FROM `breach_log` WHERE `hash`=:hash");
    $stmt->execute([
        'hash' => $_GET['hash']
    ]);

    $sources = $stmt->fetchall(PDO::FETCH_ASSOC);
    
    foreach($sources as $_ => $val){
        $stmt = $db->prepare("SELECT `name` FROM `breach_source` WHERE `id`=:source_id");
        $stmt->execute([
            'source_id' => $val['source']
        ]);
        $source_info = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $db->prepare("SELECT `name` FROM `source_item` INNER JOIN `breach_item` `s` on `s`.`id` = `source_item`.`item` WHERE `source`=:source_id");
        $stmt->execute([
            'source_id' => $val['source']
        ]);
        $items = $stmt->fetchall(PDO::FETCH_ASSOC);
        $items = reduce_items($items);

        $res['result'][$source_info['name']] = $items;
        
    }

    search_log($_GET['hash'], $res['result']);
    
    return $res;
}

function get_account($email, $hash){
    global $db2;
    $stmt = $db2->prepare("SELECT `name` FROM `subscribers` WHERE `email`=:email AND `hash`=:hash AND `disabled`=0");
	$stmt->execute([
        'email' => $email,
        'hash' => $hash
	]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res;
}

function subscribe($name, $email, $hash){
    $res = [];

    if (is_account_exist($email)){
        $res['status'] = '1';
        if (is_account_verify($email)){
            $content = EMAIL_TEST_CONTENT;
            $account = get_account($email, $hash);
            if($account['name']){
                $res['error'] = 'This email has subscribed to leaked messages, and a test letter will be sent to you.';
                $content = str_replace("§name§", $name, $content);
                simple_email($email, $name, EMAIL_TEST_SUBJECT, $content, $code);
            }else{
                $res['error'] = 'شماره وارد شده با داده های اصلی مطابقت ندارد';
            }
        }else{
            $res['error'] = 'این آدرس ایمیل در سامانه باخبرم کن ثبت شده اما هنوز تایید نشده است، لطفا با مراجعه به صندوق ورودی (Inbox) و بازکردن لینک ارسال شده، آدرس خود را تایید کنید.';
        }
    }else{
        $code = sha1(sprintf("%10d", mt_rand(1, 9999999999)) . $hash);
        if(mail_verify($email, $name, $hash, $code)){
            global $db2;
            $stmt = $db2->prepare("INSERT INTO `subscribers`(`name`, `email`, `hash`, `email_verify_code`, `sub_ip`, `sub_time`) VALUES (:name, :email, :hash, :code, :ip, NOW())");
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'hash' => $hash,
                'code' => $code,
                'ip' => get_ip()
            ]);

            $res = search($_GET['hash']);
        }else{
            $res['status'] = '1';
            $res['error'] = 'E-mail Send Error';
        }
    }
    return $res;
}

function verify_code($code){    
    global $db2;
    $stmt = $db2->prepare("SELECT `id`,`email_verify` FROM `subscribers` WHERE `email_verify_code`=:code");
    $stmt->execute([
        'code' => $code
    ]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $data['id'];
    if ($id != ''){;
        if ($data['email_verify'] != "1"){
            $stmt = $db2->prepare("UPDATE `subscribers` SET `email_verify`=1, `email_verify_time`=NOW(),`email_verify_ip`=:ip WHERE `id`=:id");
            $stmt->execute([
                'id' => $id,
                'ip' => get_ip()
            ]);
            return 1; // Verification complete
        }else{
            return 0; // Verified
        }
    }else{
        return -1; // Without this code
    }
}

function get_subscription_status($email){
    $res = [
        'status' => '0'
    ];

    if (is_account_exist($email)){
        if (is_account_verify($email)){
            $res['result'] = 'subscribed';
        }else{
            $res['result'] = 'verification_pending';
        }
    }else{
        $res['result'] = 'not_subscribed';
    }
    return $res;
}

function unsubscribe($email, $hash){
    $res = [
        'status' => '1'
    ];

    if (is_account_exist($email)){
        $account = get_account($email, $hash);
        if ($account['name']){
            global $db2;
            $stmt = $db2->prepare("UPDATE `subscribers` SET `disabled`=1 WHERE `email`=:email AND `hash`=:hash AND `disabled`=0");
            $stmt->execute([
                'email' => $email,
                'hash' => $hash
            ]);
            $res['status'] = '0';
        }else{
            $res['error'] = "Does not match the original data";
        }
    }else{
        $res['error'] = "This email Not yet subscribed to leaked messages.";
    }
    return $res;
}

function is_sha1($str) {
    return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
}

function search_log($hash, $res){
    global $db;
    $stmt = $db->prepare('INSERT INTO `search_log`(`hash`, `isbreach`, `ip`) VALUES (:hash, :isbreach, :ip)');
    $stmt->execute([
        'hash' => $hash,
        'isbreach' => ($res != array() ? '1' : '0'),
        'ip' => get_ip()
    ]);
}

function array_remove_null_return_keys($array)
{
    $keys = array();
    foreach ($array as $_key => $sarr) {
        foreach ($sarr as $key => $value) {
            if (!(is_null($sarr[$key]) or trim($sarr[$key]) == '')) {
                array_push($keys, $key);
            }
        }
    }

    return array_unique($keys);
}

function recaptcha_verify($token){
    $post_data = http_build_query([
            'secret' => RECAPTCHA_SECRET_KEY,
            'response' => $token,
            'remoteip' => get_ip()
    ]);
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $post_data
        )
    );
    $context  = stream_context_create($opts);
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    $result = json_decode($response);
    return $result;
}

function site_stat(){
    $out = [];

    global $db;
    $stmt = $db->prepare("SELECT * FROM `stat` ORDER BY `id` DESC LIMIT 1");
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $out['cache_gen_time'] = $res['time'];
    $out['unique_hash'] = intval($res['unique_hash']);
    $out['total_pop'] = intval($res['total_pop']);
    $out['cover_rate'] = $res['unique_hash'] / $res['total_pop'];
    $out['total_pop_month'] = intval($res['total_pop_month']);
    $out['hit'] = intval($res['hit']);
    $out['no_hit'] = intval($res['no_hit']);
    $out['total_unique_search'] = $res['hit'] + $res['no_hit'];
    $out['hit_rate'] = $res['hit'] / $out['total_unique_search'];

    $out['source'] = [];

    $stmt = $db->prepare("SELECT type, count(*) as `count` FROM `breach_source` WHERE major=1 GROUP BY `type`");
    $stmt->execute();
    $res = $stmt->fetchall(PDO::FETCH_ASSOC);
    $out['source']['major'] = $res;

    $stmt = $db->prepare("SELECT type, count(*) as `count` FROM `breach_source` WHERE major=0 GROUP BY `type`");
    $stmt->execute();
    $res = $stmt->fetchall(PDO::FETCH_ASSOC);
    $out['source']['minor'] = $res;

    $stmt = $db->prepare("SELECT type, count(*) as `count` FROM `breach_source` GROUP BY `type`");
    $stmt->execute();
    $res = $stmt->fetchall(PDO::FETCH_ASSOC);
    $out['source']['total'] = $res;

    foreach($out['source'] as $key1 => $val1){
        foreach($out['source'][$key1] as $key2 => $val2){
            $out['source'][$key1][$key2]['count'] = intval($out['source'][$key1][$key2]['count']);
        }
    }

    return $out;
}
?>

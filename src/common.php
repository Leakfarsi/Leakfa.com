<?php
require_once 'config.php';

function get_ip(){
    return $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];
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
    $stmt = $db->prepare("SELECT `id`,`name`,`anchor`,`description`,`round_k`,`time`,`breach_date`,`affected_accounts`,`news_url`,`news_title`,`video_url`,`video_title` FROM `breach_source` WHERE `major`=1 ORDER BY `round_k` DESC");
	$stmt->execute();
    $res = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $res;
}

function get_tag_details(){
    global $db;
    $stmt = $db->prepare("SELECT `id`,`name`,`description`,`class` FROM `tag`");
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

function get_all_breach_tags(){
    global $db;
    $stmt = $db->prepare("SELECT `source_tag`.`source`,`source_tag`.`tag`,`s`.`name`,`s`.`class` FROM `source_tag` INNER JOIN `tag` `s` on `s`.`id` = `source_tag`.`tag`");
    $stmt->execute();
    $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
    $grouped = [];
    foreach ($rows as $row) {
        $sourceId = $row['source'];
        if (!isset($grouped[$sourceId])) {
            $grouped[$sourceId] = [];
        }
        $grouped[$sourceId][] = [
            'tag' => $row['tag'],
            'name' => $row['name'],
            'class' => $row['class']
        ];
    }
    return $grouped;
}

function get_all_breach_items(){
    global $db;
    $stmt = $db->prepare("SELECT `source_item`.`source`,`breach_item`.`name` FROM `source_item` INNER JOIN `breach_item` on `breach_item`.`id` = `source_item`.`item`");
    $stmt->execute();
    $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
    $grouped = [];
    foreach ($rows as $row) {
        $sourceId = $row['source'];
        if (!isset($grouped[$sourceId])) {
            $grouped[$sourceId] = [];
        }
        $grouped[$sourceId][] = $row['name'];
    }
    return $grouped;
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
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($row && $row['id'] !== '') ? 1 : 0;
}

function is_account_exist($email){
    global $db2;
    $stmt = $db2->prepare("SELECT `id` FROM `subscribers` WHERE email=:email AND `disabled`=0");
	$stmt->execute([
        'email' => $email
	]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($row && $row['id'] !== '') ? 1 : 0;
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
    
    $stmt = $db->prepare("SELECT id FROM breach_hash WHERE hash = UNHEX(?)");
    $stmt->execute([$hash]);
    $hashRow = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$hashRow){
        search_log($hash, []);
        return $res;
    }
    
    $stmt = $db->prepare("
        SELECT bs.name AS source_name, bi.name AS item_name
        FROM breach_relation br
        INNER JOIN breach_source bs ON bs.id = br.source_id
        INNER JOIN source_item si ON si.source = br.source_id
        INNER JOIN breach_item bi ON bi.id = si.item
        WHERE br.hash_id = ?
        ORDER BY bs.name
    ");
    $stmt->execute([$hashRow['id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($rows as $row){
        if(!isset($res['result'][$row['source_name']])){
            $res['result'][$row['source_name']] = [];
        }
        if(!in_array($row['item_name'], $res['result'][$row['source_name']])){
            $res['result'][$row['source_name']][] = $row['item_name'];
        }
    }
    
    search_log($hash, $res['result']);
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
                $res['error'] = 'این ایمیل در باخبرم کن قبلا ثبت شده است، یک نامه آزمایشی برای شما ارسال می‌شود.';
                $content = str_replace("§name§", $name, $content);
                simple_email($email, $name, EMAIL_TEST_SUBJECT, $content, '');
            }else{
                $res['error'] = 'شماره وارد شده با داده های اصلی مطابقت ندارد';
            }
        }else{
            $res['error'] = 'این آدرس ایمیل در سامانه باخبرم کن ثبت شده اما هنوز تایید نشده است، لطفا با مراجعه به صندوق ورودی (Inbox) و بازکردن لینک ارسال شده، آدرس خود را تایید کنید.';
        }
    }else{
        $code = bin2hex(random_bytes(20));
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

            $res = search($hash);
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
    if ($id != ''){
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
    $stmt = $db->prepare('INSERT INTO `search_log`(`hash`, `isbreach`, `ip`) VALUES (UNHEX(:hash), :isbreach, :ip)');
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

function turnstile_verify($token){
    $post_data = http_build_query([
            'secret' => TURNSTILE_SECRET_KEY,
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
    $response = file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, $context);
    $result = json_decode($response);
    return $result;
}

function site_stat(){
    global $db;
    $out = [];

    $stmt = $db->prepare("SELECT * FROM `stat` ORDER BY `id` DESC LIMIT 1");
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    $out['cache_gen_time'] = $res['time'];
    $out['unique_hash'] = intval($res['unique_hash']);
    $out['hit'] = intval($res['hit']);
    $out['no_hit'] = intval($res['no_hit']);

    $out['total_unique_search'] = $out['hit'] + $out['no_hit'];
    $out['hit_rate'] = $out['total_unique_search'] > 0 
        ? $out['hit'] / $out['total_unique_search'] 
        : 0;

    $stmt = $db->prepare("SELECT COUNT(*) FROM breach_source WHERE major=1");
    $stmt->execute();
    $out['major'] = intval($stmt->fetchColumn());

    $stmt = $db->prepare("SELECT COUNT(*) FROM breach_source WHERE major=0");
    $stmt->execute();
    $out['minor'] = intval($stmt->fetchColumn());

    $out['total_sources'] = $out['major'] + $out['minor'];

    $out['relations'] = intval($res['relations']);

    $stmt = $db->prepare("
        SELECT 
            sc.name AS category,
            SUM(CASE WHEN bs.major = 1 THEN 1 ELSE 0 END) AS major_count,
            SUM(CASE WHEN bs.major = 0 THEN 1 ELSE 0 END) AS minor_count,
            COUNT(bs.id) AS total_count
        FROM source_category sc
        LEFT JOIN breach_source bs ON bs.category_id = sc.id
        GROUP BY sc.id, sc.name
        ORDER BY total_count DESC
    ");
    $stmt->execute();
    $out['categories'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($out['categories'] as &$row){
        $row['major_count'] = intval($row['major_count']);
        $row['minor_count'] = intval($row['minor_count']);
        $row['total_count'] = intval($row['total_count']);
    }

    return $out;
}
?>

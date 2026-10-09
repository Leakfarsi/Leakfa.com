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
    $stmt = $db->prepare("SELECT `source_item`.`source`,`breach_item`.`name` FROM `source_item` INNER JOIN `breach_item` on `breach_item`.`id` = `source_item`.`item` ORDER BY `source_item`.`id` ASC");
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

function simple_email($to, $name, $subject, $body){
    require_once 'vendor/autoload.php';
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
    $mail->Timeout = 10;
    $mail->setFrom(SMTP_EMAIL, SMTP_NICK);
    $mail->AddAddress($to, $name);
    $mail->AddReplyTo(SMTP_EMAIL,SMTP_NICK);
    $mail->Subject = $subject;
    $mail->Body = $body;
    return $mail->Send();
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

function normalize_email($email){
    return strtolower(trim($email));
}

function is_valid_email($email){
    return strlen($email) <= 191 && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function clean_name($name){
    $name = trim(preg_replace('/[\x00-\x1F\x7F]+/u', '', $name));
    return preg_match('/^.{1,50}$/u', $name) ? $name : false;
}

function get_subscriber_by_email($email){
    global $db2;
    $stmt = $db2->prepare("SELECT * FROM `subscribers` WHERE `email`=:email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_subscriber_by_token($token){
    global $db2;
    if (!is_string($token) || !preg_match('/^[0-9a-f]{64}$/', $token)) {
        return false;
    }
    $stmt = $db2->prepare("SELECT * FROM `subscribers` WHERE `link_hash`=:link_hash
        AND `link_sent_at` >= NOW() - INTERVAL " . (int)LINK_TTL_MINUTES . " MINUTE");
    $stmt->execute(['link_hash' => hash('sha256', $token)]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function subscriber_state($row){
    if ($row['disabled']) {
        return 'unsubscribed';
    }
    return $row['email_verify'] ? 'active' : 'new';
}

function delete_stale_registrations(){
    global $db2;
    $db2->exec("DELETE FROM `subscribers` WHERE `email_verify`=0 AND COALESCE(`disabled`, 0)=0
        AND (`link_sent_at` IS NULL OR `link_sent_at` < NOW() - INTERVAL " . (int)LINK_TTL_MINUTES . " MINUTE)");
}

function send_subscriber_mail($row, $subject, $template, $link){
    $name = $row['name'] ?? '';
    $body = str_replace(
        ['§name§', '§link§', '§minutes§'],
        [$name === '' ? '' : ' ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8'), $link, (int)LINK_TTL_MINUTES],
        $template
    );
    return simple_email($row['email'], $name, $subject, $body);
}

function send_notify_link($email){
    global $db2;
    delete_stale_registrations();

    $row = get_subscriber_by_email($email);
    if (!$row) {
        $stmt = $db2->prepare("INSERT IGNORE INTO `subscribers`(`email`, `sub_ip`) VALUES (:email, :ip)");
        $stmt->execute([
            'email' => $email,
            'ip' => get_ip()
        ]);
        $row = get_subscriber_by_email($email);
    }

    if ($row) {
        $token = bin2hex(random_bytes(32));
        $stmt = $db2->prepare("UPDATE `subscribers` SET `link_hash`=:link_hash, `link_sent_at`=NOW() WHERE `id`=:id
            AND (`link_sent_at` IS NULL OR `link_sent_at` < NOW() - INTERVAL 2 MINUTE)");
        $stmt->execute(['link_hash' => hash('sha256', $token), 'id' => $row['id']]);

        if ($stmt->rowCount() === 1) {
            $link = SITE_URL . '/notify.php?t=' . $token;
            if (subscriber_state($row) === 'active') {
                $sent = send_subscriber_mail($row, EMAIL_MANAGE_LINK_SUBJECT, EMAIL_MANAGE_LINK_CONTENT, $link);
            } else {
                $sent = send_subscriber_mail($row, EMAIL_REGISTER_LINK_SUBJECT, EMAIL_REGISTER_LINK_CONTENT, $link);
            }
            if (!$sent) {
                $stmt = $db2->prepare("UPDATE `subscribers` SET `link_hash`=NULL, `link_sent_at`=NULL WHERE `id`=:id");
                $stmt->execute(['id' => $row['id']]);
                return [
                    'status' => '1',
                    'error' => 'ارسال ایمیل ممکن نشد، لطفا بعداً دوباره تلاش کنید.'
                ];
            }
        }
    }

    return [
        'status' => '0',
        'message' => 'لینک ثبت یا مدیریت اشتراک به این آدرس ارسال شد؛ صندوق ورودی و پوشه اسپم را بررسی کنید. اگر ایمیلی نرسید، چند دقیقه بعد دوباره امتحان کنید.'
    ];
}

function manage_subscription($row, $action, $input){
    global $db2;
    $state = subscriber_state($row);
    $res = ['status' => '1'];

    if ($action === 'unsubscribe') {
        if ($state !== 'active') {
            $res['error'] = 'اشتراک فعالی برای لغو وجود ندارد.';
        } else {
            $stmt = $db2->prepare("UPDATE `subscribers` SET `disabled`=1 WHERE `id`=:id");
            $stmt->execute(['id' => $row['id']]);
            $res = ['status' => '0', 'message' => 'اشتراک شما لغو شد.'];
        }
        return $res;
    }

    if ($action !== 'save') {
        $res['error'] = 'درخواست نامعتبر است';
        return $res;
    }

    $name = clean_name($input['name'] ?? '');
    $hash = strtolower($input['hash'] ?? '');
    $phone_changed = $hash !== '' && $row['hash'] !== null && !hash_equals($row['hash'], $hash);
    $phone_same = $hash !== '' && $row['hash'] !== null && hash_equals($row['hash'], $hash);
    $name_changed = $name !== false && $name !== $row['name'];

    if ($name === false) {
        $res['error'] = 'نام باید بین ۱ تا ۵۰ کاراکتر باشد.';
    } elseif ($hash !== '' && !is_sha1($hash)) {
        $res['error'] = 'مقدار هش دریافتی صحیح نمی باشد';
    } elseif ($hash === '' && $row['hash'] === null) {
        $res['error'] = 'لطفا شماره تلفن همراه خود را وارد کنید.';
    } else {
        $params = ['name' => $name, 'id' => $row['id']];
        $set = "`name`=:name";
        if ($hash !== '') {
            $set .= ", `hash`=:hash";
            $params['hash'] = $hash;
        }
        if ($state !== 'active') {
            $set .= ", `email_verify`=1, `disabled`=0, `email_verify_time`=NOW(), `email_verify_ip`=:ip, `sub_time`=NOW(), `sub_ip`=:ip2";
            $params['ip'] = get_ip();
            $params['ip2'] = get_ip();
        }
        $stmt = $db2->prepare("UPDATE `subscribers` SET " . $set . " WHERE `id`=:id");
        $stmt->execute($params);

        $same_note = 'شماره وارد شده همان شماره ثبت‌شده شماست.';
        if ($state === 'new') {
            $message = 'اشتراک شما ثبت شد. اگر نشتی از اطلاعات شما در مقیاس بزرگ پیدا شود، به شما اطلاع می‌دهیم.';
        } elseif ($state === 'unsubscribed') {
            $message = 'اشتراک شما دوباره فعال شد.';
            if ($phone_changed) {
                $message .= ' شماره تلفن شما تغییر کرد.';
            } elseif ($phone_same) {
                $message .= ' ' . $same_note;
            }
        } elseif ($name_changed && $phone_changed) {
            $message = 'نام و شماره تلفن شما تغییر کرد.';
        } elseif ($name_changed) {
            $message = 'نام شما تغییر کرد.' . ($phone_same ? ' ' . $same_note : '');
        } elseif ($phone_changed) {
            $message = 'شماره تلفن شما تغییر کرد.';
        } elseif ($phone_same) {
            $message = $same_note . ' تغییری ایجاد نشد.';
        } else {
            $message = 'تغییری ایجاد نشد.';
        }
        $res = ['status' => '0', 'message' => $message];
    }
    return $res;
}

function is_http_url($url) {
    return is_string($url) && preg_match('#^https?://#i', $url) === 1;
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
            'content' => $post_data,
            'timeout' => 5
        )
    );
    $context  = stream_context_create($opts);
    $response = file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, $context);
    $result = $response === false ? null : json_decode($response);
    if (!is_object($result) || empty($result->success)) {
        return (object)['success' => false];
    }
    $real_key = strpos(TURNSTILE_SECRET_KEY, '0x') === 0;
    if ($real_key && ($result->hostname ?? '') !== parse_url(SITE_URL, PHP_URL_HOST)) {
        return (object)['success' => false];
    }
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

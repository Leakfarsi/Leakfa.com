<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

set_exception_handler(function ($e) {
    error_log('Uncaught exception: ' . $e->getMessage());
    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
    }
    echo json_encode(['status' => '1', 'error' => 'خطای داخلی سرور، لطفا بعدا دوباره تلاش کنید.']);
    exit;
});

define('DB_HOST', 'localhost');
define('DB_NAME', 'database');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_TIMEZONE', 'Asia/Tehran');
define('DB2_HOST', 'localhost');
define('DB2_NAME', 'database');
define('DB2_USER', 'username');
define('DB2_PASS', 'password');
define('DB2_TIMEZONE', 'Asia/Tehran');

define('SMTP_HOST', 'smtp.mail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'username');
define('SMTP_PASS', 'password');
define('SMTP_SEME', 'tls');
define('SMTP_EMAIL', 'noreply@domain.com');
define('SMTP_NICK', 'Leakfa');

define('TURNSTILE_SITE_KEY', ''); 
define('TURNSTILE_SECRET_KEY', '');

define('SITE_URL', 'https://leakfa.com');
define('LINK_TTL_MINUTES', 60);
define('EMAIL_REGISTER_LINK_SUBJECT', 'تکمیل اشتراک در لیک‌فا');
define('EMAIL_REGISTER_LINK_CONTENT', '<div dir="rtl" style="text-align:right;font-family:Tahoma,Arial,sans-serif;line-height:1.8;">سلام§name§،<br/><br/>برای عضویت در سرویس باخبرم کن، لینک زیر را باز کنید و نام و شماره تلفن خود را وارد کنید. این لینک تا §minutes§ دقیقه معتبر است:<br/><a href="§link§" dir="ltr">§link§</a><br/><br/>اگر نشتی از اطلاعات شخصی شما در مقیاس بزرگ پیدا شود، بلافاصله به شما اطلاع می‌دهیم.<br/>اگر این درخواست را شما ثبت نکرده‌اید، این ایمیل را نادیده بگیرید؛ هیچ اطلاعاتی ثبت نشده است.<br/>در صورت داشتن هرگونه سؤال با ما در ارتباط باشید: <span dir="ltr">info@leakfa.com</span><br/><br/>تیم لیک‌فا</div>');
define('EMAIL_MANAGE_LINK_SUBJECT', 'مدیریت اشتراک لیک‌فا');
define('EMAIL_MANAGE_LINK_CONTENT', '<div dir="rtl" style="text-align:right;font-family:Tahoma,Arial,sans-serif;line-height:1.8;">سلام§name§،<br/><br/>برای تغییر نام یا شماره تلفن، یا لغو اشتراک، لینک زیر را باز کنید. این لینک تا §minutes§ دقیقه معتبر است:<br/><a href="§link§" dir="ltr">§link§</a><br/><br/>اگر این درخواست را شما ثبت نکرده‌اید، این ایمیل را نادیده بگیرید.<br/><br/>تیم لیک‌فا</div>');

define('POW_DIFF', 5);

$connection_string = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
$connection_string2 = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB2_HOST, DB2_NAME);
try {
    $db = new PDO($connection_string, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db2 = new PDO($connection_string2, DB2_USER, DB2_PASS);
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    if (!headers_sent()) {
        http_response_code(503);
        header('Content-Type: application/json; charset=utf-8');
    }
    echo json_encode(['status' => '1', 'error' => 'خطای اتصال به پایگاه داده، لطفا بعدا دوباره تلاش کنید.']);
    exit;
}

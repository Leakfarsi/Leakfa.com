<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'leakfa');
define('DB_USER', 'leakfa');
define('DB_PASS', 'leakfa');
define('DB_TIMEZONE', 'Asia/Tehran');
define('DB2_HOST', 'localhost');
define('DB2_NAME', 'leakfa');
define('DB2_USER', 'leakfa');
define('DB2_PASS', 'leakfa');
define('DB2_TIMEZONE', 'Asia/Tehran');

define('SMTP_HOST', 'smtp.mail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'username');
define('SMTP_PASS', 'password');
define('SMTP_SEME', 'tls');
define('SMTP_EMAIL', 'noreplay@leakfa.com');
define('SMTP_NICK', 'Leakfa');

define('RECAPTCHA_SITE_KEY', '');
define('RECAPTCHA_SECRET_KEY', '');

define('EMAIL_VERIFICATION_SUBJECT', 'Please verify your email address');
define('EMAIL_VERIFICATION_CONTENT', 'Hi, §name§<br/><br/>Thanks for joining Leakfa. To finish subscription, please click the link below to verify your email address.<br/><a href="https://leakfa.com/verify.php?code=§code§">https://leakfa.com/verify.php?code=§code§</a><br/><br/>If a large-scale personal leak is discovered after subscription, you will be notified immediately.<br/>If you have any question, please contact us at: info@leakfa.com<br/><br/>Leakfa Team');
define('EMAIL_TEST_SUBJECT', 'Leakfa Notification Test');
define('EMAIL_TEST_CONTENT', 'Hi, §name§<br/><br/>This is the test letter sent by the system<br/><br/>Thanks for your use');

define('POW_DIFF', 5);

$connection_string = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
$db = new PDO($connection_string, DB_USER, DB_PASS);
$connection_string2 = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB2_HOST, DB2_NAME);
$db2 = new PDO($connection_string2, DB2_USER, DB2_PASS);

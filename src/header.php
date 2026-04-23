<?php
require 'config.php';
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com https://challenges.cloudflare.com https://www.googletagmanager.com https://www.google-analytics.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data: https:; connect-src 'self' https://challenges.cloudflare.com https://www.google-analytics.com; font-src 'self'; frame-src https://challenges.cloudflare.com;");
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8" />
        <title><?= isset($title) ? $title . ' | ' : '' ?>سامانه ردیابی نشت اطلاعات ایرانیان</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" />
        <link rel="stylesheet" type="text/css" href="/styles/main.css" />
      
      	<!-- Favicon -->
		<link rel="icon" type="image/png" href="/images/fav/favicon-96x96.png" sizes="96x96" />
		<link rel="icon" type="image/svg+xml" href="/images/fav/favicon.svg" />
		<link rel="shortcut icon" href="/images/fav/favicon.ico" />
		<link rel="apple-touch-icon" sizes="180x180" href="/images/fav/apple-touch-icon.png" />
		<meta name="apple-mobile-web-app-title" content="Leakfa" />
		<link rel="manifest" href="/images/fav/site.webmanifest" />
      
      	<!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/gh/emn178/js-sha1/build/sha1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
        function onTurnstileLoad() {
            if (typeof initTurnstileWidget === 'function') {
                initTurnstileWidget();
            }
        }
        </script>
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onTurnstileLoad" async defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/js/detectIE.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php include 'src/og.php'; ?>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/images/logo.svg" width="30" height="30" class="d-inline-block align-top" style="filter: invert(1);" alt="Leakfa" />
                    لیک‌فا | Leakfa
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <?php $uri = $_SERVER['REQUEST_URI']; ?>
                        <li class="nav-item <?= $uri == '/search.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="search.php">جستجوی نشت</a>
                        </li>
                        <li class="nav-item <?= $uri == '/leaks.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="leaks.php">فهرست نشت‌ها</a>
                        </li>
			            <li class="nav-item <?= $uri == '/notify.php' ? 'active' : '' ?>">
				            <a class="nav-link" href="notify.php">باخبرم کن</a>
			            </li>
                        <li class="nav-item <?= $uri == '/donate.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="donate.php">حمایت مالی</a>
                        </li>
                        <li class="nav-item <?= $uri == '/faq.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="faq.php">سوالات متداول</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">سایر</a>
                            <div class="dropdown-menu">
							    <a class="dropdown-item <?= $uri == '/policy.php' ? 'active' : '' ?>" href="policy.php">خط مشی</a>
                                <a class="dropdown-item <?= $uri == '/about.php' ? 'active' : '' ?>" href="about.php">درباره ما</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item <?= $uri == '/stat.php' ? 'active' : '' ?>" href="stat.php">آمار ها</a>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-2 my-lg-0" style="flex-direction: row;">
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="https://t.me/leakfarsi" target="_blank" rel="noopener noreferrer">
                                <img src="/images/telegram.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="Telegram" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="https://www.youtube.com/leakfarsi" target="_blank" rel="noopener noreferrer">
                                <img src="/images/youtube.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="Youtube" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="https://twitter.com/leakfarsi" target="_blank" rel="noopener noreferrer">
                                <img src="/images/twitter.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="Twitter" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="mailto:info@leakfa.com">
                                <img src="/images/email.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="Email" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="https://github.com/Leakfarsi/Leakfa.com" target="_blank" rel="noopener noreferrer">
                                <img src="/images/github.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="Github" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<?php
require 'config.php';
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com https://challenges.cloudflare.com https://static.cloudflareinsights.com https://www.googletagmanager.com https://www.google-analytics.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data: https:; connect-src 'self' https://challenges.cloudflare.com https://www.google-analytics.com https://*.google-analytics.com https://static.cloudflareinsights.com; font-src 'self'; frame-src https://challenges.cloudflare.com;");
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8" />
        <title><?= isset($title) ? $title . ' | ' : '' ?>سامانه ردیابی نشت اطلاعات ایرانیان</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css" />
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/js/detectIE.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php include 'src/og.php'; ?>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/images/logo.svg" width="30" height="30" class="d-inline-block align-top" style="filter: invert(1);" alt="Leakfa" />
                    لیک‌فا | Leakfa
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-bar"></span>
                    <span class="toggler-bar"></span>
                    <span class="toggler-bar"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <?php $uri = $_SERVER['REQUEST_URI']; ?>
                        <li class="nav-item <?= $uri == '/' ? 'active' : '' ?>">
                            <a class="nav-link" href="/">
                                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                جستجوی نشت
                            </a>
                        </li>
                        <li class="nav-item <?= $uri == '/leaks.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="leaks.php">
                                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                فهرست نشت‌ها
                            </a>
                        </li>
                        <li class="nav-item <?= $uri == '/notify.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="notify.php">
                                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                باخبرم کن
                            </a>
                        </li>
                        <li class="nav-item <?= $uri == '/donate.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="donate.php">
                                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                حمایت مالی
                            </a>
                        </li>
                        <li class="nav-item <?= $uri == '/faq.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="faq.php">
                                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                سوالات متداول
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                سایر
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item <?= $uri == '/policy.php' ? 'active' : '' ?>" href="policy.php">خط مشی</a>
                                <a class="dropdown-item <?= $uri == '/about.php' ? 'active' : '' ?>" href="about.php">درباره ما</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item <?= $uri == '/stat.php' ? 'active' : '' ?>" href="stat.php">آمار ها</a>
                            </div>
                        </li>
                    </ul>
                    <div class="nav-social-divider d-lg-none"></div>
                    <ul class="navbar-nav nav-social my-2 my-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="https://t.me/leakfarsi" target="_blank" rel="noopener noreferrer" title="Telegram">
                                <img src="/images/telegram.svg" width="22" height="22" class="d-inline-block align-top" style="filter: invert(1);" alt="Telegram" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.youtube.com/leakfarsi" target="_blank" rel="noopener noreferrer" title="Youtube">
                                <img src="/images/youtube.svg" width="22" height="22" class="d-inline-block align-top" style="filter: invert(1);" alt="Youtube" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://twitter.com/leakfarsi" target="_blank" rel="noopener noreferrer" title="Twitter">
                                <img src="/images/twitter.svg" width="22" height="22" class="d-inline-block align-top" style="filter: invert(1);" alt="Twitter" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mailto:info@leakfa.com" title="Email">
                                <img src="/images/email.svg" width="22" height="22" class="d-inline-block align-top" style="filter: invert(1);" alt="Email" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/Leakfarsi/Leakfa.com" target="_blank" rel="noopener noreferrer" title="Github">
                                <img src="/images/github.svg" width="22" height="22" class="d-inline-block align-top" style="filter: invert(1);" alt="Github" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<?php
require 'config.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= isset($title) ? $title . ' | ' : '' ?>سامانه ردیابی نشت اطلاعات ایرانیان</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/styles/index.css" />
        <link rel="stylesheet" type="text/css" href="/styles/rtl.css">
        <link rel="icon" href="/images/logo.svg" />
        <link rel="icon" href="/images/logo.png" />
        <script src="https://cdn.jsdelivr.net/gh/emn178/js-sha1/build/sha1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="/js/detectIE.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php include 'src/og.php'; ?>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="/images/logo.svg" width="30" height="30" class="d-inline-block align-top" style="filter: invert(1);" alt="" />
                    لیک‌فا | Leakfa
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <?php $uri = $_SERVER['REQUEST_URI']; ?>
                        <li class="nav-item <?= $uri == '/search.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="search.php">جستجوی نشت</a>
                        </li>
                        <li class="nav-item <?= $uri == '/leaks.php' ? 'active' : '' ?>">
                            <a class="nav-link" href="leaks.php">نشت‌های عمده</a>
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
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">سایر</a>
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
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="https://www.youtube.com/leakfarsi" target="_blank">
                                <img src="/images/youtube.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="https://twitter.com/leakfarsi" target="_blank">
                                <img src="/images/twitter.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="mailto:info@leakfa.com" target="_blank">
                                <img src="/images/email.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="" />
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="padding-right: 0.5rem; padding-left: 0.5rem;" href="https://github.com/Leakfarsi/Leakfa.com" target="_blank">
                                <img src="/images/github.svg" width="24" height="24" class="d-inline-block align-top" style="filter: invert(1);" alt="" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </body>
</html>

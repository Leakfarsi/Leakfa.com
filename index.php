<?php include 'src/config.php'; ?>
<!DOCTYPE HTML>
<html lang="fa" dir="rtl">
<head>
	<title>Leakfa | سامانه ردیابی نشت اطلاعات ایرانیان</title>
	<meta charset="utf-8">
	<meta name="description" content="این سرویس یک سامانه ردیابی و جستجوی نشت اطلاعات شخصی ویژه کاربران ایرانی است. با بررسی نقض‌های امنیتی بزرگ، به شما اطلاع می‌دهد که آیا اطلاعاتتان در معرض افشا قرار گرفته است یا خیر. همچنین با ارائه راهکارهای امنیتی، به افزایش آگاهی و سواد سایبری کاربران کمک می‌کند.">
	<meta name="keywords" content="Leakfa, Iranian leakage, data breach tracking, لیکفا, نشت اطلاعات, سامانه ردیابی">
	<meta name="robots" content="index, follow">
	<meta name="author" content="Leakfa Team">
	<meta property="og:title" content="Leakfa | لیک‌فا">
	<meta property="og:description" content="سامانه ردیابی نشت اطلاعات ایرانیان">
	<meta property="og:image" content="https://leakfa.com/images/og-image.png">
	<meta property="og:url" content="https://leakfa.com/">
	<meta property="og:type" content="website">
	<meta name="twitter:card" content="summary_large_image">
	<link rel="canonical" href="https://leakfa.com/">
  
  	<!-- Favicon -->
	<link rel="icon" type="image/png" href="/images/fav/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="/images/fav/favicon.svg" />
	<link rel="shortcut icon" href="/images/fav/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="/images/fav/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="Leakfa" />
	<link rel="manifest" href="/images/fav/site.webmanifest" />
  
  	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" rel="stylesheet">
  
  	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  	<!-- Mobile Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  	<!-- Structured Data -->
	<script type="application/ld+json">
	{
     "@context": "https://schema.org",
     "@type": "WebSite",
     "name": "Leakfa: Iranian Data Breach Monitoring System",
     "description": "سامانه ردیابی نشت اطلاعات ایرانیان",
     "url": "https://leakfa.com/"
	}
	</script>
  
  	<!-- Styles -->
	<style>
    html,
    body {
        height: 100%;
        width: 100%;
        color: #FFF;
        font-family: 'Lalezar', cursive;
        direction: rtl;
        margin: 0;
        padding: 0;
    }

    body {
        background: url('images/background.webp') no-repeat center center / cover fixed;
    }

    #container {
        position: absolute;
        width: 100%;
        height: 100%;
        background: radial-gradient(ellipse at center, rgb(27 27 27 / 50%) 0%, rgb(27 27 27 / 65%) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        animation: fadeIn 2s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    h1 {
        font-size: 70px;
        font-weight: bold;
        animation: slideUp 1s ease-out;
    }

    h3 {
        font-size: 32px;
        animation: slideUp 1.2s ease-out;
    }

    .btn {
        border: 2px solid #f8f9fa;
        font-weight: bold;
        transition: transform 0.3s ease;
        animation: slideUp 1.4s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .btn:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 28px;
        }

        h3 {
            font-size: 16px;
        }
    }
</style>
</head>

<body>
	<div id="container">
		<h1>Leakfa</h1>
		<h3>سامانه ردیابی نشت اطلاعات ایرانیان</h3>
		<br/>
		<div>
			<a href="search.php" class="btn btn-outline-light">جستجوی نشت</a>
			<a href="about.php" class="btn btn-outline-light">درباره ما</a>
		</div>
	</div>
</body>

</html>

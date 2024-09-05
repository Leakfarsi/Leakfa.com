<?php include 'src/config.php'; ?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Leakfa: Iranian Leakage Tracking System | لیکفا: سامانه ردیابی نشت اطلاعات ایرانیان</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include 'src/og.php'; ?>
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
        background-image: url('images/bg/6102022.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
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
			<a href="search" class="btn btn-outline-light">جستجوی نشت</a>
			<a href="about" class="btn btn-outline-light">درباره ما</a>
		</div>
	</div>
</body>

</html>

<?php $title = 'حمایت مالی';
        require 'src/header.php';
    ?>

<header class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1><?=$title?></h1>
    </div>
</header>

<div class="padded container">
	<h1 class="breach-title">حمایت مالی از سرویس</h1>
    <p> لیکفا به ارائه خدمات رایگان و بدون تبلیغات خود ادامه می‌دهد اما توسعه و حفظ کیفیت سرویس‌ها، نیازمند کمک‌های مالی شماست. در بخش زیر آدرس ولت های مختلف برای شما ارائه شده، برای انتخاب کافیست بر روی آدرس مورد نظر کلیک کرده تا به صورت خودکار در کلیپ‌بورد شما کپی شود.</p>
    <div class="donate-crypto-widget">
        <div class="coin-chooser">
            <div class="left-arrow change-coin-arrow" onclick="prevCoin()">&#9654;</div>
            <div id="coins-container">
                <img id="coin-logo" class="coin-logo" src="images/donate/btcButtonLogo.png" alt="Bitcoin" />
            </div>
            <div class="right-arrow change-coin-arrow" onclick="nextCoin()">&#9664;</div>
        </div>
        <div id="address-display">
            <input type="text" id="address-text" class="address-display" value="bc1qacqns7cvsr3t7nm6tlpamss7xnk7yffqtl6ydx" readonly onclick="copyAddress()" />
            <img id="qr" src="images/donate/btcQR.png" alt="QR Code" class="address-display" />
            <span id="copy-message" class="copy-message">!Copied to clipboard</span>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/donate.js"></script>
<link rel="stylesheet" href="styles/donate.css" />

<?php require 'src/footer.php'; ?>

<?php $title = 'حمایت مالی';
        require 'src/header.php';
    ?>

<header class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1><?=$title?></h1>
    </div>
</header>

<script type="text/javascript" src="js/dialog_box.js"></script>
<link rel="stylesheet" href="styles/donate.css" />
    <div class="padded container">
        <h1 class="breach-title">حمایت مالی از سرویس</h1>
        <p>لیکفا، یک سرویس رایگان و بدون تبلیغات برای مردم، اما مدیریت آن برای ما بدون داشتن حامی بسیار پرهزینه و دشوار است، شما میتوانید برای حمایت از کار ما با ارسال بیت کوین به روند پیشرفت و رشد سرویس کمک کنید!
            <p/>
            <p>با کلیک بر روی دکمه "Bitcoin" یک کادر محاوره ای با آدرس BTC برای ارسال آسان از هر کیف پولی نمایش داده می شود.</p>
            <p id="msg" class="text"></p>
            <div align="center">
                    <img src="images/bitcoin.png" height="250" width="250" border="0" alt="Bitcoin QR Code"><br/><button onclick="myFunction()" class="Button">Bitcoin</button>
            </div>
    </div>

<?php require 'src/footer.php'; ?>

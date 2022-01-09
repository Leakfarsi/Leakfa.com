<?php $title = 'تأیید ایمیل';
        require 'src/header.php';
        require 'src/common.php';
    ?>

    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 ><?=$title?></h1>
        </div>
    </header>

    <div class="container" style="max-width: 600px;margin: 10px auto;">
        <?php
            $status = verify_code($_GET['code']);
            if($status == 1){
        ?>
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">تأیید ایمیل به پایان رسید</h5>
                <p class="card-text">اگر نشتی از اطلاعات شخصی شما در مقیاس بزرگ پیدا شد، بلافاصله به شما اطلاع داده می شود.</p>
                <a href="/about.php" class="btn btn-dark">اطلاعات بیشتری را در مورد ما بدانید</a>
            </div>
        </div>
        <?php
            }else if($status == 0){
        ?>
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">ایمیل قبلا تایید شده است</h5>
                <a href="/" class="btn btn-dark">بازگشت به خانه</a>
            </div>
        </div>
        <?php
            }else{
        ?>
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">ممکن است اشتراک لغو شده باشد، لطفا <a href="/notify">دوباره مشترک شوید</a> اگر اشتراک لغو نشده و این پیام به طور مکرر ظاهر می شود، لطفاً مدیریت را مطلع کنید.</h5>
                <a href="/" class="btn btn-dark">بازگشت به خانه</a>
            </div>
        </div>
        <?php
            }
        ?>
    </div>

<?php $title = 'باخبرم کن';
    require 'src/header.php';
    ?>

    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1><?= $title ?></h1>
        </div>
    </header>

    <div class="padded container searchForm">
        <h1 class="breach-title">مشاهده، تغییر یا لغو اشتراک</h1>
        <p>اشتراک در سرویس باخبرم کن این امکان را به ما می دهد تا اگر نشتی از اطلاعات شخصی شما در مقیاس بزرگ پیدا کردیم، بلافاصله آن را به شما اطلاع دهیم.</p>
        <form id="subscription_status_form">
            <div class="form-group">
                <label for="email">آدرس ایمیل</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com" autocomplete="off" required />
            </div>
            <button class="btn btn-outline-dark btn-block" type="submit" id="query">ادامه</button>
            <p>فشار دادن دکمه ادامه به این معنی است که <a href="/policy">خط مشی </a>وب سایت را خوانده و قبول دارید.</p>
        </form>
    </div>

    <div class="padded container unSubForm" style="display:none">
        <h1 class="breach-title">لغو اشتراک</h1>
        <div class="alert alert-light text-center" role="alert">
            این آدرس ایمیل قبلا برای باخبر شدن <span style="color: green;">ثبت شده</span> لطفا برای لغو اشتراک، اطلاعات مورد نیاز را وارد کنید.
        </div>
        <p>ابتدا داده‌ها کدگذاری شده و سپس نتایج عملیات به شما نشان داده می شود. </p>
        <form id="unsubscribe_form">
            <div class="form-group">
                <label for="phone">شماره تلفن همراه</label>
                <input type="text" class="form-control" id="unsubscribe_form_phone" maxlength="11" placeholder="E.g. 09123456789" autocomplete="off" required />
            </div>
            <div class="form-group">
                <label for="unsubscribe_form_email">آدرس ایمیل</label>
                <input type="email" class="form-control" id="unsubscribe_form_email" placeholder="name@example.com" required disabled />
                <button type="button" class="btn btn-link" onclick="location.reload()">بازگشت به مرحله قبل</button>
            </div>
            <button class="btn btn-outline-danger btn-block" type="submit" id="unsubscribe">لغو اشتراک</button>
        </form>
    </div>
    <div class="padded container subForm" style="display:none">
        <h1 class="breach-title">فرم اشتراک</h1>
        <div class="alert alert-light text-center" role="alert">
            این آدرس ایمیل هنوز برای باخبر شدن <span style="color: red;">ثبت نشده</span> لطفا برای مشترک شدن، اطلاعات مورد نیاز را وارد کنید.
        </div>
        <p>اگر نشتی از اطلاعات شخصی شما در مقیاس بزرگ پیدا شد، بلافاصله به شما اطلاع داده می شود. </p>
        <form id="subscribe_form">
            <div class="form-group">
                <label for="subscribe_form_fullname">نام</label>
                <input type="text" class="form-control" id="subscribe_form_fullname" placeholder="E.g. John" required />
            </div>
            <div class="form-group">
                <label for="subscribe_form_phone">تلفن همراه</label>
                <input type="text" class="form-control" id="subscribe_form_phone" maxlength="11" placeholder="E.g. 09123456789" autocomplete="off" required />
            </div>
            <div class="form-group">
                <label for="subscribe_form_email">آدرس ایمیل</label>
                <input type="email" class="form-control" id="subscribe_form_email" placeholder="name@example.com" required disabled />
                <button type="button" class="btn btn-link" onclick="location.reload()">بازگشت به مرحله قبل</button>
            </div>
            <button class="btn btn-outline-primary btn-block" type="submit" id="subscribe">ثبت اشتراک</button>
        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= RECAPTCHA_SITE_KEY ?>"></script>
    <script>
        const RECAPTCHA_SITE_KEY = '<?= RECAPTCHA_SITE_KEY ?>'
    </script>
    <script src="/js/main.js"></script>

    <script>
        $('#subscribe_form').on("submit", function(e) {
            e.preventDefault();
            let el = e.target;
            subscribe_func(el);
        });

        $('#subscription_status_form').on("submit", function(e) {
            e.preventDefault();
            let el = e.target;
            subscription_status_func(el);
        });

        $('#unsubscribe_form').on("submit", function(e) {
            e.preventDefault();
            let el = e.target;
            unsubscribe_func(el);
        });
    </script>

    <?php require 'src/footer.php'; ?>

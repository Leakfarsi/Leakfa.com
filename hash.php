<?php $title = 'جستجوی نشت';
        require 'src/header.php';
    ?>

    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 ><?=$title?></h1>
        </div>
    </header>

    <div class="padded container">
        <h1 class="breach-title">هش ساز</h1> 
        <p>این روش برای جلوگیری از ارسال مستقیم اطلاعات به سمت ما طراحی شده، پس از وارد کردن شماره تلفن‌همراه یا آدرس ایمیل هش تولید شده را جستجو کنید. روش ساخت هش بر اساس الگوریتم<span style="color: red;"> SHA-1</span> می باشد.<br/>اگر هنوز شک دارید، لطفاً از سرویس استفاده نکنید!</p>
        <form id="search_step_form">
            <div class="form-group ">
                <label for="phone" >تلفن همراه یا آدرس ایمیل</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="phone" 
                    maxlength="255"  
                    placeholder="E.g. 09123456789" 
                    style="text-transform:lowercase"
                    placeholder="E.g. 09123456789"  
                    autocomplete="off" 
                    autocapitalize="off"
                    autocorrect="off"
                    required 
                    oninvalid="this.setCustomValidity('ابتدا تلفن همراه یا آدرس ایمیل را وارد کنید')"
                    oninput="this.setCustomValidity('')" 
                    />
            </div>
            <button type="submit" id="genhash" class="btn btn-outline-dark btn-block">تولید کردن</button>
        </form>
        <br/>
        <br/>
        <h1 class="breach-title">فرم جستجو</h1> 
        <form id="search_hash_form">
            <div class="form-group">
                <label for="hash" >کد هش</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="hash" 
                    maxlength="40" 
                    required />
            </div>
            <button type="submit" id="search" class="btn btn-outline-dark btn-block">جستجو</button>
        </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js?render=<?=RECAPTCHA_SITE_KEY?>"></script>
    <script>const RECAPTCHA_SITE_KEY='<?= RECAPTCHA_SITE_KEY?>'</script>
    <script src="/js/main.js"></script>

    <script>
        $('#search_step_form').on("submit", function(e) {
            e.preventDefault();
            let el = e.target;
            gen_sha1(el);
        });

        $('#search_hash_form').on("submit", function(e) {
            e.preventDefault();
            let el = e.target;
            two_step(el);
        });
    </script>

    <?php require 'src/footer.php'; ?>

<?php $title = 'جستجوی نشت';
        require 'src/header.php';
    ?>

    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 ><?=$title?></h1>
        </div>
    </header>

    <div class="padded container">
        <h1 class="breach-title">سوابق نشت را جستجو کنید</h1>
        <p>برای جستجوی سوابق نشت، لطفا شماره تلفن‌همراه یا آدرس ایمیل خود را وارد کنید. برای جلوگیری از ارسال مستقیم اطلاعات، سامانه ابتدا داده‌ها را کدگذاری می کند و سپس نتایج عملیات را به شما نشان می دهد. <br/>هنوز نگران هستید؟ <a href="hash">در اینجا نسخه‌ای با عملیات جداگانه وجود دارد.</a></p>
        <form id="search_form">
            <div class="form-group">
                <label for="phone">تلفن همراه یا آدرس ایمیل</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="phone"  
                    maxlength="255" 
                    style="text-transform:lowercase"
                    placeholder="E.g. 09123456789"  
                    autocomplete="off" 
                    autocapitalize="off"
                    autocorrect="off"
                    required 
                    />
            </div>
            <button type="submit" id="search" class="btn btn-outline-dark btn-block">جستجو</button>
        </form>
            <div id="searchResults"></div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js?render=<?=RECAPTCHA_SITE_KEY?>"></script>
    <script>const RECAPTCHA_SITE_KEY='<?= RECAPTCHA_SITE_KEY?>'</script>
    <script src="/js/main.js"></script>

    <script>
        $('#search_form').on("submit", function(e) {
            e.preventDefault();
            let el = e.target;
            one_step(el);
        });
    </script>

    <?php require 'src/footer.php'; ?>

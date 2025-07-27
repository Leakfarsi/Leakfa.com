    <?php $title = 'جستجوی نشت';
        require 'src/header.php';
    ?>
    
    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 ><?=$title?></h1>
        </div>
    </header>

    <div class="padded container">
        <h1 class="breach-title">آیا اطلاعات شما در معرض خطر است؟</h1>
        <p>برای بررسی نشت اطلاعات، لطفاً شماره تلفن همراه یا آدرس ایمیل خود را وارد کنید. برای حفظ امنیت و حریم خصوصی شما، این سامانه ابتدا داده‌ها را رمزگذاری کرده و سپس نتیجه را نمایش می‌دهد. <br/>نگران امنیت اطلاعات خود هستید؟ <a href="hash">می‌توانید از نسخه‌ای با پردازش جداگانه استفاده کنید.</a></p>
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
    <script>const TURNSTILE_SITE_KEY='<?= TURNSTILE_SITE_KEY?>'</script>
    <script src="/js/main.js"></script>

    <script>
        $('#search_form').on("submit", function(e) {
            e.preventDefault();
            let el = e.target;
            one_step(el);
        $('#phone').val('');
        });
    </script>

<?php require 'src/footer.php'; ?>

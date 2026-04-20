<?php $title = 'جستجوی نشت';
    require 'src/header.php';
?>

<section class="search-hero">
    <div class="search-hero-bg"></div>
    <div class="container search-hero-content">
        <div class="search-hero-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <path d="M9 12l2 2 4-4"/>
            </svg>
        </div>
        <h1 class="search-hero-title">آیا اطلاعات شما در معرض خطر است؟</h1>
        <p class="search-hero-subtitle">شماره تلفن یا ایمیل خود را وارد کنید تا بررسی کنیم آیا در نشت‌های اطلاعاتی قرار گرفته‌اید.</p>
    </div>
</section>

<div class="search-section">
    <div class="container search-form-wrapper">
        <form id="search_form" class="search-card">
            <div class="search-input-group">
                <div class="search-input-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    class="search-input" 
                    id="phone"  
                    maxlength="255" 
                    style="text-transform:lowercase"
                    placeholder="e.g. 09123456789"  
                    autocomplete="off" 
                    autocapitalize="off"
                    autocorrect="off"
                    required 
                />
            </div>
            <button type="submit" id="search" class="search-btn">
                <span class="search-btn-text">بررسی نشت اطلاعات</span>
                <span class="search-btn-spinner" style="display:none;">
                    <svg class="spinner-svg" viewBox="0 0 24 24" width="20" height="20"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="31.4 31.4" stroke-linecap="round"/></svg>
                </span>
            </button>
        </form>

        <div class="how-it-works">
            <div class="how-step">
                <div class="how-step-num">۱</div>
                <div class="how-step-label">وارد کردن</div>
            </div>
            <div class="how-step-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="19 12 5 12"/><polyline points="12 5 5 12 12 19"/></svg>
            </div>
            <div class="how-step">
                <div class="how-step-num">۲</div>
                <div class="how-step-label">رمزگذاری امن</div>
            </div>
            <div class="how-step-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="19 12 5 12"/><polyline points="12 5 5 12 12 19"/></svg>
            </div>
            <div class="how-step">
                <div class="how-step-num">۳</div>
                <div class="how-step-label">بررسی محرمانه</div>
            </div>
            <div class="how-step-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="19 12 5 12"/><polyline points="12 5 5 12 12 19"/></svg>
            </div>
            <div class="how-step">
                <div class="how-step-num">۴</div>
                <div class="how-step-label">نتیجه</div>
            </div>
        </div>

        <p class="search-alt-link">هنوز نگران هستید؟ <a href="hash">از جستجوی جداگانه استفاده کنید.</a></p>

        <div id="searchResults"></div>
    </div>
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

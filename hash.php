<?php $title = 'جستجوی دو مرحله‌ای';
    require 'src/header.php';
?>

<section class="search-hero">
    <div class="search-hero-bg"></div>
    <div class="container search-hero-content">
        <div class="search-hero-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
        </div>
        <h1 class="search-hero-title">جستجوی دو مرحله‌ای</h1>
        <p class="search-hero-subtitle">در این روش عملیات رمزگذاری و جستجو جدا از هم انجام می‌شود.</p>
    </div>
</section>

<div class="search-section">
    <div class="container search-form-wrapper">

        <div class="hash-step-card">
            <div class="hash-step-header">
                <span class="hash-step-badge">مرحله ۱</span>
                <h2 class="hash-step-title">تولید هش</h2>
            </div>
            <p class="hash-step-desc">شماره تلفن یا ایمیل خود را وارد کنید. هش <code>SHA-1</code> آن به صورت محلی در مرورگر شما تولید می‌شود. هیچ چیزی ارسال نمی‌شود.</p>
            <form id="search_step_form">
                <div class="search-input-group">
                    <div class="search-input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        class="search-input" 
                        id="phone" 
                        maxlength="255"  
                        placeholder="e.g. 09123456789 or john@example.com" 
                        style="text-transform:lowercase" 
                        autocomplete="off" 
                        autocapitalize="off"
                        autocorrect="off"
                        required 
                    />
                </div>
                <button type="submit" id="genhash" class="search-btn hash-gen-btn">
                    <span>تولید هش</span>
                </button>
            </form>
        </div>

        <div class="hash-step-connector">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <polyline points="19 12 12 19 5 12"/>
            </svg>
        </div>

        <div class="hash-step-card">
            <div class="hash-step-header">
                <span class="hash-step-badge">مرحله ۲</span>
                <h2 class="hash-step-title">جستجوی هش</h2>
            </div>
            <p class="hash-step-desc">هش تولید شده در فیلد زیر قرار می‌گیرد. می‌توانید آن را بررسی کرده و سپس جستجو کنید.</p>
            <form id="search_hash_form">
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
                        id="hash" 
                        maxlength="40" 
                        placeholder="e.g. a9993e364706816aba3e25717850c26c9cd0d89d"
                        required 
                    />
                </div>
                <button type="submit" id="search" class="search-btn">
                    <span class="search-btn-text">جستجو</span>
                    <span class="search-btn-spinner" style="display:none;">
                        <svg class="spinner-svg" viewBox="0 0 24 24" width="20" height="20"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="31.4 31.4" stroke-linecap="round"/></svg>
                    </span>
                </button>
            </form>
        </div>

        <p class="search-alt-link">می‌خواهید سریع‌تر بررسی کنید؟ <a href="/">از جستجوی یک‌مرحله‌ای استفاده کنید.</a></p>

    </div>
</div>

<script>const TURNSTILE_SITE_KEY='<?= TURNSTILE_SITE_KEY?>'</script>
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

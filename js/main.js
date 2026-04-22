/*
Author:         Leakfa Team
Author URI:     https://leakfa.com
Version:        4.2.0
*/

function setCookie(cname, cvalue, exdays) {
    try {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    } catch (error) {
        console.error('Error setting cookie:', error);
    }
}

function getCookie(cname) {
    try {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    } catch (error) {
        console.error('Error getting cookie:', error);
        return "";
    }
}

function checkPopupDisplayed() {
    var popupDisplayed = getCookie("popupDisplayed");
    return popupDisplayed === "true";
}

function displayPopup() {
    setCookie("popupDisplayed", "true", 30); // Expire in 30 days
    Swal.fire({
       icon: 'info',
       title: 'نکته مهم:',
       confirmButtonText: "باشه", 
       width:'90%',
       html: '<p>هنگام وارد کردن شماره تلفن همراه از کیبورد اعداد انگلیسی و هنگام وارد کردن آدرس ایمیل از حروف کوچک برای نگارش استفاده کنید، در غیر این صورت هش متفاوتی تولید شده و نتیجه دیگری به شما نمایش داده می‌شود.</p>'
    });
}

if (!checkPopupDisplayed()) {
   displayPopup();
}

// Turnstile widget
document.addEventListener('DOMContentLoaded', function() {
    if (typeof turnstile !== 'undefined') {
        initTurnstileWidget();
    }
});

const delay = s => {
    return new Promise(function (resolve, reject) {
        setTimeout(resolve, s);
    });
};

Object.size = function (obj) {
    return Object.keys(obj).length;
};

function escapeHtml(str) {
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function one_step(form) {
    $('.search-btn-text').hide();
    $('.search-btn-spinner').show();
    search_by_core(sha1(form.phone.value));
}

function resetSearchButton() {
    $('.search-btn-spinner').hide();
    $('.search-btn-text').show().text('بررسی نشت اطلاعات');
    $('#search').removeAttr('disabled');
}

// Share Result
function getShareButtons() {
    return `
    <div class="share-bar">
        <span class="share-bar-label">اشتراک‌گذاری نتیجه:</span>
        <div class="share-bar-buttons">
            <button type="button" class="share-btn share-btn-save" onclick="captureResult('save')" title="ذخیره تصویر">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span>ذخیره</span>
            </button>
            <button type="button" class="share-btn share-btn-telegram" onclick="captureResult('telegram')" title="اشتراک در تلگرام">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                <span>تلگرام</span>
            </button>
            <button type="button" class="share-btn share-btn-twitter" onclick="captureResult('twitter')" title="اشتراک در توییتر">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                <span>توییتر</span>
            </button>
            <button type="button" class="share-btn share-btn-instagram" onclick="captureResult('instagram')" title="اشتراک در اینستاگرام">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                <span>اینستاگرام</span>
            </button>
        </div>
    </div>`;
}

var SHARE_TEXT = 'نتیجه بررسی نشت اطلاعات من در لیک‌فا\n\n#leakfa #لیکفا';

async function captureResult(action) {
    var card = document.querySelector('.search-result-card');
    if (!card) return;

    var isDanger = card.classList.contains('danger');
    var iconColor = isDanger ? '#dc2626' : '#16a34a';
    var iconBg = isDanger ? '#fee2e2' : '#dcfce7';

    var wrapper = document.createElement('div');
    wrapper.style.cssText = 'position:fixed;top:-9999px;left:-9999px;background:#fff;padding:24px;border-radius:16px;width:' + Math.min(card.offsetWidth + 48, 600) + 'px;direction:rtl;font-family:Vazir,sans-serif;';
    
    var clone = card.cloneNode(true);
    var cloneShareBar = clone.querySelector('.share-bar');
    if (cloneShareBar) cloneShareBar.remove();
    var cloneFooter = clone.querySelector('.result-footer-links');
    if (cloneFooter) cloneFooter.remove();
    clone.style.animation = 'none';
    clone.style.opacity = '1';
    clone.style.transform = 'none';
    clone.style.margin = '0';

    var iconDiv = clone.querySelector('.result-icon');
    if (iconDiv) {
        iconDiv.style.background = iconBg;
        iconDiv.style.width = '72px';
        iconDiv.style.height = '72px';
        iconDiv.style.borderRadius = '50%';
        iconDiv.style.display = 'flex';
        iconDiv.style.alignItems = 'center';
        iconDiv.style.justifyContent = 'center';
        iconDiv.style.margin = '0 auto 16px auto';
        iconDiv.style.direction = 'ltr';
        var svgMarkup;
        if (isDanger) {
            svgMarkup = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="' + iconColor + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
        } else {
            svgMarkup = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="' + iconColor + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
        }
        var iconImg = document.createElement('img');
        iconImg.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgMarkup)));
        iconImg.width = 36;
        iconImg.height = 36;
        iconDiv.innerHTML = '';
        iconDiv.appendChild(iconImg);
    }

    clone.querySelectorAll('.breach-list-item-icon').forEach(function(iconSpan) {
        var breachSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
        var img = document.createElement('img');
        img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(breachSvg)));
        img.width = 18;
        img.height = 18;
        iconSpan.innerHTML = '';
        iconSpan.appendChild(img);
    });

    wrapper.appendChild(clone);

    var watermark = document.createElement('div');
    watermark.style.cssText = 'display:flex;align-items:center;justify-content:center;gap:8px;margin-top:16px;padding-top:14px;border-top:1px solid #e0e0e0;color:#3f617b;font-size:13px;font-weight:500;';
    watermark.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#3f617b" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg> <span style="color:#3f617b;">لیک‌فا - leakfa.com</span>';
    wrapper.appendChild(watermark);

    document.body.appendChild(wrapper);

    try {
        var canvas = await html2canvas(wrapper, {
            backgroundColor: '#ffffff',
            scale: 2,
            useCORS: true,
            logging: false
        });

        document.body.removeChild(wrapper);

        if (action === 'save') {
            var link = document.createElement('a');
            link.download = 'leakfa-result.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        } else if (action === 'telegram' || action === 'twitter' || action === 'instagram') {
            canvas.toBlob(async function(blob) {
                var file = new File([blob], 'leakfa-result.png', { type: 'image/png' });
                
                if (navigator.share && navigator.canShare && navigator.canShare({ files: [file] })) {
                    try {
                        await navigator.share({
                            title: 'نتیجه بررسی نشت اطلاعات - لیک‌فا',
                            text: SHARE_TEXT,
                            files: [file]
                        });
                        return;
                    } catch (e) {
                        if (e.name === 'AbortError') return; // User cancelled
                    }
                }
                
                var downloadUrl = URL.createObjectURL(blob);
                var dlLink = document.createElement('a');
                dlLink.download = 'leakfa-result.png';
                dlLink.href = downloadUrl;
                dlLink.click();
                URL.revokeObjectURL(downloadUrl);

                if (action === 'telegram') {
                    var tgText = encodeURIComponent(SHARE_TEXT);
                    window.open('https://t.me/share/url?url=' + encodeURIComponent('https://leakfa.com/search') + '&text=' + tgText, '_blank');
                } else if (action === 'twitter') {
                    var twText = encodeURIComponent(SHARE_TEXT);
                    window.open('https://twitter.com/intent/tweet?text=' + twText, '_blank');
                } else if (action === 'instagram') {
                    showToast('تصویر ذخیره شد! آن را در استوری یا پست اینستاگرام به اشتراک بگذارید.', 'success');
                    return;
                }
                showToast('تصویر ذخیره شد! می‌توانید آن را پیوست کنید.', 'success');
            }, 'image/png');
        }
    } catch (err) {
        document.body.removeChild(wrapper);
        console.error('Capture error:', err);
        showToast('خطا در ایجاد تصویر', 'error');
    }
}

function hideSearchExtras() {
    document.querySelectorAll('.trust-badges, .how-it-works, .search-alt-link').forEach(function(el) {
        el.style.overflow = 'hidden';
        el.style.maxHeight = el.scrollHeight + 'px';
        requestAnimationFrame(function() {
            el.style.transition = 'max-height 0.3s ease, opacity 0.3s ease, margin 0.3s ease';
            el.style.maxHeight = '0';
            el.style.opacity = '0';
            el.style.marginTop = '0';
            el.style.marginBottom = '0';
        });
    });
}

function showSearchExtras() {
    document.querySelectorAll('.trust-badges, .how-it-works, .search-alt-link').forEach(function(el) {
        el.style.transition = 'max-height 0.3s ease, opacity 0.3s ease, margin 0.3s ease';
        el.style.maxHeight = el.scrollHeight + 'px';
        el.style.opacity = '1';
        el.style.removeProperty('margin-top');
        el.style.removeProperty('margin-bottom');
        el.addEventListener('transitionend', function handler() {
            el.style.removeProperty('max-height');
            el.style.removeProperty('overflow');
            el.removeEventListener('transitionend', handler);
        });
    });
}

function incrementSearchCount() {
    var searchCount = parseInt(getCookie("searchCount")) || 0;
    searchCount++;
    setCookie("searchCount", searchCount, 1); // Expire in 1 day
}

function checkSearchLimit() {
    var searchCount = parseInt(getCookie("searchCount")) || 0;
    if (searchCount >= 20) { // Search limit
        showToast("شما به حد مجاز استفاده از جستجوی نشت رسیده‌اید، لطفاً کمی صبر کنید و یا از API استفاده کنید.");
        return true;
    }
    return false;
}

let turnstileWidget = null;
let turnstileContainer = null;

function initTurnstileWidget() {
    if (turnstileWidget === null) {
        turnstileContainer = document.createElement('div');
        turnstileContainer.style.position = 'fixed';
        turnstileContainer.style.top = '-1000px';
        turnstileContainer.style.left = '-1000px';
        turnstileContainer.style.visibility = 'hidden';
        document.body.appendChild(turnstileContainer);
        
        turnstileWidget = turnstile.render(turnstileContainer, {
            sitekey: TURNSTILE_SITE_KEY,
            size: 'normal',
            callback: function(token) {
                window.currentTurnstileToken = token;
            },
            'error-callback': function(error) {
                console.error('Turnstile error:', error);
                window.currentTurnstileToken = null;
            },
            'expired-callback': function() {
                window.currentTurnstileToken = null;
            }
        });
    }
}

function getTurnstileToken() {
    return new Promise((resolve, reject) => {
        if (turnstileWidget === null) {
            initTurnstileWidget();
        }
        
        if (window.currentTurnstileToken) {
            const token = window.currentTurnstileToken;
            window.currentTurnstileToken = null;
            turnstile.reset(turnstileWidget);
            resolve(token);
            return;
        }
        
        let attempts = 0;
        const maxAttempts = 100; // 10 Sec wait
        
        const checkToken = setInterval(() => {
            attempts++;
            
            if (window.currentTurnstileToken) {
                clearInterval(checkToken);
                const token = window.currentTurnstileToken;
                window.currentTurnstileToken = null;
                turnstile.reset(turnstileWidget);
                resolve(token);
            } else if (attempts >= maxAttempts) {
                clearInterval(checkToken);
                reject(new Error('Turnstile timeout'));
            }
        }, 100);
        
        if (!window.currentTurnstileToken) {
            try {
                turnstile.execute(turnstileWidget);
            } catch (e) {
                turnstile.reset(turnstileWidget);
            }
        }
    });
}

async function search_by_core(hash, hashed = false) {
    if (checkSearchLimit()) {
        return;
    }

    incrementSearchCount();

    $('#search').attr('disabled', true);
    if (!hashed) {
        $('#search')[0].blur();
        $('.search-btn-text').text('درحال کدگذاری...');
        showToast('درحال کدگذاری...');
        await delay(700);
        Swal.close();
    }

    showToast('درحال بررسی امنیتی...');
    $('.search-btn-text').text('در حال بررسی امنیتی...');

    try {
        const token = await getTurnstileToken();
        
        showToast('درحال جستجو...');
        $('.search-btn-text').text('در حال جستجو...');
        
        let param = new URLSearchParams({
            "mode": "turnstile",
            "hash": hash,
            "token": token
        });
        
        try {
            const response = await fetch('/api/search.php?' + param.toString());
            const res = await response.json();
            await delay(700);
            Swal.close();
            resetSearchButton();
            await delay(100);
            let searchResultsDiv = document.getElementById('searchResults');
            if (res.status == 0) {
                if (Object.size(res.result) > 0) {
                    let breach = [];
                    Object.keys(res.result).forEach(function(source) {
                        breach.push(escapeHtml(source) + ': ' + res.result[source].map(escapeHtml).join('، '));
                    });
                    let breachItems = breach.map(item => `
                        <li class="breach-list-item">
                            <span class="breach-list-item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            </span>
                            <span>${item}</span>
                        </li>`).join('');
                    let resultsHTML = `
                <div class="search-result-card danger">
                    <div class="result-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h2 class="result-title">اوه نه، خبر بد!</h2>
                    <p class="result-description">یه ردی از اطلاعات شما در نشت‌های داده پیدا کردیم...🕵️<br/>وقتشه یکم به امنیتش برسی.</p>
                    <ul class="breach-list">${breachItems}</ul>
                    <div class="result-footer-links">
                        <a href="/leaks" class="result-footer-link">📋 فهرست نشت‌ها</a>
                        <a href="/faq#what-should-i-do-if-leaked" class="result-footer-link">❓ باید چکار کنم؟</a>
                    </div>
                    ${getShareButtons()}
                </div>`;
                    searchResultsDiv.innerHTML = resultsHTML;
                    hideSearchExtras();
                    setTimeout(function() {
                        searchResultsDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 350);
                } else {
                    let resultsHTML = `
                <div class="search-result-card success">
                    <div class="result-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h2 class="result-title">خبر خوب!</h2>
                    <p class="result-description">فعلاً هیچ ردی از اطلاعات شما در نشت‌های داده پیدا نکردیم...😌<br/>مراقبش باش.</p>
                    <div class="result-footer-links">
                        <a href="/notify" class="result-footer-link">🔔 وقتی نشتی پیدا شد باخبرم کن!</a>
                    </div>
                    ${getShareButtons()}
                </div>`;
                    searchResultsDiv.innerHTML = resultsHTML;
                    hideSearchExtras();
                    setTimeout(function() {
                        searchResultsDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 350);
                }
            } else {
                showToast('خطای سرور: ' + escapeHtml(res.error), 'error');
            }
        } catch (fetchError) {
            resetSearchButton();
            Swal.close();
            showToast('خطا در ارتباط با سرور', 'error');
        }
    } catch (error) {
        resetSearchButton();
        Swal.close();
        showToast('خطا در تأیید امنیتی', 'error');
    }
}

async function gen_sha1(form) {
    $('#hash').val("");
    $('#genhash').text('درحال کدگذاری...').attr('disabled', true);
    showToast('درحال کدگذاری...');
    await delay(700);
    Swal.close();
    $('#genhash').text('تولید کردن').removeAttr('disabled');
    $('#hash').val(sha1(form.phone.value));
}

function two_step(form) {
    search_by_hash(form.hash.value, true);
}

async function search_by_hash(hash, hashed = false) {
    if (checkSearchLimit()) {
        return;
    }

    incrementSearchCount();

    $('#search').attr('disabled', true);
    if (!hashed) {
        $('#search')[0].blur();
        $('#search').text('درحال کدگذاری...')[0];
        showToast('درحال کدگذاری...');
        await delay(700);
        Swal.close();
    }

    showToast('درحال بررسی امنیتی...');
    $('#search').text('در حال بررسی امنیتی...');

    try {
        const token = await getTurnstileToken();
        
        showToast('درحال جستجو...');
        $('#search').text('در حال جستجو...');
        
        let param = new URLSearchParams({
            "mode": "turnstile",
            "hash": hash,
            "token": token
        });
        
        try {
            const response = await fetch('/api/search.php?' + param.toString());
            const res = await response.json();
            await delay(700);
            Swal.close();
            $('#search').text('جستجو').removeAttr('disabled');
            await delay(100);
            if (res.status == 0) {
                if (Object.size(res.result) > 0) {
                    let breach = [];
                    Object.keys(res.result).forEach(function(source) {
                        breach.push(escapeHtml(source) + ': ' + res.result[source].map(escapeHtml).join('، '));
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'اوه نه، یه خبر بد',
                        confirmButtonText: "باشه",
                        html: `ما نشتی از اطلاعات شما پیدا کردیم!<br/><br/><h4>موارد افشا شده</h4>${breach.join('<br/>')}`,
                        footer: '<a href="/notify">باخبرم کن</a>｜<a href="/leaks">فهرست نشت های عمده</a>｜<a href="/faq#what-should-i-do-if-leaked">باید چکار کنم؟</a>'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'خبر خوب!',
                        confirmButtonText: "باشه",
                        html: 'ما هیچ نشتی از اطلاعات شما پیدا نکردیم، اما ممکن است در آینده ای نزدیک اینطور نباشد!<br/>پس با دقت زیادی از داده های خود مراقبت کنید :) ',
                        footer: '<a href="/notify">وقتی نشتی پیدا شد باخبرم کن!</a>'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطای سرور',
                    confirmButtonText: "باشه",
                    text: res.error
                });
            }
        } catch (fetchError) {
            resetSearchButton();
            Swal.close();
            showToast('خطا در ارتباط با سرور', 'error');
        }
    } catch (error) {
        resetSearchButton();
        Swal.close();
        showToast('خطا در تأیید امنیتی', 'error');
    }
}

function subscribe_func(form) {
    $('#subscribe').attr('disabled', true);
    let hash = sha1(form.subscribe_form_phone.value);
    
    showToast('درحال بررسی امنیتی...');
    
    getTurnstileToken().then(function (token) {
        showToast('درحال ثبت اشتراک...');
        
        let formData = new URLSearchParams({
            "hash": hash,
            "email": form.subscribe_form_email.value,
            "name": $('<div>').text(form.subscribe_form_fullname.value).html(),
            "token": token
        });
        fetch('/api/subscribe.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (res) {
                $('#subscribe').removeAttr('disabled');
                Swal.close();
                if (res.status == 0) {
                    if (Object.size(res.result) > 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ثبت اشتراک انجام شد',
                            confirmButtonText: "باشه",
                            html: 'یک لینک تایید به ایمیل شما ارسال شد، لطفا با مراجعه به صندوق ورودی (Inbox) و بازکردن لینک ارسال شده، آدرس خود را تایید کنید. اگرچه نشتی از اطلاعات شخصی شما پیدا شده اما در صورت پیدا شدن نشتی جدید در مقیاس بزرگ، بلافاصله به شما اطلاع داده می شود.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'ثبت اشتراک انجام شد',
                            confirmButtonText: "باشه",
                            html: 'یک لینک تایید به ایمیل شما ارسال شد، لطفا با مراجعه به صندوق ورودی (Inbox) و بازکردن لینک ارسال شده، آدرس خود را تایید کنید. در حال حاضر هیچ نشتی از اطلاعات شخصی شما پیدا نشد، در صورت کشف نشتی جدید در مقیاس بزرگ، بلافاصله به شما اطلاع داده می شود.'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server error',
                        confirmButtonText: "باشه",
                        text: res.error
                    });
                }
            })
            .catch(error => {
                $('#subscribe').removeAttr('disabled');
                Swal.close();
                showToast('خطا در ارتباط با سرور', 'error');
            });
    }).catch(error => {
        $('#subscribe').removeAttr('disabled');
        Swal.close();
        showToast('خطا در تأیید امنیتی', 'error');
    });
}

function subscription_status_func(form) {
    $('#query').attr('disabled', true);
    
    showToast('درحال بررسی امنیتی...');
    
    getTurnstileToken().then(function (token) {
        showToast('درحال بررسی وضعیت...');
        
        let formData = new URLSearchParams({
            "email": form.email.value,
            "token": token
        });
        fetch('/api/subscription_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
            .then(function (res) {
                return res.json();
            }).then(function (res) {
                $('#query').removeAttr('disabled');
                Swal.close();
                if (res.status == 0) {
                    if (res.result == 'not_subscribed') {
                        $('.searchForm').hide();
                        $('.subForm').show();
                        $('#subscribe_form_email').val(form.email.value);
                    } else if (res.result == 'verification_pending') {
                        Swal.fire({
                            icon: 'info',
                            title: 'آدرس تایید نشده',
                            confirmButtonText: "باشه",
                            html: 'این  آدرس ایمیل در سامانه باخبرم کن ثبت شده اما هنوز تایید نشده است، لطفا با مراجعه به صندوق ورودی (Inbox) و بازکردن لینک ارسال شده، آدرس خود را تایید کنید.'
                        });
                    } else if (res.result == 'subscribed') {
                        $('.searchForm').hide();
                        $('.unSubForm').show();
                        $('#unsubscribe_form_email').val(form.email.value);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطایی روی داد',
                        confirmButtonText: "باشه",
                        text: res.error
                    });
                }
            })
            .catch(error => {
                $('#query').removeAttr('disabled');
                Swal.close();
                showToast('خطا در ارتباط با سرور', 'error');
            });
    }).catch(error => {
        $('#query').removeAttr('disabled');
        Swal.close();
        showToast('خطا در تأیید امنیتی', 'error');
    });
}

function unsubscribe_func(form) {
    $('#unsubscribe').attr('disabled', true);
    let hash = sha1(form.unsubscribe_form_phone.value);
    
    showToast('درحال بررسی امنیتی...');
    
    getTurnstileToken().then(function (token) {
        showToast('درحال لغو اشتراک...');
        
        let formData = new URLSearchParams({
            "hash": hash,
            "email": form.unsubscribe_form_email.value,
            "token": token
        });
        fetch('/api/unsubscribe.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
            .then(function (res) {
                return res.json();
            }).then(function (res) {
                $('#unsubscribe').removeAttr('disabled');
                Swal.close();
                if (res.status == 0) {
                    Swal.fire({
                        icon: 'success',
                        title: 'لغو اشتراک انجام شد',
                        confirmButtonText: "باشه",
                        html: 'شما با موفقیت اشتراک خود را از سامانه باخبرم کن لغو کردید. '
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطایی روی داد',
                        confirmButtonText: "باشه",
                        text: res.error
                    });
                }
            })
            .catch(error => {
                $('#unsubscribe').removeAttr('disabled');
                Swal.close();
                showToast('خطا در ارتباط با سرور', 'error');
            });
    }).catch(error => {
        $('#unsubscribe').removeAttr('disabled');
        Swal.close();
        showToast('خطا در تأیید امنیتی', 'error');
    });
}

function showToast(title, type = "info") {
    Swal.fire({
        icon: type,
        title: title,
        toast: true,
        position: 'top-end',
        showConfirmButton: false
    });
}

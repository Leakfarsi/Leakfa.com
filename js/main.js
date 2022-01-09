const delay = s => {
    return new Promise(function (resolve, reject) {
        setTimeout(resolve, s);
    });
};

Object.size = function (obj) {
    var size = 0,
        key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function one_step(form) {
    search_by_hash(sha1(form.phone.value));
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

function search_func(form) {
    search_by_hash(form.hash.value, true);
}

async function search_by_hash(hash, hashed = false) {
    $('#search').attr('disabled', true);
    if (!hashed) {
        $('#search')[0].blur(); // HTMLElement API
        $('#search').text('درحال کدگذاری...')[0];
        showToast('درحال کدگذاری...');
        await delay(700);
        Swal.close();
    }

    showToast('درحال جستجو...');
    $('#search').text('در حال جستجو...');

    grecaptcha.execute(RECAPTCHA_SITE_KEY, {
        action: 'search'
    }).then(function (token) {
        let param = new URLSearchParams({
            "mode": "recaptcha",
            "hash": hash,
            "token": token
        });
        fetch('/api/search.php?' + param.toString())
            .then(res => res.json())
            .then(async res => {
                await delay(700);
                // Clear swal
                Swal.close();
                $('#search').text('جستجو').removeAttr('disabled');
                await delay(100);
                // List results
                if (res.status == 0) {
                    if (Object.size(res.result) > 0) {
                        let breach = [];
                        for (source in res.result) breach.push(source + ': ' + res.result[source].join('، '));
                        Swal.fire({
                            type: 'error',
                            title: 'اوه نه، یه خبر بد',
                            confirmButtonText: "باشه",
                            html: `ما نشتی از اطلاعات شما پیدا کردیم!<br/><br/><h4>موارد افشا شده</h4>${breach.join('<br/>')}`,
                            footer: '<a href="/notify">باخبرم کن</a>｜<a href="/leaks">فهرست نشت های عمده</a>｜<a href="/faq#what-should-i-do-if-leaked">باید چکار کنم؟</a>'
                        });
                    } else {
                        Swal.fire({
                            type: 'success',
                            title: 'یه خبر خوب!',
                            confirmButtonText: "باشه",
                            html: 'ما هیچ نشتی از اطلاعات شما پیدا نکردیم، اما ممکن است در آینده ای نزدیک اینطور نباشد!<br/>پس با دقت زیادی از داده های خود مراقبت کنید :) ',
                            footer: '<a href="/notify">وقتی نشتی پیدا شد باخبرم کن!</a>'
                        });
                    }
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'خطای سرور',
                        confirmButtonText: "باشه",
                        text: res.error
                    });
                }
            });
    });
}

function subscribe_func(form) {
    $('#subscribe').attr('disabled', true);
    let hash = sha1(form.subscribe_form_phone.value);
    grecaptcha.execute(RECAPTCHA_SITE_KEY, {
        action: 'subscribe'
    }).then(function (token) {
        let param = new URLSearchParams({
            "hash": hash,
            "email": form.subscribe_form_email.value,
            "name": form.subscribe_form_fullname.value,
            "token": token
        });
        fetch('/api/subscribe.php?' + param.toString())
            .then(function (response) {
                return response.json();
            })
            .then(function (res) {
                $('#subscribe').removeAttr('disabled');
                if (res.status == 0) {
                    if (Object.size(res.result) > 0) {
                        Swal.fire({
                            type: 'success',
                            title: 'ثبت اشتراک انجام شد',
                            confirmButtonText: "باشه",
                            html: 'یک لینک تایید به ایمیل شما ارسال شد، لطفا با مراجعه به صندوق ورودی (Inbox) و بازکردن لینک ارسال شده، آدرس خود را تایید کنید. اگرچه نشتی از اطلاعات شخصی شما پیدا شده اما در صورت پیدا شدن نشتی جدید در مقیاس بزرگ، بلافاصله به شما اطلاع داده می شود.'
                        });
                    } else {
                        Swal.fire({
                            type: 'success',
                            title: 'ثبت اشتراک انجام شد',
                            confirmButtonText: "باشه",
                            html: 'یک لینک تایید به ایمیل شما ارسال شد، لطفا با مراجعه به صندوق ورودی (Inbox) و بازکردن لینک ارسال شده، آدرس خود را تایید کنید. در حال حاضر هیچ نشتی از اطلاعات شخصی شما پیدا نشد، در صورت کشف نشتی جدید در مقیاس بزرگ، بلافاصله به شما اطلاع داده می شود.'
                        });
                    }
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Server error',
                        confirmButtonText: "باشه",
                        text: res.error
                    });
                }
            });
    });
}

function subscription_status_func(form) {
    $('#query').attr('disabled', true);
    grecaptcha.execute(RECAPTCHA_SITE_KEY, {
        action: 'query_subscription_status'
    }).then(function (token) {
        let param = new URLSearchParams({
            "email": form.email.value,
            "token": token
        });
        fetch('/api/subscription_status.php?' + param.toString())
            .then(function (res) {
                return res.json();
            }).then(function (res) {
                $('#query').removeAttr('disabled');
                if (res.status == 0) {
                    if (res.result == 'not_subscribed') {
                        $('.searchForm').hide();
                        $('.subForm').show();
                        $('#subscribe_form_email').val(form.email.value);
                    } else if (res.result == 'verification_pending') {
                        Swal.fire({
                            type: 'info',
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
                        type: 'error',
                        title: 'خطایی روی داد',
                        confirmButtonText: "باشه",
                        text: res.error
                    });
                }
            });
    });
}

function unsubscribe_func(form) {
    $('#unsubscribe').attr('disabled', true);
    let hash = sha1(form.unsubscribe_form_phone.value);
    grecaptcha.execute(RECAPTCHA_SITE_KEY, {
        action: 'unsubscribe'
    }).then(function (token) {
        let param = new URLSearchParams({
            "hash": hash,
            "email": form.unsubscribe_form_email.value,
            "token": token
        });
        fetch('/api/unsubscribe.php?' + param.toString())
            .then(function (res) {
                return res.json();
            }).then(function (res) {
                $('#unsubscribe').removeAttr('disabled');
                if (res.status == 0) {
                    Swal.fire({
                        type: 'success',
                        title: 'لغو اشتراک انجام شد',
                        confirmButtonText: "باشه",
                        html: 'شما با موفقیت اشتراک خود را از سامانه باخبرم کن لغو کردید. '
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'خطایی روی داد',
                        confirmButtonText: "باشه",
                        text: res.error
                    });
                }
            });
    });
}

function showToast(title, type = "info") {
    Swal.fire({
        type: type,
        title: title,
        toast: true,
        position: 'top-end',
        showConfirmButton: false
    });
}

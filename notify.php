<?php $title = 'باخبرم کن';
    $token = $_GET['t'] ?? '';
    if ($token !== '') {
        header('Referrer-Policy: no-referrer');
        header('X-Robots-Tag: noindex, nofollow');
    }
    require 'src/header.php';
    require 'src/common.php';

    $row = false;
    if ($token !== '') {
        delete_stale_registrations();
        $row = get_subscriber_by_token($token);
    }
    $state = $row ? subscriber_state($row) : null;
    ?>

    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1><?= $title ?></h1>
        </div>
    </header>

    <?php if (!$row) { ?>
    <div class="padded container notify-section">
        <?php if ($token !== '') { ?>
        <div class="alert alert-warning text-center" role="alert">
            این لینک نامعتبر یا منقضی شده است. ایمیل خود را دوباره وارد کنید تا لینک جدید برایتان ارسال شود.
        </div>
        <?php } ?>
        <h1 class="breach-title">ثبت یا مدیریت اشتراک</h1>
        <p>اشتراک در سرویس باخبرم کن این امکان را به ما می دهد تا اگر نشتی از اطلاعات شخصی شما در مقیاس بزرگ پیدا کردیم، بلافاصله آن را به شما اطلاع دهیم. آدرس ایمیل خود را وارد کنید تا لینکی برایتان ارسال شود، با باز کردن آن لینک می‌توانید مشترک شوید، یا اگر قبلا مشترک شده‌اید، نام و شماره تلفن خود را تغییر دهید یا اشتراک را لغو کنید.</p>
        <form id="notify_link_form">
            <div class="form-group">
                <label for="notify_link_form_email">آدرس ایمیل</label>
                <input type="email" class="form-control" id="notify_link_form_email" maxlength="191" placeholder="name@example.com" autocomplete="off" required />
            </div>
            <button class="btn btn-outline-dark btn-block" type="submit" id="notify_link">ادامه</button>
            <p>فشار دادن دکمه ادامه به این معنی است که <a href="/policy">خط مشی </a>وب سایت را خوانده و قبول دارید.</p>
        </form>
        <div id="notify_link_sent" class="alert alert-success text-center" role="status" style="display:none">
            لینک به آدرس ایمیل شما ارسال شد. صندوق ورودی و پوشه اسپم را بررسی کنید. لینک تا <?= (int)LINK_TTL_MINUTES ?> دقیقه معتبر است.
        </div>
    </div>
    <?php } else { ?>
    <div class="padded container notify-section" id="manage" data-token="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
        <h1 class="breach-title"><?= $state === 'active' ? 'مدیریت اشتراک' : 'ثبت اشتراک' ?></h1>
        <div class="alert alert-light text-center" role="alert">
            <?php if ($state === 'active') { ?>
            این آدرس برای باخبر شدن <span style="color: green;">ثبت شده</span> است. می‌توانید نام یا شماره تلفن خود را تغییر دهید.
            <?php } elseif ($state === 'unsubscribed') { ?>
            اشتراک این آدرس <span style="color: red;">لغو شده</span> است. برای فعال‌سازی دوباره، اطلاعات زیر را تأیید کنید.
            <?php } else { ?>
            این آدرس هنوز <span style="color: red;">ثبت نشده</span> است. برای مشترک شدن، اطلاعات زیر را وارد کنید.
            <?php } ?>
        </div>
        <p>شماره تلفن شما قبل از ارسال به سمت سرور تبدیل به هش می‌شود. این لینک موقت است و <?= (int)LINK_TTL_MINUTES ?> دقیقه پس از ارسال یا با درخواست لینک جدید باطل می‌شود؛ آن را با کسی به اشتراک نگذارید.</p>
        <form id="notify_form">
            <div class="form-group">
                <label for="notify_form_name">نام</label>
                <input type="text" class="form-control" id="notify_form_name" maxlength="50" placeholder="E.g. John" value="<?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />
            </div>
            <div class="form-group">
                <?php if ($row['hash'] === null) { ?>
                <label for="notify_form_phone">شماره تلفن</label>
                <input type="text" class="form-control" id="notify_form_phone" maxlength="11" placeholder="E.g. 09123456789" autocomplete="off" required />
                <?php } else { ?>
                <label for="notify_form_phone">شماره تلفن</label>
                <input type="text" class="form-control" id="notify_form_phone" maxlength="11" placeholder="E.g. 09123456789" autocomplete="off" aria-describedby="notify_form_phone_help" />
                <small id="notify_form_phone_help" class="form-text text-muted">شماره تلفن فعلی شما از قبل ثبت شده است. اگر قصد تغییر آن را ندارید، نیازی به وارد کردن دوباره نیست.</small>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="notify_form_email">آدرس ایمیل</label>
                <input type="email" class="form-control" id="notify_form_email" dir="ltr" value="<?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') ?>" readonly disabled />
            </div>
            <button class="btn btn-outline-primary btn-block" type="submit" id="notify_save"><?= $state === 'active' ? 'ذخیره تغییرات' : ($state === 'unsubscribed' ? 'فعال‌سازی' : 'ثبت اشتراک') ?></button>
            <?php if ($state !== 'active') { ?>
            <p>فشار دادن این دکمه به این معنی است که <a href="/policy">خط مشی </a>وب سایت را خوانده و قبول دارید.</p>
            <?php } ?>
        </form>
        <?php if ($state === 'active') { ?>
        <button class="btn btn-outline-danger btn-block w-100 mt-3" type="button" id="notify_unsubscribe">لغو اشتراک</button>
        <?php } ?>
    </div>
    <?php } ?>

    <script>const TURNSTILE_SITE_KEY='<?= TURNSTILE_SITE_KEY?>'</script>
    <script src="/js/main.js"></script>

    <script>
        $('#notify_link_form').on("submit", function(e) {
            e.preventDefault();
            notify_link_func(e.target);
        });

        $('#notify_form').on("submit", async function(e) {
            e.preventDefault();
            let data = { "name": e.target.notify_form_name.value.trim() };
            let phone = normalizePhone(e.target.notify_form_phone.value);
            if (phone !== '') {
                data.hash = await sha1(phone);
            }
            manage_func('save', data);
        });

        $('#notify_unsubscribe').on("click", function() {
            Swal.fire({
                icon: 'warning',
                title: 'لغو اشتراک',
                text: 'پس از لغو، دیگر از نشت‌های جدید باخبر نمی‌شوید. برای فعال‌سازی دوباره کافیست ایمیل خود را دوباره در همین صفحه وارد کنید.',
                showCancelButton: true,
                confirmButtonText: 'لغو اشتراک',
                cancelButtonText: 'انصراف'
            }).then(function(result) {
                if (result.isConfirmed) {
                    manage_func('unsubscribe', {});
                }
            });
        });
    </script>

    <?php require 'src/footer.php'; ?>

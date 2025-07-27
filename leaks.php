<?php $title = 'نشت‌های عمده';
	require 'src/header.php';
	require 'src/common.php';
	?>

	<header class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1><?= $title ?></h1>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?= get_breach_type_count(1) ?></div>
                    <div class="stat-label">نشت عمده</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?= get_breach_type_count(0) ?></div>
                    <div class="stat-label">نشت جزئی</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?= get_breach_type_count(0) + get_breach_type_count(1) ?></div>
                    <div class="stat-label">کل نشت‌ها</div>
                </div>
            </div>
		</div>
	</header>

	<div class="container">
		<h1 class="breach-title">منبع و بیانیه</h1>
		<p>این صفحه فقط نشت های بیش از 5 هزار خط را نشان می دهد. نشت های جزئی فقط برای استعلام قربانیان در دسترس است.</p>
		<p>بزرگی نشت، موارد افشا شده و حساب‌های تحت تاثیر، بعد از حذف موارد تکراری و نادرست بدست آمده و ممکن است با داده‌های اصلی متفاوت باشند.</p>
        <p>منابع اطلاعاتی این وب‌سایت برگرفته از پایگاه داده‌های در دسترس و عمومی در اینترنت است، وب‌سایت اطلاعات اصلی پایگاه های داده را ذخیره نمی کند، فقط موارد مورد نیاز برای جستجوی کاربران که به صورت کدگذاری شده هستند، نگه داری می شود. حمله به این وب سایت هیچ اطلاعاتی در اختیار شما قرار نمی دهد. در صورت مشاهده هرگونه تلاش برای نفوذ، این وب سایت به اقدامات قانونی متوسل می شود.</p>
		<p>اگر می خواهید منابعی را به صورت ناشناس ارائه کنید، با ما در ارتباط باشید: <a href="mailto:info@leakfa.com">info@leakfa.com</a>، پیشنهاد می‌شود از <a href="https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x2bf188dd2ef22c065332b43f6c82fea37da06311"target="_blank">PGP Key</a> برای رمزنگاری استفاده شود.</p>
		<h1 class="breach-title">نشت‌های عمده</h1>
		<div class="breaches">
			<?php foreach (get_major_breaches() as $_ => $val) { ?>
				<div class="breach">
					<div class="header">
                    	<div class="title" id="<?= $val['anchor'] ?>" data-clipboard-text="<?= $val['anchor'] ?>"><?= $val['name'] ?></div>
						<div class="magnitude">
							<div>بزرگی نشت</div>
							<div><?= number_format($val['round_k'] * 1000) ?></div>
						</div>
					</div>
					<?php if (get_tags($val['id'])) { ?>
						<div class="tags">
							<?php foreach (get_tags($val['id']) as $_ => $tag) { ?>
								<button data-tag-id="<?= $tag['tag'] ?>" class="btn btn-sm <?= $tag['class'] ?>"><?= $tag['name'] ?></button>
							<?php } ?>
						</div>
					<?php } ?>
					<div class="content">
						<h4>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14,2 14,8 20,8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10,9 9,9 8,9"></polyline>
                                </svg>
                                موارد افشا شده
                            </h4>
						<p><?= join('، ', get_leaked_items($val['id'])) ?></p>
						<h4>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                                روایت
                            </h4>
						<p><?= $val['description'] ?></p>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
<script>
    const tag_details = <?= json_encode(get_tag_details()) ?>;

    // Click event for tag buttons
    $(`[data-tag-id]`).click(function() {
        let tagId = $(this).attr(`data-tag-id`);
        let tag_detail = tag_details.filter(x => x.id == tagId)[0];
        Swal.fire({
            type: 'info',
            title: `${tag_detail.name}`,
            text: tag_detail.description,
            confirmButtonText: 'باشه!'
        });
    });

    // Click event for anchor links (title)
    $(`.title`).click(function() {
        var anchorLink = $(this).attr('id');
        var url = window.location.origin + window.location.pathname + "#" + anchorLink;

        var tempInput = document.createElement("input");
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        Swal.fire({
            type: 'success',
            title: 'آدرس کپی شد!',
            text: 'آدرس روایت این نشت در کلیپ‌بورد شما کپی شد.',
            confirmButtonText: 'باشه!'
        });
    });
</script>

<?php require 'src/footer.php'; ?>

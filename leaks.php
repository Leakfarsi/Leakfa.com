<?php $title = 'نشت‌های عمده';
	require 'src/header.php';
	require 'src/common.php';
	?>

	<header class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1><?= $title ?></h1>
			<p class="lead">در حال حاضر شامل:<br />
				<?= get_breach_type_count(1) ?> نشت عمده<br />
				<?= get_breach_type_count(0) ?> نشت جزئی<br />
				در مجموع <?= get_breach_type_count(0) + get_breach_type_count(1) ?> نشت
			</p>
		</div>
	</header>

	<div class="container">
		<h1 class="breach-title">منبع و بیانیه</h1>
		<p>این صفحه فقط نشت های بیش از 5 هزار خط را نشان می دهد. نشت های جزئی فقط برای استعلام قربانیان در دسترس است.</p>
		<p>بزرگی نشت، موارد افشا شده و حساب‌های تحت تاثیر، بعد از حذف موارد تکراری و نادرست بدست آمده و ممکن است با داده‌های اصلی متفاوت باشند.</p>
        <p>منابع اطلاعاتی این وب‌سایت برگرفته از پایگاه داده‌های در دسترس و عمومی در اینترنت است، وب‌سایت اطلاعات اصلی پایگاه های داده را ذخیره نمی کند، فقط موارد مورد نیاز برای جستجوی کاربران که به صورت کدگذاری شده هستند، نگه داری می شود. حمله به این وب سایت هیچ اطلاعاتی در اختیار شما قرار نمی دهد. در صورت مشاهده هرگونه تلاش برای نفوذ، این وب سایت به اقدامات قانونی متوسل می شود.</p>
		<p>اگر می خواهید منابعی را به صورت ناشناس ارائه کنید، با ما در ارتباط باشید: <a href="mailto:info@leakfa.com">info@leakfa.com</a>، پیشنهاد می‌شود از <a href="https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x8eba26e301b4ac8584f91dd6f89c33ed43bb86b3"target="_blank">PGP Key</a> برای رمزنگاری استفاده شود.</p>
		<h1 class="breach-title">نشت‌های عمده</h1>
		<div class="breaches">
			<?php foreach (get_major_breaches() as $_ => $val) { ?>
				<div class="breach">
					<div class="header">
						<div class="title"><?= $val['name'] ?></div>
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
						<h4>موارد افشا شده</h4>
						<p><?= join('، ', get_leaked_items($val['id'])) ?></p>
						<h4>روایت</h4>
						<p><?= $val['description'] ?></p>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<script>
		const tag_details = <?= json_encode(get_tag_details()) ?>;

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
	</script>

	<?php require 'src/footer.php'; ?>

<?php $title = 'فهرست نشت‌ها';
	require 'src/header.php';
	require 'src/common.php';
	$majorBreaches = get_major_breaches();
	$maxRoundK = max(array_column($majorBreaches, 'round_k'));
	$allTags = get_tag_details();
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

	<div class="container leaks-container">
		<!-- Disclaimer Callout (Collapsible) -->
		<div class="disclaimer-callout">
			<div class="disclaimer-header" id="disclaimerToggle" role="button" aria-expanded="false" aria-controls="disclaimerBody" tabindex="0">
				<div class="disclaimer-header-right">
					<span class="disclaimer-icon">!</span>
					<span>منبع و بیانیه</span>
				</div>
				<svg class="disclaimer-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<polyline points="6 9 12 15 18 9"/>
				</svg>
			</div>
			<div class="disclaimer-body" id="disclaimerBody">
				<p>این صفحه فقط نشت های بیش از 3 هزار خط را نشان می دهد. نشت های جزئی فقط برای استعلام قربانیان در دسترس است.</p>
				<p>بزرگی نشت، موارد افشا شده و حساب‌های تحت تاثیر، بعد از حذف موارد تکراری و نادرست بدست آمده و ممکن است با داده‌های اصلی متفاوت باشند.</p>
				<p>منابع اطلاعاتی این وب‌سایت برگرفته از پایگاه داده‌های در دسترس و عمومی در اینترنت است، وب‌سایت اطلاعات اصلی پایگاه های داده را ذخیره نمی کند، فقط موارد مورد نیاز برای جستجوی کاربران که به صورت کدگذاری شده هستند، نگه داری می شود. حمله به این وب سایت هیچ اطلاعاتی در اختیار شما قرار نمی دهد. در صورت مشاهده هرگونه تلاش برای نفوذ، این وب سایت به اقدامات قانونی متوسل می شود.</p>
				<p>اگر می خواهید منابعی را به صورت ناشناس ارائه کنید، با ما در ارتباط باشید: <a href="mailto:info@leakfa.com">info@leakfa.com</a>، پیشنهاد می‌شود از <a href="https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x2bf188dd2ef22c065332b43f6c82fea37da06311" target="_blank">PGP Key</a> برای رمزنگاری استفاده شود.</p>
			</div>
		</div>

		<!-- Search & Filter Controls -->
		<div class="leaks-controls">
			<div class="leaks-search-wrap">
				<svg class="leaks-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
				</svg>
				<input type="text" id="breachSearch" class="leaks-search" placeholder="جستجوی نشت‌ها..." aria-label="جستجوی نشت‌ها">
			</div>
			<div class="leaks-compact-actions">
				<div class="leaks-sort-wrap">
					<svg class="leaks-sort-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="16" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/>
					</svg>
					<select id="breachSort" class="leaks-sort" aria-label="مرتب‌سازی">
						<option value="magnitude">بزرگی نشت</option>
						<option value="name">نام (الفبایی)</option>
					</select>
				</div>
				<?php if ($allTags) { ?>
				<button class="leaks-tag-toggle" id="tagToggleBtn" aria-label="فیلتر برچسب‌ها" title="فیلتر برچسب‌ها">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
						<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
					</svg>
					<span class="tag-toggle-label">فیلتر</span>
					<span class="tag-active-count" id="tagActiveCount" style="display:none;"></span>
				</button>
				<?php } ?>
			</div>
		</div>

		<!-- Tag Filter Chips (collapsible on mobile) -->
		<?php if ($allTags) { ?>
			<div class="tag-filter-chips" id="tagFilterChips">
				<?php foreach ($allTags as $tag) { ?>
					<button class="tag-chip" data-filter-tag="<?= $tag['id'] ?>" title="<?= htmlspecialchars($tag['description']) ?>">
						<?= $tag['name'] ?>
					</button>
				<?php } ?>
				<button class="tag-chip tag-chip-clear" id="clearTagFilter" style="display:none;">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
					پاک کردن فیلتر
				</button>
			</div>
		<?php } ?>

		<div class="breaches" id="breachesGrid" data-tag-details="<?= htmlspecialchars(json_encode($allTags), ENT_QUOTES, 'UTF-8') ?>">
			<?php foreach ($majorBreaches as $idx => $val) {
				$magnitudePercent = ($maxRoundK > 0) ? round(($val['round_k'] / $maxRoundK) * 100) : 0;
				$severityClass = $magnitudePercent >= 70 ? 'severity-high' : ($magnitudePercent >= 35 ? 'severity-medium' : 'severity-low');
				$tags = get_tags($val['id']);
				$tagIds = $tags ? implode(',', array_column($tags, 'tag')) : '';
			?>
				<div class="breach" data-name="<?= htmlspecialchars($val['name']) ?>" data-magnitude="<?= $val['round_k'] ?>" data-tags="<?= $tagIds ?>">
					<div class="header">
						<div class="title-wrap">
                    		<div class="title" id="<?= $val['anchor'] ?>" data-clipboard-text="<?= $val['anchor'] ?>"><?= $val['name'] ?></div>
							<button class="copy-link-btn" data-anchor="<?= $val['anchor'] ?>" aria-label="کپی لینک نشت" title="کپی لینک نشت">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
									<path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
								</svg>
							</button>
						</div>
						<div class="magnitude">
							<div>بزرگی نشت</div>
							<div class="magnitude-number"><?= number_format($val['round_k'] * 1000) ?></div>
							<div class="magnitude-bar <?= $severityClass ?>">
								<div class="magnitude-bar-fill" style="width: <?= $magnitudePercent ?>%"></div>
							</div>
						</div>
					</div>
					<?php if ($tags) { ?>
						<div class="tags">
							<?php foreach ($tags as $tag) { ?>
								<button data-tag-id="<?= $tag['tag'] ?>" class="btn btn-sm <?= $tag['class'] ?>" aria-label="برچسب: <?= htmlspecialchars($tag['name']) ?>" title="برای اطلاعات بیشتر کلیک کنید"><?= $tag['name'] ?></button>
							<?php } ?>
						</div>
					<?php } ?>
					<div class="content">
						<h4>
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-label="موارد افشا شده">
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
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-label="روایت">
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
		<div class="no-results" id="noResults" style="display:none;">
			<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
				<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="8" x2="14" y2="14"/><line x1="14" y1="8" x2="8" y2="14"/>
			</svg>
			<p>نشتی با این برچسب یافت نشد.</p>
		</div>
	</div>

<script src="/js/leaks.js"></script>

<?php require 'src/footer.php'; ?>

<?php $title = 'آمار وب‌سایت';
        require 'src/header.php';
        require 'src/common.php';
        $stat = site_stat();
    ?>

    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 ><?=$title?></h1>
            <p class="lead">داده های موجود در تاریخ <?=$stat['cache_gen_time']?> ثبت شده است.</p>
        </div>
    </header>

    <div class="container">
        <h3 class="breach-title">وضعیت پایگاه داده</h3> 
        <p>نشت جزئی: <?= $stat['minor'] ?>
        <br/>نشت عمده: <?= $stat['major'] ?> 
     	<br/>کل منابع نشت: <?= $stat['total_sources'] ?>
        <br/>رکوردهای ارتباط: <?= number_format($stat['relations']) ?>
      	<br/>تعداد هش‌های یکتا: <?= number_format($stat['unique_hash']) ?> <br/></p>

        <h3 class="breach-title">آمار جستجو</h3> 
        <p>کل جستجوهای مؤثر: <?= number_format($stat['total_unique_search']) ?>
        <br/>موارد منتهی به نشت: <?= number_format($stat['hit']) ?>
        <br/>موارد بدون نشت: <?= number_format($stat['no_hit']) ?>
        <br/>نرخ کشف نشت: <?=intval($stat['hit_rate'] * 10000)/100?> %</p>
        <p>* کل جستجوهای مؤثر: جستجوهای یکتا در گزارش جستجو 
        <br/>* نرخ کشف نشت: درصد جستجوهایی که حداقل یک مطابقت داشتند </p>
        
        <h3 class="breach-title">آمار منبع داده</h3> 
      <table class="table">
          <thead>
              <tr>
                  <td>دسته‌بندی</td>
                  <td>نشت‌های عمده</td>
                  <td>نشت‌های جزئی</td>
                  <td>در مجموع</td>
              </tr>
          </thead>
          <tbody>
              <?php foreach($stat['categories'] as $row): ?>
                  <tr>
                      <td><?= htmlspecialchars($row['category']) ?></td>
                      <td><?= $row['major_count'] ?></td>
                      <td><?= $row['minor_count'] ?></td>
                      <td><?= $row['total_count'] ?></td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
    </div>

    <?php require 'src/footer.php'; ?>

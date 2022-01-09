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
        <h3 class="breach-title">آمار پوشش داده ها</h3> 
        <p>تعداد هش‌های غیرتکراری: <?=$stat['unique_hash']?>
        <br/>جمعیت ایران: <?=$stat['total_pop']?>
        <br/>پوشش تخمینی داده‌ها: <?=intval($stat['cover_rate'] * 10000)/100?> %</p>
        <p>* جمعیت ایران بر اساس اطلاعات برگرفته از وب‌سایت <a href="https://www.worldometers.info/world-population/iran-population/">worldometers</a> می باشد.
        <br/>* تعداد هش‌های غیر تکراری بر اساس شماره تلفن‌های همراه بوده و ممکن است یک فرد مالک چندین شماره باشد.</p>

        <h3 class="breach-title">آمار جستجو</h3> 
        <p>کل جستجوهای مؤثر: <?=$stat['total_unique_search']?>
        <br/>جستجوهای نشت شده: <?=$stat['hit']?>
        <br/>جستجوهای نشت نشده: <?=$stat['no_hit']?>
        <br/>میزان آمار نشت: <?=intval($stat['hit_rate'] * 10000)/100?> %</p>
        <p>*کل جستجوهای مؤثر: جستجوهای غیرتکراری در گزارش جستجو
        <br/>*میزان آمار نشت: موارد نشت شده بر اساس کل جستجو های موثر </p>
        
        <?php
            // Trash Code, Need someone to fix
            $predef_type = ['دولتی', 'تالار گفتگو', 'شبکه اجتماعی', 'شرکت خصوصی', 'موسسه تحصیلی', 'سایر'];
        ?>
        <h3 class="breach-title">آمار منبع داده‌ها</h3> 
        <table class="table">  
            <thead>
                <tr>
                    <td>دسته‌بندی داده‌ها</td>
                    <td>نشت‌های عمده</td>
                    <td>نشت‌های جزئی</td>
                    <td>در مجموع</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($predef_type as $tp){
                        echo '<tr><td>' . $tp . '</td>';
                        foreach($stat['source'] as $source){
                            $match = 0;
                            foreach($source as $data){
                                if ($data['type'] == $tp){
                                    $match = $data['count'];
                                }
                            }
                            echo '<td>' . $match . '</td>';
                        }
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>



    <?php require 'src/footer.php'; ?>

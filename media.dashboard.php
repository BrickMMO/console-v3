<?php

security_check();
admin_check();

define('APP_NAME', 'Media');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/media/dashboard');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT *
    FROM media
    WHERE image IS NOT NULL 
    AND deleted_at IS NULL';
$image_count = mysqli_num_rows(mysqli_query($connect, $query));

$query = 'SELECT *
    FROM media
    WHERE video IS NOT NULL 
    AND deleted_at IS NULL';
$video_count = mysqli_num_rows(mysqli_query($connect, $query));

$query = 'SELECT *
    FROM media_downloads';
$download_count = mysqli_num_rows(mysqli_query($connect, $query));

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Media
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Media
</p>
<hr>
<p>
    Total Images: <span class="w3-tag w3-blue"><?=$image_count?></span> 
    Total Videos: <span class="w3-tag w3-blue"><?=$video_count?></span> 
    Total Downloads: <span class="w3-tag w3-blue"><?=$download_count?></span>
</p>
<hr />

<h2>Popular Media</h2>

<p>
    Display the 8 most popular downloads...
</p>

<hr />

<div
    class="w3-row-padding"
    style="margin-left: -16px; margin-right: -16px"
>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-brix"></i> Uptime Status
            </header>
            <div class="w3-container w3-padding">Uptime Status Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/uptime/bricksum"
                    class="w3-button w3-border w3-white"
                >
                    <i class="fa-regular fa-file-lines fa-padding-right"></i>
                    Full Report
                </a>
            </footer>
        </div>
    </div>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-brix"></i> Stat Summary
            </header>
            <div class="w3-container w3-padding">App Statistics Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/stats/bricksum"
                    class="w3-button w3-border w3-white"
                >
                    <i class="fa-regular fa-chart-bar fa-padding-right"></i> Full Report
                </a>
            </footer>
        </div>
    </div>
</div>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

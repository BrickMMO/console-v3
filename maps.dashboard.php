<?php

security_check();
admin_check();

define('APP_NAME', 'Bricksum');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/maps/dashboard');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$squares = city_get_squares($_city['id']);

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Maps
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Maps
</p>
<hr>
<h2>Map Squares</h2>
<div class="w3-container w3-border w3-padding-16 w3-margin-bottom">

    <?php for($row = 0; $row < $_city['height']; $row ++): ?>
    
        <div class="w3-cell-row">

            <?php for($col = 0; $col < $_city['width']; $col ++): ?>

                <div class="w3-cell w3-border">
                    <?=$row?> - <?=$col?>
                </div>

            <?php endfor; ?>    

        </div>

    <?php endfor; ?>

</div>

<a
    href="/maps/squares"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Modify Map Squares
</a>

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
                    href="/uptime/maps"
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
                    href="/stats/maps"
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

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

$squares = squares_fetch_all($_city['id']);
$width = round(100/$_city['width'],2);

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

<?php for($row = 0; $row < $_city['height']; $row ++): ?>

    <div class="w3-cell-row">

        <?php for($col = 0; $col < $_city['width']; $col ++): ?>

            <div class="w3-cell w3-border w3-<?php echo ($squares[$row][$col]['type'] == 'water') ? 'blue' : 'brown'; ?>" 
                style="width: <?=$width?>%; height: 35px; cursor: pointer;"
                onclick="location.href='/maps/square/<?=$squares[$row][$col]['id']?>';">
            </div>

        <?php endfor; ?>    

    </div>

<?php endfor; ?>

<a
    href="/maps/quick"
    class="w3-button w3-white w3-border w3-margin-top"
>
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Map Quick Edit
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

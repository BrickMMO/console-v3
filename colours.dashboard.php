<?php

security_check();
admin_check();

define('APP_NAME', 'Colours');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/colours/dashboard');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT * 
    FROM colours 
    ORDER BY name';    
$result = mysqli_query($connect, $query);

$colours_count = mysqli_num_rows($result);

$colours_last_import = setting_fetch('COLOURS_LAST_IMPORT');

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/colours.png"
        height="50"
        style="vertical-align: top"
    />
    Colours
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Colours
    </p>
<hr>
<p>
    Number of colours imported: <span class="w3-tag w3-blue"><?=$colours_count?></span> 
    Last import: <span class="w3-tag w3-blue"><?=(new DateTime($colours_last_import))->format("D, M j g:i A")?></span>
</p>
<hr />
<h2>Colour List</h2>

<?php if (mysqli_num_rows($result)): ?>

    <div class="w3-container w3-border w3-padding-16 w3-margin-bottom">

        <?php while($colour = mysqli_fetch_assoc($result)): ?>

            <div class="w3-col l1 m2 s4 w3-margin-right w3-margin-left">
                <div style="width: 75px; height: 75px; background-color: #<?=$colour['rgb']?>;"></div>
                <p>#<?=$colour['rgb']?></p>
            </div>

        <?php endwhile; ?>

    </div>

<?php else: ?>

    <p>
        Colour data has not yet been imported from 
        <a href="https://rebrickable.com/api/">Rebrickable</a>.
    </p>

<?php endif; ?>

<a
    href="/colours/import"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-download"></i> Import Colours
</a>

<hr />

<div
    class="w3-row-padding"
    style="margin-left: -16px; margin-right: -16px"
>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-colours"></i> Uptime Status
            </header>
            <div class="w3-container w3-padding">Uptime Status Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/uptime/colours"
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
                <i class="bm-colours"></i> Stat Summary
            </header>
            <div class="w3-container w3-padding">App Statistics Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/stats/colours"
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

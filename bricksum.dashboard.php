<?php

security_check();
admin_check();

define('APP_NAME', 'Bricksum');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/bricksum/dashboard');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$bricksum_wordlist = setting_fetch('BRICKSUM_WORDLIST', 'comma_2_array');
$bricksum_paragraphs_generated = setting_fetch('BRICKSUM_PARAGRAPHS_GENERATED');
$bricksum_sentences_generated = setting_fetch('BRICKSUM_SENTENCES_GENERATED');
$bricksum_words_generated = setting_fetch('BRICKSUM_WORDS_GENERATED');

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Bricksum
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Bricksum
</p>
<hr>
<p>
    Paragraphs Generated: <span class="w3-tag w3-blue"><?=$bricksum_paragraphs_generated?></span> 
    Sentences Generated: <span class="w3-tag w3-blue"><?=$bricksum_sentences_generated?></span> 
    Words Generated: <span class="w3-tag w3-blue"><?=$bricksum_words_generated?></span>
</p>
<hr />
<h2>Bricksum Word List</h2>
<div class="w3-container w3-border w3-padding-16 w3-margin-bottom">

    <?php foreach($bricksum_wordlist as $word): ?>
        <span class="w3-tag w3-green w3-round w3-margin-bottom w3-padding">
            <?=$word?>
        </span>
    <?php endforeach; ?>
    
</div>
<a
    href="/bricksum/wordlist"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Modify Word List
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

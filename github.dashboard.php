<?php

security_check();
admin_check();

define('APP_NAME', 'GitHub Scanner');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-tools');
define('PAGE_SELECTED_SUB_PAGE', '/github/dashboard');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$github_accounts = setting_fetch('GITHUB_ACCOUNTS');
$github_last_import = setting_fetch('GITHUB_LAST_IMPORT');
$github_repos_scanned = setting_fetch('GITHUB_REPOS_SCANNED');

$query = 'SELECT *
    FROM repos
    ORDER BY error_count DESC
    LIMIT 6';
$result = mysqli_query($connect, $query);

?>

<!-- CONENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/colours.png"
        height="50"
        style="vertical-align: top"
    />
    GitHub Tools
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    GitHub Tools
</p>
<hr>
<p>
    Currently scanning: <span class="w3-tag w3-blue"><?=$github_accounts?></span> 
    Number of repos scanned: <span class="w3-tag w3-blue"><?=$github_repos_scanned?></span> 
    Last import: <span class="w3-tag w3-blue"><?=(new DateTime($github_last_import))->format("D, M j g:i A")?></span>
</p>
<hr />
<h2>Next Six Repos</h2>


<div class="w3-row-padding" style="margin-left: -16px; margin-right: -16px">

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <div class="w3-third">
            <div class="w3-card w3-container w3-margin-bottom w3-padding-24">
                <a href="/github/repo/<?=$record['name']?>">
                    <i class="fa-brands fa-github" aria-hidden="true"></i> /<?=$record['owner']?>/<?=$record['name']?>
                </a>
                <div class="w3-margin-top">
                    <span class="w3-tag w3-black">
                        <?=explode(chr(13), $record['error_comments'])[0]?> 
                        (+<?=count(explode(chr(13), $record['error_comments']))?>)
                    </span>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

</div>


<?php foreach(explode(',', $github_accounts) as $account): ?>

<a
    href="/github/import/<?=$account?>"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Import <?=$account?>
</a>

<?php endforeach; ?>

<hr />

<div
    class="w3-row-padding"
    style="margin-left: -16px; margin-right: -16px"
>
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

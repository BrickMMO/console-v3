<?php

security_check();
admin_check();

define('APP_NAME', 'GitHub Scanner');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-tools');
define('PAGE_SELECTED_SUB_PAGE', '/github/results');

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
    ORDER BY error_count DESC';
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
    <a href="/github/dashboard">GitHub Tools</a> / 
    Scan Results
</p>
<hr />
<h2>Scan Results</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th class="bm-table-number">Errors</th>
        <th>Last Scanned</th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <a href="/github/repo/<?=$record['name']?>">
                    <i class="fa-brands fa-github" aria-hidden="true"></i> /<?=$record['owner']?>/<?=$record['name']?>
                </a>
            </td>
            <td>
                <?=$record['error_count']?>
            </td>
            <td>
                <?=time_elapsed_string($record['updated_at'])?>
            </td>
        </tr>
    <?php endwhile; ?>

</table>


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

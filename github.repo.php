<?php

security_check();
admin_check();

if(isset($_GET['key']))
{

    $query = 'SELECT *
        FROM repos
        WHERE name = "'.addslashes($_GET['key']).'"
        ORDER BY error_count DESC';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {
        message_set('Repo Error', 'There was an error loading this repo.', 'red');
        header_redirect('/github/dashboard');
    }

    $record = mysqli_fetch_assoc($result);

}
elseif(isset($_GET['rescan']))
{

    $query = 'SELECT *
        FROM repos
        WHERE name = "'.addslashes($_GET['rescan']).'"
        ORDER BY error_count DESC';
    $result = mysqli_query($connect, $query);

    if(!mysqli_num_rows($result))
    {
        message_set('Repo Error', 'There was an error loading this repo.', 'red');
        header_redirect('/github/dashboard');
    }

    $record = mysqli_fetch_assoc($result);

    github_scan_repo($record['owner'], $record['name']);

    message_set('Repo Success', 'Repo has been rescanned.');
    header_redirect('/github/repo/'.$record['name']);
    
}

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
    <a href="/github/results">Scan Results</a> / 
    Repo Scan Details    
</p>
<hr />
<h2>Repo Scan Details: <?=$record['name']?></h2>

<a href="https://github.com/<?=$record['owner']?>/<?=$record['name']?>">
    <i class="fa-brands fa-github" aria-hidden="true"></i> /<?=$record['owner']?>/<?=$record['name']?>
</a>

<p>
    Pull requests: <span class="w3-tag w3-blue"><?=$record['pull_requests']?></span> 
    Errors found: <span class="w3-tag w3-blue"><?=$record['error_count']?></span> 
    Last scan: <span class="w3-tag w3-blue"><?=(new DateTime($record['updated_at']))->format("D, M j g:i A")?></span>
</p>

<ul class="w3-ul w3-margin-bottom">
    <?php foreach(explode(chr(13), $record['error_comments']) as $error): ?>
        <li><?=$error?></li>
    <?php endforeach; ?>
</ul>

<a
    href="/github/repo/rescan/<?=$record['name']?>"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-pen-to-square fa-padding-right"></i> Rescan Repo
</a>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

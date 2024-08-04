<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_blank($_POST['bricksum_wordlist']))
    {
        message_set('Word List Error', 'There was an error saving your workd list.', 'red');
        header_redirect('/bricksum/wordlist');
    }

    setting_update('BRICKSUM_WORDLIST', $_POST['bricksum_wordlist']);

    message_set('Word List Success', 'Word list has been updated.');
    header_redirect('/bricksum/wordlist');
    
}

define('APP_NAME', 'Bricksum');

define('PAGE_TITLE', 'Modify Word List');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/bricksum/wordlist');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$bricksum_wordlist = setting_fetch('BRICKSUM_WORDLIST', 'comma');
$bricksum_stopwords = setting_fetch('BRICKSUM_STOPWORDS', 'comma');

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
    <a href="/bricksum/dashboard">Bricksum</a> / 
    Modify Word List
</p>
<hr />
<h2>Modify Word List</h2>

<form
    method="post"
    onsubmit="return validateLoginForm()"
    novalidate
>
    <textarea name="bricksum_wordlist" class="w3-input w3-border w3-margin-bottom" rows="10"><?=$bricksum_wordlist?></textarea>
    <textarea name="bricksum_stopwords" class="w3-input w3-border" rows="4"><?=$bricksum_stopwords?></textarea>
    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-bottom w3-margin-top">
        <i class="fa-solid fa-save fa-padding-right"></i>
        Save Word List
    </button>
</form>
    
<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

<?php

security_check();

define('APP_NAME', 'My City');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/main_header.php');

?>

<?php include('templates/message.php'); ?>

<div class="w3-center">

    <h1><?=$_SESSION['city']['name']?></h1>

</div>

<?php

include('templates/modal_city.php');

include('templates/debug.php');

include('templates/main_footer.php');
include('templates/html_footer.php');

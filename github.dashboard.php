<?php

security_check();

define('APP_NAME', 'GitHub Scanner');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-tools');
define('PAGE_SELECTED_SUB_PAGE', '/github/dashboard');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

?>

<h1>Dashboard</h1>

<?php include('templates/message.php'); ?>

<a href="/action/logout">Logout</a> | 
<a href="/login">Login</a> | 
<a href="/city/dashboard">Dashboard</a>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

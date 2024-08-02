<?php

$city = city_fetch($_GET['key'], 'url');


if(!$city)
{
    message_set('Profile error', 'This city does not exist.', 'red');
    include('404.php');
    die();
}

define('APP_NAME', 'Profile');

define('PAGE_TITLE', $city['url']);

include('templates/html_header.php');
include('templates/login_header.php');

?>

<div class="w3-center">

    <h1>CITY PROFILE</h1>

    <h2>    
        <?=$city['name']?>
    </h2>

</div>

<?php

include('templates/login_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

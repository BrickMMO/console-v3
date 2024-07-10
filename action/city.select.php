<?php

$query = 'UPDATE users SET
    city_id = '.$_GET['id'].'
    WHERE id = '.$_SESSION['user']['id'].'
    LIMIT 1';
mysqli_query($connect, $query);

security_set_user_session($_SESSION['user']['id']);

message_set('Success', 'You are now working on '.$_SESSION['city']['name'].'.');
header_redirect(ENV_CONSOLE_DOMAIN.'/console/dashboard');

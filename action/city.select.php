<?php

$_city = city_fetch($_GET['id']);

$query = 'UPDATE users SET
    city_id = '.$_city['id'].'
    WHERE id = '.$_user['id'].'
    LIMIT 1';
mysqli_query($connect, $query);

security_set_user_session($_user['id']);

message_set('Success', 'You are now working on '.$_city['name'].'.');
header_redirect(ENV_CONSOLE_DOMAIN.'/city/dashboard');

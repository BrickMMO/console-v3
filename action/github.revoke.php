<?php

security_check();

$user = user_fetch($_SESSION['user']['id']);

github_revoke($user['github_access_token']);

$query = 'UPDATE users SET
    github_username = "",
    github_access_token = ""
    WHERE id = '.$user['id'].'
    LIMIT 1';
mysqli_query($connect, $query);

security_set_user_session($user['id']);

message_set('Success', 'Your account has disconnected from your GitHub account.');
header_redirect('/account/dashboard');

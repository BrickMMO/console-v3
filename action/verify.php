<?php

if(!isset($_GET['hash']) or !user_fetch($_GET['hash']))
{
    message_set('Hash Error', 'There was an error with the password reset link, please try again.', 'red');
    header_redirect('/forgot');
}
else
{

    $user = user_fetch($_GET['hash']);
    
    $query = 'UPDATE users SET
        email_verified_at = NOW()
        WHERE verify_hash = "'.addslashes($_GET['hash']).'"
        AND email_verified_at IS NULL
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Email Verified', 'Your email address has been verified.');
    header_redirect('/login');
    
}

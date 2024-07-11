<?php

if(!isset($_GET['hash']) or !invite_fetch($_GET['hash']))
{
    message_set('Hash Error', 'There was an error with the password reset link, please try again.', 'red');
    header_redirect(ENV_ACCOUNT_DOMAIN.'/login');
}

$_SESSION['invite'] = $_GET['hash'];

if($_user)
{

    header_redirect(ENV_ACCOUNT_DOMAIN.'/account/dashboard');

}

message_set('City Invite', 'Login or register to accept invitation.');
header_redirect(ENV_ACCOUNT_DOMAIN.'/login');

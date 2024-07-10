<?php

if(!isset($_GET['hash']) or !invite_fetch($_GET['hash']))
{
    message_set('Hash Error', 'There was an error with the password reset link, please try again.', 'red');
    header_redirect('/forgot');
}

$invite = invite_fetch($_GET['hash']);

$_SESSION['invite'] = $invite;

if($_user)
{

    header_redirect(ENV_ACCOUNT_DOMAIN.'/account/dashboard');

}

message_set('City Invite', 'Login or register to accept invitation.', 'green');
header_redirect(ENV_ACCOUNT_DOMAIN.'/login');
    
<?php

function user_avatar()
{
    return (
        isset($_SESSION['user']['avatar']) &&
        $_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : '/images/no_avatar.png';
}

function user_name()
{
    return $_SESSION['user']['first'].' '.$_SESSION['user']['last'];
}

function user_fetch($identifier)
{

    global $connect;

    $query = 'SELECT *
        FROM users
        WHERE id = "'.addslashes($identifier).'"
        OR email = "'.addslashes($identifier).'"
        OR github_username = "'.addslashes($identifier).'"
        OR (reset_hash = "'.addslashes($identifier).'" AND reset_hash != "")
        OR (verify_hash = "'.addslashes($identifier).'" AND verify_hash != "")
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}

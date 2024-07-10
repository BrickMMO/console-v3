<?php

function city_avatar()
{
    return (
        isset($_SESSION['city']['image']) &&
        $_SESSION['city']['image']) ? $_SESSION['city']['image'] : '/images/no_city.png';
}

function city_fetch($identifier)
{

    if(!$identifier) return false;

    global $connect;

    $query = 'SELECT *
        FROM cities
        WHERE id = "'.addslashes($identifier).'"
        AND deleted_at IS NULL
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}
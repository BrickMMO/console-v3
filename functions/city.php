<?php

function city_avatar($id)
{
    $city = city_fetch($id);
    return $city['image'] ? $city['image'] : '/images/no_city.png';
}

function city_fetch($identifier, $field = false)
{

    if(!$identifier) return false;

    global $connect;

    if($field)
    {
        $query = 'SELECT *
            FROM cities
            WHERE '.$field.' = "'.addslashes($identifier).'"
            LIMIT 1';
    }
    else
    {
        $query = 'SELECT *
            FROM cities
            WHERE id = "'.addslashes($identifier).'"
            AND deleted_at IS NULL
            LIMIT 1';
    }
    
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
    else return false;

}

function city_check()
{

    global $_city, $_user;

    if(!$_city)
    {
        user_set_city($_user['id']);
        header_redirect(ENV_ACCOUNT_DOMAIN.'/account/dashboard');
    }

}



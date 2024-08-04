<?php

function time_elapsed_string($datetime, $full = false) 
{

    $datetime = time_adjust($datetime);

    $now = new DateTime;
    $ago = new DateTime($datetime); 
    $diff = $now->diff($ago);

    @$diff->w = floor($diff->d / 7);
    @$diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach ($string as $k => &$v) 
    {
        if ($diff->$k) 
        {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        }
        else 
        {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';

}

function time_adjust($datetime)
{

    if(isset($_SESSION['timezone']))
    {
        $datetime = new DateTime($datetime);
        $datetime->modify('+ '.$_SESSION['timezone']['offset'].' minutes');
    }

    return $datetime->format('Y-m-d H:i:s');

}
<?php

/**
 * Load libraries through composer.
 */ 
require __DIR__ . '/vendor/autoload.php';

/**
 * Include database connecton, session initialiation, and function
 * files. 
 */
include('includes/connect.php');
include('includes/session.php');
include('functions/functions.php');

/**
 * Convert standard format URL parameters to slashes.
 */ 
if(strpos($_SERVER['REQUEST_URI'], '?'))
{
    $url = $_SERVER['REQUEST_URI'];
    $url = str_replace(array('?','='), '/', $url);
    header_redirect($url);
}

/**
 * Split URL infor array.
 */ 
$parts = array_filter(explode("/", trim($_SERVER['REQUEST_URI'], "/")));

/**
 * If there are no parts, redirect to login page.
 */
if(!count($parts))
{
    header_redirect('/console/dashboard');
}

/**
 * If the request is an ajax request. 
 */
if($parts[0] == 'ajax')
{

    define('PAGE_TYPE', 'ajax');
    array_shift($parts);
    $folder = 'ajax/';

}

/**
 * If the request is an API request. 
 */
elseif($parts[0] == 'api')
{

    define('PAGE_TYPE', 'api');
    array_shift($parts);
    $folder = 'api/';

}

/**
 * If the request is a action request. 
 */
elseif($parts[0] == 'action')
{

    define('PAGE_TYPE', 'action');
    array_shift($parts);
    $folder = 'action/';

}

/**
 * If the request is a standard web request. 
 */
else
{

    define('PAGE_TYPE', 'web');
    $folder = '';
    
}

/**
 * Parse URL for possible filenames and check if file exists. 
 */
$file = '';

foreach($parts as $part)
{
    
    $file = str_replace('php', '', $file);
    $file .= array_shift($parts).'.php';

    if(file_exists($folder.$file)) 
    {
        define('PAGE_FILE', $file);
        break;
    }

}

/**
 * If URL does not result in an existing file. 
 */
if(!defined('PAGE_FILE'))
{
    include($folder.'404.php');
    exit;
}

/**
 * Parse remaining URL data into a $_GET array. 
 */

if(count($parts) == 1)
{
    $_GET['key'] = array_shift($parts);
}
for($i = 0; $i < count($parts); $i += 2)
{
    $_GET[$parts[$i]] = isset($parts[$i+1]) ? $parts[$i+1] : true;
}

/**
 * If the request is an ajax request. 
 */
if(PAGE_TYPE == 'ajax') 
{
    $_POST = json_decode(file_get_contents('php://input'), true);
    include('ajax/'.$file);
    echo json_encode($data);
    exit;
}

/**
 * If the request is an API request. 
 */
elseif(PAGE_TYPE == 'api') 
{
    include('api/'.$file);
    echo json_encode($data);
    exit;
}

/**
 * If the request is an action request. 
 */
elseif(PAGE_TYPE == 'action') 
{
    include('action/'.$file);
    exit;
}

/**
 * If the request is a standard web request. 
 */
else
{
    include($file);
}


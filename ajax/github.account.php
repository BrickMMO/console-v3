<?php

// TODO
// If not logged in
// Check for key

if(!security_is_logged_in())
{
    $data = array('message' => 'Must be logged in to use this ajaz call.', 'error' => false);
}

$user = user_fetch($_SESSION['user']['id']);

$url = 'https://api.github.com/users/'.$_GET['key'];

$headers[] = 'Content-type: application/json';
$headers[] = 'Authorization: Bearer '.$user['github_access_token'];
$headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$user = json_decode(curl_exec($ch), true);

curl_close($ch);

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App   ';

$repos = array();

for($i = 0; $i < $user['public_repos'] / 100; $i ++)
{

    $url = 'https://api.github.com/users/'.$_GET['key'].'/repos?per_page=100&page='.($i+1);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $repos = array_merge($repos, json_decode(curl_exec($ch), true));

    curl_close($ch);

}

$data = array(
    'message' => 'GitHub account and repo list has been retrieved.',
    'error' => false, 
    'user' => $user,
    'repos' => $repos,
);

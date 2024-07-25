<?php

function github_url($redirect_uri = '/action/github/token')
{

    return 'https://github.com/login/oauth/authorize?scope=read:user,user:email,public_repo&client_id='.GITHUB_CLIENT_ID.
        '&redirect_uri='.urlencode(ENV_ACCOUNT_DOMAIN.$redirect_uri);

}

function github_revoke($access_token)
{

    $url = 'https://api.github.com/applications/'.GITHUB_CLIENT_ID.'/grant';

    $headers = [
        'Accept: application/vnd.github+json',
        "Authorization: Basic ". base64_encode(GITHUB_CLIENT_ID.':'.GITHUB_CLIENT_SECRET),
        'User-Agent: BrickMMO',
    ];

    $data = [
        'access_token' => $access_token,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $result = curl_exec($ch);

}

function github_access_token($code)
{
    $url = 'https://github.com/login/oauth/access_token';

    $data = [
        'client_id' => GITHUB_CLIENT_ID,
        'client_secret' => GITHUB_CLIENT_SECRET,
        'code' => $code,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    parse_str(curl_exec($ch), $result);
    curl_close($ch);

    return $result;

}

function github_emails($access_token)
{

    $url = "https://api.github.com/user/emails";
    
    $headers = [
        'Accept: application/json',
        'Authorization: Bearer '.$access_token,
        'User-Agent: BrickMMO',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = json_decode(curl_exec($ch), true);
    curl_close($ch);

    return $result;

}

function github_user($access_token)
{

    $url = "https://api.github.com/user";

    $headers = [
        'Accept: application/json',
        'Authorization: Bearer '.$access_token,
        'User-Agent: BrickMMO',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = json_decode(curl_exec($ch), true);
    curl_close($ch);

    return $result;

}
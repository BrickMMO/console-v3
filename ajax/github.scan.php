<?php

// TODO
// If not logged in
// Check for account and repo

if(!security_is_logged_in())
{
    $data = array('message' => 'Must be logged in to use this ajaz call.', 'error' => false);
}

$query = 'DELETE FROM repos 
    WHERE owner = "'.$_GET['account'].'"
    AND name = "'.$_GET['repo'].'"';
mysqli_query($connect, $query);

$user = user_fetch($_SESSION['user']['id']);


// Fetch repo information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'];

$headers[] = 'Content-type: application/json';
$headers[] = 'Authorization: Bearer '.$user['github_access_token'];
$headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$repo = json_decode(curl_exec($ch), true);

curl_close($ch);


// Fetch README.md information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'].'/contents/README.md';

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$readme = json_decode(curl_exec($ch), true);

curl_close($ch);


// Fetch favicon.ico information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'].'/contents/favicon.ico';

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$favicon = json_decode(curl_exec($ch), true);

curl_close($ch);


// Fetch favicon.ico information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'].'/contents/CNAME';

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$cname = json_decode(curl_exec($ch), true);

curl_close($ch);


// Fetch .gitignore information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'].'/contents/.gitignore';

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$gitignore = json_decode(curl_exec($ch), true);

curl_close($ch);


// Fetch pulls information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'].'/pulls';

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$pulls = json_decode(curl_exec($ch), true);

curl_close($ch);


// Fetch favicon.ico information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'].'/branches/main/protection';

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$protection = json_decode(curl_exec($ch), true);

curl_close($ch);


/*
// Fetch pages information
$url = 'https://api.github.com/repos/'.$_GET['account'].'/'.$_GET['repo'].'/pages';

$headers[] = 'Content-type: application/json';
// $headers[] = 'Authorization: Bearer '.$user['github_access_token'];
// $headers[] = 'User-Agent: Awesome-Octocat-App';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$pages = json_decode(curl_exec($ch), true);

curl_close($ch);
*/

/*
echo '<hr />';
echo '<h2>REPO</h2>';
debug_pre($repo);
echo '<hr />';
echo '<h2>README</h2>';
debug_pre($readme);
echo '<hr />';
echo '<h2>FAVICON</h2>';
debug_pre($favicon);
echo '<hr />';
echo '<h2>CNAME</h2>';
debug_pre($cname);
echo '<hr />';
echo '<h2>GITIGNORE</h2>';
debug_pre($gitignore);
echo '<hr />';
echo '<h2>PULLS</h2>';
debug_pre($pulls);
echo '<hr />';
echo '<h2>PROTECTION</h2>';
debug_pre($protection);
echo '<hr />';
*/

$error_comments = array();

// error_readme_exists: boolean default:0
$errors['error_readme_exists'] = 1;

if(!isset($readme['path'])) 
{
    $errors['error_readme_exists'] = 0;
    $error_comments[] = 'README.md does not exists';
}

// error_readme_content: boolean default:0
$errors['error_readme_contents'] = 1;

if(isset($readme['path'])) 
{
    $content = base64_decode($readme['content']);

    // echo '<pre>';
    // echo htmlentities($content);
    // echo '</pre>';

    if(strpos($content, '# ') !== 0)
    {
        $errors['error_readme_contents'] = 0;
        $error_comments[] = 'README.md is missing main heading';
    }

    if(!strpos($content, '## '))
    {
        $errors['error_readme_contents'] = 0;
        $error_comments[] = 'README.md does not appear to have level two headings';
    }

    if(!strpos($content, 'Repo Resources'))
    {
        $errors['error_readme_contents'] = 0;
        $error_comments[] = 'README.md does not appear to have resources';
    }

    if(!strpos($content, 'code-block.png') && !strpos($content, 'brickmmo-logo-coloured-horizontal.png'))
    {
        $errors['error_readme_contents'] = 0;
        $error_comments[] = 'README.md does not appear to have a footer image';
    }

}

// error_favicon_exits: boolean default:0
$errors['error_favicon_exists'] = 1;

if($repo['has_pages'] && isset($cname['path']))
{
    if(!isset($favicon['path']))
    {
        $errors['error_favicon_exists'] = 0;
        $error_comments[] = 'Pages is activated, but there is no favicon.ico';
    }
}

// error_gitignore_exists: boolean default:0
$errors['error_gitignore_exists'] = 1;

if(!isset($gitignore['path'])) 
{
    $errors['error_gitignore_exists'] = 0;
    $error_comments[] = '.gitignore does not exists';
}

// error_gitignore_contents: boolean default:0
$errors['error_gitignore_contents'] = 1;

if(isset($gitignore['path'])) 
{
    $content = base64_decode($gitignore['content']);

    // echo '<pre>';
    // echo htmlentities($content);
    // echo '</pre>';

    if(!is_numeric(strpos($content, '.DS_Store')))
    {
        $errors['error_gitignore_contents'] = 0;
        $error_comments[] = '.gitignore is missing main .DS_Store';
    }
}

// error_protected: boolean default:0
$errors['error_protected'] = 1;

if(!isset($protection['restrictions'])) 
{
    $errors['error_protected'] = 0;
    $error_comments[] = 'Main branch is not protected';
}

// error_description: boolean default:0
$errors['error_description'] = 1;

if(!$repo['description'])
{
    $errors['error_description'] = 0;
    $error_comments[] = 'Repo description is empty';
}

// error_topics: boolean default:0
$errors['error_topics'] = 1;

if(count($repo['topics']) == 0) 
{
    $errors['error_topics'] = 0;
    $error_comments[] = 'Repo has no topics';
}

// pull_requests: integer
$pull_requests = count($pulls);

/*
debug_pre($errors);
debug_pre($error_comments);
*/

$query = 'INSERT INTO repos (
        name,
        owner,
        pull_requests,
        error_readme_exists,
        error_readme_contents,
        error_favicon_exists,
        error_gitignore_exists,
        error_gitignore_contents,
        error_protected,
        error_description,
        error_topics,
        error_comments,
        error_count,
        created_at,
        updated_at
    ) VALUES (
        "'.$_GET['repo'].'",
        "'.$_GET['account'].'",
        "'.$pull_requests.'",
        "'.$errors['error_readme_exists'].'",
        "'.$errors['error_readme_contents'].'",
        "'.$errors['error_favicon_exists'].'",
        "'.$errors['error_gitignore_exists'].'",
        "'.$errors['error_gitignore_contents'].'",
        "'.$errors['error_protected'].'",
        "'.$errors['error_description'].'",
        "'.$errors['error_topics'].'",
        "'.implode(chr(13),$error_comments).'",
        "'.count($error_comments).'",
        NOW(),
        NOW()        
    )';
mysqli_query($connect, $query);

// debug_pre($query);
// debug_pre($error_comments);

$query = 'SELECT COUNT(*) AS total_repos
    FROM repos';
$result = mysqli_query($connect, $query);

$record = mysqli_fetch_assoc($result);

setting_update('GITHUB_REPOS_SCANNED', $record['total_repos']);

$data = array(
    'message' => 'GitHub repo details has been retrieved.',
    'error' => false, 
    'repo' => $repo,
    'pull_requests' => $pull_requests,
    'errors' => $error_comments,
);

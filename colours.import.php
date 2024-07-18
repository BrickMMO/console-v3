<?php

security_check();
admin_check();

if ($_GET['key'] == 'go') 
{
    $url = 'https://rebrickable.com/api/v3/lego/colors/';

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: key '.REBRICKABLE_KEY,
    ]);

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response, true);

    foreach($response['results'] as $colour)
    {

        $query = 'INSERT INTO colours (
                name,
                rgb,
                is_trans,
                created_at,
                updated_at
            ) VALUES (
                "'.$colour['name'].'",
                "'.$colour['rgb'].'",
                "'.($colour['is_trans'] ? 'yes' : 'no').'",
                NOW(),
                NOW()
            )';

        mysqli_query($connect, $query);

        $id = mysqli_insert_id($connect);

        foreach($colour['external_ids'] as $key => $value)
        {

            foreach($value['ext_ids'] as $key2 => $value2)
            {

                $query = 'INSERT INTO externals (
                        name,
                        source,
                        colour_id,
                        created_at,
                        updated_at
                    ) VALUES (
                        "'.$colour['external_ids'][$key]['ext_descrs'][$key2][0].'",
                        "'.strtolower($key).'",
                        "'.$id.'",
                        NOW(),
                        NOW()
                    )';
                mysqli_query($connect, $query);

            }

        }
    }
    
    message_set('Colour List', 'Pulling the colour list.');
    header_redirect('/colours/import');
}

define('APP_NAME', 'Colours');

define('PAGE_TITLE', 'Import Colours');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/colours/import');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$bricksum_wordlist = setting_fetch('BRICKSUM_WORDLIST', 'comma');
$bricksum_stopwords = setting_fetch('BRICKSUM_STOPWORDS', 'comma');

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/colours.png"
        height="50"
        style="vertical-align: top"
    />
    Colours
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/bricksum/dashboard">Colours</a> / 
    Import Colours
</p>
<hr />
<h2>Import Progress</h2>

<div class="w3-container w3-border w3-padding-16 w3-margin-bottom">

    <?php
        $query = 'SELECT * FROM colours ORDER BY name';
        
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "<h3>Import Details...</h3>";
        } else {
            echo "<h3>Data Imported:</h3>
                  <div class='w3-white'>[";
            while($colour = mysqli_fetch_assoc($result)): 
    ?>

        <div class="w3-margin-left w3-white">
            <p>{</p>
            <div class="w3-margin-left">
                <p><span class="w3-text-red">"name"</span>: <span class="w3-text-indigo">"<?=$colour['name']?>"</span>,</p>
                <p><span class="w3-text-red">"rgb"</span>: <span class="w3-text-indigo">"<?=$colour['rgb']?>"</span>,</p>
                <p><span class="w3-text-red">"is_trans"</span>: <span class="w3-text-indigo"><?= ($colour['is_trans'] == "yes" ? "true" : "false")?></span></p>
            </div>
            <p>}</p>
        </div>
 
    <?php 
            endwhile;
            echo "]</div>"; 
        } 
    ?>
</div>

<button onclick='window.location.href = "http://local.console.brickmmo.com:7777/colours/import/go"' 
        class="w3-block w3-btn w3-orange w3-text-white w3-margin-bottom w3-margin-top">
    <i class="fa-solid fa-download"></i>
    Start Import
</button>
    
<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

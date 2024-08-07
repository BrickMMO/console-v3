<?php

security_check();
admin_check();

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Events list');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/events/list');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT 
    * FROM events
    ORDER BY start_date';
$result = mysqli_query($connect, $query);

$events_count = mysqli_num_rows($result);

$query = 'SELECT 
    * FROM events
    WHERE start_date > NOW()
    ORDER BY start_date';
    
$result_coming = mysqli_query($connect, $query);

$coming_count = mysqli_num_rows($result_coming);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/events.png"
        height="50"
        style="vertical-align: top"
    />
    Events List
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/events/dashboard">Events</a> / 
    List
</p>

<hr />

<p>
    Number of events created: <span class="w3-tag w3-blue"><?=$events_count?></span> 

    Number of events coming: <span class="w3-tag w3-blue"><?=$coming_count ?></span> 
</p>

<hr />

<h2>Events List</h2>

<?php
    $query = 'SELECT *
    FROM events
    ORDER BY 
        CASE 
            WHEN start_date > NOW() THEN 0
            ELSE 1
        END,
        start_date';

    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result)):
?>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th class="bm-table-icon"></th>
        <th>Event Name</th>
        <th>Date</th>
        <th>Capacity</th>
        <th>Participants</th>
        <th>Status</th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php foreach($result as $index => $coming): ?>
        <tr>
            <td>
                <?=$index +1 . "."?>
            </td>
            <td>
                <?=$coming['event_name']?>
            </td>
            <td>
                <?php 
                    $start_date = new DateTime($coming['start_date']);
                    $end_date = new DateTime($coming['end_date']);  
                    echo $start_date->format("D, M j g:i A") . " - " . $end_date->format("g:i A")              
                ?>
            </td>
            <td>
                <?=$coming['max_capacity']?>
            </td>
            <td>
                <?=$coming['tickets_bought']?>
            </td>
            <td>
                <?php
                    date_default_timezone_set('America/Toronto');
                    if($coming['start_date'] > date('Y-m-d H:i:s')){
                        echo "<strong style='color: #4CAF50'>Coming</strong>";
                    } else {
                        echo "<strong style='color: #FF0000'>Finished</strong>";
                    }
                ?>
            </td>
            <td>
                <a href="/events/edit/<?=$coming['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php else: ?>

<p>
    There are not events yet. 
</p>

<?php endif; ?>

<a
    href="/events/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-plus"></i> Add New Event
</a>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

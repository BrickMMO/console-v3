<?php

security_check();
admin_check();

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/events/dashboard');

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
    ORDER BY created_at DESC';
$events_date_created = mysqli_query($connect, $query);

?>


<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/events.png"
        height="50"
        style="vertical-align: top"
    />
    Events
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    Events
</p>
<hr>
<p>
    Number of events created: <span class="w3-tag w3-blue"><?=$events_count?></span> 

    <?php 
        if (mysqli_num_rows($events_date_created)): 
            $latest_created = mysqli_fetch_assoc($events_date_created);
            $created_at = new DateTime($latest_created['created_at']);
    ?>

    Latest event created: 
    <span class="w3-tag w3-blue">
        <?= $latest_created['event_name'] . " - " . $created_at->format("D, M j") ?>
    </span> 
    
    <?php endif; ?>
</p>
<hr />

<!-- Upcoming events -->

<h2>Upcoming events</h2>

<?php
    $query = 'SELECT 
    * FROM events
    WHERE start_date > NOW()
    ORDER BY start_date';
    
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result)):
        echo "<p>Displaying the <strong>upcoming events</strong></p>";
?>

<div class="w3-row">

    <?php 
        while($event = mysqli_fetch_assoc($result)): 

        $start_date = new DateTime($event['start_date']);
        $event_created = new DateTime($event['created_at']);
    ?>

        <div class="w3-col l3 m5 s12 w3-border w3-margin-right w3-margin-bottom">
            <div class="w3-display-container w3-border-bottom" style="background-image: url('<?=events_photo($event['id']);?>'); background-size: cover; background-position: center; height: 168px">
                <p class="w3-padding w3-display-bottomright w3-margin-right w3-round-xlarge" style="background-color: #B2B2B2; font-size: 12px">
                    <strong><?= $start_date->format("D, M j g:i A") ?></strong>
                </p>
            </div>
            <div class="w3-container">
                <p><span style="font-size: 12px">Name:</span> <br> <strong><?=$event['event_name']?></strong></p>
                <p><span style="font-size: 12px">Location:</span> <br> <strong><?=$event['location']?></strong></p>
                <p style="font-size: 12px">Participants: <strong><?=$event['tickets_bought']?>/<?=$event['max_capacity']?></strong></p>
                <p style="font-size: 12px">Created on: <strong><?=$event_created->format('Y/m/d')?></strong></p>
            </div>
        </div>

    <?php endwhile; ?>

</div>

<?php else: ?>

    <p>
        There are not events yet. 
        <a href="add">Add a new Event</a>.
    </p>

<?php endif; ?>

<!-- Latest events created -->

<h2>Latest events created</h2>

<?php
    mysqli_data_seek($events_date_created, 0);

    if (mysqli_num_rows($events_date_created)):
        echo "<p>Displaying the <strong>3 latest events created</strong></p>";
?>

<div class="w3-row">

    <?php 
        $i = 0;
        while($event = mysqli_fetch_assoc($events_date_created)): 

        $start_date = new DateTime($event['start_date']);
        $event_created = new DateTime($event['created_at']);
    ?>

        <div class="w3-col l3 m5 s12 w3-border w3-margin-right w3-margin-bottom">
            <div class="w3-display-container w3-border-bottom" style="background-image: url('<?=events_photo($event['id']);?>'); background-size: cover; background-position: center; height: 168px">
                <p class="w3-padding w3-display-bottomright w3-margin-right w3-round-xlarge" style="background-color: #B2B2B2; font-size: 12px">
                    <strong><?= $start_date->format("D, M j g:i A") ?></strong>
                </p>
            </div>
            <div class="w3-container">
                <p><span style="font-size: 12px">Name:</span> <br> <strong><?=$event['event_name']?></strong></p>
                <p><span style="font-size: 12px">Location:</span> <br> <strong><?=$event['location']?></strong></p>
                <p style="font-size: 12px">Created on: <strong><?=$event_created->format('Y/m/d')?></strong></p>
            </div>
        </div>

    <?php 
        if ($i === 2) {
            break;
        }
        $i++;
        endwhile; 
    ?>

</div>

<?php else: ?>

    <p>
        There are not events yet. 
        <a href="add">Add a new Event</a>.
    </p>

<?php endif; ?>

<!-- Recent registrations -->

<h2>Recent registrations</h2>

<?php
    $query = 'SELECT event_name, COUNT(events.id) AS "count_participants"
    FROM events 
    INNER JOIN ( 
        SELECT * 
        FROM participants 
        ORDER BY created_at DESC 
        LIMIT 10 ) AS recent_registrations 
    ON events.id = recent_registrations.event_id 
    GROUP BY event_name';

    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result)):
        echo "<p>Displaying the <strong>10 most recent registrations</strong></p>";
?>

<div class="w3-row">

    <?php while($event = mysqli_fetch_assoc($result)): ?>

        <div class="w3-col l3 m5 s12 w3-border w3-margin-right w3-margin-bottom">
            <div class="w3-container">
                <p><strong><span class="w3-text-orange" style="font-size: 12px">Event:</span> <br> <?=$event['event_name']?></strong></p>
                <?php 
                    $query = 'SELECT first_name, last_name, email, participants.created_at 
                    FROM participants 
                    INNER JOIN events 
                    ON events.id = event_id 
                    WHERE event_name = "'. $event['event_name'] .'"
                    ORDER BY participants.created_at DESC 
                    LIMIT '.$event['count_participants'];
                
                    $participants = mysqli_query($connect, $query);
                    while($participant = mysqli_fetch_assoc($participants)):
                ?>
                <p style="font-size: 12px">Name: <strong><?=$participant['first_name'] . " " .  $participant['last_name']?></strong>
                <br> Email: <strong><?=$participant['email']?></strong>
                <?php 
                    $created_at = new DateTime($participant['created_at']);
                ?>
                <br> Created: <strong><?=$created_at->format('Y/m/d')?></strong></p>
                <?php endwhile; ?>
            </div>
        </div>

    <?php endwhile; ?>

</div>

<?php else: ?>

    <p>
        There are not registrations yet. 
        <a href="registrations/add">Add a new Registration</a>.
    </p>

<?php endif; ?>

<hr />

<div
    class="w3-row-padding"
    style="margin-left: -16px; margin-right: -16px"
>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-brix"></i> Uptime Status
            </header>
            <div class="w3-container w3-padding">Uptime Status Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/uptime/bricksum"
                    class="w3-button w3-border w3-white"
                >
                    <i class="fa-regular fa-file-lines fa-padding-right"></i>
                    Full Report
                </a>
            </footer>
        </div>
    </div>
    <div class="w3-half">
        <div class="w3-card">
            <header class="w3-container w3-grey w3-padding w3-text-white">
                <i class="bm-brix"></i> Stat Summary
            </header>
            <div class="w3-container w3-padding">App Statistics Summary</div>
            <footer class="w3-container w3-border-top w3-padding">
                <a
                    href="/stats/bricksum"
                    class="w3-button w3-border w3-white"
                >
                    <i class="fa-regular fa-chart-bar fa-padding-right"></i> Full Report
                </a>
            </footer>
        </div>
    </div>
</div>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');
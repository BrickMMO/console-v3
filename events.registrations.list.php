<?php

security_check();
admin_check();

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Registrations list');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/events/registrations');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT 
    event_name FROM events
    ORDER BY start_date';

$result = mysqli_query($connect, $query);

$events_count = mysqli_num_rows($result);

$query = 'SELECT CONCAT(first_name, " ", last_name) AS name, email, participants.created_at, event_name 
FROM participants 
INNER JOIN events 
ON events.id = event_id 
ORDER BY participants.created_at DESC';

$participants = mysqli_query($connect, $query);

$participants_count = mysqli_num_rows($participants);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/events.png"
        height="50"
        style="vertical-align: top"
    />
    Registrations List
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/events/dashboard">Events</a> / 
    Registrations List
</p>

<hr />

<p>
    Number total of registration: <span class="w3-tag w3-blue"><?=$participants_count?></span> 

    Number total of events: <span class="w3-tag w3-blue"><?=$events_count ?></span> 

    Show event: 
    <select name="filter">
        <?php 
            if (mysqli_num_rows($result)){
                echo "<option value='Show all' selected>Show all</option>";
                while($event = mysqli_fetch_assoc($result)){
                    echo "<option value='".$event['event_name']."'>".$event['event_name']."</option>";
                }
            }       
        ?>
    </select>
</p>

<hr />

<h2>Registrations List</h2>

<?php
    if (mysqli_num_rows($participants)):
?>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th class="bm-table-icon"></th>
        <th>Name</th>
        <th>Email</th>
        <th>Date Registration</th>
        <th>Event</th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php foreach($participants as $index => $participant): ?>
        <tr class="participant-row">
            <td>
                <?=$index +1 . "."?>
            </td>
            <td>
                <?=$participant['name']?>
            </td>
            <td>
                <?=$participant['email']?>
            </td>
            <td>
                <?php 
                    $registration_date = new DateTime($participant['created_at']);
                    echo $registration_date->format("D, M j")             
                ?>
            </td>
            <td>
                <?=$participant['event_name']?>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the tag <?=$record['name']?>?', '/media/tags/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php else: ?>

<p>
    There are not events yet. 
    <a href="https://events.brickmmo.com/">Add a new Event</a>.
</p>

<?php endif; ?>

<button class="w3-button w3-white w3-border" id="see-more">See More</button>

<script>

    let participants = document.querySelectorAll('.participant-row');
    let btn = document.getElementById('see-more');
    btn.style.display = "none";

    btn.onclick = seeMore;

    let isButtonDisplayed = false;

    participants.forEach((participant, index) => {        
        if(index > 14){
            participant.style.display = 'none';
            
            if (!isButtonDisplayed) {
                btn.style.display = "inline-block";
                isButtonDisplayed = true;
            }
        }
    });

    function seeMore(){
        participants.forEach((participant, index) => {
            participant.style.display = 'table-row';
        });
        btn.style.display = "none";
    }

</script>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

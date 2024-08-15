<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM participants 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Registration has been deleted.');
    header_redirect('/events/registrations/list');
    
}

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

$query = 'SELECT participants.id, CONCAT(first_name, " ", last_name) AS name, email, participants.created_at, event_name 
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
    <select id="filter" class="w3-blue">
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

<a
    href="/events/registrations/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-plus"></i> Add New Registration
</a>

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
                <a href="/events/registrations/edit/<?=$participant['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the participant: <strong><?=$participant['name']?></strong>, who is attending the event: <strong><?=$participant['event_name']?></strong>?', '/events/registrations/list/delete/<?=$participant['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php else: ?>

<p>
    There are not registrations yet. 
    <a href="add">Add a new Registration</a>.
</p>

<?php endif; ?>

<div class="w3-container w3-center">
    <button class="w3-button w3-white w3-border w3-text-orange" id="moreParticipants">Show More</button>
</div>

<script>

    let participants = document.querySelectorAll('.participant-row');
    let btn = document.getElementById('moreParticipants');
    let slctFilter = document.getElementById('filter');

    slctFilter.onchange = filterFtn;

    btn.style.display = "none";

    btn.onclick = showMore;

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

    function showMore(){
        participants.forEach((participant, index) => {
            participant.style.display = 'table-row';
        });
        btn.style.display = "none";
    }

    function filterFtn(){        
        participants.forEach((participant, index) => {
            if(slctFilter.value === "Show all"){
                participant.style.display = 'table-row';
            } else{
                console.log(slctFilter.value, "****", (participant.children[4].innerText).trim());
                if(slctFilter.value === (participant.children[4].innerText).trim()){
                    participant.style.display = 'table-row';
                } else{
                    participant.style.display = 'none';
                }
            }
        });
        btn.style.display = "none";
    }

</script>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

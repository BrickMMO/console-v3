<?php

security_check();
admin_check();

if(
    !isset($_GET['key']) || 
    !is_numeric($_GET['key']))
{
    message_set('Registration Error', 'There was an error with the provided registration.', 'red');
    header_redirect('/events/registrations/list');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['first_name']) || !validate_blank($_POST['last_name']) || !validate_blank($_POST['email']))
    {
        message_set('Registration Error', 'There was an error with the provided registration.', 'red');
        header_redirect('/events/registrations/list');
    }
    
    $query = 'UPDATE participants SET
        first_name = "'.addslashes($_POST['first_name']).'",
        last_name = "'.addslashes($_POST['last_name']).'",
        email = "'.addslashes($_POST['email']).'",
        event_id = "'.addslashes($_POST['event_id']).'",
        updated_at = NOW()
        WHERE id = '.$_GET['key'].'
        LIMIT 1';
        
    mysqli_query($connect, $query);

    message_set('Registration Success', 'The registration has been edited.');
    header_redirect('/events/registrations/list');
    
}

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Edit Registration');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/events/registrations');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT *
    FROM participants
    WHERE id = "'.$_GET['key'].'"
    LIMIT 1';

$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Events - Edit Registration
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/events/dashboard">Events</a> / 
    <a href="/events/registrations/list">Registrations List</a> /
    Edit 
    <?php
        if(mysqli_num_rows($result)){
            $participant = mysqli_fetch_assoc($result);
            echo $participant['first_name'] . " " .  $participant['last_name'];
        }
    ?>
</p>

<hr />

<h2>Edit participant: <?=$participant['first_name'] . " " .  $participant['last_name']?></h2>

<?php

$query = 'SELECT 
    id, event_name, max_capacity, tickets_bought FROM events
    ORDER BY start_date';

$result = mysqli_query($connect, $query);

?>

<form
    method="post"
    novalidate
    id="main-form"
    onsubmit="return validateMainForm();"
>
    <input 
        type="hidden" 
        id="event_attending_id" 
        value=<?=$participant['event_id']?>
    />

    <select name="event_id" id="event" class="w3-input w3-border">
    <?php
        if (mysqli_num_rows($result)){
            while($event = mysqli_fetch_assoc($result)){
                $selected = ($participant['event_id'] === $event['id']) ? 'selected' : '';

                echo "<option value='".$event['id']."' " . $selected . " data-max_capacity='".$event['max_capacity']."' data-tickets_bought='".$event['tickets_bought']."'>".$event['event_name']."</option>";
            }
        }
    ?>
    </select>
    <label for="event" class="w3-text-gray">
        Event <span id="event_error" class="w3-text-red"></span>
    </label>

    <input  
        name="first_name" 
        class="w3-input w3-border" 
        type="text" 
        id="first_name" 
        autocomplete="off"
        value="<?=$participant['first_name']?>"
    />
    <label for="first_name" class="w3-text-gray">
        First Name <span id="first_name_error" class="w3-text-red"></span>
    </label>

    <input  
        name="last_name" 
        class="w3-input w3-border" 
        type="text" 
        id="last_name" 
        autocomplete="off"
        value="<?=$participant['last_name']?>"
    />
    <label for="last_name" class="w3-text-gray">
        Last Name <span id="last_name_error" class="w3-text-red"></span>
    </label>

    <input  
        name="email" 
        class="w3-input w3-border" 
        type="text" 
        id="email" 
        autocomplete="off"
        value="<?=$participant['email']?>"
    />
    <label for="email" class="w3-text-gray">
        Email <span id="email_error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top">
        <i class="fa-solid fa-pencil"></i>
        Update Registration
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let event = document.getElementById("event");
        let event_capacity = event.options[event.selectedIndex].getAttribute("data-max_capacity");
        let tickets_bought = event.options[event.selectedIndex].getAttribute("data-tickets_bought");
        let event_updating_id = event.options[event.selectedIndex].value;

        let event_attending_id = document.getElementById("event_attending_id");
        
        let first_name = document.getElementById("first_name");
        let last_name = document.getElementById("last_name");
        let email = document.getElementById("email");

        let event_error = document.getElementById("event_error");
        let first_name_error = document.getElementById("first_name_error");
        let last_name_error = document.getElementById("last_name_error");
        let email_error = document.getElementById("email_error");

        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        event_error.innerHTML = "";
        first_name_error.innerHTML = "";
        last_name_error.innerHTML = "";
        email_error.innerHTML = "";       
        

        if ((parseInt(event_attending_id.value) !== parseInt(event_updating_id)) 
                && 
            (parseInt(tickets_bought) >= parseInt(event_capacity))) {
            event_error.innerHTML = "(Sorry this event is full)";
            errors++;
        }

        if (first_name.value === "") {
            first_name_error.innerHTML = "(First Name is required)";
            errors++;
        } 

        if (last_name.value === "") {
            last_name_error.innerHTML = "(Last Name is required)";
            errors++;
        }

        if (!regexEmail.test(email.value)) {
            email_error.innerHTML = "(Email is invalid)";
            errors++;
        }

        if (errors > 0) {
            return false;
        }
    }

</script>
    

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

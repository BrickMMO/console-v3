<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['first_name']) || !validate_blank($_POST['last_name']) || !validate_blank($_POST['email']))
    {
        message_set('Registration Error', 'There was an error with the registration.', 'red');
        header_redirect('/events/registrations/add');
    }
    
    $query = 'INSERT INTO participants (
            first_name,
            last_name,
            email,
            event_id, 
            created_at,
            updated_at
        ) VALUES (
            "'.addslashes($_POST['first_name']).'",
            "'.addslashes($_POST['last_name']).'",
            "'.addslashes($_POST['email']).'",
            "'.addslashes($_POST['event_id']).'",
            NOW(),
            NOW()
        )';
    mysqli_query($connect, $query);

    message_set('Registration Success', 'Your registration has been added.');
    header_redirect('/events/registrations/list');
    
}

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Add Registration');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/events/registrations');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT 
    id, event_name, max_capacity, tickets_bought FROM events
    ORDER BY start_date';

$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Events - Registration
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/events/dashboard">Events</a> / 
    <a href="/events/registrations/list">Registrations List</a> / 
    Add Registration
</p>

<hr />

<h2>Add Registration</h2>

<form
    method="post"
    novalidate
    id="main-form"
    onsubmit="return validateMainForm();"
>
    <select name="event_id" id="event" class="w3-input w3-border">
    <?php
        if (mysqli_num_rows($result)){
            while($event = mysqli_fetch_assoc($result)){
                echo "<option value='".$event['id']."' data-max_capacity='".$event['max_capacity']."' data-tickets_bought='".$event['tickets_bought']."'>".$event['event_name']."</option>";
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
    />
    <label for="email" class="w3-text-gray">
        Email <span id="email_error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top">
        <i class="fa-solid fa-plus"></i>
        Add Registration
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let event = document.getElementById("event");
        let event_capacity = event.options[event.selectedIndex].getAttribute("data-max_capacity");
        let tickets_bought = event.options[event.selectedIndex].getAttribute("data-tickets_bought");
        
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
        

        if (parseInt(tickets_bought) >= parseInt(event_capacity)) {
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

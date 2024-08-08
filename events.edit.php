<?php

security_check();
admin_check();

if(
    !isset($_GET['key']) || 
    !is_numeric($_GET['key']))
{
    message_set('Event Error', 'There was an error with the provided event.', 'red');
    header_redirect('/events/list');
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (!validate_blank($_POST['event_name']) || !validate_blank($_POST['start_date']) || !validate_blank($_POST['end_date']) || !validate_blank($_POST['description']) || !validate_blank($_POST['organizer']) || !validate_blank($_POST['location']) || !validate_blank($_POST['detail_description']) || !validate_blank($_POST['max_capacity']))
    {
        message_set('Event Error', 'There was an error with the provided event.', 'red');
        header_redirect('/events/list');
    }
    
    $query = 'UPDATE events SET
        event_name = "'.addslashes($_POST['event_name']).'",
        start_date = "'.addslashes($_POST['start_date']).'",
        end_date = "'.addslashes($_POST['end_date']).'",
        description = "'.addslashes($_POST['description']).'",
        organizer = "'.addslashes($_POST['organizer']).'",
        location = "'.addslashes($_POST['location']).'",
        detail_description = "'.addslashes($_POST['detail_description']).'",
        max_capacity = "'.addslashes($_POST['max_capacity']).'",
        updated_at = NOW()
        WHERE id = '.$_GET['key'].'
        LIMIT 1';
        
    mysqli_query($connect, $query);

    if (validate_image($_FILES['photo']))
    {
        $photo = 'data:image/jpeg;base64, '.base64_encode(file_get_contents($_FILES['photo']['tmp_name']));
        
        $query = 'UPDATE events SET
            photo = "'.addslashes($photo).'"
            WHERE id = '.$_GET['key'].'
            LIMIT 1';
        mysqli_query($connect, $query);
    }

    message_set('Event Success', 'The event has been edited.');
    header_redirect('/events/list');
    
}

define('APP_NAME', 'Events');

define('PAGE_TITLE', 'Edit Event');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/events/list');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT *
    FROM events
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
    Events - Edit
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/events/dashboard">Events</a> / 
    <a href="/events/list">Event List</a> /
    Edit 
    <?php
        if(mysqli_num_rows($result)){
            $event = mysqli_fetch_assoc($result);
            echo $event['event_name'];
        }
    ?>
</p>

<hr />

<h2>Edit Event: <?=$event['event_name']?></h2>

<form
    enctype="multipart/form-data"
    method="post"
    novalidate
    id="main-form"
    onsubmit="return validateMainForm();"
>
    <input  
        name="event_name" 
        class="w3-input w3-border" 
        type="text" 
        id="event_name" 
        autocomplete="off"
        value="<?=$event['event_name']?>"
    />
    <label for="event_name" class="w3-text-gray">
        Event Name <span id="event_name_error" class="w3-text-red"></span>
    </label>

    <input  
        name="photo" 
        class="w3-input w3-border" 
        type="file" 
        id="photo" 
        autocomplete="off"
    />

    <label for="photo" class="w3-text-gray">
        Photo
    </label>

    <input  
        name="start_date" 
        class="w3-input w3-border" 
        type="datetime-local" 
        id="start_date" 
        autocomplete="off"
        value="<?=$event['start_date']?>"
    />
    <label for="start_date" class="w3-text-gray">
        Start Date <span id="start_date_error" class="w3-text-red"></span>
    </label>

    <input  
        name="end_date" 
        class="w3-input w3-border" 
        type="datetime-local" 
        id="end_date" 
        autocomplete="off"
        value="<?=$event['end_date']?>"
    />
    <label for="end_date" class="w3-text-gray">
        End Date <span id="end_date_error" class="w3-text-red"></span>
    </label>

    <textarea 
        name="description" 
        class="w3-input w3-border" 
        id="description"
        rows="3"><?=$event['description']?></textarea>
    <label for="description" class="w3-text-gray">
        Description <span id="description_error" class="w3-text-red"></span>
    </label>

    <input  
        name="organizer" 
        class="w3-input w3-border" 
        type="text" 
        id="organizer" 
        autocomplete="off"
        value="<?=$event['organizer']?>"
    />
    <label for="organizer" class="w3-text-gray">
        Organizer <span id="organizer_error" class="w3-text-red"></span>
    </label>

    <input  
        name="location" 
        class="w3-input w3-border" 
        type="text" 
        id="location" 
        autocomplete="off"
        value="<?=$event['location']?>"
    />
    <label for="location" class="w3-text-gray">
        Location <span id="location_error" class="w3-text-red"></span>
    </label>

    <textarea 
        name="detail_description" 
        class="w3-input w3-border" 
        id="detail_description"
        rows="3"><?=$event['detail_description']?></textarea>
    <label for="detail_description" class="w3-text-gray">
        Details description <span id="detail_description_error" class="w3-text-red"></span>
    </label>

    <input  
        name="max_capacity" 
        class="w3-input w3-border" 
        type="number" 
        id="max_capacity" 
        autocomplete="off"
        min="0"
        value="<?=$event['max_capacity']?>"
    />
    <label for="max_capacity" class="w3-text-gray">
        max_capacity <span id="max_capacity_error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top">
        <i class="fa-solid fa-pencil"></i>
        Update Event
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;
        
        let event_name = document.getElementById("event_name");
        let start_date = document.getElementById("start_date");
        let end_date = document.getElementById("end_date");
        let description = document.getElementById("description");
        let organizer = document.getElementById("organizer");
        let location = document.getElementById("location");
        let detail_description = document.getElementById("detail_description");
        let max_capacity = document.getElementById("max_capacity");
        

        let event_name_error = document.getElementById("event_name_error");
        let start_date_error = document.getElementById("start_date_error");
        let end_date_error = document.getElementById("end_date_error");
        let description_error = document.getElementById("description_error");
        let organizer_error = document.getElementById("organizer_error");
        let location_error = document.getElementById("location_error");
        let detail_description_error = document.getElementById("detail_description_error");
        let max_capacity_error = document.getElementById("max_capacity_error");

        event_name_error.innerHTML = "";
        start_date_error.innerHTML = "";
        end_date_error.innerHTML = "";
        description_error.innerHTML = "";
        organizer_error.innerHTML = "";
        location_error.innerHTML = "";
        detail_description_error.innerHTML = "";
        max_capacity_error.innerHTML = "";
        

        if (event_name.value === "") {
            event_name_error.innerHTML = "(Event Name is required)";
            errors++;
        } 

        if (start_date.value === "") {
            start_date_error.innerHTML = "(Start Date is required)";
            errors++;
        }

        if (end_date.value === "") {
            end_date_error.innerHTML = "(End Date is required)";
            errors++;
        }

        if (description.value.trim().length === 0) {
            description_error.innerHTML = "(Description is required)";
            errors++;
        }

        if (organizer.value === "") {
            organizer_error.innerHTML = "(Organizer is required)";
            errors++;
        }

        if (location.value === "") {
            location_error.innerHTML = "(Location is required)";
            errors++;
        }

        if (detail_description.value.trim().length === 0) {
            detail_description_error.innerHTML = "(Details description is required)";
            errors++;
        }

        if (parseInt(max_capacity.value) <= 0 || max_capacity.value === "") {
            max_capacity_error.innerHTML = "(The max capacity should be greater than 0)";
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

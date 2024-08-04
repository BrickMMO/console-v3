<?php

security_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    
    // Basic serverside validation
    if (
        !validate_blank($_POST['name']) || 
        !validate_number($_POST['width']) || 
        !validate_number($_POST['height']))
    {
        message_set('Login Error', 'There was an error with your profile information.', 'red');
        header_redirect('/city/profile');
    }

    $query = 'UPDATE cities SET
        name = "'.addslashes($_POST['name']).'",
        width = "'.addslashes($_POST['width']).'",
        height = "'.addslashes($_POST['height']).'"
        WHERE id = '.$_SESSION['city']['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Success', 'Your city profile has been updated.');
    header_redirect('/city/dashboard');
    
}

define('APP_NAME', $_SESSION['city']['name']);

define('PAGE_TITLE', 'City Profile');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/main_header.php');

include('templates/message.php');

$city = city_fetch($_SESSION['city']['id']);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    <?=$_SESSION['city']['name']?>
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    City Profile
</p>
<hr />

<h2>City Profile</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <input  
        name="name" 
        class="w3-input w3-border" 
        type="text" 
        id="name" 
        autocomplete="off"
        value="<?=$city['name']?>"
    />
    <label for="name" class="w3-text-gray">
        Name <span id="name-error" class="w3-text-red"></span>
    </label>

    <input 
        name="width" 
        class="w3-input w3-margin-top w3-border" 
        type="number" 
        id="width" 
        autocomplete="off"
        value="<?=$city['width']?>"
    />
    <label for="width" class="w3-text-gray">
        <i class="fa-solid fa-ruler"></i>
        Width <span id="width-error" class="w3-text-red"></span>
    </label>

    <input 
        name="height" 
        class="w3-input w3-border w3-margin-top" 
        type="number" 
        id="height" 
        autocomplete="off" 
        value="<?=$city['height']?>"
    />  
    <label for="height" class="w3-text-gray">
        <i class="fa-solid fa-ruler"></i>
        Height <span id="height-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="validateMainForm();">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Profile
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let name = document.getElementById("name");
        let name_error = document.getElementById("name-error");
        name_error.innerHTML = "";
        if (name.value == "") {
            name_error.innerHTML = "(name is required)";
            errors++;
        }

        let width = document.getElementById("width");
        let width_error = document.getElementById("width-error");
        width_error.innerHTML = "";
        if (width.value == "") {
            width_error.innerHTML = "(width is required)";
            errors++;
        }

        let height = document.getElementById("height");
        let height_error = document.getElementById("height-error");
        height_error.innerHTML = "";
        if (height.value == "") {
            height_error.innerHTML = "(height is required)";
            errors++;
        }

        if (errors) return false;
    }

</script>
    
<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

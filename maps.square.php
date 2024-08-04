<?php

security_check();
admin_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    // Basic serverside validation
    if (
        !validate_blank($_POST['type']))
    {
        message_set('Square Error', 'There was an error with your square information.', 'red');
        header_redirect('/maps/square/'.$_GET['key']);
    }

    $query = 'UPDATE squares SET
        type = "'.addslashes($_POST['type']).'"
        WHERE id = '.$_GET['key'].'
        LIMIT 1';

    echo $query;
    mysqli_query($connect, $query);
    

    message_set('Square Success', 'Square has been updated.');
    header_redirect('/maps/dashboard');
    
}

define('APP_NAME', 'Maps');

define('PAGE_TITLE', 'Modify Map Squares');
define('PAGE_SELECTED_SECTION', 'geography');
define('PAGE_SELECTED_SUB_PAGE', '/maps/squares');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$square = square_fetch($_GET['key']);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Maps
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/maps/dashboard">Maps</a> / 
    Modify Map Square
</p>
<hr />
<h2>Modify Map Square</h2>

<form
    method="post"
    novalidate
    id="main-form"
>

    <select
        name="type" 
        class="w3-input w3-border" 
        id="type" 
    >
        <option value="ground" <?=$square['type'] == 'ground' ? 'selected' : ''?>>Ground</option>
        <option value="water" <?=$square['type'] == 'water' ? 'selected' : ''?>>Water</option>
    </select>
    <label for="type" class="w3-text-gray">
        Type <span id="type-error" class="w3-text-red"></span>
    </label>

    <button class="w3-block w3-btn w3-orange w3-text-white w3-margin-top" onclick="return validateMainForm();">
        <i class="fa-solid fa-pen fa-padding-right"></i>
        Update Square
    </button>
</form>

<script>

    function validateMainForm() {
        let errors = 0;

        let type = document.getElementById("type");
        let type_error = document.getElementById("type-error");
        type_error.innerHTML = "";
        if (type.value == "") {
            type_error.innerHTML = "(type is required)";
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

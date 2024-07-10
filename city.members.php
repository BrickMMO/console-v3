<?php

security_check();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

    die();
    
    // Basic serverside validation
    if (
        !validate_blank($_POST['name']) || 
        !validate_number($_POST['width']) || 
        !validate_number($_POST['length']))
    {
        message_set('Login Error', 'There was an error with your profile information.', 'red');
        header_redirect('/city/profile');
    }

    $query = 'UPDATE cities SET
        name = "'.addslashes($_POST['name']).'",
        width = "'.addslashes($_POST['width']).'",
        length = "'.addslashes($_POST['length']).'"
        WHERE id = '.$_SESSION['city']['id'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    message_set('Success', 'Your city profile has been updated.');
    header_redirect('/city/dashboard');
    
}

define('APP_NAME', $_SESSION['city']['name']);

define('PAGE_TITLE', 'Members');
define('PAGE_SELECTED_SECTION', '');
define('PAGE_SELECTED_SUB_PAGE', '');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/main_header.php');

include('templates/message.php');

$city = city_fetch($_SESSION['city']['id']);

$query = 'SELECT users.*
    FROM users
    INNER JOIN city_user ON users.id = city_user.user_id
    WHERE city_user.city_id = '.$_SESSION['city']['id'].'
    ORDER BY last,first';
$result = mysqli_query($connect, $query);

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
    Members
</p>
<hr />

<h2>Members</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
        <th>Name</th>
        <th>GitHub</th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <img
                    src="<?=user_avatar($record['id']);?>"
                    style="height: 25px"
                    class="w3-circle"
                />
            </td>
            <td>
                <?php if($record['city_id'] == $_SESSION['city']['id']): ?>
                    <i class="fa-solid fa-lock"></i>
                <?php endif; ?>
            </td>
            <td>
                <?=$record['first']?> <?=$record['last']?>
            </td>
            <td>
                <?php if($record['github_username']): ?>
                    <a href="https://github.com/<?=$record['github_username']?>">
                        <i class="fa-brands fa-github"></i>
                        <?=$record['github_username']?>
                    </a>
                <?php endif; ?>
            </td>
            <td>
                <?php if($record['city_id'] != $_SESSION['city']['id']): ?>
                    <a href="/city/uninvite/user/<?=$record['id']?>">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/city/invite/"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-envelope fa-padding-right"></i> Invite New Member
</a>
    
<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

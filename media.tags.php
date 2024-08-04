<?php

security_check();
admin_check();

if (isset($_GET['delete'])) 
{

    $query = 'DELETE FROM tags 
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);

    $query = 'DELETE FROM media_tag
        WHERE medium_id = '.$_GET['delete'];
    mysqli_query($connect, $query);

    message_set('Delete Success', 'Tag has been deleted.');
    header_redirect('/media/tags');
    
}

define('APP_NAME', 'Media');

define('PAGE_TITLE', 'Tags');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/media/tags');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT tags.*,(
        SELECT COUNT(id)
        FROM media
        LEFT JOIN media_tag
        ON media.id = media_tag.medium_id
        WHERE image IS NOT NULL
    ) AS images,(
        SELECT COUNT(id)
        FROM media
        LEFT JOIN media_tag
        ON media.id = media_tag.medium_id
        WHERE video IS NOT NULL
    ) AS videos
    FROM tags
    ORDER BY name';
$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/bricksum.png"
        height="50"
        style="vertical-align: top"
    />
    Media
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/media/dashboard">Media</a> / 
    Tags
</p>

<hr />

<h2>Media Tags</h2>

<table class="w3-table w3-bordered w3-striped w3-margin-bottom">
    <tr>
        <th>Name</th>
        <th class="bm-table-number">Images</th>
        <th class="bm-table-number">Videos</th>
        <th class="bm-table-icon"></th>
        <th class="bm-table-icon"></th>
    </tr>

    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>
                <?=$record['name']?>
            </td>
            <td>
                <?=$record['images']?>
            </td>
            <td>
                <?=$record['videos']?>
            </td>
            <td>
                <a href="/media/tags/edit/<?=$record['id']?>">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            </td>
            <td>
                <a href="#" onclick="return confirmModal('Are you sure you want to delete the tag <?=$record['name']?>?', '/media/tags/delete/<?=$record['id']?>');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<a
    href="/media/tags/add"
    class="w3-button w3-white w3-border"
>
    <i class="fa-solid fa-tag fa-padding-right"></i> Add New Tag
</a>

<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');

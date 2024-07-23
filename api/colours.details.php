<?php

$query = 'SELECT colours.id, colours.name, rgb, is_trans, rebrickable_id, externals.name AS external_name, source
    FROM colours 
    INNER JOIN externals
    ON colours.id = externals.colour_id
    WHERE colours.id = 65';    

$result = mysqli_query($connect, $query);

if ($result) {

    header("Content-type: JSON");

    $colourObject = mysqli_fetch_assoc($result);

    $colour = array(
        'id' => $colourObject['id'],
        'name' => $colourObject['name'],
        'rgb' => $colourObject['rgb'],
        'is_trans' => $colourObject['is_trans'],
        'rebrickable_id' => $colourObject['rebrickable_id'],
        'external_ids' => array(),
    );

    mysqli_data_seek($result, 0);

    while ($externals = mysqli_fetch_assoc($result)) {
        $colour['external_ids'][] = array(
            'source' => $externals['source'],
            'name' => $externals['external_name']
        );
    }

    $data = array(
        'message' => 'Colours retrieved successfully.',
        'error' => false, 
        'colours' => $colour,
    );

} else {
    $data = array(
        'message' => 'Error retrieving colours detail.',
        'error' => true,
        'colours' => null,
    );
}

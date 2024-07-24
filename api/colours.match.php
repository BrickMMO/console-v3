<?php

if(isset($_GET['key'])) {

    $query = 'SELECT * 
    FROM colours 
    ORDER BY name'; 

    $result = mysqli_query($connect, $query);

    $colorArray = array();

    if($result){

        header("Content-type: JSON");

        $i = 0;

        while($colour = mysqli_fetch_assoc($result)){
            $colorArray[$i]['id'] = $colour['id'];
            $colorArray[$i]['name'] = $colour['name'];
            $colorArray[$i]['rgb'] = $colour['rgb'];
            $i++;
        }

        $colorDistanceArray = $colorArray;

        foreach($colorArray as $index => $color){

            $rgbColorDistance = colorDistance($color['rgb'], $_GET['key']);

            $colorDistanceArray[$index]['colorDistance'] = $rgbColorDistance;
        }
        
        usort($colorDistanceArray, function($first, $second) {
            if ($first['colorDistance'] == $second['colorDistance']) return 0;
            return ($first['colorDistance'] < $second['colorDistance']) ? -1 : 1;
        });

        $data = array(
            'message' => 'Colours retrieved successfully.',
            'error' => false, 
            'colours' => $colorDistanceArray,
        );
        
    } else {
        $data = array(
            'message' => 'Error retrieving colours detail.',
            'error' => true,
            'colours' => null,
        );
    }
}

function colorDistance($colorArray, $colourSearch) {

    $colorArray = hexToRgb($colorArray);
    $colourSearch = hexToRgb($colourSearch);

    $redDifference = $colorArray[0] - $colourSearch[0];
    $greenDifference = $colorArray[1] - $colourSearch[1];
    $blueDifference = $colorArray[2] - $colourSearch[2];

    return sqrt(($redDifference ** 2) + ($greenDifference ** 2) + ($blueDifference ** 2));       
}

function hexToRgb($hex) {

    if(strlen($hex) === 3){
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return [$r, $g, $b];
}
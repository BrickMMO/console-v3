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

        $minimun = 255;

        $closest = $colorArray[0];

        foreach($colorArray as $color){

            $rgbColorArray = colorDistance($color['rgb'], $_GET['key']);

            if($rgbColorArray < $minimun){
                $closest = $color;
                $minimun = $rgbColorArray;
            }
        }
        
        $data = array(
            'message' => 'Colours retrieved successfully.',
            'error' => false, 
            'colours' => $closest,
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
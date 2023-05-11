<?php

function imageToArray($imagePath){

    $imageContents = file_get_contents($imagePath);
    $image = imagecreatefromstring($imageContents);

    $imageArray = [];


    for ($y = 0; $y < 28; $y++) {
        for ($x = 0; $x < 28; $x++) {
            // Get the grayscale value of the pixel
            $pixel = imagecolorat($image, $x, $y);
            $gray = ($pixel >> 16) & 0xFF; // Extract the grayscale value

            echo $gray . " - ";

            $imageArray[] = $gray;
        }
    }

    imagedestroy($image);

    echo "xx: " . implode(" ", $imageArray) . "<br>";

    return implode(" ", $imageArray);
}

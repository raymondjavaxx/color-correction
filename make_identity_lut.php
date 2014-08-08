<?php

define('LUT_SIZE', 32);

$img = imagecreatetruecolor(LUT_SIZE * LUT_SIZE, LUT_SIZE);

$mult = 255 / LUT_SIZE;

foreach (range(0, LUT_SIZE - 1) as $r) {
    foreach (range(0, LUT_SIZE - 1) as $g) {
        foreach (range(0, LUT_SIZE - 1) as $b) {
            $x = $r + ($b * LUT_SIZE);
            $y = $g;
            $color = imagecolorallocate($img, $r * $mult, $g * $mult, $b * $mult);
            imagesetpixel($img, $x, $y, $color);
        };
    }
}

imagepng($img, __DIR__ . '/luts/identity.png');
imagedestroy($img);

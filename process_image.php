<?php

define('LUT_SIZE', 32);

$luts = glob('luts/*.png');

function color_map($lut, $r, $g, $b) {
    $x = floor(($r / 255) * (LUT_SIZE - 1)) + (floor(($b / 255) * (LUT_SIZE - 1)) * LUT_SIZE);
    $y = floor(($g / 255) * (LUT_SIZE - 1));

    $output = imagecolorsforindex($lut, imagecolorat($lut, $x, $y));

    return array(
        $output['red'],
        $output['green'],
        $output['blue']
    );
}

foreach ($luts as $lutfile) {
    $img = imagecreatefromjpeg(__DIR__ . '/image.jpg');
    $lut = imagecreatefrompng($lutfile);

    $w = imagesx($img);
    $h = imagesy($img);

    for ($x=0; $x < $w; $x++) {
        for ($y=0; $y < $h; $y++) {
            $rgb = imagecolorsforindex($img, imagecolorat($img, $x, $y));
            list($r, $g, $b) = color_map($lut, $rgb['red'], $rgb['green'], $rgb['blue']);
            imagesetpixel($img, $x, $y, imagecolorallocate($img, $r, $g, $b));
        }
    }

    $fn = __DIR__ . "/output/" . basename($lutfile, '.png') . ".jpg";
    imagejpeg($img, $fn);
}

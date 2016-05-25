<?php

$size = $_GET["size"];
$content = $_GET["content"];
$fgcolor = htmlspecialchars($_GET["fgcolor"]);
$bgcolor = htmlspecialchars($_GET["bgcolor"]);

$qr_image = 'https://chart.googleapis.com/chart?cht=qr&chs=' . $size . 'x' . $size . '&chl=' . $content  . '&choe=UTF-8';

$im = imagecreatefrompng($qr_image);

$fgcolors = covertHexToRGB($fgcolor);
$bgcolors = covertHexToRGB($bgcolor);

$im = changeForeground($im, $fgcolors[0], $fgcolors[1], $fgcolors[2]);
$im = changeBackground($im, $bgcolors[0], $bgcolors[1], $bgcolors[2]);

header("Content-Type: image/png");
imagepng($im);
imagedestroy($im);  

function changeForeground($im, $red, $green, $blue) {
	imagefilter($im, IMG_FILTER_COLORIZE, $red, $green, $blue);
	return $im;
}

function changeBackground($im, $red, $green, $blue) {
	imagetruecolortopalette($im, false, 255);
	$ig = imagecolorat($im, 0, 0);
	imagecolorset($im, $ig, $red, $green, $blue);
	return $im;
}

function covertHexToRGB($hex){
	$colors = sscanf($hex, "%02x%02x%02x");
	return $colors;
}
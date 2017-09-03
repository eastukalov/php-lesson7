<?php
	$im = imagecreatetruecolor(1500, 100);
    $text_color = imagecolorallocate($im, 19, 136, 8);
    $back_color = imagecolorallocate($im, 220, 220, 220);
    imagefill($im, 0, 0, $back_color);
    $font = __DIR__ . '/font/' . 'ofont.ru_Microsoft Sans Serif.ttf';
    $text=$_GET['fio'] . ', Ваш результат: ' . $_GET['score'];
    imagettftext($im, 45, 0, 10, 70, $text_color, $font, $text);
   	header('Content-Type: image/png');
 	imagepng($im);
	imagedestroy($im);
?>
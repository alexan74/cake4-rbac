<?php
if(!isset($_SESSION)) session_start();
//session_name('CAKEPHP');

define("WIDTH", 200);
define("HEIGHT", 70);
define("F_SIZE", 20);
define("F_ANGLE", 0);
define("VAR_ANGLE",35);



$rnd = rand(1,4);
$rnd = 1;
switch ($rnd) {
	case 1:
	    define("F_FONT", $_SERVER['DOCUMENT_ROOT']."/files/captcha/myfont.ttf");
		break;
	case 2:
	    define("F_FONT", $_SERVER['DOCUMENT_ROOT']."/files/captcha/myfont2.ttf");
		break;
	case 3:
	    define("F_FONT", $_SERVER['DOCUMENT_ROOT']."/files/captcha/myfont3.ttf");
		break;
	case 4:
	    define("F_FONT", $_SERVER['DOCUMENT_ROOT']."/files/captcha/myfont4.ttf");
		break;
}

	$img = imagecreate(WIDTH, HEIGHT);

    $white = imagecolorallocate($img, 255,255,255);
    $brdr = imagecolorallocate($img, 0,0,0);
	$black = imagecolorallocate($img, rand(0,50),rand(0,50),rand(0,50));

    $start_x = rand(10,15);
    $start_y = (int)HEIGHT/2;

    imagerectangle($img, 0,0,WIDTH-1,HEIGHT-1, $brdr);

	$text = chr(rand(65,90));
	$key = $text;
    imageTTFtext($img, F_SIZE, F_ANGLE + rand(VAR_ANGLE*-1,VAR_ANGLE), $start_x+rand(-8,8), $start_y + (rand(-5,15)), $black, F_FONT, $text);
	$text = chr(rand(65,90));
	$key = $key.$text;
	imageTTFtext($img, F_SIZE, F_ANGLE + rand(VAR_ANGLE*-1,VAR_ANGLE), $start_x+30+rand(-8,8), $start_y + (rand(-5,15)), $black, F_FONT, $text);
	$text = chr(rand(65,90));
	$key = $key.$text;
	imageTTFtext($img, F_SIZE, F_ANGLE + rand(VAR_ANGLE*-1,VAR_ANGLE), $start_x+60+rand(-8,8), $start_y + (rand(-5,15)), $black, F_FONT, $text);
	$text = chr(rand(65,90));
	$key = $key.$text;
	imageTTFtext($img, F_SIZE, F_ANGLE + rand(VAR_ANGLE*-1,VAR_ANGLE), $start_x+90+rand(-8,8), $start_y + (rand(-5,15)), $black, F_FONT, $text);
	$text = chr(rand(65,90));
	$key = $key.$text;
	imageTTFtext($img, F_SIZE, F_ANGLE + rand(VAR_ANGLE*-1,VAR_ANGLE), $start_x+120+rand(-8,8), $start_y + (rand(-5,15)), $black, F_FONT, $text);
	$text = chr(rand(65,90));
	$key = $key.$text;
	imageTTFtext($img, F_SIZE, F_ANGLE + rand(VAR_ANGLE*-1,VAR_ANGLE), $start_x+150+rand(-8,8), $start_y + (rand(-5,15)), $black, F_FONT, $text);
        
        
    $_SESSION['hash']=$key;

$rnd = rand(1,9);
switch ($rnd) {
	case 1:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha.png");
		break;
	case 2:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha2.png");
		break;
	case 3:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha3.png");
		break;
	case 4:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha4.png");
		break;
	case 5:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha5.png");
		break;
	case 6:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha6.png");
		break;
	case 7:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha7.png");
		break;
	case 8:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha8.png");
		break;
	case 9:
	    $img_copy = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/files/captcha/captcha9.png");
		break;
}
imagecopymerge($img, $img_copy, 0, 0, 0, 0, imagesx($img), imagesy($img), rand(30,50));
header("Content-Type: image/png");
imagepng($img);
imagedestroy($img);
?>
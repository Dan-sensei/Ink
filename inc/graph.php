	<?php
	define('WIDTH', 300);
	define('HEIGHT', 250);
	$data = array(
		"Dia 1"=>40,
		"Dia 2"=>2,
		"Dia 3"=>14,
		"Dia 4"=>81,
		"Dia 5"=>10,
		"Dia 6"=>24,
		"Dia 7"=>70
    );
    $img = imagecreatetruecolor(WIDTH, HEIGHT); 
    $bg_color = imagecolorallocate($img, 255, 255, 255); // white
	$text_color = imagecolorallocate($img, 255, 255, 255); // black
	$bar_color =imagecolorallocate($img, 124, 56, 183);
	$score_color = imagecolorallocate($img,255, 195, 0);

 	imagealphablending($img, false);
	$transparency = imagecolorallocatealpha($img, 0, 0, 0, 127);
	imagefill($img, 0, 0, $transparency);
	imagesavealpha($img, true);

	imageline($img,(count($data)*50),HEIGHT-18,30,HEIGHT-18, $text_color);
	imageline($img, 30, 18, 30, HEIGHT-20, $text_color);

	$r=1;
	foreach ($data as $course=>$result):
		$rectx1 = 35*$r;
		$form=1;
		$start =0;
		$stop=0;
		
		$strx =36*$r;
		$text_size = 0.9;
		$start = HEIGHT-20;
		$stop = HEIGHT-20-(($result)*2);
		imagefilledrectangle($img, $rectx1, $stop, $rectx1+20, $start, $bar_color);
		imagestring($img, $text_size, $strx, $start-$result*2-9, $result, $score_color);

		imagestring($img,0.4,36*$r,HEIGHT-15,$course,$text_color);
		$r++;
	endforeach;

	imagestring($img,10, 100, 10,"Ultimas fotos", $text_color);

	for ($i=0;$i<11;$i++)
		imagestringup($img,0.2, 20, 230-($i*20), $i*10, $text_color);
	
	//header("Content-type: image/png");
	ob_start();
	imagepng($img);
	printf('<img src="data:image/png;base64,%s"/>', base64_encode(ob_get_clean()));
	imagedestroy($img);
?>

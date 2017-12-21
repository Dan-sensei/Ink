<?php
	define('WIDTH', 300);
	define('HEIGHT', 250);
	$init = parse_ini_file("config.ini");
	$error = -1;
	$inkbd = @new mysqli( 
	         $init["Server"],   	// El servidor 
	         $init["User"],    		// El usuario 
	         $init["Password"],     // La contraseña 
	         $init["Database"]); 	// La base de datos 
	 
	if($inkbd->connect_errno) 
	   $error = 1;
/*
	$last_7_days = "SELECT FRegistro, COUNT(*) as total
      FROM (SELECT DATE_SUB(NOW(), INTERVAL 7 DAY) the_day) a
      LEFT JOIN fotos b ON YEAR(b.FRegistro) = YEAR(a.the_day) 
      AND MONTH(b.FRegistro)=MONTH(a.the_day) AND DAY(b.FRegistro) = DAY(a.the_day)
      GROUP BY DAY(FRegistro)";
      */

      $last_7_days = "SELECT (DATE(NOW()) - INTERVAL day DAY) AS DayDate, count(IdFoto) as total
      FROM (SELECT 0 AS day
      		UNION SELECT 1
      		UNION SELECT 2
      		UNION SELECT 3
      		UNION SELECT 4
      		UNION SELECT 5
      		UNION SELECT 6
      		UNION SELECT 7
      	) AS week
      	LEFT JOIN fotos ON DATE(FRegistro) = (DATE(NOW()) - INTERVAL `day` DAY)
      GROUP BY `DayDate`
      ORDER BY `DayDate` ASC";
//FROM (SELECT FRegistro FROM fotos BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() ) a
//FRegistro BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()
	if(!($graph = $inkbd->query($last_7_days))) { 
		echo "<p>Error al ejecutar la sentencia <b>$last_7_days</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit; 
	} 
	
	$data = array();
	while ($item = $graph -> fetch_assoc()) {
		$data[$item['DayDate']] = $item['total'];
	}

	foreach ($data as $key => $value) {
		echo $key." ".$value."<br>";
	}
	$data = array(
		"Dia 1"=>40,
		"Dia 2"=>2,
		"Dia 3"=>14,
		"Dia 4"=>81,
		"Dia 5"=>10,
		"Dia 6"=>24,
		"Dia 7"=>70
    );

	exit;
    $img 			=	imagecreatetruecolor(WIDTH, HEIGHT); 
    $bg_color 		= 	imagecolorallocate($img, 255, 255, 255); 	// WHITE
	$text_color 	= 	imagecolorallocate($img, 255, 255, 255); 	// BLACK
	$bar_color 		=	imagecolorallocate($img, 124,  56, 183);	// PURPLE
	$score_color 	= 	imagecolorallocate($img, 255, 195,   0);	// ORANGE

 	imagealphablending($img, false);
	$transparency = imagecolorallocatealpha($img, 0, 0, 0, 127);
	imagefill($img, 0, 0, $transparency);
	imagesavealpha($img, true);

	imageline($img,(count($data)*50), HEIGHT-18, 30, HEIGHT-18, $text_color);
	imageline($img, 30, 18, 30, HEIGHT-20, $text_color);

	$r=1;
	foreach ($data as $course=>$result):
		$rectx1 = 35*$r;
		$start = 0;
		$stop= 0;	
		$strx = 36*$r;
		$text_size = 0.9;
		$start = HEIGHT-20;
		$stop = HEIGHT-20-(($result)*2);
		imagefilledrectangle($img, $rectx1, $stop, $rectx1+20, $start, $bar_color);
		imagestring($img, $text_size, $strx, $start-$result*2-9, $result, $score_color);
		imagestring($img, 0.4, 36*$r, HEIGHT-15, $course, $text_color);
		$r++;
	endforeach;

	imagestring($img, 10, 100, 10, "Ultimas fotos", $text_color);

	for ($i=0; $i<11; $i++)
		imagestringup($img, 0.2, 20, 230-($i*20), $i*10, $text_color);
	
	//header("Content-type: image/png");
	ob_start();
	imagepng($img);
	printf('<img src="data:image/png;base64,%s"/>', base64_encode( ob_get_clean() ) );
	imagedestroy($img);
?>

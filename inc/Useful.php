<?php
	define("finalx", 400);
	define("finaly", 244);
	//https://stackoverflow.com/questions/15035632/merge-a-png-ontop-of-a-jpg-and-retain-transparency-with-php
	function Miniaturiza($path, $min) {

		$size = getimagesize($path);
		$aspect = $size[0] / $size[1];

		if($size[0]>$size[1]){
			$width = $min;
			$height = round($width / $aspect);
		}
		else{
			$height = $min;
			$width = round($height / $aspect);
		}

		$ink = imagecreatefrompng("img/Default.png");
		$parts = pathinfo($path);

		switch ($parts['extension']) {
			case "jpg":
			case "jpeg":
						$img = imagecreatefromjpeg($path);
						break;
			
			case "png":
						$img = imagecreatefrompng($path);
						break;

			case "gif":
						$img = imagecreatefromgif($path);
						break;
		}

		$thumbnail = imagecreatetruecolor($width, $height);
		
		$final = imagecreatetruecolor(finalx, finaly);

		imagealphablending($thumbnail, true);
		$transparency = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127);
		imagefill($thumbnail, 0, 0, $transparency);
		imagesavealpha($thumbnail, true);

		imagealphablending($final, true);
		$transparency = imagecolorallocatealpha($final, 0, 0, 0, 127);
		imagefill($final, 0, 0, $transparency);
		imagesavealpha($final, true);

		imagecopyresampled($thumbnail, $img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
		imagecopyresampled($final, $thumbnail, finalx-$width, finaly-$height-13, 0, 0, $width, $height, $width, $height);
		imagecopyresampled($final, $ink, finalx/4-10, 0, 0, 0, 248, 244, 248, 244);

		ob_start();
		imagepng($final);
		
		printf('<img src="data:image/png;base64,%s"/>', base64_encode( ob_get_clean() ) );

		ob_end_clean();
		imagedestroy($thumbnail);

	}

	function Miniaturiza_DOS($path, $path2, $min) {

		$size = getimagesize($path);
		$size2 = getimagesize($path2);

		$aspect = $size[0] / $size[1];
		$aspect2 = $size2[0] / $size2[1];

		if($size[0]>$size[1]){
			$width = $min;
			$height = round($width / $aspect);
		}
		else{
			$height = $min;
			$width = round($height / $aspect);
		}

		if($size2[0]>$size2[1]){
			$width2 = $min;
			$height2 = round($width2 / $aspect2);
		}
		else{
			$height2 = $min;
			$width2 = round($height2 / $aspect2);
		}

		$ink = imagecreatefrompng("img/Default.png");
		$parts = pathinfo($path);

		switch ($parts['extension']) {
			case "jpg":
			case "jpeg":
						$img = imagecreatefromjpeg($path);
						break;
			
			case "png":
						$img = imagecreatefrompng($path);
						break;

			case "gif":
						$img = imagecreatefromgif($path);
						break;
		}

		$parts = pathinfo($path2);
		switch ($parts['extension']) {
			case "jpg":
			case "jpeg":
						$img2 = imagecreatefromjpeg($path2);
						break;
			
			case "png":
						$img2 = imagecreatefrompng($path2);
						break;

			case "gif":
						$img2 = imagecreatefromgif($path2);
						break;
		}

		$thumbnail = imagecreatetruecolor($width, $height);
		$thumbnail2 = imagecreatetruecolor($width2, $height2);

		$final = imagecreatetruecolor(finalx, finaly);

		imagealphablending($thumbnail, true);
		$transparency = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127);
		imagefill($thumbnail, 0, 0, $transparency);
		imagesavealpha($thumbnail, true);

		imagealphablending($thumbnail2, true);
		$transparency = imagecolorallocatealpha($thumbnail2, 0, 0, 0, 127);
		imagefill($thumbnail2, 0, 0, $transparency);
		imagesavealpha($thumbnail2, true);

		imagealphablending($final, true);
		$transparency = imagecolorallocatealpha($final, 0, 0, 0, 127);
		imagefill($final, 0, 0, $transparency);
		imagesavealpha($final, true);

		imagecopyresampled($thumbnail, $img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);	//REDIMENSION
		imagecopyresampled($thumbnail2, $img2, 0, 0, 0, 0, $width2, $height2, $size2[0], $size2[1]);

		imagecopyresampled($final, $thumbnail, finalx-$width, finaly-$height-13, 0, 0, $width, $height, $width, $height);
		imagecopyresampled($final, $thumbnail2, 20, 50, 0, 0, $width2, $height2, $width2, $height2);

		imagecopyresampled($final, $ink, finalx/4-10, 0, 0, 0, 248, 244, 248, 244);

		ob_start();
		imagepng($final);
		
		printf('<img src="data:image/png;base64,%s"/>', base64_encode( ob_get_clean() ) );

		ob_end_clean();
		imagedestroy($thumbnail);
	}

	function Miniaturiza_MOTTO($path, $min){
		$size = getimagesize($path);
		$aspect = $size[0] / $size[1];

		if($size[0]>$size[1]){
			$width = $min;
			$height = round($width / $aspect);
		}
		else{
			$height = $min;
			$width = round($height / $aspect);
		}

		$ink = imagecreatefrompng("img/Default.png");
		$parts = pathinfo($path);

		switch ($parts['extension']) {
			case "jpg":
			case "jpeg":
						$img = imagecreatefromjpeg($path);
						break;
			
			case "png":
						$img = imagecreatefrompng($path);
						break;

			case "gif":
						$img = imagecreatefromgif($path);
						break;
		}

		$thumbnail = imagecreatetruecolor($width, $height);

		imagealphablending($thumbnail, true);
		$transparency = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127);
		imagefill($thumbnail, 0, 0, $transparency);
		imagesavealpha($thumbnail, true);

		imagecopyresampled($thumbnail, $img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);

		ob_start();
		imagepng($thumbnail);
		
		printf('<img src="data:image/png;base64,%s"/>', base64_encode( ob_get_clean() ) );

		imagedestroy($thumbnail);
	}
?>
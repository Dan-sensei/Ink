<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php"); 
	require_once("inc/validation.php");

	if(!isset($_POST["name"]) || $_POST["name"]==""){
		$host = $_SERVER["HTTP_HOST"];
		$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: http://$host$uri/Solicitar.php");
		exit;
	}

	$name = $talbum = $destinatario = $adicional = $direccion = $color = $copias = $res = $album = $date = $acolor = "";
	
	$name = 		validate_input($_POST["name"])." ".validate_input($_POST["surname"]);
	$talbum = 		validate_input($_POST["talbum"]);
	$destinatario = validate_input($_POST["destinatario"]);
	$adicional = 	validate_input($_POST["adicional"]);

	$direccion = 	validate_input($_POST["direccion"])." ".validate_input($_POST["direccion2"]);
	//$direccion = 	validate_input($_POST["direccion"])." ".validate_input($_POST["direccion2"]).", <br>".validate_input($_POST["ciudad"]).", ".validate_input($_POST["provincia"])." ".validate_input($_POST["cp"])."<br>".validate_input($_POST["pais"]);
	$pais = validate_input($_POST["pais"]);
	$ciudad = validate_input($_POST["ciudad"]);
	$provincia = validate_input($_POST["provincia"]);
	$cp = validate_input($_POST["cp"]);
	$color = 		validate_input($_POST["color"]);
	$copias = 		validate_input($_POST["copias"]);
	$res = 			validate_input($_POST["res"]);
	$album = 	validate_input($_POST["album"]);
	$date = 	validate_input($_POST["date"]);
	$acolor = 	validate_input($_POST["acolor"]);

	validate_name($name, 0);
	validate_email($destinatario, 0);
	validate_pais($pais);
	validate_cit($city);

	$paginas=15;
	$precio=0;
	switch ($res) {
		case '150':
			$precio+=0.8*$paginas;
			if($acolor=="Color")
				$precio+=1;
			else
				$precio+=0.7;
			break;
		case '300':
			$precio+=1.2*$paginas;
			if($acolor=="Color")
				$precio+=2.5;
			else
				$precio+=2.7;
			break;
		case '450':
			$precio+=1.6*$paginas;
			if($acolor=="Color")
				$precio+=4;
			else
				$precio+=3.5;
			break;
		case '600':
			$precio+=2.4*$paginas;
			if($acolor=="Color")
				$precio+=8;
			else
				$precio+=7.3;
			break;
		case '750':
			$precio+=3.2*$paginas;
			if($acolor=="Color")
				$precio+=12;
			else
				$precio+=10;
			break;
		case '900':
			$precio+=4*$paginas;
			if($acolor=="Color")
				$precio+=15;
			else
				$precio+=12.5;
			break;
	}

	if($adicional=="")
		$adicional="-";
?>
	
	<section id="confirmacion">

		<h2>Pedido confirmado</h2>
			<p><b>Nombre: </b> <?php echo $name?> </p>
			<p><b>Título del album:</b> <?php echo $talbum?> </p>
			<p><b>Correo del destinatario: </b> <?php echo $destinatario?> </p>
			<p><b>Texto adicional: </b> <?php echo $adicional?> </p>
			<p><b>Dirección: </b> <?php echo $direccion?> </p>
			<p><b>Color de la portada: </b> <?php echo $color?> </p>
			<p><b>Número de copias: </b> <?php echo $copias?> </p>
			<p><b>Resolución de las fotos: </b> <?php echo $res?> </p>
			<p><b>Álbum: </b> <?php echo $album?> </p>
			<p><b>Fecha de recepción: </b> <?php echo $date?> </p>
			<p><b>Impresión: </b> <?php echo $acolor?> </p>

		<h2>Precio: <?php echo $precio?> € </h2>

	</section>
	
<?php
	require_once("inc/footer.php"); 
?>
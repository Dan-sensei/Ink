<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	
	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$id=intval($_GET['id']);
	$sql = "SELECT COUNT(IdAlbum) as 'exists', Fecha, NomPais, IdAlbum, Titulo, Descripcion, Cover 
			FROM (`usuarios` INNER JOIN `albumes` ON IdUsuario = '".$_SESSION["IdUsuario"]."' AND Usuario = IdUsuario AND IdAlbum=".$id.") LEFT JOIN `paises` ON albumes.Pais=IdPais";

	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$album = $resultado->fetch_assoc();

	if($album['exists'] == 0){
		$error = 0;
		require("inc/error.php");
		exit;
	}

	if(!isset($_SESSION['datosYerrores']))
		header("Location: http://$host$uri/albumes.php");

	unset($_SESSION['datosYerrores']);
	unset($_SESSION['error2']);
	
?>
<section id="albumes">
	<h3> Album creado! </h3>
	<div id="columnas_insercion">

		<?php
		$fecha="";
		if($album['Fecha']!= NULL)
			$fecha = date_create($album['Fecha'])->format('d m Y')."<br>";
		
		if(empty($album['Cover']))
			$album['Cover'] = 'img/icon.png';

		echo "<figure>
				<a href='Album.php?id=".$album['IdAlbum']."'>
					<div>
						<img src='".$album['Cover']."' alt='Album ".$album['Descripcion']."'>	
					</div>
					<div>
						<p>
							<span class='titulo'>".$album['Titulo']."</span><br>
							<span>".$album['Descripcion']."</span><br>
							".$fecha.$album['NomPais']."
						</p>
					</div>
				</a>
			</figure>
		</div>";

	$resultado->close();
	require_once("inc/footer.php"); 
?>
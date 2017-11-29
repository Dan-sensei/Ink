<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	
	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$id=intval($_GET['id']);
	$sql = "SELECT COUNT(IdFoto) as 'exists', IdFoto, fotos.Titulo as fTitulo, fotos.Descripcion as fDescripcion, fotos.Fecha as fFecha, NomPais, IdAlbum, albumes.Titulo as aTitulo, Fichero 
			FROM (`fotos` INNER JOIN `albumes` ON Album = IdAlbum) LEFT JOIN `paises` ON fotos.Pais=IdPais
			WHERE IdFoto=".$id;

	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$foto = $resultado->fetch_assoc();

	if($foto['exists'] == 0){
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
	<h3> Foto añadida al album <?php echo "<a style='color:#a437ad;' href='Album.php?id=".$foto['IdAlbum']."'>".$foto['aTitulo']."</a>!"; ?></h3>
	<div id="columnas_insercion">

		<?php
		$fecha="";
		if($foto['fFecha']!=NULL)
			$fecha = date_create($foto['fFecha'])->format('d m Y')."<br>";
		
		if(empty($foto['Cover']))
			$foto['Cover'] = 'img/icon.png';

		echo "<figure>
				<a href='Detalle_foto.php?id=".$foto['IdFoto']."'>
					<div>
						<img src='".$foto['Fichero']."' alt='".$foto['fDescripcion']."'>	
					</div>
					<div>
						<p>
							<span class='titulo'>".$foto['fTitulo']."</span><br>
							<span>".$foto['fDescripcion']."</span><br>
							".$fecha.$foto['NomPais']."
						</p>
					</div>
				</a>
			</figure>
		</div>";

	$resultado->close();
	require_once("inc/footer.php"); 
?>
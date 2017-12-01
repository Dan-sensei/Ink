<?php
	include_once("inc/head.php");
	include_once("inc/header_logged.php");

	$sql_t = "SELECT Titulo, Cover from albumes WHERE IdAlbum = '".$_GET['id']."'";
	if(!($resultado = $inkbd->query($sql_t))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_t</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$title = $resultado->fetch_assoc();
	$resultado->close();

	$id = intval($_GET['id']);

	$sql = "SELECT COUNT(*) as 'exists', Foto, IdUsuario, NomUsuario
			FROM `usuarios`,`fotos` INNER JOIN `albumes` ON Album=IdAlbum AND Album = ".$id." 
			WHERE IdUsuario = Usuario";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$image = $resultado->fetch_assoc();

	if(empty($title['Titulo'])){
		$error = 0;
		require("inc/error.php");
		exit;
	}
	else{
		echo "<section id='albumes'>";
		if($image['IdUsuario'] != $_SESSION['IdUsuario'])
			echo	"	<a id='u' href=#> <img id='user_mini_f' src='".$image['Foto']."'><span>". $image['NomUsuario'] . "</span></a>";

		echo "<img style='display:block; margin: 0 auto; height: 150px;' src='".$title['Cover']."'>
				<h3>".$title['Titulo']."</h3>";
		if($image['exists']==0){
			echo "<h2 style=' margin:0; padding-top:20px; color:white; text-align:center;'>No hay fotos añadidas a este album</h2>";
		}
		else{

			$sql = "SELECT albumes.Titulo as aTitulo, IdFoto, fotos.Titulo as fTitulo, fotos.Descripcion as fDescripcion, fotos.fecha as fFecha, fotos.Pais as fPais, Fichero, NomPais
			FROM (`fotos` INNER JOIN `albumes` ON Album=IdAlbum AND Album = ".$id.") LEFT JOIN `paises` ON fotos.Pais = IdPais";
			
			if(!($resultado = $inkbd->query($sql))) { 
				echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
				echo "</p>"; 
				exit;
			}
			$image = $resultado->fetch_assoc();

			echo "<div id='columnas'>";
			do {
				if($image['fFecha']!= NULL)
					$date = date_create($image['fFecha'])->format('d-m-Y')."<br>";
				else
					$date = "";

				echo   "<figure>
							<a href='Detalle_foto.php?id=".$image['IdFoto']."'>
								<div>
									<img src='".$image['Fichero']."' alt='".$image['fTitulo']."'>
									<div><p>
											<span class='titulo'>".$image['fTitulo']."</span><br>".$date.$image['NomPais']."</p>
									</div>
								</div>
							</a>
						</figure>";

			} while($image = $resultado->fetch_assoc() );

			echo "</div>
				</section>";
		}
	}

	$resultado->close(); 
	require_once("inc/footer.php"); 
?>
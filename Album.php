<?php
	include_once("inc/head.php");
	include_once("inc/header_logged.php");
	include_once("inc/Useful.php");

	define("limit", 5);


	$sql_t = "SELECT IdAlbum, Titulo, Cover from albumes WHERE IdAlbum = '".$_GET['id']."'";
	if(!($resultado = $inkbd->query($sql_t))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_t</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$title = $resultado->fetch_assoc();
	$resultado->close();

	if($title['Cover'] == "img/Default.png"){
		$get_album = "SELECT Fichero, (SELECT count(IdFoto) FROM fotos WHERE Album=".$title['IdAlbum'].") AS count FROM fotos WHERE Album=".$title['IdAlbum']." LIMIT 2";

		if(!($resultado = $inkbd->query($get_album))) { 
			echo "<p>Error al ejecutar la sentencia <b>$get_album</b>: " . $inkbd->error; 
			echo "</p>"; 
			exit;
		}
		$i = $resultado->fetch_assoc();

		if($i['count'] == 1)
			$path = $i['Fichero'];
		else if($i['count'] == 2){
			$path = $i['Fichero'];
			$i = $resultado->fetch_assoc();
			$path2 = $i['Fichero'];
		}
			
	}

	$id = intval($_GET['id']);

	//Usuario al que pertenece el album en caso de que no sea tuyo
	$sql = "SELECT COUNT(IdFoto) as 'exists', Foto, IdUsuario, NomUsuario
			FROM `usuarios`,`fotos` INNER JOIN `albumes` ON Album=IdAlbum AND Album = ".$id." 
			WHERE IdUsuario = Usuario";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$image = $resultado->fetch_assoc();
	$n_imagenes = $image['exists'];

	if(isset($_GET['page']) && ($_GET['page'] < 1 || $_GET['page'] > floor($n_imagenes/5)+1)){
		$error=0;
		require("inc/error.php");
		exit;
	}
	if(empty($title['Titulo'])){
		$error = 0;
		require("inc/error.php");
		exit;
	}
	else{
		//=========================================== DUEÑO DEL ALBUM ===========================================
		echo "<section id='albumes'>";
		if($image['IdUsuario'] != $_SESSION['IdUsuario'])
			echo	"<a id='u' href=#> <img id='user_mini_f' src='".$image['Foto']."'><span>". $image['NomUsuario'] . "</span></a>";
		//=======================================================================================================

		if(!empty($path)){
			if(!empty($path2))
				Miniaturiza_DOS($path, $path2, 180);
			else
				Miniaturiza($path1, 180);
		}else
			echo "<img style='height: 150px;' src='".$title['Cover']."'>";

		echo "<h3>".$title['Titulo']."</h3>";
		
		if($n_imagenes==0){
			echo "<h2>No hay fotos añadidas a este album</h2>";
		}
		else{
			//=========================================== IMAGENES ===========================================
			if(isset($_GET['page'])){
				if($_GET['page'] == 0) $_GET['page'] = 1;
				$offset = ($_GET['page']-1) * limit;
			}
			else
				$offset = 0;

			$sql = "SELECT albumes.Titulo as aTitulo, IdFoto, fotos.Titulo as fTitulo, fotos.Descripcion as fDescripcion, fotos.fecha as fFecha, fotos.Pais as fPais, Fichero, NomPais
			FROM (`fotos` INNER JOIN `albumes` ON Album=IdAlbum AND Album = ".$id.") LEFT JOIN `paises` ON fotos.Pais = IdPais LIMIT ".$offset.",".limit;
			
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
								<div>";
									 echo "<img src='".$image['Fichero']."' alt='".$image['fTitulo']."'>"; //Miniaturiza_MOTTO($image['Fichero'], 674); //
				echo			"<div><p>
											<span class='titulo'>".$image['fTitulo']."</span><br>".$date.$image['NomPais']."</p>
									</div>
								</div>
							</a>
						</figure>";

			} while($image = $resultado->fetch_assoc() );
			//================================================================================================
			echo "</div>";
			$n_imagenes = floor($n_imagenes/5)+1;
			if(!isset($_GET['page'])){
				$previous = 1;
				$current = 1;
				$next = $current == $n_imagenes ? 1 : 2;
			}
			else{

				$current = $_GET['page']; 
				$previous = $current == 1 ? 1 : $_GET['page']-1;
				$next = $current == $n_imagenes ? $n_imagenes : $_GET['page']+1;
			}

			
			echo 	"<div class='pagination'>
						<a href='Album.php?id=".$_GET['id']."&page=".$previous."''>&laquo;</a>";
						for($i = 1 ; $i<=$n_imagenes; $i++){
							if($i == $current)
								echo "<a class='active' href='Album.php?id=".$_GET['id']."&page=".$i."'>".$i."</a>";
							else
								echo "<a href='Album.php?id=".$_GET['id']."&page=".$i."'>".$i."</a>";
						}
						
			echo		"<a href='Album.php?id=".$_GET['id']."&page=".$next."''>&raquo;</a>
			 		</div>";
			echo "</section>";
		}
	}

	$resultado->close(); 
	require_once("inc/footer.php"); 
?>



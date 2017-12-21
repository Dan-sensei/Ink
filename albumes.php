<?php
	include_once("inc/head.php");
	include_once("inc/header_logged.php");
	include_once("inc/Useful.php");

	$sql = "SELECT Fecha, NomPais, IdAlbum, Titulo, Descripcion, Cover 
			FROM (`usuarios` INNER JOIN `albumes` ON IdUsuario = '".$_SESSION["IdUsuario"]."' AND Usuario = IdUsuario) LEFT JOIN `paises` ON albumes.Pais=IdPais";

	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
?>

	<section id="albumes">
		<img style='display:block; margin: 0 auto; height: 150px;' src='img/multiple_albums_icon.png'>
		<h3>Mis albumes</h3>
		
			<?php 
			$c = 0;
			echo "<div id='columnas3'>";
				while($option = $resultado->fetch_assoc() ) {
					$path = "";
					$path2 = "";
					$c=$c+1;
					$fecha="";
					if($option['Fecha']!= NULL)
						$fecha = date_create($option['Fecha'])->format('d m Y')."<br>";

					if($option['Cover'] == "img/Default.png"){
						$get_album = "SELECT Fichero, (SELECT count(IdFoto) FROM fotos WHERE Album=".$option['IdAlbum'].") AS count FROM fotos WHERE Album=".$option['IdAlbum']." LIMIT 2";

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
					
					echo "<figure>
							<a href='Album.php?id=".$option['IdAlbum']."'>
								<div>";

								if(!empty($path)){
									if(!empty($path2))
										Miniaturiza_DOS($path, $path2, 180);
									else
										Miniaturiza($path1, 180);
								}	
								else
									echo "<img src='".$option['Cover']."' alt='Album ".$c."'>";
								//$path ? Miniaturiza($path) : echo "<img src='".$option['Cover']."' alt='Album ".$c."'>";	
					echo		"</div>
								<div>
									<p>
										<span class='titulo'>".$option['Titulo']."</span><br>
										<span>".$option['Descripcion']."</span><br>
										".$fecha.$option['NomPais']."
									</p>
								</div>
							</a>
						</figure>";


			 	} 
			 	echo "</div>";
			 	if($c==0){
					echo "<h2 style='color:white; text-align: center;'>No tienes nigun album</h2>";
				}
			?>

		
	</section>

<?php
	require_once("inc/footer.php"); 
?>
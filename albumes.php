<?php
	include_once("inc/head.php");
	include_once("inc/header_logged.php");

	$sql = "SELECT Fecha, NomPais, IdAlbum, Titulo 
			FROM (`usuarios` INNER JOIN `albumes` ON IdUsuario = '".$_SESSION["IdUsuario"]."' AND Usuario = IdUsuario) LEFT JOIN `paises` ON albumes.Pais=IdPais";

	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
?>

	<section id="albumes">

		<h3>Mis albumes</h3>
		
			<?php 
			$c = 0;
			echo "<div id='columnas3'>";
				while($option = $resultado->fetch_assoc() ) { 

					$c=$c+1;
					$fecha="";
					if($option['Fecha']!="0000-00-00"){
						$fecha = date_create($option['Fecha'])->format('d m Y')."<br>";
					}

					
					echo "<figure>
							<a href='Album.php?id=".$option['IdAlbum']."'>
								<div>
									<img src='img/album_icon.png'>
									
								</div>
								<div>
									<p>
										<span class='titulo'>".$option['Titulo']."</span><br>".$fecha.$option['NomPais']."
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
	require_once("inc/footer.inc"); 
?>
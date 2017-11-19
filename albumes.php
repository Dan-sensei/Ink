<?php
	include_once("inc/head.php");
	include_once("inc/header_logged.php");

	$sql = "SELECT * FROM `usuarios`, `albumes` WHERE NomUsuario = '".$_SESSION["usuario"]."' AND IdUsuario=Usuario";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$pais = $resultado->fetch_assoc();

?>

	<section id="albumes">

		<h3>Mis albumes</h3>	
		<div id="columnas3">

			<?php 
			$c = 0;
				while($option = $resultado->fetch_assoc() ) { 

					$c=$c+1;
					$fecha="";
					if($option['Fecha']!="0000-00-00"){
						$date = date_create($option['Fecha'])->format('d m Y')."<br>";
					}

					$sql_getPaisC = "SELECT * FROM `paises` WHERE IdPais = '".$option['Pais']."'";
					if(!($resultado2 = $inkbd->query($sql_getPaisC))) { 
						echo "<p>Error al ejecutar la sentencia <b>$sql_getPaisC</b>: " . $inkbd->error; 
						echo "</p>"; 
						exit; 
					} 
					$pais = $resultado2->fetch_assoc();
					echo "<figure>
							<a href='Album.php?id=".$option['IdAlbum']."'>
								<div>
									<img src='img/album_icon.png'>
									
								</div>
								<div>
									<p>
										<span class='titulo'>".$option['Titulo']."</span><br>".$fecha.$pais['NomPais']."
									</p>
								</div>
							</a>
						</figure>";


			 	} 

			 	if($c==0){
					echo "<h2 style='color:white; text-align: center;'> Nada que mostrar</h2>";
				}
			?>

		</div>
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
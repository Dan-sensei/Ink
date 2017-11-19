<?php
	include_once("inc/head.php");
	include_once("inc/header_logged.php");

	$sql_t = "SELECT * from albumes WHERE IdAlbum = '".$_GET['id']."'";
	if(!($resultado = $inkbd->query($sql_t))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_t</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$title = $resultado->fetch_assoc();

	$sql = "SELECT IdFoto, fotos.Titulo as fTitulo, fotos.Descripcion as fDescripcion, fotos.fecha as fFecha, fotos.Pais as fPais, Fichero, albumes.Titulo as aTitulo, albumes.Descripcion as aDescripcion FROM `fotos`,`albumes` WHERE Album = '".$_GET['id']."' AND IdAlbum = '".$_GET['id']."'";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	

?>
	<section id="albumes">
		<h3><?php echo $title['Titulo'] ?></h3>	
		<div id="columnas">
			<?php
			$c=0;
			while($image = $resultado->fetch_assoc() ) {
				$c=$c+1;
				if($image['fFecha']!="0000-00-00")
					$date = date_create($image['fFecha'])->format('d-m-Y')."<br>";
				else
					$date = "";

				$sql_getPaisC = "SELECT * FROM `paises` WHERE IdPais = '".$image['fPais']."'";
				if(!($resultado2 = $inkbd->query($sql_getPaisC))) { 
					echo "<p>Error al ejecutar la sentencia <b>$sql_getPaisC</b>: " . $inkbd->error; 
					echo "</p>"; 
					exit; 
				} 
				$pais = $resultado2->fetch_assoc();
				echo   "<figure>
							<a href='Detalle_foto.php?id=".$image['IdFoto']."'>
								<div>
									<img src='".$image['Fichero']."' alt='".$image['fTitulo']."'>
									<div><p>
											<span class='titulo'>".$image['fTitulo']."</span><br>".$date.$pais['NomPais']."</p>
									</div>
								</div>
							</a>
						</figure>";
			} 

			if($c==0){
				echo "<h2 style='color:white;'>No hay fotos añadidas a este album</h2>";
			}
			?>

		</div>
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
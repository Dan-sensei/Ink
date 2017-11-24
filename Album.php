<?php
	include_once("inc/head.php");
	include_once("inc/header_logged.php");

	$sql_t = "SELECT Titulo from albumes WHERE IdAlbum = '".$_GET['id']."'";
	if(!($resultado = $inkbd->query($sql_t))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_t</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$title = $resultado->fetch_assoc();

	$sql = "SELECT albumes.Titulo, IdFoto, fotos.Titulo as fTitulo, fotos.Descripcion as fDescripcion, fotos.fecha as fFecha, fotos.Pais as fPais, Fichero, NomPais
			FROM (`fotos`,`albumes` WHERE Album = '".$_GET['id']."' ) LEFT JOIN `paises` ON fotos.Pais = IdPais";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	
?>
	<section id="albumes">
		<?php
		if($title['Titulo']!=""){
			 echo "<h3>".$title['Titulo'],"</h3>";	
				echo "<div id='columnas'>";

				$c=0;
				while($image = $resultado->fetch_assoc() ) {
					$c=$c+1;
					if($image['fFecha']!="0000-00-00")
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
				} 
				echo "</div>";
				if($c==0){
					echo "<h2 style='color:white; text-align:center;'>No hay fotos añadidas a este album</h2>";
				}
		}
		else{
			echo "<div id='NotFound'>
					<img  src='img/404 not found.png' alt='Elemento no encontrado'>
				</div>";
		}
			?>

		
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
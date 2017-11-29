<?php 

	require_once("inc/head.php"); 
	require_once("inc/header.php"); 

	$sql_getFotos = "SELECT * FROM `fotos` ORDER BY IdFoto DESC LIMIT 5";
	if(!($resultado = $inkbd->query($sql_getFotos))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_getFotos</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit; 
	} 
?>
	<section id="columnas">
		<?php
		while($image = $resultado->fetch_assoc() ) {
			if($image['Fecha']!=NULL)
				$date = date_create($image['Fecha'])->format('d-m-Y')."<br>";
			else
				$date = "";

			$sql_getPaisC = "SELECT * FROM `paises` WHERE IdPais = '".$image['Pais']."'";
			if(!($resultado2 = $inkbd->query($sql_getPaisC))) { 
				echo "<p>Error al ejecutar la sentencia <b>$sql_getPaisC</b>: " . $inkbd->error; 
				echo "</p>"; 
				exit; 
			} 
			$pais = $resultado2->fetch_assoc();
			echo   "<figure>
						<a href='Detalle_foto.php?id=".$image['IdFoto']."'>
							<div>
								<img src='".$image['Fichero']."' alt='".$image['Titulo']."'>
								<div><p>
										<span class='titulo'>".$image['Titulo']."</span><br>".$date.$pais['NomPais']."</p>
								</div>
							</div>
						</a>
					</figure>";
		} 
		?>
	</section>

<?php
	require_once("inc/footer.php"); 
?>
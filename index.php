<?php 

	require_once("inc/head.php"); 
	require_once("inc/header.php"); 

	$sql_getFotos = "SELECT IdFoto, Titulo, Fecha, Fichero, NomPais FROM `fotos` LEFT JOIN `paises` ON IdPais=Pais ORDER BY IdFoto DESC LIMIT 5";
	if(!($resultado = $inkbd->query($sql_getFotos))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_getFotos</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit; 
	} 

	$SelectedFotos = array();
	$TOP = fopen("inc/TOP.txt", "r") or die("Unable to open file!");
	while(fgets($TOP)!=NULL){
		array_push(
			$SelectedFotos, 
			array(
				fgets($TOP),
				fgets($TOP),
				fgets($TOP)
			)
		);
	}
	fclose($TOP);

	shuffle($SelectedFotos);
	$selected1 = pathinfo($SelectedFotos[0][0]);
	$selected1 = substr($selected1['filename'], 6);

	$selected2 = pathinfo($SelectedFotos[1][0]);
	$selected2 = substr($selected2['filename'], 6);

	$selected3 = pathinfo($SelectedFotos[2][0]);
	$selected3 = substr($selected3['filename'], 6);

	$sql_getSelectedFotos = "SELECT IdFoto, Titulo, Fecha, Fichero, NomPais FROM `fotos` LEFT JOIN `paises` ON IdPais=Pais
								WHERE IdFoto IN(".$selected1.",".$selected2.",".$selected3.")
								ORDER BY FIELD(IdFoto,".$selected1.",".$selected2.",".$selected3.")";

	if(!($resultadoS = $inkbd->query($sql_getSelectedFotos))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_getFotos</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit; 
	} 

?>

	<div id="selected">
		<h2>Fotos seleccionadas</h2>
		<?php
		$i = 0;
		while($image = $resultadoS->fetch_assoc()){
			if($image['Fecha']!=NULL)
				$date = date_create($image['Fecha'])->format('d-m-Y')."<br>";
			else
				$date = "";

			echo "<figure>
					<a href='Detalle_foto.php?id=".$image['IdFoto']."'>
						<div>
							<img src='".$image['Fichero']."' alt='".$image['Titulo']."'>
							<div><p>
									<span class='titulo'>".$image['Titulo']."</span>
									<br>".$date.$image['NomPais']."<br>
									<br>\"".$SelectedFotos[$i][2]."\"
									<br><span style='color:black;'>".$SelectedFotos[$i][1]."</span>
								</p>
							</div>
						</div>
					</a>
				</figure>";
				$i++;
		}
		?>
		
	</div>
	<section id="columnas">
		<?php
		while($image = $resultado->fetch_assoc() ) {
			if($image['Fecha']!=NULL)
				$date = date_create($image['Fecha'])->format('d-m-Y')."<br>";
			else
				$date = "";

			echo   "<figure>
						<a href='Detalle_foto.php?id=".$image['IdFoto']."'>
							<div>
								<img src='".$image['Fichero']."' alt='".$image['Titulo']."'>
								<div><p>
										<span class='titulo'>".$image['Titulo']."</span><br>".$date.$image['NomPais']."</p>
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
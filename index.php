<?php 

	require_once("inc/head.php"); 
	require_once("inc/header.php"); 

	$sql_getFotos = "SELECT IdFoto, Titulo, Fecha, Fichero, NomPais FROM `fotos` LEFT JOIN `paises` ON IdPais=Pais ORDER BY IdFoto DESC LIMIT 5";
	if(!($resultado = $inkbd->query($sql_getFotos))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_getFotos</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit; 
	} 

	$contador_s = 0;
	$selected1 = $selected2 = $selected3 = "";

	$SelectedFotos = array();
	$TOP = fopen("inc/TOP.txt", "r") or die("Unable to open file!");
	$line = fgets($TOP);
	if($line != NULL && !empty($line)){
		while($line!=NULL){
			$split = explode("|", $line);	
			$contador_s++;
			array_push(
				$SelectedFotos, 
				array(
					trim($split[0]),
					trim($split[1]),
					trim($split[2])
				)
			);
			$line = fgets($TOP);
		}	

		shuffle($SelectedFotos);

		if($contador_s > 0){
			$selected = pathinfo($SelectedFotos[0][0]);
			$selected = substr($selected['filename'], 6);			
		}
		else
			$selected = -1;


		$sql_getSelectedFotos = "SELECT IdFoto, Titulo, Fecha, Fichero, NomPais FROM `fotos` LEFT JOIN `paises` ON IdPais=Pais
									WHERE IdFoto =".$selected;
									
		if(!($resultadoS = $inkbd->query($sql_getSelectedFotos))) { 
			echo "<p>Error al ejecutar la sentencia <b>$sql_getSelectedFotos</b>: " . $inkbd->error; 
			echo "</p>"; 
			exit; 
		} 
	}
	fclose($TOP);



?>

	<div id="selected">

		<h3>Últimas fotos subidas</h3>
		<?php require_once("inc/graph.php"); ?>

		<h3>Foto seleccionada</h3>
		<?php
		$i = 0;

		if($contador_s == 0){
			echo "No hay foto seleccionada.";
		}
		else{
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
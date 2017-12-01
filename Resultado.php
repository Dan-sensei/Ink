<?php 
	require_once("inc/head.php"); 
	require_once("inc/header.php"); 
	
	$title = $date1 = $date2 = $country = "";
	$error_consulta = false;
	$error_paises = false;

	if(isset($_POST["title"]))
		$title = htmlspecialchars($_POST["title"]);

	if(isset($_POST["date1"]))
		$date1 = htmlspecialchars($_POST["date1"]);
	
	if(isset($_POST["date2"]))
		$date2 = htmlspecialchars($_POST["date2"]);

	if(isset($_POST["country"]))
		$country = htmlspecialchars($_POST["country"]);

	$and = "";
	if(!empty($title) || !empty($date1) || !empty($date2) || !empty($country)){
		$sql_getFotos = "SELECT IdFoto, Titulo, Fecha, Fichero, NomPais FROM `fotos` LEFT JOIN `paises` ON fotos.Pais = IdPais WHERE ";
		if(!empty($title)){
			$sql_getFotos = $sql_getFotos . "Titulo like '%".$title."%' ";
			$and = "AND";
		}
		if(!empty($date1)){
			$sql_getFotos = $sql_getFotos .$and. " Fecha > '".$date1."' ";
			$and = "AND";
		}
		if(!empty($date2)){
			$sql_getFotos = $sql_getFotos .$and. " Fecha < '".$date2."' ";
			$and = "AND";
		}
		if(!empty($country)){
		 	$sql_getFotos = $sql_getFotos .$and. " Pais = '".$country."'";
		}
	}
	else
		$sql_getFotos = "SELECT IdFoto, Titulo, Fecha, Fichero, NomPais FROM `fotos` LEFT JOIN `paises` ON fotos.Pais = IdPais";
	
	if(!($resultado = $inkbd->query($sql_getFotos))) 
		$error_consulta = true;

	$sql_getPais = "SELECT IdPais, NomPais FROM `paises` ORDER BY NomPais ASC";
	if(!($paises = $inkbd->query($sql_getPais))) 
		$error_paises = true;
?>
	<div id="panel">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="parametros">
			<label for="title">Título</label>
			<p><input type="text" id="title" name="title" value=<?php echo "'".$title."'" ?>  ></p>

			<label for="date1">Fecha entre </label>
			<p><input id="date1" type="date" value=<?php echo "'".$date1."'" ?> > <span>y</span> <input id="date2" type="date" value=<?php echo "'".$date2."'"?> ></p>

			<label for="country">País</label>
			<?php 
			if (!$error_paises){
				echo "<select form='busqueda 'name='country' id='country'>
					<option selected='selected' value=''></option>";
				
						while($option = $paises->fetch_assoc() ) { 
							echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
					 	} 
					
				echo "</select>";
			}
			?>
			<p><input type="submit" value="Buscar"></p>
		</form>
	</div>
	
  <section id="columnas2">
  		<?php

  		$c = 0;
		while($image = $resultado->fetch_assoc() ) {
			$c=$c+1;
			if($image['Fecha']!=NULL)
				$date = date_create($image['Fecha'])->format('d m Y')."<br>";
			else
				$date = "";
			
			echo   "<figure>
						<a href='Detalle_foto.php?id=".$image['IdFoto']."'>
							<div>
								<img src='".$image['Fichero']."' alt='".$image['Titulo']."'>
								<div>
									<p>
										<span class='titulo'>".$image['Titulo']."</span><br>".$date.$image['NomPais']."
									</p>
								</div>
							</div>
						</a>
					</figure>";
		} 
		if($c==0){
			echo "<img style='max-height: 650px;' src='img/no-results-icon.png' alt='Sin resultados'>	";
		}
  		?>
	</section>

<?php
	$resultado->close(); 
	require_once("inc/footer.php"); 
?>
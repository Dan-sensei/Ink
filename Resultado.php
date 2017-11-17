<?php 
	require_once("inc/head.php"); 
	require_once("inc/header.php"); 
	
	$title = "";
	$date1 = "";
	$date2 = "";
	$country = "";

	if(isset($_POST["title"]))
		$title = htmlspecialchars($_POST["title"]);

	if(isset($_POST["date1"]))
		$date1 = htmlspecialchars($_POST["date1"]);
	
	if(isset($_POST["date2"]))
		$date2 = htmlspecialchars($_POST["date2"]);

	if(isset($_POST["country"]))
		$country = htmlspecialchars($_POST["country"]);

	$and ="";
	if($title!="" || $date1!="" || $date2 !="" || $country != ""){
		$sql_getFotos = "SELECT * FROM `fotos` WHERE ";
		if($title!=""){
			$sql_getFotos = $sql_getFotos . "Titulo like '%".$title."%' ";
			$and = "AND";
		}
		if($date1!=""){
			$sql_getFotos = $sql_getFotos .$and. " Fecha > '".$date1."' ";
			$and = "AND";
		}
		if($date2!=""){
			$sql_getFotos = $sql_getFotos .$and. " Fecha < '".$date2."' ";
			$and = "AND";
		}
		if($country!=""){
		 	$sql_getFotos = $sql_getFotos .$and. " Pais = '".$country."'";
		}
	}
	else
		$sql_getFotos = "SELECT * FROM `fotos`";
	

	if(!($resultado = $inkbd->query($sql_getFotos))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql_getFotos</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit; 
	} 

	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado2 = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	 } 
?>
	<div id="panel">
		<form action="Resultado.php" method="post" id="parametros">
			<div class="filtro">
				<label for="title">Título</label>
				<p><input type="text" id="title" name="title" value=<?php echo "'".$title."'" ?>  ></p>
			</div>
			<div class="filtro">
				<label for="date1">Fecha entre </label>
				<p><input id="date1" type="date" value=<?php echo "'".$date1."'" ?> > <span>y</span> <input id="date2" type="date" value=<?php echo "'".$date2."'"?> ></p>
			</div>
			<div class="filtro">
				<label for="country">País</label>
				<select form="busqueda" class="extra" name="country" id="country">
					<option selected='selected' value=''></option>
					<?php 
						while($option = $resultado2->fetch_assoc() ) { 
							echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
					 	} 
					?>
				</select>
			</div>
			<div class="filtro">
				<p><input type="submit" value="Buscar"></p>
			</div>
		</form>
	</div>
  <section id="columnas2">
  		<?php

		while($image = $resultado->fetch_assoc() ) {
			if($image['Fecha']!="0000-00-00")
				$date = date_create($image['Fecha'])->format('d m Y')."<br>";
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
	$resultado->close(); 
	$inkbd->close(); 
	require_once("inc/footer.inc"); 
?>
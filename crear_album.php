<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado = $inkbd->query($sql_getPais))) {
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	}

	if(!isset($_SESSION['datosYerrores'])){
		$datosYerrores = array(
		0 => array("",""),			//Nombre
		1 => array("",""),	//Descripcion
		2 => array("",""),			//Fecha
		3 => array("",""),			//Pais
		4 => array("","<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>")
		);
	}else{
		$datosYerrores = $_SESSION['datosYerrores'];
		unset($_SESSION['datosYerrores']);
	}
?>

	<section id="crear_album">
		<div>
			<form action="access.php" method="post" id ="crea">
				<h3>Crear álbum</h3>
				<img src="img/album_icon.png">
				<label for="title">Título<span>*</span></label>
				<p><input type="text" name="titulo" id="titulo" required></p>
			
				<label for="desc">Descripción<span>*</span></label>
				<p><input type="text" name="desc" id="desc" required></p>

				<label for="date">Fecha</label>
				<p><input type="date" name="date" id="date"></p>

				<label for="pais">País</label>
				<select form="crea" class="extra" name="pais" id="pais">
					<option selected='selected' value=''></option>
					<?php 

						$p = $datosYerrores[3][0] ? $datosYerrores[3][0] : "ES";
						while($option = $resultado->fetch_assoc() ) {
							 if($option['IdPais']==$p){
								echo  "<option selected='selected' value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 		  
							}
							else 
								echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
					 	}
					?>
				</select>

				<label for="pic">Foto</label>
				<p><input type="file" name="pic" id="pic" accept="image/*"></p>
				<p class="fuente_centrada"><span><?php echo "Uee"; ?></span></p>

				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<input type="submit" value="Crea">
			</form>
		</div>
	</section>

<?php
	require_once("inc/footer.php"); 
?>
<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	
	$message2="";

	if (isset($_SESSION["error2"])) {
	    $message2 = $_SESSION["error2"];
	    unset($_SESSION["error2"]);
	}

	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado = $inkbd->query($sql_getPais))) {
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	}

	if(!isset($_SESSION['datosYerrores'])){
		$datosYerrores = array(
		0 => array("",""),			//Nombre
		1 => array("",""),			//Descripcion
		2 => array("",""),			//Fecha
		3 => array("",""),			//Pais
		4 => array("","<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>")
		);
	}else{
		$datosYerrores = $_SESSION['datosYerrores'];
		unset($_SESSION['datosYerrores']);
	}
?>
	<nav>
		<div>
			<a href="albumes.php">Mis álbumes</a><br>
			<a href="crear_album.php">Crear un nuevo álbum</a><br>
			<a href="Solicitar.php">Solicitar álbum impreso</a><br>
			<a href="addFoto.php">Añadir foto a album</a><br>
			<a href="Baja.php">Darse de baja</a>
		</div>
	</nav>
	<section id="crear_album">
		<div>
			<form action="INSERT_Album.php" method="post" enctype="multipart/form-data" id ="crea">
				<h3>Crear álbum</h3>
				<img src="img/add_album_icon.png">
				<label for="title">Título<span>*</span></label>
				<p><input type="text" name="titulo" id="titulo" value=<?php echo "'".$datosYerrores[0][0]."'";?> required></p>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[0][1]; ?></span></p>

				<label for="desc">Descripción<span>*</span></label>
				<p><input type="text" name="desc" id="desc" value=<?php echo "'".$datosYerrores[1][0]."'";?> required></p>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[1][1]; ?></span></p>

				<label for="date">Fecha</label>
				<p><input type="date" name="date" id="date" value=<?php echo "'".$datosYerrores[2][0]."'";?>></p>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[2][1]; ?></span></p>

				<label for="pais">País</label>
				<select form="crea" class="extra" name="pais" id="pais">
					<option selected='selected' value=''></option>
					<?php 

						$p = $datosYerrores[3][0] ? $datosYerrores[3][0] :"";
						while($option = $resultado->fetch_assoc() ) {
							 if($option['IdPais']==$p){
								echo  "<option selected='selected' value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 		  
							}
							else 
								echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
					 	}
					?>
				</select>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[3][1];?></span></p>

				<label for="pic">Portada</label>
				<p><input type="file" name="pic" id="pic" accept="image/*"></p>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[4][1];?></span></p>

				<p class="fuente_centrada"><span><?php echo $message2?></span></p>
				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<input type="submit" value="Crea">
			</form>
		</div>
	</section>

<?php
	require_once("inc/footer.php"); 
?>
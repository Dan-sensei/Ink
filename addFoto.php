<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");


	$sql_getalbum = "SELECT COUNT(IdAlbum) as 'exists' FROM `albumes` WHERE Usuario = ".$_SESSION['IdUsuario'];
	if(!($a = $inkbd->query($sql_getalbum))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getalbum</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	}
	$exist = $a->fetch_assoc();

	if($exist['exists']==0){
		?>
		<section id="crear_album">
			<div>
				<img src="img/sg-lux-2.png" alt="Sin albumes">
				<h3>Para añadir una foto a un album, primero debes tener algún álbum</h3>
				<a href="crear_album.php">Crear album</a>
			</div>
		</section>
		<?php
		exit;
	}

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

 	$sql = "SELECT * FROM `usuarios`, `albumes` WHERE IdUsuario = '".$_SESSION["IdUsuario"]."' AND IdUsuario=Usuario";
	if(!($resultado2 = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}

	if(!isset($_SESSION['datosYerrores'])){
		$datosYerrores = array(
		0 => array("",""),			//Nombre
		1 => array("",""),			//Descripcion
		2 => array("",""),			//Fecha
		3 => array("",""),			//Pais
		4 => array("",""),			//Album
		5 => array("","<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>")
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
			<form action="INSERT_Foto.php" method="post" enctype="multipart/form-data" id = "addphoto">
				<h3>Añadir foto a album</h3>
				<img src="img/photo_album_icon.png" alt="Añadir icon">
				<label for="title">Título<span>*</span></label>
				<p><input type="text" name="titulo" id="titulo" value=<?php echo "'".$datosYerrores[0][0]."'";?> required></p>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[0][1]; ?></span></p>

				<label for="desc">Descripción<span>*</span></label>
				<p><input type="text" name="desc" id="desc" value=<?php echo "'".$datosYerrores[1][0]."'";?> required></p>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[1][1]; ?></span></p>

				<label for="date">Fecha</label>
				<p><input type="date" name="date" id="date" value=<?php echo "'".$datosYerrores[2][0]."'";?>></p>

				<label for="pais">País</label>
				<select form="addphoto" class="extra" name="pais" id="pais">
					<option selected='selected' value=''></option>
					<?php 
						$p = $datosYerrores[3][0] ? $datosYerrores[3][0] : "";
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

				<label for="album">Álbum<span>*</span></label>
					<select form="addphoto" class="extra" name="album" id="album">
					<?php 
						$a = $datosYerrores[4][0];
						while($option = $resultado2->fetch_assoc() ) {
							if($option['IdAlbum'] == $a) {
								echo "<option selected='selected' value='".$option['IdAlbum']."'>".$option['Titulo'] ."</option>";
							}
							else
								echo  "<option value='".$option['IdAlbum']."'>".$option['Titulo'] ."</option>"; 
					 	} 
					?>
					</select> 
				<p class="fuente_centrada"><span><?php echo $datosYerrores[4][1];?></span></p>

				<label for="pic">Imagen</label>
				<p><input type="file" name="pic" id="pic" accept="image/*" required></p>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[5][1];?></span></p>

				<p class="fuente_centrada"><span><?php echo $message2?></span></p>
				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<input type="submit" value="Añadir">
			</form>
		</div>
	</section>

<?php
	require_once("inc/footer.php"); 
?>
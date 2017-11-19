<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	 } 

 	$sql = "SELECT * FROM `usuarios`, `albumes` WHERE NomUsuario = '".$_SESSION["usuario"]."' AND IdUsuario=Usuario";
	if(!($resultado2 = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}

	$logged =
			"<a href='perfil.php'>
				<img src='img/Sona_profile.png' id='user_mini'>
			</a>
		</div>
	</header>";

	echo $logged;
?>

	<section id="crear_album">
		<div>
			<form action="access.php" method="post">
				<h3>Añadir foto a album</h3>
				<img src="img/album_icon.png">
				<label for="title">Título<span>*</span></label>
				<p><input type="text" name="titulo" id="titulo" required></p>

				<label for="date">Fecha<span>*</span></label>
				<p><input type="date" name="date" id="date" required></p>

				<label for="country">País</label>
				<select form="busqueda" class="extra" name="country" id="country">
					<option selected='selected' value=''></option>
					<?php 
						while($option = $resultado->fetch_assoc() ) { 
							echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
					 	} 
					?>
				</select>

				<label for="album">Álbum<span>*</span></label>
					<select form="f_solicitar" class="extra" name="album" id="album">
					<?php 
						while($option = $resultado2->fetch_assoc() ) { 
							echo  "<option value='".$option['Titulo']."'>".$option['Titulo'] ."</option>"; 
					 	} 
					?>
					</select> 

				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<input type="submit" value="Login">
			</form>
		</div>
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
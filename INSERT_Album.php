<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
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
			<form action="access.php" method="post" id ="crea">
				<h3>Crear álbum</h3>
				<img src="img/album_icon.png">
				<label for="title">Título<span>*</span></label>
				<p><input type="text" name="titulo" id="titulo" required></p>
			
				<label for="desc">Descripción<span>*</span></label>
				<p><input type="text" name="desc" id="desc" required></p>

				<label for="date">Fecha<span>*</span></label>
				<p><input type="date" name="date" id="date" required></p>

				<label for="crea">País</label>
				<select form="busqueda" class="extra" name="country" id="country">
					<option selected='selected' value=''></option>
					<?php 
						while($option = $resultado->fetch_assoc() ) { 
							echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
					 	} 
					?>
				</select>

				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<input type="submit" value="Login">
			</form>
		</div>
	</section>

<?php
	require_once("inc/footer.php"); 
?>
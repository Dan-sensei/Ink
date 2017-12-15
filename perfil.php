<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php");
	require_once("inc/validation.php");

	
	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";
	if(!($resultadoPais = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sentencia</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	} 

	$id=intval(validate_input($_SESSION['IdUsuario']));
	$sql = "SELECT NomUsuario, Foto, Email, Sexo, FNacimiento, Ciudad, NomPais FROM `usuarios`,`paises` WHERE IdUsuario =".$id." AND Pais=IdPais";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$user = $resultado->fetch_assoc();

	$Sexo = array(
		0 => 'Hombre',
		1 => 'Mujer',
		2 => 'Otro'
	);

	if(!isset($_SESSION['errores'])){
		$errores = array(
			0 => "",		//Nombre
			1 => "",		//Email
			2 => "",		//Foto
			3 => "",		//Contraseña
			4 => "",		//Fecha de nacimiento
			5 => "",		//Sexo
			6 => "",		//Ciudad
			7 => "",		//Pais

			8 => "",		//Encabezado Cuenta
			9 => "",		//Encabezado Contraseña
			10 => ""		//Encabezado Datos personales
		);
	}else{
		$errores = $_SESSION['errores'];
		unset($_SESSION['errores']);
	}
?>

	<section id="perfil">
		<aside>
			<!--Enlaces-->
			<nav>
				<!-- Nuevos
				<a href="Modificar.php">Modificar datos</a><br>
				<a href="Albumes.php">Mis álbumes</a><br>
				<a href="Nuevo_album.php">Crear un nuevo álbum</a><br>
				<a href="Solicitar.php">Solicitar álbum impreso</a><br>
				<a href="Baja.php">Darse de baja</a>
				-->
				<div>
					<a href="albumes.php">Mis álbumes</a><br>
					<a href="crear_album.php">Crear un nuevo álbum</a><br>
					<a href="Solicitar.php">Solicitar álbum impreso</a><br>
					<a href="addFoto.php">Añadir foto a album</a><br>
					<a href="Baja.php">Darse de baja</a>
				</div>
			</nav>
		</aside>
		<div>
			<span>
				<?php echo "<img src='".$user['Foto']."' class='user'> "?>
				<h1><?php echo $user['NomUsuario'];?>
				</h1>
			</span>	
		</div>
		<section>
			<div class='encabezado'>Mi cuenta <p class="fuente_centrada"><span><?php echo $errores[8]?></span></p></div>
			<div>
			  	<form action ='Modify.php' method='post' enctype='multipart/form-data' id='cuenta'>
			  		<div>
				  		<div>
							<p><label for='name'>Nombre de usuario</label></p>
							<input type='text' name='name' id='name' placeholder='Nick' value=<?php echo "'".$user['NomUsuario']."'"?> >
							<p class="fuente_centrada"><span><?php echo $errores[0]?></span></p>
						</div>
						<div>
							<p><label for='email'>Email</label></p>
							<input type='email' name='email' id='email' placeholder='example@gmail.com' value=<?php echo "'".$user['Email']."'"?>>
							<p class="fuente_centrada"><span><?php echo $errores[1]?></span></p>
						</div>
					</div>
					<div>
						<div>
							<p><label for='pic'>Foto de perfil</label></p>
							<input type='file' name='pic' id='pic' accept='image/*'>
							<p class="fuente_centrada"><span><?php echo $errores[2]?></span></p>

							<div class='fuente_centrada'>
								<input type='checkbox' name='borrar' id='borrar' value='borrar'>
								<label for='borrar'>Borrar foto de perfil</label>
							</div>
							
						</div>		
						<div>
							<p><input type='submit' name='cuenta' value='Guardar'></p>
						</div>
					</div>
				</form>
			</div>
			<div class='encabezado'>Contraseña <p class="fuente_centrada"><span><?php echo $errores[9]?></span></p></div>
			<div>
			  	<form action ='Modify.php' method='post' id='password'>
			  		<div>
				  		<div>
							<p><label for='old_code'>Antigua contraseña</label></p>
							<input type='password' name='old_code' id='old_code' required>
						</div>
						<div>
							<p><label for='code'>Nueva contraseña</label></p>
							<input type='password' name='code' id='code' required>
						</div>
						<div>
							<p><label for='code2'>Confirmar contraseña</label></p>
							<input type='password' name='code2' id='code2' required>
						</div>
					</div>
					<div>
						<div>
							<p class="fuente_centrada"><span><?php echo $errores[3]?></span></p>
						</div>
						<div>
							<p><input type='submit' name='password' value='Guardar'></p>
						</div>
					</div>
				</form>
			</div>
				
			<div class='encabezado'>Datos personales <p class="fuente_centrada"><span><?php echo $errores[10]?></span></p></div>
			<div>
			  	<form action ='Modify.php' method='post' id='personal'>
			  		<div>
				  		<div>
							<p><label for="date">Fecha de nacimiento</label></p>
							<input type='date' name='date' id='date' value=<?php echo "'".$user['FNacimiento']."'"?>>
							<p class="fuente_centrada"><span><?php echo $errores[4]?></span></p>
						</div>
						<div>
							<p><label for="otro">Sexo</label></p>
							
							<div class="radio_div">
								<label for="hombre">Hombre</label>
								<input type="radio" name="gender" id="hombre" <?php if($user['Sexo']==0) echo "checked='checked'"?> value=0 required>
							</div>

							<div class="radio_div">
								<label for="mujer">Mujer</label>
								<input type="radio" name="gender" id="mujer" <?php if($user['Sexo']==1) echo "checked='checked'"?> value=1>
							</div>

							<div class="radio_div">
								<label for="otro">Otro</label>
								<input type="radio" name="gender" id="otro" <?php if($user['Sexo']==2) echo "checked='checked'"?> value=2>
							</div>
							<p class="fuente_centrada"><span><?php echo $errores[5]?></span></p>
						</div>
					</div>
					<div>
				  		<div>
							<p><label for='city'>Ciudad</label></p>
							<input type='text' name='city' id='city' value=<?php echo "'".$user['Ciudad']."'"?> >
							<p class="fuente_centrada"><span><?php echo $errores[6]?></span></p>
						</div>
						<div>
							<p><label for="pais">País</label></p>
							<select form="registro" class="extra" name="pais" id="pais">
								<?php 
									while($option = $resultadoPais->fetch_assoc() ) { 
										if($option['NomPais']==$user['NomPais']){
											echo  "<option selected='selected' value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 		  
										}
										else{
											echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
										}
								 	} 
								?>
							</select>
							<p class="fuente_centrada"><span><?php echo $errores[7]?></span></p>
						</div>	
						<div>
							<p><input type='submit' name='personal' value='Guardar'></p>
						</div>
					</div>
				</form>
			</div>
		</div>
		</section>
	</section>
<?php
	$resultadoPais->close();
	$resultado->close();
	require_once("inc/footer.php"); 
?>
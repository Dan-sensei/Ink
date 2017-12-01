<?php 
	
	require_once("inc/head.php"); 

	$message="";
	$message2="";

	if (isset($_SESSION["error"])) {
	    $message = $_SESSION["error"];
	    unset($_SESSION["error"]);
	}

	if (isset($_SESSION["error2"])) {
	    $message2 = $_SESSION["error2"];
	    unset($_SESSION["error2"]);
	}

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	if(isset($_SESSION["IdUsuario"])){
		header("Location: http://$host$uri/Perfil.php"); 
		exit;
	}
	
	if((isset($_GET["unset"]))){
		setcookie("recuerdame", "asd",time()-3600);
		header("Location: http://$host$uri/Registro.php");
		exit;
	}

	if(isset($_COOKIE["recuerdame"])){

		$data = json_decode($_COOKIE['recuerdame'], true);
		$min="";

		if((int)($data['3']['minutes'])<10){$min="0";}
		$structure = "<div id='cookie_div'>
					<p class='cookie'>Hola <span class='saludo_big'>".$data['0']."</span>, <br>
					su última visita fue el <br> 
					<span>".$data['3']['mday']."/".$data['3']['mon']."/".$data['3']['year']."</span> a las <span>".$data['3']['hours'].":".$min.$data['3']['minutes']."</span></p>
					<input type='submit' value='Login'>
					<a href='Registro.php?unset=true'>Cambiar de usuario</a>
				</div>";
	}
	else{
		$structure = "<label for='fname'>Nombre<span>*</span></label>
				<p><input type='text' name='fname' id='fname' placeholder='Usuario' required></p>
			
				<label for='code_login'>Contraseña<span>*</span></label>
				<p><input type='password' name='code_login' id='code_login' placeholder='Contraseña' required></p>
				<p class='fuente_centrada'><a href=#>¿Has olvidado tu contraseña?</a></p>
				<p class='fuente_centrada'><span>*</span><span class='obligatorio'>Obligatorio</span></p>
				<div class='fuente_centrada'>
					<input type='checkbox' name='recordar' id='recordar' value='recordar'>
					<label for='recordar'>Recuérdame</label>
				</div>
				<p class='fuente_centrada'><span>".$message."</span></p>
				<input type='submit' value='Login'>";
	}

	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";
	if(!($resultado = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sentencia</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	 } 
	
	if(!isset($_SESSION['datosYerrores'])){
		$datosYerrores = array(
			0 => array("","<span style='color:white; font-size:11px;'>Solos letras y numeros, 3 a 15 caracteres.</span>"),
			1 => array("","<span style='color:white; font-size:11px;'>Solos letras, numeros y '_'. <br>Mínimo 1 mayúscula, 1 minúscula, 1 número. <br> De 6 a 15 caracteres.</span>"),
			2 => array("",""),
			3 => array("2",""),
			4 => array("",""),
			5 => array("",""),
			6 => array("",""),
			7 => array("","<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>")
		);
	}
	else{
		$datosYerrores = $_SESSION['datosYerrores'];
		unset($_SESSION['datosYerrores']);
	}
?>
	<section id="acceso">
		<div>
			<form action="access.php" method="post">
				<h3>Conectarse</h3>
				<?php echo $structure ?>
			</form>
		</div>
		<div>
			<a href="index.php" id="logo_jl">
				<span>Home</span>
				<img src="img/dark_ink.png" title="Logo">
			</a>
		</div>
		<div>
		  <form action="INSERT_User.php" method="post" enctype="multipart/form-data" id="registro">
		  		<h3>Registro</h3>
		  		<label for="name2">Nombre<span>*</span></label>
				<input type="text" name="name2" id="name2" placeholder="Nombre de usuario" value=<?php echo "'".$datosYerrores[0][0]."'" ?> required>
				<span class="fuente_centrada"><?php echo $datosYerrores[0][1]?></span>

				<label for="code">Contraseña<span>*</span></label>
				<input type="password" name="code"  id="code" placeholder="Contraseña" required>

				<label for="code2">Confirmar contraseña<span>*</span></label>
				<input type="password" name="code2"  id="code2" placeholder="Repetir contraseña" required>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[1][1]?></span></p>

				<label for="email">Email<span>*</span></label>
				<input type="email" name="email" id="email" placeholder="example@gmail.com" value=<?php echo "'".$datosYerrores[2][0]."'" ?> required>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[2][1]?></span></p>

				<label for="otro">Sexo<span>*</span></label>
				<div>
					
					<div class="radio_div">
						<label for="hombre">Hombre</label>
						<input type="radio" name="gender" id="hombre" <?php if($datosYerrores[3][0]==0) echo "checked='checked'"?> value=0 required>
					</div>

					<div class="radio_div">
						<label for="mujer">Mujer</label>
						<input type="radio" name="gender" id="mujer" <?php if($datosYerrores[3][0]==1) echo "checked='checked'"?> value=1>
					</div>

					<div class="radio_div">
						<label for="otro">Otro</label>
						<input type="radio" name="gender" id="otro" <?php if($datosYerrores[3][0]==2) echo "checked='checked'"?> value=2>
					</div>
				</div>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[3][1]?></span></p>

				<label for="date">Fecha de nacimiento<span>*</span></label>
				<input id="date" name="date" type="date" value=<?php echo "'".$datosYerrores[4][0]."'" ?> required>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[4][1]?></span></p>

				<label for="city">Ciudad<span>*</span></label>
				<input type="text" name="city" id="city" placeholder="Ciudad" value=<?php echo "'".$datosYerrores[5][0]."'" ?> required>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[5][1]?></span></p>

				<label for="pais">País<span>*</span></label>
				<select form="registro" name="pais" id="pais">
					<?php 
						$p = $datosYerrores[6][0] ? $datosYerrores[6][0] : "ES";
						while($option = $resultado->fetch_assoc() ) {
							if($option['IdPais']==$p){
								echo  "<option selected='selected' value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 		  
							}
							else{
								echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
							}
					 	} 
					?>
				</select>
				<p class="fuente_centrada"><span><?php echo $datosYerrores[6][1]?></span></p>

				<label for="pic">Foto</label>
				<input type="file" name="pic" id="pic" accept="image/*">
				<p class="fuente_centrada"><span><?php echo $datosYerrores[7][1]?></span></p>

				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<p class="fuente_centrada"><span><?php echo $message2?></span></p>
				<p><br><input type="submit" name="submit" value="Registrarse"></p>
		  </form>
		</div>
	</section>

<?php

	$resultado->close(); 
	require_once("inc/footer.php"); 
?>
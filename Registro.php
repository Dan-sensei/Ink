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

	if(isset($_SESSION["usuario"])){
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
					<label for='recordar'><span>Recuérdame</span></label>
				</div>
				<p class='fuente_centrada'><span>".$message."</span></p>
				<input type='submit' value='Login'>";
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
		  <form action="Insercion.php" method="post" enctype="multipart/form-data">
		  		<h3>Registro</h3>
		  		<label for="name2">Nombre<span>*</span></label>
				<p><input type="text" name="name2"  id="name2" placeholder="Nombre de usuario" required></p>

				<label for="code">Contraseña<span>*</span></label>
				<p><input type="password" name="code"  id="code" placeholder="Contraseña" required></p>

				<label for="code2">Confirmar contraseña<span>*</span></label>
				<p><input type="password" name="code2"  id="code2" placeholder="Repetir contraseña" required></p>

				<label for="email">Email<span>*</span></label>
				<p><input type="email" name="email" id="email" placeholder="example@gmail.com" required></p>
				<p class="fuente_centrada"><br>Sexo</p>
				<div>
					<div class="radio_div">
						<label for="hombre">Hombre</label>
						<input type="radio" name="gender" id="hombre" value="hombre">
					</div>

					<div class="radio_div">
						<label for="mujer">Mujer</label>
						<input type="radio" name="gender" id="mujer" value="mujer">
					</div>

					<div class="radio_div">
						<label for="otro">Otro</label>
						<input type="radio" name="gender" id="otro" value="otro">
					</div>
				</div>
				<label for="date">Fecha de nacimiento<span>*</span></label>
				<p><input id="date" name="date" type="date" required></p>

				<label for="city">Ciudad<span>*</span></label>
				<p><input type="text" name="city" id="city" placeholder="Ciudad" required></p>

				<label for="pais">Pais<span>*</span></label>
				<p><input type="text" name="pais" id="pais" placeholder="Pais de residencia" required></p>
				<label for="pic">Foto</label>
				<p><input type="file" name="pic" id="pic" accept="image/*"></p>
				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<p class="fuente_centrada"><span><?php echo $message2?></span></p>
				<p><br><input type="submit" name="submit" value="Registrarse"></p>
		  </form>
		</div>
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php"); 

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	if(!isset($_SESSION['datosYerrores']))
		header("Location: http://$host$uri/perfil.php");

	unset($_SESSION['datosYerrores']);
	unset($_SESSION['error2']);
	
	if(!isset($_SESSION["IdUsuario"])){
		header("Location: http://$host$uri/Registro.php"); 
		exit;
	}

	$id=intval($_SESSION['IdUsuario']);
	$sql = "SELECT NomUsuario, Clave, Email, Sexo, FNacimiento, Ciudad, NomPais, Foto FROM `usuarios`,`paises` WHERE Pais = IdPais AND IdUsuario =".$id;
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
	$date = date_create($user['FNacimiento'])->format("d-m-Y");

?>

	<section id="insercion">
		<div>
			<span>
				<h2>Inserción realizada correctamente</h2>
				<img src=<?php echo "'".$user['Foto']."'"; ?> class="user">
				<h1> <?php echo $user['NomUsuario']; ?> </h1>
			</span>	
		</div>
		<section>
			<div>
				<p><b>Sexo:</b> <?php echo $Sexo[$user['Sexo']]; ?> </p>
				<p><b>Email: </b> <?php echo $user['Email']; ?> </p>
				<p><b>Fecha de nacimiento: </b> <?php echo $date ?> </p>
				<p><b>Ciudad: </b> <?php echo $user['Ciudad'] ?> </p>
				<p><b>País: </b> <?php echo $user['NomPais'] ?> </p>
			</div>
		</section>
	</section>

<?php
	require_once("inc/footer.php"); 
?>
<?php 
	require_once("inc/head.php"); 
	require_once("inc/validation.php");

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$name2 = $code  = $code2 = $email = $gender = $date = $ciudad = $pais = $foto = "";

	if(!isset($_POST['name2']) || !isset($_POST['code']) || !isset($_POST['email']) || !isset($_POST['gender']) || !isset($_POST['date']) || !isset($_POST['city']) || !isset($_POST['pais']) ){
		$_SESSION['error2']="Algunos datos no se han especificado";
		header("Location: http://$host$uri/Registro.php");
		exit;
	}

	$name2 	= 	validate_input($_POST["name2"]);
	$code 	= 	validate_input($_POST["code"]);
	$code2 	= 	validate_input($_POST["code2"]);
	$email 	= 	validate_input($_POST["email"]);
	$gender	= 	intval(validate_input($_POST["gender"]));
	$date 	= 	validate_input($_POST["date"]);
	$city 	= 	validate_input($_POST["city"]);
	$pais 	= 	validate_input($_POST["pais"]);

	if(empty( validate_input($_FILES['pic']['name'])) )
		$pic =	"'img/icon.png'";

	$datosYerrores = array(
		0 => array($name2,"<span style='color:white; font-size:11px;'>Solos letras y numeros, 3 a 15 caracteres.</span>"),
		1 => array("","<span style='color:white; font-size:11px;'>Solos letras, numeros y '_'. <br>Mínimo 1 mayúscula, 1 minúscula, 1 número. <br> De 6 a 15 caracteres.</span>"),
		2 => array($email, ""),
		3 => array($gender, ""),
		4 => array($date, ""),
		5 => array($city, ""),
		6 => array($pais, ""),
		7 => array("", "<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>"),
		8 => ""
	);
	$_SESSION['datosYerrores'] = $datosYerrores;

	$fail_detector = false;

	validate_name($name2);
	validate_password($code, $code2);
	validate_email($email);
	validate_gender($gender);
	validate_date($date);
	validate_city($city);
	validate_pais($pais);
	validate_pic();

	if($fail_detector){
		header("Location: http://$host$uri/Registro.php");
		exit;
	}

	$sql_newUser = "INSERT INTO `usuarios`(`NomUsuario`, `Clave`, `Email`, `Sexo`, `FNacimiento`, `Ciudad`, `Pais`, `Foto`) VALUES ('".$name2."','".$code."', '".$email."', '".$gender."', '".$date."', '".$city."', '".$pais."', ".$pic.")";

	if(!($resultado = $inkbd->query($sql_newUser))) { 
		$_SESSION["error2"] = "Hubo un error al procesar la solicitud. Inténtelo de nuevo.";
	   	header("Location: http://$host$uri/Registro.php");
		exit;
	}
	else{
	 	$sql = "SELECT COUNT(IdUsuario) as 'exists', IdUsuario, NomPais FROM `usuarios`,`paises` WHERE NomUsuario='". $name2 ."' AND Clave ='". $code ."' AND Pais = IdPais";
		if(!($resultado = $inkbd->query($sql))) { 
			echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
			echo "</p>"; 
			exit;
		}
		$c = $resultado->fetch_assoc();
		$_SESSION["IdUsuario"]=$c['IdUsuario'];
	 	$_SESSION["usuario"]=$name2;
	}

	require_once("inc/header_logged.php"); 
	$Sexo = array(
		0 => 'Hombre',
		1 => 'Mujer',
		2 => 'Otro'
	);
	$date = date_create($date)->format("d-m-Y");
?>

	<section id="insercion">
		<div>
			<span>
				<h2>Inserción realizada correctamente</h2>
				<img src=<?php echo $pic ?> class="user">
				<h1> <?php echo $name2 ?> </h1>
			</span>	
		</div>
		<section>
			<div>
				<p><b>Contraseña:</b> <?php echo $code ?> </p>
				<p><b>Sexo:</b> <?php echo $Sexo[$gender] ?> </p>
				<p><b>Email: </b> <?php echo $email ?> </p>
				<p><b>Fecha de nacimiento: </b> <?php echo $date ?> </p>
				<p><b>Ciudad: </b> <?php echo $city ?> </p>
				<p><b>País: </b> <?php echo $c['NomPais'] ?> </p>
			</div>
		</section>
	</section>
<?php
	require_once("inc/footer.php"); 
?>
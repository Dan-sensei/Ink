<?php 
	require_once("inc/head.php"); 
	require_once("inc/validation.php");

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	
	if(isset($_SESSION["IdUsuario"])){
		header("Location: http://$host$uri/Perfil.php"); 
		exit;
	}

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
		7 => array("", "<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>")
	);
	

	$fail_detector = false;
	$datosYerrores[0][1] = validate_name($name2) ? validate_name($name2) : $datosYerrores[0][1];
	$datosYerrores[1][1] = validate_password($code, $code2) ? validate_password($code, $code2) : $datosYerrores[1][1];
	$datosYerrores[2][1] = validate_email($email, 1);
	$datosYerrores[3][1] = validate_gender($gender);
	$datosYerrores[4][1] = validate_date($date);
	$datosYerrores[5][1] = validate_city($city);
	$datosYerrores[6][1] = validate_pais($pais);
	$datosYerrores[7][1] = validate_pic() ? validate_pic() : $datosYerrores[7][1];

	$_SESSION['datosYerrores'] = $datosYerrores;
	
	
	if($fail_detector){
		header("Location: http://$host$uri/Registro.php");
		exit;
	}

	$sql_newUser = "INSERT INTO `usuarios`(`NomUsuario`, `Clave`, `Email`, `Sexo`, `FNacimiento`, `Ciudad`, `Pais`, `Foto`) VALUES ('".$name2."','".password_hash($code, PASSWORD_DEFAULT)."', '".$email."', '".$gender."', '".$date."', '".$city."', '".$pais."', ".$pic.")";

	if(!($inkbd->query($sql_newUser))) { 
		$_SESSION["error2"] = "Hubo un error al procesar la solicitud. Inténtelo de nuevo.";
	   	header("Location: http://$host$uri/Registro.php");
		exit;
	}
	else{
	 	$sql = "SELECT IdUsuario FROM `usuarios` WHERE NomUsuario='". $name2."'";
		if(!($resultado = $inkbd->query($sql))) { 
			echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
			echo "</p>"; 
			exit;
		}
		$c = $resultado->fetch_assoc();
		$_SESSION["IdUsuario"]=$c['IdUsuario'];
		header("Location: http://$host$uri/Insercion.php"); 
	}
?>

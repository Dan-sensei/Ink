<?php 
	require_once("inc/head.php"); 
	require_once("inc/validation.php");

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$id=intval(validate_input($_SESSION['IdUsuario']));
	$sql = "SELECT NomUsuario, Clave, Foto, Email, Sexo, FNacimiento, Ciudad, NomPais FROM `usuarios`,`paises` WHERE IdUsuario =".$id." AND Pais=IdPais";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$user = $resultado->fetch_assoc();

	$name = $code  = $code2 = $email = $gender = $date = $ciudad = $pais = $foto = "";

	if(empty( validate_input($_FILES['pic']['name'])) )
		$pic =	"'img/icon.png'";

	$datosYerrores = array(
		0 => array("", ""),
		1 => array("", ""),
		2 => array("", ""),
		3 => array("", ""),
		4 => array("", ""),
		5 => array("", ""),
		6 => array("", ""),
		7 => array("", ""),
		8 => ""
	);
	$_SESSION['datosYerrores'] = $datosYerrores;


	$fail_detector = false;
	$booleano_molon = false;
	$update = "UPDATE `usuarios` SET "; 

	//FORM DATOS DE LA CUENTA
	if(isset($_POST['cuenta'])){
		if(isset($_POST['name'])){
			$name=validate_input($_POST["name"]);
			if($user['NomUsuario'] != $name){
				validate_name($name);
				$update .= "NomUsuario ='".$name."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['email'])){
			$email = validate_input($_POST["email"]);
			if($user['Email'] != $email){
				validate_email($email);
				$update .= "Email ='".$email."' ";
				$booleano_molon = true;
			}
		}
		if(!empty( validate_input($_FILES['pic']['name'])) ){
			$pic=$user['Foto'];
			validate_pic();
			$update .= "Foto =".$pic." ";
			$booleano_molon = true;
		}
	}
	//FORM CONTRASEÑA
	else if(isset($_POST['password'])){
		if(isset($_POST['old_code']) && isset($_POST['code']) && isset($_POST['code2']) && !empty($_POST['old_code']) && !empty($_POST['code']) && !empty($_POST['code2'])){
			//$_SESSION["datosYerrores"][1][1]
			$old_code = validate_input($_POST['old_code']);
			
			if($old_code == $user['Clave']){
				$code = validate_input($_POST['code']);
				$code2 = validate_input($_POST['code2']);

				validate_password($code, $code2);
				$update .= "Clave ='".$code."' ";
				$booleano_molon = true;	
			}
			else
				$_SESSION["datosYerrores"][1][1] = "Antigua contraseña incorrecta.";	
		}
		else
			$_SESSION["datosYerrores"][1][1] = "Introduce todos los datos.";
	}
	//FORM DATOS PERSONALES
	else if(isst($_POST['personal'])){
		if(isset($_POST['old_code'])){
			$name=validate_input($_POST["name"]);
			if($user['NomUsuario'] != $name){
				validate_name($name);
				$update .= "NomUsuario ='".$name."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['email'])){
			$email = validate_input($_POST["email"]);
			if($user['Email'] != $email){
				validate_email($email);
				$update .= "Email ='".$email."' ";
				$booleano_molon = true;
			}
		}
		if(!empty( validate_input($_FILES['pic']['name'])) ){
			$pic=$user['Foto'];
			validate_pic();
			$update .= "Foto =".$pic." ";
			$booleano_molon = true;
		}
	}

	$update .= "WHERE IdUsuario =".$id;
	if(!$fail_detector && $booleano_molon)
		if(!($inkbd->query($update))) { 
			die("Error: no se pudo realizar la inserción"); 
		}

	header("Location: http://$host$uri/Perfil.php");
	exit;
	require_once("inc/footer.php"); 
?>
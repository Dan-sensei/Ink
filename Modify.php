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

	$errores = array(
		0 => "",	//Nombre
		1 => "",	//Email
		2 => "",	//Foto
		3 => "",	//Contraseña
		4 => "",	//Fecha de nacimiento
		5 => "",	//Sexo
		6 => "",	//Ciudad
		7 => "",	//Pais

		8 => "",	//Encabezado Cuenta
		9 => "",	//Encabezado Contraseña
		10 => ""	//Encabezado Datos personales
	);
	


	$fail_detector = false;
	$booleano_molon = false;
	$update = "UPDATE `usuarios` SET "; 
	$result = -1;
	//FORM DATOS DE LA CUENTA
	if(isset($_POST['cuenta'])){
		if(isset($_POST['name'])){
			$name=validate_input($_POST["name"]);
			if($user['NomUsuario'] != $name){
				$errores[0] = validate_name($name);
				$update .= "NomUsuario ='".$name."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['email'])){
			$email = validate_input($_POST["email"]);
			if($user['Email'] != $email){
				$errores[1] = validate_email($email,1);
				$update .= "Email ='".$email."' ";
				$booleano_molon = true;
			}
		}
		if(!empty( validate_input($_FILES['pic']['name'])) ){
			$pic=$user['Foto'];
			$errores[2] = validate_pic();
			$update .= "Foto =".$pic." ";
			$booleano_molon = true;
		}
		$result = 8;
	}
	//FORM CONTRASEÑA
	else if(isset($_POST['password'])){
		if(isset($_POST['old_code']) && isset($_POST['code']) && isset($_POST['code2']) && !empty($_POST['old_code']) && !empty($_POST['code']) && !empty($_POST['code2'])){
			$old_code = validate_input($_POST['old_code']);
			
			if(password_verify($old_code, $user['Clave'])){
				$code = validate_input($_POST['code']);
				$code2 = validate_input($_POST['code2']);

				$errores[3] = validate_password($code, $code2);
				$update .= "Clave ='".password_hash($code, PASSWORD_DEFAULT)."' ";
				$booleano_molon = true;	
			}
			else
				$errores[3] = "Antigua contraseña incorrecta.";	
		}
		else
			$errores[3] = "Introduce todos los datos.";
		$result = 9;
	}
	//FORM DATOS PERSONALES
	else if(isset($_POST['personal'])){
		if(isset($_POST['date'])){
			$date=validate_input($_POST["date"]);
			if($user['FNacimiento'] != $date){
				$errores[4] = validate_date($date);
				$update .= "FNacimiento ='".$date."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['gender'])){
			$gender = validate_input($_POST["gender"]);
			if($user['Sexo'] != $gender){
				$errores[5] = validate_gender($gender);
				$update .= "Sexo ='".$gender."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['city'])){
			$city = validate_input($_POST["city"]);
			if($user['Ciudad'] != $city){
				$errores[6] = validate_city($city);
				$update .= "Ciudad ='".$city."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['pais'])){
			$pais = validate_input($_POST["pais"]);
			if($user['Pais'] != $pais){
				$errores[7] = validate_pais($pais);
				$update .= "Pais ='".$pais."' ";
				$booleano_molon = true;
			}
		}
		$result = 10;
	}

	$update .= "WHERE IdUsuario =".$id;
	if(!$fail_detector && $booleano_molon && $result!=-1){
		if(!($inkbd->query($update))) {
			$errores[$result] = "<span style='color:#ea4c44'>| Algo salio mal, inténtalo de nuevo</span>";
		}
		else
			$errores[$result] = "<span style='color:#43eaa4'>| Datos actualizados</span>";
	}

	$_SESSION['errores'] = $errores;
	require_once("inc/footer.php"); 

	header("Location: http://$host$uri/Perfil.php");
	exit;
?>
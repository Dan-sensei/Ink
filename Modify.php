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
	$result = -1;
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
				validate_email($email,1);
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
		$result = 0;
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
		$result = 1;
	}
	//FORM DATOS PERSONALES
	else if(isset($_POST['personal'])){
		if(isset($_POST['date'])){
			$date=validate_input($_POST["date"]);
			if($user['FNacimiento'] != $date){
				validate_date($date);
				$update .= "FNacimiento ='".$date."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['gender'])){
			$gender = validate_input($_POST["gender"]);
			if($user['Sexo'] != $gender){
				validate_gender($gender);
				$update .= "Sexo ='".$gender."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['city'])){
			$city = validate_input($_POST["city"]);
			if($user['Ciudad'] != $city){
				validate_city($city);
				$update .= "Ciudad ='".$city."' ";
				$booleano_molon = true;
			}
		}
		if(isset($_POST['pais'])){
			$pais = validate_input($_POST["pais"]);
			if($user['Pais'] != $pais){
				validate_pais($pais);
				$update .= "Pais ='".$pais."' ";
				$booleano_molon = true;
			}
		}
		$result = 2;
	}

	$update .= "WHERE IdUsuario =".$id;
	if(!$fail_detector && $booleano_molon && $result!=-1){
		if(!($inkbd->query($update))) {
			$_SESSION["datosYerrores"][$result][0] = "<span style='color:#ea4c44'>&nbsp;| Algo salio mal, inténtalo de nuevo</span>";
		}
		else
			$_SESSION["datosYerrores"][$result][0] = "<span style='color:#43eaa4'>&nbsp;| Datos actualizados</span>";
	}

	require_once("inc/footer.php"); 

	header("Location: http://$host$uri/Perfil.php");
	exit;
?>
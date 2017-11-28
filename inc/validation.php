<?php

	function validate_input($data) {
	  	$data = trim($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	//NOMBRE DE USUARIO
	function validate_name($name){
		$error = "";
		if (!preg_match("/^[a-zA-Z\d]{3,15}$/",$name)) {
			$GLOBALS['fail_detector'] = true;
			$error = "El nombre de usuario solo puede contener letras y numeros, y debe tener una longitud de 3 a 15 caracteres.";
		}
		else{
			$sql = "SELECT COUNT(IdUsuario) as 'exists' FROM `usuarios` WHERE NomUsuario='".$name."'";
			if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
				$GLOBALS['fail_detector'] = true;
				$error = "Error al comprobar disponibilidad del nombre de usuario. Inténtelo de nuevo.".$pais; 
			}
			$exists = $resultado->fetch_assoc();
			if($exists['exists'] == 1){
				$GLOBALS['fail_detector'] = true;
				$error = "Nombre de usuario en uso. Elige otro.";
			}
			$resultado -> close();
		}
		return $error;
	}

	//CONTRASEÑA
	function validate_password($code, $code2){
		$error = "";
		$id=intval($_SESSION['IdUsuario']);
		$sql = "SELECT COUNT(IdUsuario) as 'exists' FROM `usuarios` WHERE IdUsuario =".$id." AND Clave='".$code."'";
		if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
			$GLOBALS['fail_detector'] = true;
			$error = "Error al comprobar contraseña.".$pais; 
		}
		$exists = $resultado->fetch_assoc();
		if($exists['exists'] == 1){
			$GLOBALS['fail_detector'] = true;
			$error = "Introduce una contraseña diferente a la actual.";
		}
		$resultado -> close();

		if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d_]{6,15}$/", $code) ){
			$GLOBALS['fail_detector'] = true;
			$error = "La contraseña solo puede contener letras, numeros y '_'. Debe tener al menos, una letra mayuscula, una minuscula, un numero y una lonitud de 6 a 15 caracteres.";//.$code;
		}
		if($code != $code2){
			$GLOBALS['fail_detector'] = true;
			$error = "Las contraseñas no coinciden";
		}
		return $error;
	}

	//EMAIL
	function validate_email($email, $bool){
		$error = "";
		if (!preg_match("/^[a-zA-Z\d.-_]+@[a-zA-Z]+.[a-zA-Z]{2,4}$/", $email)){	 // !($email=filter_var($email,FILTER_VALIDATE_EMAIL))
			$GLOBALS['fail_detector'] = true;
			$error = "Introduce una direccion de correo válida.";
		}
		else if($bool == 1){
			$sql = "SELECT COUNT(IdUsuario) as 'exists' FROM `usuarios` WHERE Email='".$email."'";
			if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
				$GLOBALS['fail_detector'] = true;
				$error = "Error al comprobar disponibilidad del email. Inténtelo de nuevo.".$pais; 
			}
			$exists = $resultado->fetch_assoc();
			if($exists['exists'] == 1){
				$GLOBALS['fail_detector'] = true;
				$error = $email." está asociado a otra cuenta.";
			}
			$resultado -> close();
		}
		return $error;
	}

	//SEXO
	function validate_gender($gender){
		$error = "";
		if($gender != 0 && $gender != 1 && $gender != 2){
			$GLOBALS['fail_detector'] = true;
			$error = "Elige una de las 3 opciones - ";//.$gender;
		}
		return $error;
	}

	//FECHA
	function validate_date($date){
		$error = "";
		$d = date_parse_from_format("Y-m-d", $date);
		$today = date("Y-m-d");
		if(!checkdate($d['month'], $d['day'], $d['year']) || $date > $today){
			$GLOBALS['fail_detector'] = true;
			$error = "Escoge una fecha válida.";//.$date;
		}
		return $error;
	}

	function validate_date2($date){
		$error = "";
		$d = date_parse_from_format("Y-m-d", $date);
		$today = date("Y-m-d");
		if(!checkdate($d['month'], $d['day'], $d['year']) || $date < $today){
			$GLOBALS['fail_detector'] = true;
			$error = "Escoge una fecha válida.";//.$date;
		}
		return $error;
	}

	//CIUDAD
	function validate_city($city){
		$error = "";
		if(!ctype_alpha($city) && !empty($city)){
			$GLOBALS['fail_detector'] = true;
			$error = "La ciudad solo puede contener letras.";//.$city;
		}
		return $error;
	}

	//PAIS
	function validate_pais($pais){
		$error = "";
		$sql = "SELECT COUNT(IdPais) as 'exists' FROM `paises` WHERE IdPais='".$pais."'";
		if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
			$GLOBALS['fail_detector'] = true;
			$error = "Error al acceder a paises. Inténtelo de nuevo.";//.$pais; 
		}
		$exists = $resultado->fetch_assoc();
		if($exists['exists'] != 1){
			$GLOBALS['fail_detector'] = true;
			$error = "Elige un pais de la lista.";//.$pais;
		}
		$resultado -> close();
		return $error;
	}

	//IMAGEN
	function validate_pic(){
		$error = "";
		$name       = $_FILES['pic']['name'];  
		$temp_name  = $_FILES['pic']['tmp_name'];  
		if(isset($name) && !empty($name)){
	    	if ($_FILES["pic"]["size"] < 4194304) {
	    		$location = 'img/';      
	            if(move_uploaded_file($temp_name, $location.$name)){
	            	$GLOBALS['pic'] = 	"'img/".$name."'"; 
	            }
	            else{
	            	$GLOBALS['fail_detector'] = true;
	            	$error = "Hubo un error al subir la imagen. Asegúrate de que es un formato de imagen valido y que ocupa menos de 4MB.";//.:".$name.":";
	            }
	    	}
	    	else{
	    		$GLOBALS['fail_detector'] = true;
	    		$error = "La imagen ocupa más de 4MB.";
	    	}
	    }
	    return $error;
	}

	//CODIGO POSTAL
	function validate_cp($cp){
		$error = "";
		if (!preg_match("/^[\d]{5}$/",$cp)) {
			$GLOBALS['fail_detector'] = true;
			$error = "Introduce un codigo postal valido";
			//$_SESSION["datosYerrores"][0][1] = "El nombre de usuario solo puede contener letras y numeros, y debe tener una longitud de 3 a 15 caracteres.";
		}
		return $error;
	}

	//COLOR
	
	function validate_color($color){
		$error = "";
		if (!preg_match("/^#[\dA-Fa-f]{6}$/",$color)) {
			$GLOBALS['fail_detector'] = true;
			$error = "Escoge un color válido.";
		}
		return $error;
	}

	//REAL NAME
	function validate_realname($name){
		$error = "";
		if (!preg_match("/^[a-zA-Z]+$/",$name)) {
			$GLOBALS['fail_detector'] = true;
			$error = "El nombre solo puede contener letras.";
		}
		return $error;
	}

	function validate_album($album){
		$sql = "SELECT COUNT(IdAlbum) as 'exists' FROM `usuarios`,`albumes` WHERE Usuario=".$_SESSION['IdUsuario']." AND IdAlbum='".$album."'";
		if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
			$GLOBALS['fail_detector'] = true;
			$error = "Error al comprobar album. Inténtelo de nuevo.".$pais; 
		}
		$exists = $resultado->fetch_assoc();
		if($exists['exists'] != 1){
			$GLOBALS['fail_detector'] = true;
			$error = "Elige un album de la lista.";
		}
		$resultado -> close();
	}
?>
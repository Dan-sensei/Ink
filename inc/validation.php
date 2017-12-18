<?php

	function validate_input($data) {
	  	$data = trim($data);
	  	$data = htmlspecialchars($data);
	  	$data = $GLOBALS['inkbd']->real_escape_string($data);
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
		if(isset($_SESSION['IdUsuario'])){
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
		}
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
		else if( !(strtotime($date) < (time() - (16 * 60 * 60 * 24 * 365)))){
			$GLOBALS['fail_detector'] = true;
			$error = "Debes tener 16 años para registrarte.";
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
	function validate_pic($path, $new){
		$error = "";
		$name       = $_FILES['pic']['name'];  
		$temp_name  = $_FILES['pic']['tmp_name'];
		if(isset($name) && !empty($name)){
	    	if ($_FILES["pic"]["size"] < 4194304) {
	    		//$directory = "users/u_".$GLOBALS['name2']."/";
	    		$name       = $_FILES['pic']['name'];  
				$temp_name  = $_FILES['pic']['tmp_name'];
				$path_parts = pathinfo($path.$name);

				$name = $new.".".$path_parts['extension'];

				echo "'".$path.$name."'"."<br>";
				echo "'".$path.$new.".".$path_parts['extension']."'";

	    		if(move_uploaded_file($temp_name, $path.$name)){
	        		$GLOBALS['pic'] = 	$path.$new.".".$path_parts['extension'];
		        }
		        else{
		        	$GLOBALS['fail_detector'] = true;
		        	$error = "Hubo un error al subir la imagen. Asegúrate de que es un formato de imagen valido y que ocupa menos de 4MB.";
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
		$error = "";
		$sql = "SELECT COUNT(IdAlbum) as 'exists' FROM `albumes` WHERE Usuario=".$_SESSION['IdUsuario']." AND IdAlbum=".$album;
		if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
			$GLOBALS['fail_detector'] = true;
			$error = "Error al comprobar album. Inténtelo de nuevo.".$pais; 
		}
		$exists = $resultado->fetch_assoc();
		if($exists['exists'] == 0){
			$GLOBALS['fail_detector'] = true;
			$error = "Elige un album de la lista.";
		}
		$resultado -> close();
		return $error;
	}

	function deleteDirectory($dir) {
		$dir = validate_input($dir);
	    if (!file_exists($dir)) 
	        return true;
	    if (!is_dir($dir)) 
	        return unlink($dir);
	    foreach (scandir($dir) as $item) {
	        if ($item == '.' || $item == '..') 
	            continue;
	        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) 
	            return false;    
	    }
	    return rmdir($dir);
	}
?>
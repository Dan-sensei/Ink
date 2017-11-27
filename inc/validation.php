<?php

	function validate_input($data) {
	  	$data = trim($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	//NOMBRE DE USUARIO
	function validate_name($name){
		if (!preg_match("/^[a-zA-Z\d]{3,15}$/",$name)) {
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][0][1] = "El nombre de usuario solo puede contener letras y numeros, y debe tener una longitud de 3 a 15 caracteres.";
		}
		else{
			$sql = "SELECT COUNT(IdUsuario) as 'exists' FROM `usuarios` WHERE NomUsuario='".$name."'";
			if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
				$GLOBALS['fail_detector'] = true;
				$_SESSION["datosYerrores"][0][1] = "Error al comprobar disponibilidad del nombre de usuario. Inténtelo de nuevo.".$pais; 
			}
			$exists = $resultado->fetch_assoc();
			if($exists['exists'] == 1){
				$GLOBALS['fail_detector'] = true;
				$_SESSION["datosYerrores"][0][1] = "Nombre de usuario en uso. Elige otro.";
			}
			$resultado -> close();
		}
	}

	//CONTRASEÑA
	function validate_password($code, $code2){
		$id=intval($_SESSION['IdUsuario']);
		$sql = "SELECT COUNT(IdUsuario) as 'exists' FROM `usuarios` WHERE IdUsuario =".$id." AND Clave='".$code."'";
		if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][1][1] = "Error al comprobar contraseña.".$pais; 
		}
		$exists = $resultado->fetch_assoc();
		if($exists['exists'] == 1){
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][1][1] = "Introduce una contraseña diferente a la actual.";
		}
		$resultado -> close();

		if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d_]{6,15}$/", $code) ){
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][1][1] = "La contraseña solo puede contener letras, numeros y '_'. Debe tener al menos, una letra mayuscula, una minuscula, un numero y una lonitud de 6 a 15 caracteres.";//.$code;
		}
		if($code != $code2){
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][1][1] = "Las contraseñas no coinciden";
		}
	}

	//EMAIL
	function validate_email($email){
		if (!preg_match("/^[a-zA-Z\d.-_]+@[a-zA-Z]+.[a-zA-Z]{2,4}$/", $email)){	 // !($email=filter_var($email,FILTER_VALIDATE_EMAIL))
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][2][1] = "Introduce una direccion de correo válida.";
		}
	}

	//SEXO
	function validate_gender($gender){
		if($gender != 0 && $gender != 1 && $gender != 2){
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][3][1] = "Elige una de las 3 opciones - ";//.$gender;
		}
	}

	//FECHA
	function validate_date($date){
		$d = date_parse_from_format("Y-m-d", $date);
		$today = date("Y-m-d");
		if(!checkdate($d['month'], $d['day'], $d['year']) || $date > $today){
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][4][1] = "Escoge una fecha válida.";//.$date;
		}
	}

	//CIUDAD
	function validate_city($city){
		if(!ctype_alpha($city) && !empty($city)){
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][5][1] = "La ciudad solo puede contener letras.";//.$city;
		}
	}

	//PAIS
	function validate_pais($pais){
		$sql = "SELECT COUNT(IdPais) as 'exists' FROM `paises` WHERE IdPais='".$pais."'";
		if(!($resultado = $GLOBALS['inkbd']->query($sql))) {
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][6][1] = "Error al acceder a paises. Inténtelo de nuevo.";//.$pais; 
		}
		$exists = $resultado->fetch_assoc();
		if($exists['exists'] != 1){
			$GLOBALS['fail_detector'] = true;
			$_SESSION["datosYerrores"][6][1] = "Elige un pais de la lista.";//.$pais;
		}
		$resultado -> close();
	}

	//IMAGEN
	function validate_pic(){
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
	            	$_SESSION["datosYerrores"][7][1] = "Hubo un error al subir la imagen. Asegúrate de que es un formato de imagen valido y que ocupa menos de 4MB.";//.:".$name.":";
	            }
	    	}
	    	else{
	    		$GLOBALS['fail_detector'] = true;
	    		$_SESSION["datosYerrores"][7][1] = "La imagen ocupa más de 4MB.";
	    	}
	    }
	}


?>
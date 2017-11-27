<?php
	session_start();
	require_once("inc/connect.php");

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	
	if(isset($_GET["logout"])){
		session_destroy();
		if(isset($_COOKIE["recuerdame"])){
			$data = json_decode($_COOKIE['recuerdame'], true);
			$datos = array(
						"0" => $data['0'],
						"1" => $data['1'],
						"3" => getdate(),
						"4" => "0",
			);
			//GALLETAS---------------------------------------------------------------------		
			setcookie("recuerdame", json_encode($datos), time() + 365 * 24 * 60 * 60);
		}
		header("Location: http://$host$uri/index.php");
		exit;
	}

	if(isset($_SESSION["usuario"])){
		header("Location: http://$host$uri/Perfil.php"); 
		exit;
	}

	if((!(isset($_POST["fname"])) || empty($_POST["fname"])) && !(isset($_COOKIE["recuerdame"])) ){		
		header("Location: http://$host$uri/Registro.php"); 
		exit;
	}
	else{

		if(!(isset($_POST["fname"])) && isset($_COOKIE["recuerdame"])){
			$data = json_decode($_COOKIE['recuerdame'], true);
			$GET_Usuario=$data['0'];
			$GET_Code=$data['1'];
		}
		else{
			$GET_Usuario = $_POST["fname"];
			$GET_Code = $_POST["code_login"];
		}

		$bool=false;

		$sql = "SELECT COUNT(IdUsuario) as 'exists', IdUsuario FROM `usuarios` WHERE NomUsuario='". $GET_Usuario ."' AND Clave ='". $GET_Code ."'";
		if(!($resultado = $inkbd->query($sql))) { 
			echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
			echo "</p>"; 
			exit;
		}
		$c = $resultado->fetch_assoc();

		if($c['exists'] == 1){
			$_SESSION["usuario"]=$GET_Usuario;
			$_SESSION["IdUsuario"]=$c['IdUsuario'];
			$datos = array(
				"0" => $GET_Usuario,
				"1" => $GET_Code,
				"3" => getdate(),
				"4" => "1",
			);
			//GALLETAS---------------------------------------------------------------------
			if(isset($_POST["recordar"]) && $_POST["recordar"]=="recordar"){
				setcookie("recuerdame", json_encode($datos), time() + 365 * 24 * 60 * 60);
			}
			$extra = "index.php";
			
			$bool=true;
		}
		
		if(!$bool){
			if(isset($_COOKIE["recuerdame"])){
				setcookie("recuerdame", "asd",time()-3600);
			}
			$_SESSION["error"] = "Nombre de usuario y/o contraseña incorrectos";
			$extra = "registro.php";
		}

		require_once("inc/footer.php"); 
		header("Location: http://$host$uri/$extra"); 
		exit;
	}
?>
<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	require_once("inc/validation.php");

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	 }

	 $titulo = $descripcion = $date = $pais = "";

	 if(!isset($_POST['titulo']) || !isset($_POST['desc']) || empty($_POST['titulo']) || empty($_POST['desc'])){
		$_SESSION['error2']="El titulo y la descripcion son obligatorios.";
		header("Location: http://$host$uri/crear_album.php");
		exit;
	}

	 $titulo = validate_input($_POST['titulo']);
	 $descripcion = validate_input($_POST['desc']);
	 $date = validate_input($_POST['date']);
	 $pais = validate_input($_POST['pais']);
	 if(empty(validate_input($_FILES['pic']['name'])) )
		$pic =	"img/Default.png";

	$datosYerrores = array(
		0 => array($titulo,""),			//Nombre
		1 => array($descripcion,""),	//Descripcion
		2 => array($date,""),			//Fecha
		3 => array($pais,""),			//Pais
		4 => array("","<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>")
	);

	$fail_detector = false;
	
	if(empty($pais))
		$pais="NULL";
	else{
		$datosYerrores[3][1] = validate_pais($pais);
		$pais = "'".$pais."'";
	}

	$directory = "users/u_".$user['NomUsuario']."/album_tmp";
	if(!$fail_detector){
		if(is_dir($directory)){
			deleteDirectory($directory);
		}
		if(!mkdir($directory, 0700)){
			$fail_detector = true;
			$_SESSION['error2']="Hubo un error al crear tu espacio personal.";
		}
		else if(!empty(validate_input($_FILES['pic']['name'])) ){
			$tmp = validate_pic($directory."/", "Cover");
			$datosYerrores[4][1] = $tmp ? $tmp : $datosYerrores[4][1];
		}
	}

	$date = $date ? "'".$date."'" : "NULL";

	$_SESSION['datosYerrores'] = $datosYerrores;

	if($fail_detector){
		header("Location: http://$host$uri/crear_album.php");
		exit;
	}

	$id=intval($_SESSION['IdUsuario']);
	$album = "INSERT INTO `albumes`( `Titulo`, `Descripcion`, `Fecha`, `Pais`, `Usuario`, `Cover`) VALUES ('".$titulo."','".$descripcion."',".$date.",".$pais.",".$id.",'".$pic."')";

	echo "<br><br><br><br>".$pic."<br>";

	if(!($inkbd->query($album))) {
		$_SESSION["error2"] = "Hubo un error al procesar la solicitud. Inténtelo de nuevo.1";
	   	header("Location: http://$host$uri/crear_album.php");
		exit;
	}
	else{
		$id = $inkbd->insert_id;
		
		$new = "users/u_".$user['NomUsuario']."/album_".$id;

		$path_parts = pathinfo($pic);

		$album = "UPDATE `albumes` SET Cover='".$new."/Cover.".$path_parts['extension']."' WHERE IdAlbum=".$id;

		$fail_detector = !rename($directory, $new);	
		if(!empty(validate_input($_FILES['pic']['name'])))
			$fail_detector = $fail_detector ? $fail_detector : !$inkbd->query($album);

		if($fail_detector){
			deleteDirectory($directory);
			deleteDirectory($new);
			$album = "DELETE FROM `albumes` WHERE IdAlbum=".$id;
			$inkbd->query($album);
			$_SESSION["error2"] = "Hubo un error al procesar la solicitud. Inténtelo de nuevo.2";
	   		header("Location: http://$host$uri/crear_album.php");
	   		exit;
		}
		
		header("Location: http://$host$uri/Insercion_album.php?id=".$id);
		exit;
	}
	require_once("inc/footer.php"); 
?>
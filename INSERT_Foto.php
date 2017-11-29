﻿<?php 
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

	 $titulo = $descripcion = $date = $pais = $album = "";

	 if(!isset($_POST['titulo']) || !isset($_POST['desc']) || empty($_POST['titulo']) || empty($_POST['desc'])){
		$_SESSION['error2']="El titulo y la descripcion son obligatorios.";
		header("Location: http://$host$uri/crear_album.php");
		exit;
	}

	$titulo = validate_input($_POST['titulo']);
	$descripcion = validate_input($_POST['desc']);
	$date = validate_input($_POST['date']);
	$pais = validate_input($_POST['pais']);
	$album = validate_input($_POST['album']);

	$datosYerrores = array(
		0 => array($titulo,""),			//Nombre
		1 => array($descripcion,""),	//Descripcion
		2 => array($date,""),			//Fecha
		3 => array($pais,""),			//Pais
		4 => array($album,""),			//Album
		5 => array("","<span style='color:white; font-size:11px;'>Tamaño máximo de archivo: 4MB</span>")
	);


	$fail_detector = false;
	
	if(empty($pais))
		$pais="NULL";
	else{
		$datosYerrores[3][1] = validate_pais($pais);
		$pais = "'".$pais."'";
	}

	$datosYerrores[4][1] = validate_album($album);

	if(empty(validate_input($_FILES['pic']['name'])) ){
		$datosYerrores[5][1] = "Elige una imagen para subir.";
	}
	else	
		$datosYerrores[5][1] = validate_pic() ? validate_pic() : $datosYerrores[4][1];

	if(empty($date))
		$date="NULL";
	else
		$date = "'".$date."'";

	$_SESSION['datosYerrores'] = $datosYerrores;

	if($fail_detector){
		header("Location: http://$host$uri/addFoto.php");
		exit;
	}
	echo $album."<br>";
	$sql_album = "INSERT INTO `fotos`( `Titulo`, `Descripcion`, `Fecha`, `Pais`, `Album`, `Fichero`) VALUES ('".$titulo."','".$descripcion."',".$date.",".$pais.",".$album.",".$pic.")";

	if(!($inkbd->query($sql_album))) { 
		$_SESSION["error2"] = "Hubo un error al procesar la solicitud. Inténtelo de nuevo.";
	   	header("Location: http://$host$uri/addFoto.php");
		exit;
	}
	else{
		header("Location: http://$host$uri/Insercion_foto.php?id=".$inkbd->insert_id);
		exit;
	}
	require_once("inc/footer.php"); 
?>
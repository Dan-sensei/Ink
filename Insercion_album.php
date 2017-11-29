<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");
	
	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	unset($_SESSION['datosYerrores']);
	unset($_SESSION['error2']);

	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";
	if(!($resultado = $inkbd->query($sql_getPais))) {
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	}
	
?>
<section id="albumes">
	<h3> <?php echo  ?> </h3>
	<div id='columnas3'>
	

<?php
	require_once("inc/footer.php"); 
?>
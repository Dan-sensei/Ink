<?php 
require_once("inc/head.php"); 
require_once("inc/header_logged.php"); 

if($_GET['trigger']=="true"){
	$foto = "'"."img/681367.jpg"."'";
	$titulo="Miku";
	$fecha="29/02/2017";
	$pais="Alemania";
	$album="Vocaloid";
	$usuario="Dan";
}
else{
	$foto = "img/p2.jpg";
	$titulo="Puerto";
	$fecha="05/08/2017";
	$pais="Ámsterdam";
	$album="Paisaje";
	$usuario="Datrix";
}
?>
	<section id="detalle">
		<div>
			<img src=<?php echo $foto?> alt="PI">
		</div>
		<div>
			<p><?php echo $titulo?></p>
			<p><?php echo $fecha?></p>
			<p><?php echo $pais?></p>
			<a href=#><?php echo $album?></a>
			<a href=#><?php echo $usuario?></a>
		</div>
	</section>

<?php
require_once("inc/footer.inc"); 
?>
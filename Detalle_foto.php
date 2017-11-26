<?php 
require_once("inc/head.php"); 
require_once("inc/header_logged.php"); 

$sql=  "SELECT fotos.Titulo as fTitulo, fotos.Descripcion as fDescripcion, fotos.Fecha as fFecha, Fichero, NomPais, IdAlbum, albumes.Titulo as aTitulo, NomUsuario 
		FROM (`fotos`,`albumes` INNER JOIN `usuarios` ON Usuario = IdUsuario)
		LEFT JOIN `paises` ON fotos.Pais = IdPais
		WHERE IdFoto='".$_GET['id']."' AND Album = IdAlbum";

if(!($resultado = $inkbd->query($sql))) { 
	echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
	echo "</p>"; 
	exit;
}

$image = $resultado->fetch_assoc();

$foto = "'" . $image['Fichero'] . "'";
$titulo = $image['fTitulo'];
$descripcion = $image['fDescripcion'];
$fecha = $image['fFecha'];
$pais= $image['NomPais'];
$idAlbum = $image['IdAlbum'];	
$album = $image['aTitulo'];
$usuario= $image['NomUsuario'];	

if(empty($titulo)){
	$error=0;
	require("inc/error.php");
}
else{
?>
	<section id="detalle">

		<div>
			<img src=<?php echo $foto?> alt="PI">
		</div>
		<div>
			<?php
				$detalle = 	"<p>" . $titulo . "</p>";
				if($descripcion!="") $detalle = $detalle . "<p>" . $descripcion . "</p>";
				if($fecha!="0000-00-00") $detalle = $detalle . "<p>" . $fecha . "</p>";
				if($pais!="") $detalle = $detalle . "<p>" . $pais . "</p>";
				
				$detalle = $detalle . "<a href='Album.php?id=".$idAlbum."''> Album: " . $album . "</a>
									<a href=#> Usuario: " . $usuario . "</a>";
				echo $detalle;

			?>
		</div>
	</section>

<?php
}
require_once("inc/footer.php");
?>
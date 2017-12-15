<?php 
require_once("inc/head.php"); 
require_once("inc/header_logged.php"); 

$sql=  "SELECT Foto, fotos.Titulo as fTitulo, fotos.Descripcion as fDescripcion, fotos.Fecha as fFecha, Fichero, NomPais, IdAlbum, albumes.Titulo as aTitulo, NomUsuario 
		FROM (`fotos`,`albumes` INNER JOIN `usuarios` ON Usuario = IdUsuario)
		LEFT JOIN `paises` ON fotos.Pais = IdPais
		WHERE IdFoto='".$_GET['id']."' AND Album = IdAlbum AND Usuario = IdUsuario";

if(!($resultado = $inkbd->query($sql))) { 
	echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
	echo "</p>"; 
	exit;
}

$image = $resultado->fetch_assoc();

$foto = "'" . $image['Fichero'] . "'";
$titulo = $image['fTitulo'];
$descripcion = $image['fDescripcion'];
$fecha = $image['fFecha'] ? date_create($image['fFecha'])->format("d m Y") : "";
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
			<?php 
			$a = $usuario == $user['NomUsuario'] ? "'Perfil.php'" : '#';
					echo "<a href=".$a."> <img id='user_mini_f' src='".$image['Foto']."'><span>". $usuario . "</span></a>
						<a href='Album.php?id=".$idAlbum."''> <img src='img/album_icon.png'><span>" . $album . "</span></a>"
			?>
		</div>
		<div>
			<img src=<?php echo $foto?> alt="PI">
			<?php 
				echo "<span>".$titulo."</span>
						<span>".$descripcion."</span>"; 
			?>
		</div>
		<div>
			<?php
				$detalle ="";
				if($fecha!=NULL) $detalle = "<p> <img src='img/date-icon.png'>" . $fecha . "</p>";
				if($pais!="") $detalle .= "<p> <img src='img/location-icon.png'>" . $pais . "</p>";

				echo $detalle;
			?>
		</div>
	</section>

<?php
}
require_once("inc/footer.php");
?>
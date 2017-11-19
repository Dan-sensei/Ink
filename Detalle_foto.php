<?php 
require_once("inc/head.php"); 
require_once("inc/header_logged.php"); 
$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
$sql= "SELECT * FROM `fotos` WHERE IdFoto='".$_GET['id']."'";
if(!($resultado = $inkbd->query($sql))) { 
	echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
	echo "</p>"; 
	exit;
}

$image = $resultado->fetch_assoc();

$foto = "'".$image['Fichero']  . "'";			//--------------------PATH
$titulo = $image['Titulo'];						//--------------------TITULO
$descripcion = $image['Descripcion'];			//--------------------DESCRIPCION
$fecha = $image['Fecha'];						//--------------------FECHA

//Cojo el nombre del pais en vez de su Id
$sql = "SELECT * FROM `paises` WHERE IdPais='".$image['Pais']."'";
if(!($resultado = $inkbd->query($sql))) { 
	echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
	echo "</p>"; 
	exit;
}
$pais = $resultado->fetch_assoc();
$pais=	$pais['NomPais'];	//-------------------NOMBRE DEL PAIS

$sql = "SELECT * FROM `albumes` WHERE IdAlbum='".$image['Album']."'";
if(!($resultado = $inkbd->query($sql))) { 
	echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
	echo "</p>"; 
	exit;
}
$album = $resultado->fetch_assoc();
$sql = "SELECT * FROM `usuarios` WHERE IdUsuario='".$album['Usuario']."'";
if(!($resultado = $inkbd->query($sql))) { 
	echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
	echo "</p>"; 
	exit;
}
$usuario = $resultado->fetch_assoc();

$idAlbum = $album['IdAlbum'];	
$album = $album['Titulo'];			//--------------TITULO DEL ALBUM
$usuario= $usuario['NomUsuario'];		//--------------NOMBRE DE USUARIO


?>

	<section id="detalle">
		<div>
			<img src=<?php echo $foto?> alt="PI">
		</div>
		<div>
			<?php
				if($titulo==""){
					header("Location: http://$host$uri/Busqueda.php"); 
					exit;
				}
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
require_once("inc/footer.inc"); 
?>
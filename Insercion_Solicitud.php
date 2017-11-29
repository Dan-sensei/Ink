<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php"); 
	require_once("inc/validation.php");

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	if(!isset($_SESSION['datosYerrores']))
		header("Location: http://$host$uri/perfil.php");

	unset($_SESSION['datosYerrores']);
	unset($_SESSION['error2']);


	$id=intval($_GET['id']);
	$sql = "SELECT COUNT(IdSolicitud) as 'exists', albumes.Titulo as aTitulo, Nombre, solicitudes.Titulo as sTitulo, solicitudes.Descripcion as sDescripcion, solicitudes.Email as sEmail, Direccion, Color, Copias, Resolucion, solicitudes.Fecha as sFecha, IColor, Coste FROM `solicitudes`,`usuarios`,`albumes` 
		WHERE IdUsuario = Usuario AND Album = IdAlbum AND IdSolicitud =".$id." AND Usuario=".$_SESSION['IdUsuario'];

	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}
	$solicitud = $resultado->fetch_assoc();

	if($solicitud['exists']==0){
		$error = 0;
		require("inc/error.php");
		require_once("inc/footer.php");
		exit;
	}

	$date = date_create($solicitud['sFecha'])->format("d-m-Y");
?>
	
	<section id="confirmacion">

		<h2>Pedido confirmado</h2>
			<p><b>Nombre: </b> <?php echo $solicitud['Nombre']; ?> </p>
			<p><b>Título del album:</b> <?php echo $solicitud['sTitulo']; ?> </p>
			<p><b>Correo del destinatario: </b> <?php echo $solicitud['sEmail']; ?> </p>
			<p><b>Texto adicional: </b> <?php echo $solicitud['sDescripcion']; ?> </p>
			<p><b>Dirección: </b> <?php echo $solicitud['Direccion']; ?> </p>
			<p><b>Color de la portada: </b> <?php echo $solicitud['Color']; ?> </p>
			<p><b>Número de copias: </b> <?php echo $solicitud['Copias']; ?> </p>
			<p><b>Resolución de las fotos: </b> <?php echo $solicitud['Resolucion']; ?> DPI</p>
			<p><b>Álbum: </b> <?php echo $solicitud['aTitulo'] ?> </p>
			<p><b>Fecha de recepción: </b> <?php echo $date?> </p>
			<p><b>Impresión: </b> 
				<?php if($solicitud['IColor']==0) echo "En blanco y negro";
						else echo "A color";
				?> 
			</p>

		<h2>Precio: <?php echo $solicitud['Coste']; ?> € </h2>

	</section>
	
<?php
	require_once("inc/footer.php"); 
?>
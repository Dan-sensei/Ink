<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php");

	$id=intval($_SESSION['IdUsuario']);
	$sql = "SELECT Foto, Email, Sexo, FNacimiento, Ciudad, NomPais FROM `usuarios`,`paises` WHERE IdUsuario =".$id." AND Pais=IdPais";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}

	$user = $resultado->fetch_assoc();
	$Sexo = array(
		0 => 'Hombre',
		1 => 'Mujer',
		2 => 'Otro'
	);
?>

	<section id="perfil">
		<aside>
			<!--Enlaces-->
			<nav>
				<!-- Nuevos
				<a href="Modificar.php">Modificar datos</a><br>
				<a href="Albumes.php">Mis álbumes</a><br>
				<a href="Nuevo_album.php">Crear un nuevo álbum</a><br>
				<a href="Solicitar.php">Solicitar álbum impreso</a><br>
				<a href="Baja.php">Darse de baja</a>
				-->
				<a href="#">Modificar datos</a><br>
				<a href="albumes.php">Mis álbumes</a><br>
				<a href="crear_album.php">Crear un nuevo álbum</a><br>
				<a href="Solicitar.php">Solicitar álbum impreso</a><br>
				<a href="addFoto.php">Añadir foto a album</a><br>
				<a href="#">Darse de baja</a>

			</nav>
		</aside>
		<div>
			<span>
				<?php echo "<img src='".$user['Foto']."' class='user'> "?>
				<h1><?php echo $_SESSION["usuario"] ?></h1>
			</span>	
		</div>
		<section>
			<div>
				<?php
				if($user['Sexo']!=null)
					echo "<p><b>Sexo: </b>".$Sexo[$user['Sexo']]."</p>";
				$date = date_create($user['FNacimiento'])->format('d-m-Y');

				echo   "<p><b>Email: </b>".$user['Email']."</p>
						<p><b>Ciudad: </b>".$user['Ciudad']."</p>
						<p><b>País: </b>".$user['NomPais']."</p>
						<p><b>Fecha de nacimiento: </b>".$date."</p>";
				?>
			</div>
		</section>
	</section>
<?php
	$resultado->close();
	require_once("inc/footer.php"); 
?>
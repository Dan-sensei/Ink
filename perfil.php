<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php"); 
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
				<a href="#">Darse de baja</a>

			</nav>
		</aside>
		<div>
			<span>
				<img src="img/Sona_profile.png" class="user">
				<h1><?php echo $_SESSION["usuario"] ?></h1>
			</span>	
		</div>
		<section>
			<div>
				<p><b>Sexo:</b> Hombre</p>
				<p><b>Email: </b>datrixz997@gmail.com</p>
				<p><b>Móvil: </b>658640065</p>
				<p><b>Ciudad: </b>Ibi</p>
				<p><b>País: </b>España</p>
			</div>
		</section>
	</section>
<?php
	require_once("inc/footer.inc"); 
?>
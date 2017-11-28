<?php 
	require_once("inc/head.php");
	require_once("inc/validation.php");

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$id=intval(validate_input($_SESSION['IdUsuario']));
	$erase = "DELETE FROM `usuarios` WHERE IdUsuario =".$id;
	$message="";

	if(isset($_POST['si'])){
		if(!($inkbd->query($erase))){
			$message = "<span style='color:#ea4c44'>Algo salio mal, inténtalo de nuevo</span>";
		}
		else{
			session_destroy();
			session_start();

			echo "<section id='baja'>
					<div>
						<a href='index.php' id='logo_jl'>
							<span>Home</span>
							<img src='img/dark_ink.png' lat='Logo'>
						</a>
						<p class='fuente_centrada'><span style='color:#43eaa4;'>Borrado realizado</span></p>
					</div>  
				</section>";
			exit;
		}
	}
	else if(isset($_POST['no'])){
		require_once("inc/footer.php"); 
		header("Location: http://$host$uri/Perfil.php");
		exit;
	}
?>
	<section id="baja">
		<div>
			<a href="index.php" id="logo_jl">
				<span>Home</span>
				<img src="img/dark_ink.png" lat="Logo">
			</a>
			<form action="Baja.php" method="post">
				<img src="img/sg-soraka.png" alt="Abandono">
				<p class="fuente_centrada"><span>¿Seguro de que quieres eliminar tu cuenta?</span></p>
				<div>
					<input type="submit" name="si" value="Sí">
					<input type="submit" name="no" value="No">
				</div>
				<p class="fuente_centrada"><span><?php echo $message; ?></span></p>
		  </form>
		</div>  
	</section>

<?php
	require_once("inc/footer.php"); 
?>
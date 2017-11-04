<?php 
	require_once("inc/head.php");
	require_once("inc/header_logged.php");

	$logged =
			"<a href='perfil.php'>
				<img src='img/Sona_profile.png' id='user_mini'>
			</a>
		</div>
	</header>";

	echo $logged;
?>

	<section id="crear_album">
		<div>
			<form action="access.php" method="post">
				<h3>Crear álbum</h3>
				<label for="title">Título<span>*</span></label>
				<p><input type="text" name="titulo" id="titulo" required></p>
			
				<label for="desc">Descripción<span>*</span></label>
				<p><input type="text" name="desc" id="desc" required></p>

				<label for="date">Fecha<span>*</span></label>
				<p><input type="date" name="date" id="date" required></p>

				<label for="country">País<span>*</span></label>
				<p><input type="text" name="country" id="country" required></p>

				<p class="fuente_centrada"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<input type="submit" value="Login">
			</form>
		</div>
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
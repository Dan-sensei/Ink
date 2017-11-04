<?php 
	require_once("inc/head.php");
?>

	<section id="busqueda_avanzada">
		<div>
			<a href="index.php" id="logo_jl">
				<span>Home</span>
				<img src="img/dark_ink.png" lat="Logo">
			</a>
			<form action="Resultado.php" method="post">
				<label for="title">Título</label>
				<p><input type="text" id="title" name="title"></p>

				<label for="date1">Fecha entre </label>
				<p><input id="date1" name="date1" type="date"> <span>y</span> <input id="date2" name="date2" type="date"></p>

				<label for="country">País</label>
				<p><input type="text" id="country" name="country"></p>

				<p><input type="submit" value="Buscar"></p>
		  </form>
		</div>  
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
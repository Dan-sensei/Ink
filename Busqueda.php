<?php 
	require_once("inc/head.php");
	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	 } 

	 
?>

	<section id="busqueda_avanzada">
		<div>
			<a href="index.php" id="logo_jl">
				<span>Home</span>
				<img src="img/dark_ink.png" lat="Logo">
			</a>
			<form action="Resultado.php" method="post" id="busqueda">
				<label for="title">Título</label>
				<p><input type="text" id="title" name="title"></p>

				<label for="date1">Fecha entre </label>
				<p><input id="date1" name="date1" type="date"> <span>y</span> <input id="date2" name="date2" type="date"></p>

				<label for="country">País</label>
				<select form="busqueda" class="extra" name="country" id="country">
					<option selected='selected' value=''></option>
					<?php 
						while($option = $resultado->fetch_assoc() ) { 
							echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
					 	} 
					?>
				</select>

				<p><input type="submit" value="Buscar"></p>
		  </form>
		</div>  
	</section>

<?php
	$resultado->close(); 
	$inkbd->close(); 
	require_once("inc/footer.inc"); 
?>
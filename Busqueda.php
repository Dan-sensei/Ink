<?php 
	require_once("inc/head.php");
	$sql_getPais = "SELECT IdPais, NomPais FROM `paises` ORDER BY NomPais ASC";
	$error= false;
	if(!($resultado = $inkbd->query($sql_getPais)))
		$error= true;	 
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
				<?php 
				if (!$error){
					echo "<select form='busqueda' class='extra' name='country' id='country'>
						<option selected='selected' value=''></option>";
					
							while($option = $resultado->fetch_assoc() ) { 
								echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
						 	} 
						
					echo "</select>";
				}
				?>
				<p><input type="submit" value="Buscar"></p>
		  </form>
		</div>  
	</section>

<?php
	$resultado->close(); 
	require_once("inc/footer.php"); 
?>
<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php"); 

	$sql = "SELECT * FROM `usuarios`, `albumes` WHERE NomUsuario = '".$_SESSION["usuario"]."' AND IdUsuario=Usuario";
	if(!($resultado = $inkbd->query($sql))) { 
		echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
		echo "</p>"; 
		exit;
	}

	$sql_getPais = "SELECT * FROM `paises` ORDER BY NomPais ASC";

	if(!($resultado2 = $inkbd->query($sql_getPais))) { 
	   echo "<p>Error al ejecutar la sentencia <b>$sql_getPais</b>: " . $inkbd->error; 
	   echo "</p>"; 
	   exit; 
	 } 
?>
	
	<section id="solicitar">
		<div>
		<h2>Solicitar álbum</h2>
		  
		  	<p>Rellena este formulario para solicitar tu propio álbum impreso. Personalízalo a tu gusto, con título, portada y comentarios. Una vez completado, pasarás a la confirmación del pedido.</p>

		  	<table>
		  		<tr>
		  			<td></td>
		  			<td></td>
		  			<th colspan="6"><b>Resolucion (DPI)</b></th>
		  			<td></td>

		  		</tr>
		  		<tr>
		  			<td></td>
		  			<td></td>
		  			<td class="morado2"><b>150</b></td>
		  			<td class="morado2"><b>300</b></td>
		  			<td class="morado2"><b>450</b></td>
		  			<td class="morado2"><b>600</b></td>
		  			<td class="morado2"><b>750</b></td>
		  			<td class="morado2"><b>900</b></td>
		  			<td class="morado2"></td>
		  		</tr>
		  		<tr>
		  			<td rowspan=6 class="morado">Paginas</td>
		  			<th><b>1 - 5</b></th>
		  			<td>1</td>
		  			<td>1.5</td>
		  			<td>2</td>
		  			<td>3</td>
		  			<td>4</td>
		  			<td>5</td>
		  			<td rowspan=6 class="vertical">€ / pagina</td>
		  		</tr>
		  		<tr>
		  			<th><b>6 - 10</b></th>
		  			<td>0.9</td>
		  			<td>1.35</td>
		  			<td>1.8</td>
		  			<td>2.7</td>
		  			<td>3.6</td>
		  			<td>4.5</td>
		  		</tr>
		  		<tr>
		  			<th><b>11 - 20</b></th>
		  			<td>0.8</td>
		  			<td>1.2</td>
		  			<td>1.6</td>
		  			<td>2.4</td>
		  			<td>3.2</td>
		  			<td>4</td>
		  		</tr>
		  		<tr>
		  			<th><b>21 - 50</b></th>
		  			<td>0.7</td>
		  			<td>1.05</td>
		  			<td>1.4</td>
		  			<td>2.1</td>
		  			<td>2.8</td>
		  			<td>3.5</td>
		  		</tr>
		  		<tr>
		  			<th><b>51 - 100</b></th>
		  			<td>0.6</td>
		  			<td>0.9</td>
		  			<td>1.2</td>
		  			<td>1.8</td>
		  			<td>2.4</td>
		  			<td>3</td>
		  		</tr>
		  		<tr>
		  			<th><b>+100</b></th>
		  			<td>0.5</td>
		  			<td>0.75</td>
		  			<td>1</td>
		  			<td>1.5</td>
		  			<td>2</td>
		  			<td>2.5</td>
		  		</tr>
		  		<tr>
		  			<td><br></td>
		  			<td></td>
		  			<td></td>
		  			<td></td>
		  			<td></td>
		  			<td></td>
		  			<td></td>
		  			<td></td>
		  			<td></td>
		  		</tr>
		  		<tr>
		  			<td rowspan=2 class="vertical">Portada</td>
		  			<td><b>Color</b></td>
		  			<td>+1</td>
		  			<td>+2.5</td>
		  			<td>+4</td>
		  			<td>+8</td>
		  			<td>+12</td>
		  			<td>+15</td>
		  			<td></td>
		  		</tr>
		  		<tr>
		  			<td><b>Blanco y negro</b></td>
		  			<td>+0.7</td>
		  			<td>+2</td>
		  			<td>+3.5</td>
		  			<td>+7.3</td>
		  			<td>+10</td>
		  			<td>+12.5</td>
		  			<td></td>
		  		</tr>
		  	</table>
		</div>
		  	<!--Usar asterisco-->
		  <div>
		  	<form action="Rsolicitar.php" method="post" id="f_solicitar">
			  	<section>
				  	<h2>Datos</h2>
				  	
				  	<label for="name">Nombre<span>*</span></label>
					<p><input type="text" name="name" id="name" placeholder="(obligatorio)" maxlength="200" required>
					<input type="text" name="surname" placeholder="(opcional)"></p>

					<label for="talbum">Título del album<span>*</span></label>
					<p><input type="text" name="talbum" id="talbum" placeholder="Album 1" maxlength="200" required></p>
					
					<label for="destinatario">Destinatario (email)<span>*</span></label>
					<p><input type="email" name="destinatario" id="destinatario" placeholder="example@gmail.com" maxlength="200" required></p>

					<label for="adicional">Comentario adicional</label>
				  	<p><input type="text" name="adicional" id="adicional" maxlength="4000" placeholder="Escribe aquí..."></p>
				</section>

				<section>
					<h2>Direccion</h2>

					<label for="direccion">Dirección postal<span>*</span></label>
					<p><input type="text" name="direccion" id="direccion" placeholder="Calle y número" required></p>
					<p><input type="text" name="direccion2" id="direccion2" placeholder="Bloque, piso, escalera, etc."></p>

					<label for="country">País<span>*</span></label>
					<select form="busqueda" class="extra" name="country" id="country" required>
						<option selected='selected' value=''></option>
						<?php 
							while($option = $resultado2->fetch_assoc() ) { 
								echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
						 	} 
						?>
					</select>

					<label for="ciudad">Ciudad<span>*</span></label>
					<p><input type="text" name="ciudad" id="ciudad" required></p>

					<label for="provincia">Provincia<span>*</span></label>
					<p><input type="text" name="provincia" id="provincia" required></p>

					<label for="cp">Código postal<span>*</span></label>
					<p><input type="text" name="cp" id="cp" maxlength="5" required></p>
				</section>

				<section>
					<h2>Personalización</h2>
					<label for="color">Color de la portada</label>
					<p><input type="color" name="color" id="color" value="#000000"></p>	

					<label for="copias">Número de copias<span>*</span></label>
					<p><input type="number" name="copias" id="copias" min="1" value="1" required></p>

					<label for="res">Resolución de las fotos (DPI)<span>*</span></label>
					<p><input type="number" name="res" id="res" min="150" step="150" value="150" required></p>

					<label for="album">Álbum<span>*</span></label>
					<select form="f_solicitar" class="extra" name="album" id="album">
					<?php 
						while($option = $resultado->fetch_assoc() ) { 
							echo  "<option value='".$option['Titulo']."'>".$option['Titulo'] ."</option>"; 
					 	} 
					?>
					</select> 

					<p><label for="date">Fecha de recepción<span>*</span></label></p>
					<p><input id="date" type="date" name="date" required></p>

					<p class="centered"><br>Impresión</p>
					<div>
						<label for="acolor">Color</label>
						<input type="radio" name="acolor" id="acolor" value="Color" checked><br>

						<label for="abyn">Blanco y negro</label>
						<input type="radio" name="acolor" id="abyn" value="Blanco y negro"><br>
					</div>
				</section>
				<p class="fuente_centrada2"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<p><br><input type="submit" value="Comprar"></p>
		  </form>
		</div>
	</section>
	
<?php
require_once("inc/footer.php"); 
?>
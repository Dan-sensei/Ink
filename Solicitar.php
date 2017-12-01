<?php 
	require_once("inc/head.php"); 
	require_once("inc/header_logged.php"); 

	if(isset($_SESSION['done'])) unset($_SESSION['done']);
	$message="";
	if (isset($_SESSION["error"])) {
	    $message = $_SESSION["error"];
	    unset($_SESSION["error"]);
	}

	$sql = "SELECT IdAlbum, Titulo FROM `usuarios`, `albumes` WHERE IdUsuario = '".$_SESSION["IdUsuario"]."' AND IdUsuario=Usuario";
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

	 if(!isset($_SESSION['datosYerrores'])){
		$datosYerrores = array(
			0 => array("", ""),			//Nombre
			1 => array("", ""),		//Nombre 2
			2 => array("", ""),		//Titulo album
			3 => array("", ""),	//Destinatario
			4 => array("", ""),		//Comentario
			5 => array("", ""),		//Direccion
			6 => array("", ""),	//Direccin 2
			7 => array("", ""),			//Pais
			8 => array("", ""),		//Ciudad
			9 => array("", ""),		//Provincia
		   10 => array("", ""),			//Codigo postal
		   11 => array("#000000", ""),			//Color
		   12 => array("1", ""),		//Numero de copias
		   13 => array("150", ""),			//Resolucion
		   14 => array("", ""),			//Album
		   15 => array("", ""),			//Fecha de recepcion
		   16 => array("1", "")			//A color?
		);
	}else{
		$datosYerrores = $_SESSION['datosYerrores'];
		unset($_SESSION['datosYerrores']);
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
		  	<form action="INSERT_Solicitud.php" method="post" id="f_solicitar">
			  	<section>
				  	<h2>Datos</h2>
				  	
				  	<label for="name">Nombre<span>*</span></label>
					<input type="text" name="name" id="name" placeholder="(obligatorio)" maxlength="200" value=<?php echo "'".$datosYerrores[0][0]."'" ?> required>
					<input type="text" name="surname" value=<?php echo "'".$datosYerrores[1][0]."'" ?> placeholder="(opcional)">
					<p class="fuente_centrada"><span><?php echo $datosYerrores[0][1]?></span></p>


					<label for="talbum">Título del album<span>*</span></label>
					<input type="text" name="talbum" id="talbum" placeholder="Album 1" maxlength="200" value=<?php echo "'".$datosYerrores[2][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[2][1]?></span></p>

					<label for="destinatario">Destinatario (email)<span>*</span></label>
					<input type="email" name="destinatario" id="destinatario" placeholder="example@gmail.com" maxlength="200" value=<?php echo "'".$datosYerrores[3][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[3][1]?></span></p>


					<label for="adicional">Comentario adicional</label>
				  	<input type="text" name="adicional" id="adicional" maxlength="4000" value=<?php echo "'".$datosYerrores[4][0]."'" ?> placeholder="Escribe aquí...">
				  	<p class="fuente_centrada"><span><?php echo $datosYerrores[4][1]?></span></p>

				</section>

				<section>
					<h2>Direccion</h2>

					<label for="direccion">Dirección postal<span>*</span></label>
					<input type="text" name="direccion" id="direccion" placeholder="Calle y número" value=<?php echo "'".$datosYerrores[5][0]."'" ?> required>
					<input type="text" name="direccion2" id="direccion2" placeholder="Bloque, piso, escalera, etc." value=<?php echo "'".$datosYerrores[6][0]."'" ?>>

					<p class="fuente_centrada"><span><?php echo $datosYerrores[6][1]?></span></p>

					<label for="pais">País<span>*</span></label>
					<select form="f_solicitar" name="pais" id="pais" required>
						<?php 
							$p = $datosYerrores[7][0] ? $datosYerrores[7][0] : "ES";
							while($option = $resultado2->fetch_assoc() ) {
								 if($option['IdPais']==$p){
									echo  "<option selected='selected' value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 		  
								}
								else 
									echo  "<option value='".$option['IdPais']."'>".$option['NomPais'] ."</option>"; 
						 	} 
						?>
					</select>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[7][1]?></span></p>

					<label for="ciudad">Ciudad<?php echo $p?><span>*</span></label>
					<input type="text" name="ciudad" id="ciudad" value=<?php echo "'".$datosYerrores[8][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[8][1]?></span></p>


					<label for="provincia">Provincia<span>*</span></label>
					<input type="text" name="provincia" id="provincia" value=<?php echo "'".$datosYerrores[9][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[9][1]?></span></p>


					<label for="cp">Código postal<span>*</span></label>
					<input type="text" name="cp" id="cp" maxlength="5" value=<?php echo "'".$datosYerrores[10][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[10][1]?></span></p>

				</section>

				<section>
					<h2>Personalización</h2>
					<label for="color">Color de la portada</label>
					<input type="color" name="color" id="color" value=<?php echo "'".$datosYerrores[11][0]."'" ?>>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[11][1]?></span></p>


					<label for="copias">Número de copias<span>*</span></label>
					<input type="number" name="copias" id="copias" min="1" value=<?php echo "'".$datosYerrores[12][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[12][1]?></span></p>


					<label for="res">Resolución de las fotos (DPI)<span>*</span></label>
					<input type="number" name="res" id="res" min="150" max="900" step="150" value=<?php echo "'".$datosYerrores[13][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[13][1]?></span></p>


					<label for="album">Álbum<span>*</span></label>
					<select form="f_solicitar" class="extra" name="album" id="album">
					<?php 
						$a = $datosYerrores[14][0];
						while($option = $resultado->fetch_assoc() ) {
							if($option['IdAlbum'] == $a) {
								echo "<option selected='selected' value='".$option['IdAlbum']."'>".$option['Titulo'] ."</option>";
							}
							else
								echo  "<option value='".$option['IdAlbum']."'>".$option['Titulo'] ."</option>"; 
					 	} 
					?>
					</select> 
					<p class="fuente_centrada"><span><?php echo $datosYerrores[14][1]?></span></p>

					<label for="date">Fecha de recepción<span>*</span></label></p>
					<input id="date" type="date" name="date" value=<?php echo "'".$datosYerrores[15][0]."'" ?> required>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[15][1]?></span></p>

					<p class="centered"><br>Impresión</p>
					<div>
						<label for="acolor">Color</label>
						<input type="radio" name="acolor" id="acolor" value="1" <?php if($datosYerrores[16][0]==1) echo "checked='checked'"?>><br>

						<label for="abyn">Blanco y negro</label>
						<input type="radio" name="acolor" id="abyn" value="0" <?php if($datosYerrores[16][0]==0) echo "checked='checked'"?> ><br>
					</div>
					<p class="fuente_centrada"><span><?php echo $datosYerrores[16][1]?></span></p>

				</section>
				<p class="fuente_centrada2"><span>*</span><span class="obligatorio">Obligatorio</span></p>
				<p class="fuente_centrada" style="width: 39%; font-weight: bold;"><span><?php echo $message?></span></p>
				<br><input type="submit" value="Comprar"></p>
		  </form>
		</div>
	</section>
	
<?php
require_once("inc/footer.php"); 
?>
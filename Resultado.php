<?php 
	require_once("inc/head.php"); 
	require_once("inc/header.php"); 
	
	$title = "";
	$date1 = "";
	$date2 = "";
	$country = "";

	if(isset($_POST["title"]))
		$title = "'".htmlspecialchars($_POST["title"])."'";

	if(isset($_POST["date1"]))
		$date1 = "'".htmlspecialchars($_POST["date1"])."'";
	
	if(isset($_POST["date2"]))
		$date2 = "'".htmlspecialchars($_POST["date2"])."'";

	if(isset($_POST["country"]))
		$country = "'".htmlspecialchars($_POST["country"])."'";
?>
	<div id="panel">
		<form action="Resultado.php" id="parametros">
			<div class="filtro">
				<label for="title">Título</label>
				<p><input type="text" id="title" name="title" value=<?php echo $title?>  ></p>
			</div>
			<div class="filtro">
				<label for="date1">Fecha entre </label>
				<p><input id="date1" type="date" value=<?php echo $date1?> > <span>y</span> <input id="date2" type="date" value=<?php echo $date2?>></p>
			</div>
			<div class="filtro">
				<label for="country">País</label>
				<p><input type="text" id="country" name="country" value=<?php echo $country?>></p>
			</div>
			<div class="filtro">
				<p><input type="submit" value="Buscar"></p>
			</div>
		</form>
	</div>
  <section id="columnas2">
  	
		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/Sona_profile.png" alt="Zed">
					<div><p>Titulo 1<br>
							21/7/2017 <br>
							Alemania</p>
					</div>
				</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/p5.jpg" alt="Sona">
					<div>
						<p>Titulo 1<br>
						21/7/2017<br>
						Alemania</p>
					</div>
				</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p1.jpg" alt="Sona">
					<div>
						<p>Titulo 1 <br>
						21/7/2017 <br>
						Alemania</p>
					</div>
				</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/Midoriya.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
				
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p2.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
				
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/681367.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
				
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p3.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
				
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/p4.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
				
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p5.jpg" alt="Sona">
					<div>
					<p>Titulo 1 <br>
					21/7/2017 <br>
					Alemania</p>
					</div>
				</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/afd.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
			</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/681367.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/p2.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p4.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
			</a>
		</figure>
		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/p2.jpg" alt="Sona">
					<div>
				<p>Titulo 1 <br>
				21/7/2017 <br>
				Alemania</p>
				</div>
				</div>
			</a>
		</figure>
		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p1.jpg" alt="Sona">
					<div>
						<p>Titulo 1 <br>
						21/7/2017 <br>
						Alemania</p>
				</div>
				</div>
			</a>
		</figure>
	</section>

<?php
	require_once("inc/footer.inc"); 
?>
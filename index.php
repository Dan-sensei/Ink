<?php 

	require_once("inc/head.php"); 
	require_once("inc/header.php"); 

	
?>
	<section id="columnas">
		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/Zed.jpg" alt="Zed" class="img" title="Sona">
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
					<img src="img/p5.jpg" alt="Sona" title="Imagen5">
					<div>
						<p>
							Titulo 1<br>
							21/7/2017<br>
							Alemania
						</p>
					</div>
				</div>

			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p1.jpg" alt="Sona" title="Imagen2">
					<div>
						<p>
						Titulo 1<br>
						21/7/2017<br>
						Alemania
					</p>
					</div>
				</div>
				
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=false">
				<div>
					<img src="img/Midoriya.jpg" alt="Sona">
					<div>
						<p>
						Titulo 1 <br>
						21/7/2017 <br>
						Alemania
					</p>
					</div>
					
				</div>
			</a>
		</figure>

		<figure>
			<a href="Detalle_foto.php?trigger=true">
				<div>
					<img src="img/p2.jpg" alt="Sona">
					<div>
						<p>
						Titulo 1 <br>
						21/7/2017 <br>
						Alemania
					</p>
					</div>
				</div>
			</a>
		</figure>

	</section>

<?php
	require_once("inc/footer.inc"); 
?>
	<?php
	
		if(isset($_SESSION["usuario"])){
			
			$fecha="";
			if(isset($_COOKIE['recuerdame'])){
				$data = json_decode($_COOKIE['recuerdame'], true);
				$fecha="<br>ult. vez <br><span>".$data['3']['mday']."/".$data['3']['mon']."/".$data['3']['year']."</span> <span>".$data['3']['hours'].":".$data['3']['minutes']."</span>";
			}
			$logged =	"<a href='perfil.php'>
							<div>
								<img src='img/Sona_profile.png' id='user_mini'>

								<span class='saludo_small'> Hola, <span class='saludo_big'>" . $_SESSION["usuario"] ."</span>".$fecha."</span>

							</div>
						</a>
						<div>
							<a id='logout' href='access.php?logout=true'><span>Salir</span></a>
						</div>
					</div>
				</header>";
		}

		else{
			
			if(isset($_COOKIE["recuerdame"])){
				$data = json_decode($_COOKIE['recuerdame'], true);
				if($data['4']=="1"){
					$host = $_SERVER["HTTP_HOST"];
					$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
					header("Location: http://$host$uri/access.php");
				}
				else{
					$logged = 	"<a href='registro.php' id='login'>
							<span>Homeee</span>
						</a>
					</div>
				</header>";
				}
			}
			else{
				$logged = 	"<a href='registro.php' id='login'>
							<span>Homeee</span>
						</a>
					</div>
				</header>";
			}
			
			/*
			
			$logged = 	"<a href='registro.php' id='login'>
							<span>Homeee</span>
						</a>
					</div>
				</header>";

				*/
				
		}

		/*
		$logged =	"<a href='perfil.php'>
							<div>
								<img src='img/Sona_profile.png' id='user_mini'>
								<span class='saludo_small'> Hola, <span class='saludo_big'>" . $_SESSION["usuario"] ."</span> <br>ult. vez <br>10/10/2010 10:10</span>
							</div>
						</a>
						<div>
							<a id='logout' href='access.php?logout=true'><span>Logout</span></a>
						</div>
					</div>
				</header>";
		*/

	?>

	<header>
		<div>
			<a href="index.php" tabindex="1" id="logo">
				<span>Home</span>
				<img src="img/dark_ink.png" title="Logo">
			</a>
		</div>

		<div>
			<form action="Resultado.php">
				<div class="busqueda">
	      			<input tabindex="3" class="icon" type="submit" value="">
					<input tabindex="2" type="search" id="search" name="fname" placeholder="Fotos, lugares, ideas...">

					<a class="avanzada" href="Busqueda.php"><span>Búsqueda avanzada</span></a>
				</div>
			</form>
		</div>

		<div>
			<?php echo $logged ?>
			
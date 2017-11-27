	<header>
		<div>
			<a href="index.php" tabindex="1" id="logo">
				<span>Home</span>
				<img src="img/dark_ink.png" title="Logo">
			</a>
		</div>

		<div>
			<form action="Resultado.php" method="post">
				<div class="busqueda">
	      			<input tabindex="3" class="icon" type="submit" value="">
					<input tabindex="2" type="search" id="title" name="title" placeholder="Fotos, lugares, ideas...">

					<a class="avanzada" href="Busqueda.php"><span>Búsqueda avanzada</span></a>
				</div>
			</form>
		</div>

		<div>

		<?php
		if(isset($_SESSION["usuario"])){
			$fecha="";
			if(isset($_COOKIE['recuerdame'])){
				$data = json_decode($_COOKIE['recuerdame'], true);
				$fecha="<br>ult. vez <br><span>".$data['3']['mday']."/".$data['3']['mon']."/".$data['3']['year']."</span> <span>".$data['3']['hours'].":".$data['3']['minutes']."</span>";
			}
		$id=intval($_SESSION['IdUsuario']);
		$sql = "SELECT NomUsuario, Foto FROM `usuarios` WHERE IdUsuario =".$id;
		if(!($resultado = $inkbd->query($sql))) { 
			echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
			echo "</p>"; 
			exit;
		}
		$user = $resultado->fetch_assoc();

			$logged =
				"<a href='perfil.php'>
					<div>
						<img src='".$user['Foto']."' id='user_mini'>

						<span class='saludo_small'> Hola, <span class='saludo_big'>" . $user['NomUsuario'] ."</span>".$fecha."</span>

					</div>
				</a>
				<div>
					<a id='logout' href='access.php?logout=true'><span>Salir</span></a>
				</div>
			</div>
		</header>";

		echo $logged;
		}
		else{
			$host = $_SERVER["HTTP_HOST"];
			$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
			header("Location: http://$host$uri/Registro.php"); 
			exit;

			//<span class='saludo_small'> Hola, <span class='saludo_big'>" . $_SESSION["usuario"] ."</span> <br>ult. vez <br>10/10/2010 10:10</span>
		}
		?>

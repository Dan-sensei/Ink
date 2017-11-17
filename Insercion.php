<?php 
	require_once("inc/head.php"); 
	

	

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$name2 = $code  = $code2 = $email = $gender = $date = $ciudad = $pais = $foto = "";

	$name2 = 	htmlspecialchars($_POST["name2"]);
	$code = 	htmlspecialchars($_POST["code"]);
	$code2 = 	htmlspecialchars($_POST["code2"]);

	if($code != $code2){
		header("Location: http://$host$uri/Registro.php");
		$_SESSION["error2"] = "Las contraseñas no coinciden";
		exit;
	}
	$email = 	htmlspecialchars($_POST["email"]);

	if(isset($_POST["gender"]))
		$gender = 	htmlspecialchars($_POST["gender"]);
	else
		$gender = "-";

	$pic = "'img/icon.png'";
	$date = 	htmlspecialchars($_POST["date"]);
	$city = 	htmlspecialchars($_POST["city"]);
	$pais = 	htmlspecialchars($_POST["pais"]);
	
	//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	//https://stackoverflow.com/questions/19027992/undefined-index-while-uploading-file
	if(isset($_POST['submit'])){
	    $name       = $_FILES['pic']['name'];  
	    $temp_name  = $_FILES['pic']['tmp_name'];  
	    if(isset($name)){
	        if(!empty($name)){    
	        	if ($_FILES["pic"]["size"] < 5000000) {
	        		$location = 'img/';      
		            if(move_uploaded_file($temp_name, $location.$name))
		            $pic = 	"'img/".$name."'"; 
	        	}  
	            
	        }       
	    }
	}
	
	

	$sql_newUser = "INSERT INTO `usuarios`(`NomUsuario`, `Clave`, `Email`, `Sexo`, `FNacimiento`, `Ciudad`, `Pais`, `Foto`, `FRegistro`) VALUES ('".$name2."','".$code."', '".$email."', '".$gender."', '".$date."', '".$city."', '".$pais."', ".$pic.", '".$date."')";

	if(!($resultado = $inkbd->query($sql_newUser))) { 
	   	echo "<p>Error al ejecutar la sentencia <b>$sql_newUser</b>: " . $inkbd->error; 
	   	//header("Location: http://$host$uri/Registro.php");
		$_SESSION["error2"] = "Permiso denegado"
		exit;
	 }
	 else{
	 	$_SESSION["usuario"]=$name2;
	 }
	

	require_once("inc/header_logged.php"); 

?>

	<section id="insercion">
		<div>
			<span>
				<h2>Inserción realizada correctamente</h2>
				<img src=<?php echo $pic ?> class="user">
				<h1> <? echo $name2 ?> </h1>
			</span>	
		</div>
		<section>
			<div>
				<p><b>Contraseña:</b> <?php echo $code ?> </p>
				<p><b>Sexo:</b> <?php echo $gender ?> </p>
				<p><b>Email: </b> <?php echo $email ?> </p>
				<p><b>Fecha de nacimiento: </b> <?php echo $date ?> </p>
				<p><b>Ciudad: </b> <?php echo $city ?> </p>
				<p><b>País: </b> <?php echo $pais ?> </p>
			</div>
		</section>
	</section>
<?php
	require_once("inc/footer.inc"); 
?>
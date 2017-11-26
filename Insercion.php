<?php 
	require_once("inc/head.php"); 
	
	function validate_input($data) {
	  	$data = trim($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	$name2 = $code  = $code2 = $email = $gender = $date = $ciudad = $pais = $foto = "";

	if(!isset($_POST['name2']) || !isset($_POST['code']) || !isset($_POST['email']) || !isset($_POST['gender']) || !isset($_POST['date']) || !isset($_POST['city']) || !isset($_POST['pais']) ){
		$_SESSION['error2']="Algunos datos no se han especificado";
		header("Location: http://$host$uri/Registro.php");
		exit;
	}

	$name2 	= 	validate_input($_POST["name2"]);
	$code 	= 	validate_input($_POST["code"]);
	$code2 	= 	validate_input($_POST["code2"]);
	$email 	= 	validate_input($_POST["email"]);
	$gender	= 	validate_input($_POST["gender"]);
	$date 	= 	validate_input($_POST["date"]);
	$city 	= 	validate_input($_POST["city"]);
	$pais 	= 	validate_input($_POST["pais"]);

	if(empty($_FILES['pic']['name']))
		$pic = $_FILES['pic']['name'] =	"'img/icon.png'";
	else
		$pic =  "'img/".$_FILES['pic']['name']."'";

	$datosYerrores = array(
		0 => array($name2, ""),
		1 => array("",""),
		2 => array($email, ""),
		3 => array($gender, ""),
		4 => array($date, ""),
		5 => array($city, ""),
		6 => array($pais, ""),
		7 => array($pic, ""),
		8 => ""
	);
	$_SESSION['datosYerrores'] = $datosYerrores;

	$booleano_molon = false;

	$int_options = array(
		"options" => array("min_range" => 3, "max_range" => 15)
	);

	//NOMBRE DE USUARIO
	if (!preg_match("/^[a-zA-Z\d]{3,15}$/",$name2)) {
		$booleano_molon = true;
		$_SESSION["datosYerrores"][0][1] = "El nombre de usuario solo puede contener letras y numeros, y debe tener una longitud de 3 a 15 caracteres.";
	}

	//CONTRASEÑA
	if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d_]{6,15}$/", $code) ){
		$booleano_molon = true;
		$_SESSION["datosYerrores"][1][1] = "La contraseña solo puede contener letras, numeros y '_'. Debe tener al menos, una letra mayuscula, una minuscula, un numero y una lonitud de 6 a 15 caracteres. ".$code;
	}
	if($code != $code2){
		$booleano_molon = true;
		$_SESSION["datosYerrores"][1][1] = "Las contraseñas no coinciden";
	}

	//EMAIL
	if (!($email=filter_var($email,FILTER_VALIDATE_EMAIL))){			//!preg_match("/^[a-zA-Z\d.-_]+@[a-zA-Z]+.[a-zA-Z]{2,4}$/", $email)
		$booleano_molon = true;
		$_SESSION["datosYerrores"][2][1] = "Introduce una direccion válida. - ".$email;
	}

	//SEXO
	if($gender != 0 && $gender != 1 && $gender != 2){
		$booleano_molon = true;
		$_SESSION["datosYerrores"][3][1] = "Elige una de las 3 opciones - ".$gender;
	}

	//FECHA
	$d = date_parse_from_format("Y-m-d", $date);
	$today = date("Y-m-d");
	if(!checkdate($d['month'], $d['day'], $d['year']) || $date > $today){
		$booleano_molon = true;
		$_SESSION["datosYerrores"][4][1] = "Escoge una fecha válida. ".$date;
	}

	//CIUDAD
	if(!ctype_alpha($city) && !empty($city)){
		$booleano_molon = true;
		$_SESSION["datosYerrores"][5][1] = "La ciudad solo puede contener letras.".$city;
	}

	//PAIS
	$sql = "SELECT COUNT(IdPais) as 'exists' FROM `paises` WHERE IdPais='".$pais."'";
	if(!($resultado = $inkbd->query($sql))) { 
		$_SESSION["datosYerrores"][6][1] = "Error al acceder a paises. Inténtelo de nuevo.".$pais; 
		exit;
	}
	$exists = $resultado->fetch_assoc();
	if($exists['exists'] != 1){
		$_SESSION["datosYerrores"][6][1] = "Elige un pais de la lista.".$pais;
	}
	$resultado -> close();

	//IMAGEN
	if(isset($_POST['submit'])){
		echo "Dentro imagen<br>";
	    $name       = $_FILES['pic']['name'];  
	    $temp_name  = $_FILES['pic']['tmp_name'];  
	    if(isset($name) && !empty($name))
        	if ($_FILES["pic"]["size"] < 5000000) {
        		$location = 'img/';      
	            if(move_uploaded_file($temp_name, $location.$name)){
	            	$pic = 	"'img/".$name."'"; 
	            }
	    	}
	}
	//$_SESSION["datosYerrores"][8] = $pic;
	if($booleano_molon){
		header("Location: http://$host$uri/Registro.php");
		exit;
	}

	$sql_newUser = "INSERT INTO `usuarios`(`NomUsuario`, `Clave`, `Email`, `Sexo`, `FNacimiento`, `Ciudad`, `Pais`, `Foto`) VALUES ('".$name2."','".$code."', '".$email."', '".$gender."', '".$date."', '".$city."', '".$pais."', ".$pic.")";

	if(!($resultado = $inkbd->query($sql_newUser))) { 
	   	echo "<p>Error al ejecutar la sentencia <b>$sql_newUser</b>: " . $inkbd->error; 
	   	//header("Location: http://$host$uri/Registro.php");
		$_SESSION["error2"] = "Permiso denegado";
		exit;
	 }
	 else{
	 	$sql = "SELECT COUNT(IdUsuario) as 'exists', IdUsuario, NomPais FROM `usuarios`,`paises` WHERE NomUsuario='". $name2 ."' AND Clave ='". $code ."' AND Pais = IdPais";
		if(!($resultado = $inkbd->query($sql))) { 
			echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . $inkbd->error; 
			echo "</p>"; 
			exit;
		}
		$c = $resultado->fetch_assoc();
		$_SESSION["IdUsuario"]=$c['IdUsuario'];
	 	$_SESSION["usuario"]=$name2;
	 }
	

	require_once("inc/header_logged.php"); 
	$Sexo = array(
		0 => 'Hombre',
		1 => 'Mujer',
		2 => 'Otro'
	);
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
				<p><b>Sexo:</b> <?php echo $Sexo[$gender] ?> </p>
				<p><b>Email: </b> <?php echo $email ?> </p>
				<p><b>Fecha de nacimiento: </b> <?php echo $date ?> </p>
				<p><b>Ciudad: </b> <?php echo $city ?> </p>
				<p><b>País: </b> <?php echo $c['NomPais'] ?> </p>
			</div>
		</section>
	</section>
<?php
	require_once("inc/footer.php"); 
?>
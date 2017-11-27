<?php

	//Fichero de configuracion
	$init = parse_ini_file("inc/config.ini");
	$error = -1;
	$inkbd = @new mysqli( 
	         $init["Server"],   	// El servidor 
	         $init["User"],    		// El usuario 
	         $init["Password"],     // La contraseña 
	         $init["Database"]); 	// La base de datos 
	 
	if($inkbd->connect_errno) 
	   $error = 1;
	
?>
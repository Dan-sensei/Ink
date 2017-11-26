<?php
$error_image = array(
	0 => array('img/404 not found.png', '#2e2e2e'),
	1 => array('img/502 server error.png','#191919')
 );

echo "<section style='background-color:".$error_image[$error][1]."' id='error'>
		<div id='NotFound'>
				<img  src='".$error_image[$error][0]."' alt='Elemento no encontrado'>
		</div>
	</section>";

?>


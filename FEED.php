<?php
	include_once("inc/connect.php");

	header('Content-Type: text/xml; charset=utf-8', true);
	$dom = new DOMDocument("1.0");

	$rss = $dom -> createElement("rss");
	$channel = $dom -> createElement("channel");

	$rssNode = $dom -> appendChild($rss);
	$channelNode = $rssNode -> appendChild($channel);

	$rssNode -> setAttribute("version","2.0");

	$date_f = date("D, d M Y H:i:s T", time());
	$build_date = gmdate(DATE_RFC2822, strtotime($date_f));

	$atom = $dom -> createElement("atom:link");
	$atom->setAttribute("href","http://localhost"); //url of the feed
	$atom->setAttribute("rel","self");
	$atom->setAttribute("type","application/rss+xml");
	$channelNode->appendChild($atom); 

	$title 			= 	$dom->createElement("title", "Ink");
	$descripcion 	= 	$dom->createElement("description", "Tu lugar donde compartir tus momentos");
	$link 			= 	$dom->createElement("link", "http://localhost/index.php");
	$language 		= 	$dom->createElement("language", "es-es");
	$lastBuildDate 	= 	$dom->createElement("lastBuildDate", $build_date);
	$generator 		= 	$dom->createElement("generator", "PHP DOMDocument");

	$channelNode -> appendChild($title);
	$channelNode -> appendChild($descripcion);
	$channelNode -> appendChild($link);
	$channelNode -> appendChild($language);
	$channelNode -> appendChild($lastBuildDate); 
	$channelNode -> appendChild($generator);


	$GET = "SELECT IdFoto, Titulo, Fecha, Descripcion, Fichero, NomPais, FRegistro FROM `fotos` LEFT JOIN `paises` ON IdPais=Pais ORDER BY IdFoto DESC LIMIT 5";
	$results = $inkbd->query($GET);

	if($results){
	    while($datos = $results->fetch_object()) 
	    {
	    	$FRegistro 		= gmdate(DATE_RFC2822, strtotime($datos->FRegistro));

			$item 			= 	$dom->createElement("item");
			$i_title 		= 	$dom->createElement("title", $datos->Titulo);
			$i_link 		= 	$dom->createElement("link", "http://localhost/Detalle_foto.php?id=".$datos->IdFoto);
			$i_description 	= 	$dom->createElement("description",$datos->Descripcion);  
			$i_date 		= 	$dom->createElement("pubDate", $FRegistro);  
			$i_guid 		=	$dom->createElement("guid", "http://localhost/Detalle_foto.php?id=". $datos->IdFoto);  

      		$i_guid->setAttribute("isPermaLink","false");

			$item -> appendChild($i_title);
			$item -> appendChild($i_link);
			$item -> appendChild($i_description);
	    	$item -> appendChild($i_date);
	    	$item -> appendChild($i_guid);

	    	$channelNode -> appendChild($item);
	    }
	}
	echo $dom->saveXML();
?>


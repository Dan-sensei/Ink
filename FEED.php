<?php
	include_once("inc/connect.php");

	if(!isset($_GET['feed']) && $_GET['feed']!="RSS" && $_GET['feed']!="Atom"){
		$host = $_SERVER["HTTP_HOST"];
		$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: http://$host$uri"); 
		exit;
	}

	header('Content-Type: text/xml; charset=utf-8', true);
	$dom = new DOMDocument("1.0", "utf-8");

	if( $_GET['feed']=="RSS"){
		$rss = $dom -> createElement("rss");
		$channel = $dom -> createElement("channel");

		$rssNode = $dom -> appendChild($rss);
		$channelNode = $rssNode -> appendChild($channel);

		$rssNode -> setAttribute("version","2.0");
		$rssNode -> setAttribute("xmlns:dc", "http://purl.org/dc/elements/1.1/");
		$rssNode -> setAttribute("xmlns:content", "http://purl.org/rss/1.0/modules/content/");
		$rssNode -> setAttribute("xmlns:atom", "http://www.w3.org/2005/Atom");
		$date_f = date("D, d M Y H:i:s T", time());
		$build_date = gmdate(DATE_RFC2822, strtotime($date_f));

		$atom = $dom -> createElement("atom:link");
		$atom->setAttribute("href","http://localhost/FEED.php");
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
	}

	else{
		$feed = $dom -> createElement("feed");
		$feedNode = $dom -> appendChild($feed);

		$feedNode -> setAttribute("xmlns", "http://www.w3.org/2005/Atom");

		$date_f = date("D, d M Y H:i:s T", time());
		$build_date = gmdate(DATE_ATOM, strtotime($date_f));

		$title 			= 	$dom->createElement("title", "Ink");
		$link 			= 	$dom->createElement("link");
		$link -> setAttribute("href", "http://localhost/index.php");
		$author  		=	$dom->createElement("author");
		$name 			= 	$dom->createElement("name", "Danny Gabriel Rivera Solorzano");
		$author ->appendChild($name);
		$lastBuildDate 	= 	$dom->createElement("updated", $build_date);
		$id 			= 	$dom->createElement("id", "http://localhost/");

		$feedNode -> appendChild($title);
		$feedNode -> appendChild($link);
		$feedNode -> appendChild($author);
		$feedNode -> appendChild($lastBuildDate); 
		$feedNode ->  appendChild($id);


		$GET = "SELECT IdFoto, Titulo, Fecha, Descripcion, Fichero, NomPais, FRegistro FROM `fotos` LEFT JOIN `paises` ON IdPais=Pais ORDER BY IdFoto DESC LIMIT 5";
		$results = $inkbd->query($GET);

		if($results){
		    while($datos = $results->fetch_object()) 
		    {
		    	$FRegistro 		= gmdate(DATE_ATOM, strtotime($datos->FRegistro));

				$entry 			= 	$dom->createElement("entry");
				$i_title 		= 	$dom->createElement("title", $datos->Titulo);
				$i_link 		= 	$dom->createElement("link");
				$i_link -> setAttribute("href", "http://localhost/Detalle_foto.php?id=".$datos->IdFoto);
				$i_date 		= 	$dom->createElement("updated", $FRegistro);  
				$i_description 	= 	$dom->createElement("summary",$datos->Descripcion);  
				$i_guid 		=	$dom->createElement("id", "http://localhost/Detalle_foto.php?id=". $datos->IdFoto);  

				$entry -> appendChild($i_title);
				$entry -> appendChild($i_link);
				$entry -> appendChild($i_description);
		    	$entry -> appendChild($i_date);
		    	$entry -> appendChild($i_guid);

		    	$feedNode -> appendChild($entry);
		    }
		}
	}
	echo $dom->saveXML();
?>


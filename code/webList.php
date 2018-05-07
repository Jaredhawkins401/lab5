<?php 

function addLinks($site_id, $URL) {//add links to sitelinks DB 
	global $db;
	$i = 0;//counter
	
	foreach($URL as $links) {//since working with multidimensional array, need double foreach to get to data
		foreach($links as $link) {
			$linkArray[$i] = $link[0];
			$i += 1;
		}
	}
	
	$linkArray = array_unique($linkArray);
	
	for($i = 0; $i < count($linkArray); $i++) { //add unique links to sitelinks DB based on foreign key
		$sql = "INSERT INTO sitelinks (site_id, link) VALUES ($site_id, :link)";
		$statement = $db->prepare($sql);
		$statement->bindParam(':link', $linkArray[$i]);
		$statement->execute();
	}
	
	return $linkArray;
}

function returnURL($site_id) { //return array of links for associated key
	global $db;
	$sql = "SELECT link FROM sitelinks WHERE site_id = :site_id";
	$statement = $db->prepare($sql);
	$statement->bindParam(':site_id', $site_id);
	$statement->execute();
	$webURL = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	return $webURL;
}
?>
		
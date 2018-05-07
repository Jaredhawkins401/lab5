<?php 

function findWeb($webSearch) { //check website for valid links
	$fileReturned = file_get_contents($webSearch);
	preg_match_all("(https?:\/\/[\da-z\.-]+\.[a-z\.]{2,6}[\/\w \.-]+)", $fileReturned, $webLink, PREG_OFFSET_CAPTURE);
	
	return $webLink;
}

function isUniqueSite($siteToSearch) {//checks that website isn't already in DB
	global $db;
	
	$sql = "SELECT * FROM sites WHERE site = :site";
	$statement = $db->prepare($sql);
	$statement->bindParam(':site', $siteToSearch);
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);//if site name is there, returns 1 if not returns 0
	return $result;
}

function addURL($siteToSearch) { //add unique URL
	global $db;
	$sql = "INSERT INTO sites (site, date) VALUES (:site, NOW())";
	$statement = $db->prepare($sql);
	$statement->bindParam(':site', $siteToSearch);
	$statement->execute();
	$lastID = $db->lastInsertId();
	
	return $lastID;
}

function returnSites() { //grab urls for site to populate drop down
	global $db;
	$sql = "SELECT * FROM sites";
	$statement = $db->prepare($sql);
	$statement->execute();
	$webList = $statement->fetchAll();
	
	return $webList;
}

function returnDate($site_id) { //gives date to be formatted on table page
	global $db;
	$sql = "SELECT date FROM sites WHERE site_id = :site_id";
	$statement = $db->prepare($sql);
	$statement->bindParam(':site_id', $site_id);
	$statement->execute();
	$webDate = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	return $webDate;
}

?>
	
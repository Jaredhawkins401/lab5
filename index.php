<?php

require_once('code/dbConn.php');
require_once('code/webSite.php');
require_once('code/webList.php');

$action = '';
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ??
	filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? NULL;
	
$siteToSearch = filter_input(INPUT_GET, 'siteToSearch', FILTER_SANITIZE_STRING) ?? NULL;
$site_id = filter_input(INPUT_GET, 'siteForm', FILTER_SANITIZE_STRING) ?? NULL;

switch($action) {
	
	case "Read":
		
		$webList = returnSites();
		$webURL = returnURL($site_id);
		include_once('code/head.php');
		include_once('code/webTable.php');
		include_once('code/foot.php');
		break;
	
	case "Add":
		
		include_once("code/head.php");
		$errorMessage = '';
		preg_match("(https?:\/\/[\da-z\.-]+\.[a-z\.]{2,6}[\/\w \.-]+)", $siteToSearch, $results, PREG_OFFSET_CAPTURE);//make sure valid URL
		
		if(count($results) != 1){ //if it isn't valid
			$errorMessage = "URL entered is invalid, please enter again.";
			echo($errorMessage);
		}
		
		else {//if it is valid
			$webLinks = findWeb($siteToSearch);//search URL for links
			
			if(empty($webLinks)) { //no links found
					$errorMessage = "There are no URLs for the page searched, please enter again.";
					echo($errorMessage);
			}
			
		
			
			elseif(count(isUniqueSite($siteToSearch)) > 0 ){ //elseif link is already found in DB
				$errorMessage = "Site entered must be unique, please enter again.";
				echo($errorMessage);
			}
			
			else {//else link is valid, link is unique, add to DB
				$lastID = addURL($siteToSearch);
				$linkArray = addLinks($lastID, $webLinks);
				$output = "Success!  Added Website: " . $siteToSearch . "<br> Links: ";
				
				foreach($linkArray as $links) {
					$output .= $links . "<br>";
				}
				echo($output);
			}
		}
		
		include_once("code/webAdd.php");
		include_once("code/foot.php");
		break;

		
	case "Search":
		include_once("code/head.php");
		$webList = returnSites();
		$webURL = returnURL($site_id);
		$webDate = returnDate($site_id);
		include_once("code/webTable.php");
		include_once("code/foot.php");
		break;
		
	default:
		include_once("code/head.php");
		include_once("code/webAdd.php");
		break;

}
include_once('code/foot.php');
?>
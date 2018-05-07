
<form action='index.php' method='get'>
	
	
	<select name='siteForm'>
		<?php 
		foreach($webList as $site) { ?>
			<option value="<?php echo($site['site_id']); ?>"><?php  echo($site['site']) //populate dropbox from db?> </option> 
			<?php
		} ?>
	</select>
		
		
		 

	<input type='Submit' name='action'  value="Search"></input>
	</form>

	<div>
	<?php 
	
	$table = "<table>";

	foreach($webURL as $sites) {
		foreach($sites as $site){
			$table .= "<tr>";
			$table .= "<td> <a href='" . $site . "'>" . $site . "</a> </td> </tr>";
		}
	}
	
	if(!empty($webDate)){
		$webDate = strtotime($webDate[0]["date"]);//convert date from str
	
	
	echo(count($webList) . " links found  " .  " retrieved on:"); 
	echo(date('m/d/y h:m:s', $webDate)); //format date
	echo($table);
	}
	?>
	</div>
	

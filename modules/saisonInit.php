<?php




function getSpielTag() {
	$result = mysql_query("SELECT spieltag FROM `io_Spielplan` where guestScore is not null order by timestamp desc limit 1");
	$row = mysql_fetch_row($result);
	
	return $row[0];
}


	$SpielTag = $_GET["spieltag"];
	
	if(!$SpielTag)
		$SpielTag = getSpielTag() ;
		
	
?>

<?php
//echo "<html><head></head><body>";

$hfile = fopen("spielplan.csv", "r+");

$spielTag = 0;
$spieldatum_plan = "";
$spielnummer = "";
$heim_team = "";
$gast_team = "";
$anfiff_plan = "";
$schiri = "";
$zusatzinfo = "";
$verlegtdatum = "";
$printOne = false;


// SQL: INSERT INTO  `io_Spielplan` (  `nummer` ,  `heim` ,  `gast` ,  `InfoPlatz` ,  `InfoSchiri` ,  `timestamp` ,  `spieltag` ,  `InterGame` ,  `homeId` ,  `guestId` ,  `homeScore` ,  `guestScore` ,  `freeGame` ,  `alternativeDate` ) 
// VALUES ( '1',  'Inter',  'Junge',  'Platz',  'Schiri',  '0',  '1',  '1',  '1',  '1', NULL , NULL ,  '0',  '1000' );


while ( ($line = fgets($hfile)) !== false) {
	
	$parts = array();
	
	$parts = explode(";", $line);
	// Fall 1: Spiel Datum
	if($parts[0] == "" && $parts[1] != "") {
		if($printOne == true) {
			echo "VALUES ('$spielnummer', '$heim_team', '$gast_team', '$zusatzinfo', '$schiri', '" . dateToTimestamp($spieldatum_plan, $anfiff_plan). "', '" . getSpieltag($spielnummer) . "', '0', '0', '0', NULL, NULL, '" . isFree($gast_team) . "', '" . datetimeToTimestamp($verlegtdatum)."');\n";			
		}
		$spieldatum_plan = $parts[1];
		$spielnummer = "";
		$heim_team = "";
		$gast_team = "";
		$anfiff_plan = "";
		$schiri = "";
		$zusatzinfo = "";
		$verlegtdatum = "";
		$printOne = false;
	}
	// Fall 2: Mannschaften
	elseif($parts[0] != "" && $parts[1] != "") {
		if($printOne == true) {
			echo "VALUES ('$spielnummer', '$heim_team', '$gast_team', '$zusatzinfo', '$schiri', '" . dateToTimestamp($spieldatum_plan, $anfiff_plan). "', '" . getSpieltag($spielnummer) . "', '0', '0', '0', NULL, NULL, '" . isFree($gast_team) . "', '" . datetimeToTimestamp($verlegtdatum)."');\n";
		}
		$spielnummer = $parts[0];
		$heim_team = $parts[1];
		$gast_team = $parts[2];
		$anfiff_plan = $parts[3];
		$verlegtdatum = $parts[4];
		$zusatzinfo = "";
		$schiri = "";
	}
	// Fall 3: Schiri oder Zusatz Info
	elseif($parts[0] != "" && $parts[1] == "") {
		if(strpos($parts[0], "//") === false) {
			// schiri
			$schiri = $parts[0];
			$printOne = true;
		}
		else {
			// zusatzinfos
			$zusatzinfo = $parts[0];
			$printOne = true;
		}
	}	
}

echo "VALUES ('$spielnummer', '$heim_team', '$gast_team', '$zusatzinfo', '$schiri', '" . dateToTimestamp($spieldatum_plan, $anfiff_plan). "', '" . getSpieltag($spielnummer) . "', '0', '0', '0', NULL, NULL, '" . isFree($gast_team) . "', '" . datetimeToTimestamp($verlegtdatum)."');\n";
fclose($hfile);

function isFree($gast) {
	if($gast === "SPIELFREI")
		return 1;
	else 
		return 0;
}

function dateToTimestamp($date, $time) {
	if($time === "") $time = "00:00";
	$datePart = explode(" ",$date);
	if(sizeof($datePart) == 2)
		$date = $datePart[1];
	else
		$date = $datePart[0];
	$datePart = explode(".",$date);
	$timePart = explode(":",$time);	
	return mktime($timePart[0], $timePart[1], 0, $datePart[1], $datePart[0], $datePart[2]);
}

function datetimeToTimestamp($datetime) {
	if($datetime == "") return 0;
	$parts = explode(" ", $datetime);
	return dateToTimestamp($parts[0], $parts[1]);
}

function getSpieltag($spielnr) {
	return ceil($spielnr / 7);
}

//echo "</body>";

?>
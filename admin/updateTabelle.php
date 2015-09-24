<?php 

$startTime = microtime(true);

include("modules/database.php");

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Tabelle Berechnen</title>

</head>
<body>
<?php

// datenbank leeren
echo "Datenbank leeren";
flush();
mysql_query("TRUNCATE TABLE `io_Tabelle`");
echo "... OK <br>";
flush();

// alle teams durchgehen
// mysql_query("INSERT INTO  `io_Tabelle` (  `teamId` ,  `spielTagId` ,  `plays` ,  `won` ,  `lost` ,  `draw` ,  `goals` ,  `cgouls` ,  `goaldiffs` ,  `points` ,  `teamName` ) VALUES ('',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '')");

echo "Punkte berechnen";
flush();
for($teamId = 1; $teamId < 14; $teamId++) {
	$plays = 0;
	$won = 0;
	$lost = 0;
	$draw = 0;
	$goals = 0; // tore
	$cgols = 0; // gegentore
	$goaldiffs = 0;
	$points = 0;
	$lastSpieltag = 0;
	
	// alle Spieltage durchgehen
	$SQL_Query = "SELECT spieltag, homeId, guestId, homeScore, guestScore FROM  `io_Spielplan` WHERE homeScore IS NOT NULL AND guestScore IS NOT NULL AND (guestId =$teamId OR homeId =$teamId) ORDER BY timestamp asc";
	$SQL_Result= mysql_query($SQL_Query);
	while($spieldaten = mysql_fetch_row($SQL_Result)) {			
		$spielTag = $spieldaten[0];
		$id1 = $spieldaten[1];
		$id2 = $spieldaten[2];
		
		// falls Spieltage frei waren
		while($spielTag > ($lastSpieltag+1)) {
			$lastSpieltag++;
			mysql_query("INSERT INTO  `io_Tabelle`  (  `teamId` ,  `spielTagId` ,  `plays` ,  `won` ,  `lost` ,  `draw` ,  `goals` ,  `cgouls` ,  `goaldiffs` ,  `points` ,  `teamName` ,  `position` ,  `positionLast` )  VALUES ('$teamId',  '$lastSpieltag',  '$plays',  '$won',  '$lost' ,'$draw',  '$goals',  '$cgols',  '$goaldiffs',  '$points',  '', '', '')");
		}
		
		$plays++;	

		
		// wenn Heim spiel
		if($id1 == $teamId) {
			$goal1= $spieldaten[3];
			$goal2= $spieldaten[4];
		}
		// wenn Auswärtsspiel
		else {
			$goal1= $spieldaten[4];
			$goal2= $spieldaten[3];
		}
		
		if($goal1 > $goal2) { // won
			$won++;
			$points += 3;
		}
		else if($goal1 == $goal2) { // draw
			$draw++;
			$points += 1;
		}
		else {
			$lost++;	
		} 
		
		$goals += $goal1;
		$cgols += $goal2;
		$goaldiffs = $goals - $cgols;
		
		mysql_query("INSERT INTO  `io_Tabelle`  (  `teamId` ,  `spielTagId` ,  `plays` ,  `won` ,  `lost` ,  `draw` ,  `goals` ,  `cgouls` ,  `goaldiffs` ,  `points` ,  `teamName` ,  `position` ,  `positionLast` )  VALUES ('$teamId',  '$spielTag',  '$plays',  '$won',  '$lost' ,'$draw',  '$goals',  '$cgols',  '$goaldiffs',  '$points',  '', '', '')");
		
		
		$lastSpieltag = $spielTag;
	}
	
	while($spielTag < 27) {
		$spielTag++;
		mysql_query("INSERT INTO  `io_Tabelle`  (  `teamId` ,  `spielTagId` ,  `plays` ,  `won` ,  `lost` ,  `draw` ,  `goals` ,  `cgouls` ,  `goaldiffs` ,  `points` ,  `teamName` ,  `position` ,  `positionLast` )  VALUES ('$teamId',  '$spielTag',  '$plays',  '$won',  '$lost' ,'$draw',  '$goals',  '$cgols',  '$goaldiffs',  '$points',  '', '', '')");
	}
	
	mysql_query("INSERT INTO  `io_Tabelle`  (  `teamId` ,  `spielTagId` ,  `plays` ,  `won` ,  `lost` ,  `draw` ,  `goals` ,  `cgouls` ,  `goaldiffs` ,  `points` ,  `teamName` ,  `position` ,  `positionLast` )  VALUES ('$teamId',  '0',  '$plays',  '$won',  '$lost' ,'$draw',  '$goals',  '$cgols',  '$goaldiffs',  '$points',  '', '', '')");
}

echo "... OK <br> ";
flush();

echo "Namen updaten";
flush();
// Update alle Team name
mysql_query("UPDATE  `io_Tabelle` a SET teamName = ( SELECT LONGNAME FROM  `io_Mannschaft` b WHERE a.teamId = b.id )");
echo "... OK <br> ";
flush();

echo "Sortieren";
flush();
// alle Positionen Eintragen
for($spieltag = 0; $spieltag < 27; $spieltag++) {
	$position = 0;
	$SQL_Result = mysql_query("SELECT  teamId FROM  `io_Tabelle` WHERE spieltagid ='$spieltag' ORDER BY points DESC , goaldiffs DESC, teamName ASC");
	
	while($datensatz = mysql_fetch_row($SQL_Result)){
		$teamId = $datensatz[0];
		$position++;
		mysql_query("UPDATE `io_Tabelle` SET  `position` =  '$position' WHERE  `teamId` = '$teamId' AND `spielTagId` ='$spieltag'");
	}
	echo "... $spieltag";
	flush();
}

echo "... OK <br> ";
flush();

$endTime = microtime(true);
$execTime = $endTime - $startTime;
echo "Fertig nach $execTime Sekunden<br><br><br> ";
flush();

echo "MYSQL Meldungen: ". mysql_error();

?>
</body>
</html>

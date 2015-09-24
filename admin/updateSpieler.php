<?php

$startTime = microtime(true);

include("../modules/database.php");

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Spielerstatus Aktualisieren</title>

</head>
<body>
<?php
// spieleinsätze löschen
mysql_query("TRUNCATE TABLE `io_Spielereinsatz`");

$SELECTQ = "SELECT * FROM io_Spieler";
$SQL_ResultA = mysql_query($SELECTQ);
while($rowA = mysql_fetch_row($SQL_ResultA)) {
	$SpielerID = $rowA[0];
	echo "<br>Update SpielerID $SpielerID <br>";
	$plays = 0;
	$goals = 0;
	$plymin = 0;
	$yellowcards = 0;
	$redcards = 0;

	// spiele und spielzeit ermitteln
	// eventId 1-2 sind einwechslungen
	// eventId 3 sind auswechslungen
	$SQL_Query = "SELECT `spielId`,`spielMin` FROM `io_Spielevents` WHERE (`eventType` BETWEEN 1 AND 2) AND `spielerId` = '$SpielerID'";
	$SQL_ResultB = mysql_query($SQL_Query);
	while($rowB = mysql_fetch_row($SQL_ResultB)) {
		$plays++;
		$spielId = $rowB[0];
		$startMin = $rowB[1];
		// so, jetzt ermitteln ob der kerl mal ausgewechselt wurde, oder rot gesehen hat
		$SQL_Query = "SELECT `spielMin` FROM `io_Spielevents` WHERE (`eventType` = 3 OR `eventType` = 5 OR `eventType` = 6 )AND spielerId = '$SpielerID' AND `spielId` = '$spielId'";
		$SQL_Result = mysql_query($SQL_Query);
		$rowC = mysql_fetch_row($SQL_Result);
		if($rowC[0] == "")
		$endMin = 90;
		else
		$endMin = $rowC[0];
		$plyminL = ($endMin - $startMin);
		$plymin += $plyminL;

		// hier ermitteln wieviel karten und tore der kollege in diesem spiel bekommen hat
		// gelbe Karten eventType = 4
		$SQL_Query = "SELECT count(*) FROM `io_Spielevents` WHERE eventType = '4' AND `spielerId` = '$SpielerID' AND `spielId` = '$spielId'";
		$SQL_Result = mysql_query($SQL_Query);
		$rowD = mysql_fetch_row($SQL_Result);
		$yellowcardsL = $rowD[0];
		// rote Karten eventType = 5/6
		$SQL_Query = "SELECT count(*) FROM `io_Spielevents` WHERE (eventType BETWEEN 5 AND 6) AND `spielerId` = '$SpielerID' AND `spielId` = '$spielId'";
		$SQL_Result = mysql_query($SQL_Query);
		$rowE = mysql_fetch_row($SQL_Result);
		$redcardsL = $rowE[0];
		// tore eventType = 7
		$SQL_Query = "SELECT count(*) FROM `io_Spielevents` WHERE eventType = '7' AND `spielerId` = '$SpielerID' AND `spielId` = '$spielId'";
		$SQL_Result = mysql_query($SQL_Query);
		$rowF = mysql_fetch_row($SQL_Result);
		$goalsL = $rowF[0];
		// und dann ein eintrag in der tabelle spieleinsätze machen

		$SQL_Query = "INSERT INTO  `io_Spielereinsatz` (`spielId` ,`spielerId` ,`einsatzDauer` ,`einsatzStart` ,`einsatzEnde` ,`yellows` ,`reds` ,`goals`)
						VALUES ('$spielId',  '$SpielerID',  '$plyminL ',  '$startMin',  '$endMin',  '$yellowcardsL',  '$redcardsL',  '$goalsL');";
		
		mysql_query($SQL_Query);
		
	}

	// gelbe Karten eventType = 4
	$SQL_Query = "SELECT count(*) FROM `io_Spielevents` WHERE eventType = '4' AND `spielerId` = '$SpielerID'";
	$SQL_Result = mysql_query($SQL_Query);
	$rowD = mysql_fetch_row($SQL_Result);
	$yellowcards = $rowD[0];
	// rote Karten eventType = 5/6
	$SQL_Query = "SELECT count(*) FROM `io_Spielevents` WHERE (eventType BETWEEN 5 AND 6) AND `spielerId` = '$SpielerID'";
	$SQL_Result = mysql_query($SQL_Query);
	$rowE = mysql_fetch_row($SQL_Result);
	$redcards = $rowE[0];
	// tore eventType = 7
	$SQL_Query = "SELECT count(*) FROM `io_Spielevents` WHERE eventType = '7' AND `spielerId` = '$SpielerID'";
	$SQL_Result = mysql_query($SQL_Query);
	$rowF = mysql_fetch_row($SQL_Result);
	$goals = $rowF[0];


	$UPDATEQ = "UPDATE io_Spieler SET `PLAYS` = '$plays', `GOALS` = '$goals', `PLAYTIME` = '$plymin', `Yellows` = '$yellowcards', `Reds` = '$redcards' WHERE `ID` = '$SpielerID'";
	mysql_query($UPDATEQ);
	echo "`PLAYS` = '$plays', `GOALS` = '$goals', `PLAYTIME` = '$plymin', `Yellows` = '$yellowcards', `Reds` = '$redcards'<br>";

	flush();

}





$endTime = microtime(true);
$execTime = $endTime - $startTime;
echo "Fertig nach $execTime Sekunden<br><br><br> ";
flush();

echo "MYSQL Meldungen: ". mysql_error();

?>
</body>
</html>

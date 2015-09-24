<?php

include("./../modules/database.php");

if(isset($_POST["fertig"]))
{
	// hier speichern
	$spielnummer = $_POST["nummer"];
	$homeScore = $_POST["ScoreH"];
	$guestScore = $_POST["ScoreG"];
	$playDate = $_POST["datum"];
	$playTime = $_POST["uhrzeit"];
	$schiriTxt = utf8_decode($_POST["referee"]);
	$platzInfo = utf8_decode($_POST["adress"]);
	$dateArray = explode(".", $playDate);
	$timeArray = explode(":", $playTime);
	$timestempel = mktime($timeArray[0],$timeArray[1],0,$dateArray[1],$dateArray[0],$dateArray[2]);

	if($homeScore == "") $homeScore = "NULL";
	if($guestScore == "") $guestScore = "NULL";

	$SQL_Query = "UPDATE `io_Spielplan` SET InfoPlatz = '$platzInfo', InfoSchiri = '$schiriTxt', timestamp = $timestempel, homeScore = $homeScore, guestScore = $guestScore WHERE nummer = $spielnummer;";
	mysql_query($SQL_Query);
	// alte events l�schen
	mysql_query("DELETE FROM `io_Spielevents` WHERE spielId = $spielnummer");

	// events parsen
	$startTeam = $_POST["startelf"];
	$gameEvents = $_POST["events"];
	$spielBericht = utf8_decode($_POST["bericht"]);

	// events speichern
	// start elf - EventId = 1
	/*
	 * 	eventType[Startaufstellung = 1, Auswechslung = 2, Einwechslung = 3, Gelbekarte = 4, Rotekarte = 5, GelbRotekarte = 6, Tor = 7, Eigentor = 8, Spielbericht = 10]
		eventText[Nur f�r Spielberichte]

		Ein Spielbericht hat als Spielminute 0, und spielerId 0.
	 */

	$startTeamArray = explode(";", $startTeam);
	$gameEventsLines = explode("\n", $gameEvents);

	for($i=0; $i < count($startTeamArray); $i++){
		if($startTeamArray[$i] == "")
		continue;
		$spielMin = 0;
		$spielerNr = $startTeamArray[$i];
		$eventTypeId = 1;
		$SQL_Query = "INSERT INTO `DB668090`.`io_Spielevents` (`spielId`, `spielMin`, `spielerId`, `eventType`, `eventText`) VALUES ('$spielnummer', '$spielMin', '$spielerNr', '$eventTypeId', '');";
		mysql_query($SQL_Query);
	}

	for($i=0; $i < count($gameEventsLines); $i++){
		$gameEventsArray = explode(";", $gameEventsLines[$i]);
		if(count($gameEventsArray) != 3) {
			$errorTxt .= "Syntax fehler im SpielEvents Eingabefeld wurde ignoriert - Zeile: ". ($i+1) ."\n";
			continue;
		}
		$eventTypeId = $gameEventsArray[0];
		$spielMin = $gameEventsArray[1];
		$spielerNr = $gameEventsArray[2];
		$SQL_Query = "INSERT INTO `DB668090`.`io_Spielevents` (`spielId`, `spielMin`, `spielerId`, `eventType`, `eventText`) VALUES ('$spielnummer', '$spielMin', '$spielerNr', '$eventTypeId', '');";
		mysql_query($SQL_Query);
	}


	// spielbericht
	if($spielBericht != "") {
		$spielMin = 0;
		$spielerNr = 0;
		$eventTypeId = 10;
		$eventTxt = $spielBericht;
		$SQL_Query = "INSERT INTO `DB668090`.`io_Spielevents` (`spielId`, `spielMin`, `spielerId`, `eventType`, `eventText`) VALUES ('$spielnummer', '$spielMin', '$spielerNr', '$eventTypeId', '$eventTxt');";
		mysql_query($SQL_Query);
	}



	//header ("Location: splp.php");
}

if(!isset($_GET["spielnr"])) header ("Location: splp.php");

$spielnr = $_GET["spielnr"];
$SQL_Query = "SELECT nummer, heim, gast, infoPlatz, infoschiri, timestamp, spieltag, homeScore, guestScore, InterGame FROM `io_Spielplan` WHERE nummer = $spielnr";
$SQL_Result = mysql_query($SQL_Query);
$row = mysql_fetch_row($SQL_Result);
$homeTeam = utf8_encode($row[1]);
$guestTeam =  utf8_encode($row[2]);
$platzAdresse  =  utf8_encode($row[3]);
$unpartaischer =  utf8_encode($row[4]);
$zeitstempel = $row[5];
$spieltag = $row[6];
$homeScore = $row[7];
$guestScore = $row[8];
$isInterGame = $row[9];
$disabled = "disabled=\"disabled\"";

if($isInterGame == 1) {
	$disabled = "";
	// read startaufstellung
	$SQL_Query = "SELECT `spielerId` FROM `io_Spielevents` WHERE `eventType` = 1 AND `spielId` = '$spielnr' order by `spielerId` ASC ";
	$SQL_Result = mysql_query($SQL_Query);
	while($row = mysql_fetch_row($SQL_Result)) {
		$gameStartupFormatted .= $row[0].";";
	}

	// read events
	$SQL_Query = "SELECT `eventType`,`spielMin`,`spielerId`  FROM `io_Spielevents` WHERE (`eventType` BETWEEN 2 AND 9) AND `spielId` = '$spielnr' order by `spielMin` ASC ";
	$SQL_Result = mysql_query($SQL_Query);
	while($row = mysql_fetch_row($SQL_Result)) {
		$gameEventsFormatted .= $row[0].";".$row[1].";".$row[2]."\n";
	}

	// read spielBericht
	$SQL_Query = "SELECT `eventText` FROM `io_Spielevents` WHERE `eventType` = '10' AND `spielId` = $spielnr";
	$SQL_Result = mysql_query($SQL_Query);
	$row = mysql_fetch_row($SQL_Result);
	$gameReportFormatted = utf8_encode($row[0]);

}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Spielbericht</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #000;
}

body {
	background-color: #F0F0F0;
}

a:link {
	color: #F60;
}
-->
</style>
<script src="SpryAssets/SpryValidationTextField.js"
	type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet"
	type="text/css" />
</head>



<body>
<form action="" method="post">
<table width="900" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<th scope="col">Spieldetails</th>
		<th scope="col">Bericht</th>
	</tr>
	<tr>
		<td>
		<table>
			<tr>
				<th>Spielnummer</th>
				<td><?php echo $spielnr; ?><input type="hidden" name="nummer"
					value="<?php echo $spielnr; ?>" /></td>
			</tr>
			<tr>
				<th>Spieltag</th>
				<td><?php echo $spieltag; ?></td>
			</tr>
			<tr>
				<th>Datum</th>
				<td><span id="sprytextfield1"> <input type="text" name="datum"
					id="text1" value="<?php echo date("d.m.Y", $zeitstempel); ?>" /> <span
					class="textfieldRequiredMsg">Es muss ein Wert angegeben werden.</span><span
					class="textfieldInvalidFormatMsg">Ungültiges Format.</span></span></td>
			</tr>
			<tr>
				<th>Anstoß</th>
				<td><span id="sprytextfield2"> <input type="text" name="uhrzeit"
					id="uhrzeit" value="<?php echo date("H:i", $zeitstempel); ?>" /> <span
					class="textfieldRequiredMsg">Es muss ein Wert angegeben werden.</span><span
					class="textfieldInvalidFormatMsg">Ungültiges Format.</span></span></td>
			</tr>
			<tr>
				<th>Schiri</th>
				<td><input name="referee" type="text" size="20" maxlength="36"
					value="<?php echo $unpartaischer; ?>" /></td>
			</tr>
			<tr>
				<th>Spielplatz</th>
				<td><textarea name="adress" cols="45" rows="5"><?php echo $platzAdresse; ?></textarea></td>
			</tr>
			<tr>
				<th>Ergebnis</th>
				<td><?php echo $homeTeam; ?> <input name="ScoreH" type="text"
					value="<?php echo $homeScore; ?>"  size="2" maxlength="2" /> : <input
					name="ScoreG" type="text" value="<?php echo $guestScore; ?>"
					size="2" maxlength="2" /><?php echo $guestTeam; ?></td>
			</tr>

		</table>
		</td>
		<td>
		<table>
			<tr>
				<th>Startaufstellung</th>
				<td>Format: SpielerNr;SpielerNr;.... <textarea name="startelf"
					cols="45" rows="3" <?php echo $disabled; ?>><?php echo $gameStartupFormatted; ?></textarea>
				</td>
			</tr>
			<tr>
				<th>Spielereignisse</th>
				<td>Format: EventNr;SpielMin;SpielerNr (ein Event pro Zeile). <textarea
					name="events" cols="45" rows="5" <?php echo $disabled; ?>><?php echo $gameEventsFormatted; ?></textarea>
				</td>
			</tr>
			<tr>
				<th>Spielbericht</th>
				<td>Hier ist HTML Erlaubt !!!. <textarea name="bericht" cols="45"
					rows="10" <?php echo $disabled; ?>><?php echo $gameReportFormatted; ?></textarea></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="right"><input type="submit" name="fertig" value="Speichern" /></td>
		<td align="left"><input type="reset" value="Zurücksetzen" /></td>
	</tr>
</table>
</form>

<br />
<br />

<table align="center">
	<tr>
		<th>Spieler</th>
		<th>Events</th>
	</tr>

	<tr>
		<td>
		<table>
			<tr>
				<th>#</th>
				<th>Name</th>
			</tr>
			<?php
			$result = mysql_query("SELECT ID, PRENAME, SURNAME FROM  `io_Spieler` ORDER BY ID ASC ");
			while($row = mysql_fetch_row($result))
			echo "<tr> <td> ". $row[0]." </td>   <td> ". utf8_encode($row[1]) ." " . utf8_encode($row[2]) ." </td> </tr>";

			?>
		</table>
		</td>
		<td>
		<table>
			<tr>
				<th>#</th>
				<th>Eventtyp</th>
			</tr>
			<tr>
				<td>2</td>
				<td>Einwechslung</td>
			</tr>
			<tr>
				<td>3</td>
				<td>Auswechslung</td>
			</tr>
			<tr>
				<td>4</td>
				<td>Gelbe Karte</td>
			</tr>
			<tr>
				<td>5</td>
				<td>Rote Karte</td>
			</tr>
			<tr>
				<td>6</td>
				<td>Gelb-Rote Karte</td>
			</tr>
			<tr>
				<td>7</td>
				<td>Tor</td>
			</tr>
			<tr>
				<td>8</td>
				<td>Eigentor</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd.mm.yyyy"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "time");
//-->
</script>
</body>
</html>

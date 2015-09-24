<?PHP



$PlayerID = $_GET["pid"];

if(!$PlayerID)
$PlayerID = 1;



// Generate Player Menu
// <a href="#">name</a>

$SQL_Query = "SELECT `ID` , `PRENAME` , `SURNAME` FROM  `io_Spieler` WHERE POSITION < 10 AND INACTIVE = 0  ORDER BY `SURNAME` ASC, `PRENAME` ASC LIMIT 0 , 60";
$AllPlayerQuery = mysql_query($SQL_Query);

while($playerEntities = mysql_fetch_array($AllPlayerQuery)) {
	if($playerEntities[0] != $PlayerID)
	$AllPlayerMenu .= "<a href=\"?cat=spieler&pid=". $playerEntities[0] ."\">". utf8_encode($playerEntities[2]) . ", " . utf8_encode($playerEntities[1]) ."</a><br>";
	else
	$AllPlayerMenu .=  utf8_encode($playerEntities[2]) . ", " . utf8_encode($playerEntities[1]) ."<br>";
}

// Generate Trainer Menu

$SQL_Query = "SELECT `ID` , `PRENAME` , `SURNAME` FROM  `io_Spieler` WHERE POSITION >= 10 AND INACTIVE = 0  ORDER BY `SURNAME` DESC, `PRENAME` ASC  LIMIT 0 , 60";
$AllPlayerQuery = mysql_query($SQL_Query);

while($playerEntities = mysql_fetch_array($AllPlayerQuery)) {
	if($playerEntities[0] != $PlayerID)
	$AllTrainerMenu .= "<a href=\"?cat=spieler&pid=". $playerEntities[0] ."\">". utf8_encode($playerEntities[2]) . ", " . utf8_encode($playerEntities[1]) ."</a><br>";
	else
	$AllTrainerMenu .=  utf8_encode($playerEntities[2]) . ", " . utf8_encode($playerEntities[1]) ."<br>";
}


// Load Detail Player Info
$SQL_Query = "SELECT * FROM  `io_Spieler` WHERE ID = $PlayerID LIMIT 0 , 1";
$DetailPlayerQuery = mysql_query($SQL_Query);

while($playerDetails = mysql_fetch_array($DetailPlayerQuery)) {
	$PlayerPreName = utf8_encode( $playerDetails[1]);
	$PlayerSurName = utf8_encode($playerDetails[2]);
	$PlayerBDate = $playerDetails[3];
	$PlayerPic = $playerDetails[4];
	$PlayerEntryDate = $playerDetails[5];
	$PlayerPosition = $playerDetails[6];
	$PlayerNumber = $playerDetails[7];
	$PlayerSize = $playerDetails[8];
	$PlayerPlays = $playerDetails[9];
	$PlayerGoals = $playerDetails[10];
	$PlayerComment =utf8_encode($playerDetails[11]);
	$PlayerTime =utf8_encode($playerDetails[14]);
	$PlayerYellow =utf8_encode($playerDetails[15]);
	$PlayerRed =utf8_encode($playerDetails[16]);

	$PlayerName = $PlayerPreName . " " . strtoupper($PlayerSurName);
	$PlayerSize = $PlayerSize . " cm";

	if($PlayerPic == "") $PlayerPic = "images/SpielerInfo_PhotoPlace.png";
	else $PlayerPic = "upload/spieler/". $PlayerPic;

	if($PlayerNumber <10) $PlayerNumberTxt = "&nbsp;". $PlayerNumber;
	else $PlayerNumberTxt = $PlayerNumber;

	if($PlayerPosition == 2)
	$PlayerPositionTxt = "Torwart";
	if($PlayerPosition == 4)
	$PlayerPositionTxt = "Abwehr";
	if($PlayerPosition == 6)
	$PlayerPositionTxt = "Mittelfeld";
	if($PlayerPosition == 8)
	$PlayerPositionTxt = "Sturm";
	if($PlayerPosition == 10) {
		$PlayerPositionTxt = "Trainer";
		$PlayerNumberTxt = "<div style=\"font-size:7px\">Train</div>";
	}





}

$CategoryTitle .=" &raquo; " . $PlayerPreName . " " . $PlayerSurName ;





?>
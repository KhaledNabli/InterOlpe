<?php

include("../modules/database.php");

function getSpielTag() {
	$result = mysql_query("SELECT spieltag FROM `io_Spielplan` where guestScore is not null order by timestamp desc limit 1");
	$row = mysql_fetch_row($result);
	
	return $row[0];
}

	$SpielTag = $_GET["spieltag"];
	
	if(!$SpielTag)
		$SpielTag = getSpielTag() ;
		
		
		
	$SQL_Query = "SELECT timestamp, nummer, heim, gast, InterGame, homeScore, guestScore FROM `io_Spielplan` WHERE spieltag = $SpielTag ORDER BY `timestamp` ASC";
	$SQL_Result = mysql_query($SQL_Query);
	echo mysql_error();


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Spielplan</title>

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
a:visited {
	color: #F60;
}
-->
</style>
</head>


<body>
<div align="center">
<form name="form" id="form" action="splp.php">
  <select name="spieltag" id="spieltag">
  <?php 
  	for($i = 1; $i < 31; $i++) {
		if($SpielTag == $i)
			echo "<option value=\"$i\" SELECTED>Spieltag $i</option>\n";
		else 
			echo "<option value=\"$i\">Spieltag $i</option>\n";
	}
  ?>
  </select>
  <input type="submit" value="Gehe zu"/>
</form>
</div>

<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr style="background:#969696;">
    <th scope="col">#</th>
    <th scope="col">Datum</th>
    <th scope="col">Begegnung</th>
    <th scope="col">Ergebnis</th>
    <th scope="col">Bearbeiten</th>
  </tr>
<?php
	$colnum = 0;
	while($SpielPlanEntity = mysql_fetch_row($SQL_Result)) {
		$colnum = ++$colnum%2;
	$datum = date("d.M. H:i", $SpielPlanEntity[0]);
	$nummer = $SpielPlanEntity[1];
	$heim = utf8_encode($SpielPlanEntity[2]);
	$gast = utf8_encode($SpielPlanEntity[3]);
	$isInter = $SpielPlanEntity[4];
	$homeScore = $SpielPlanEntity[5];
	$guestScore = $SpielPlanEntity[6];
	if($colnum == 1)
		$bg = "bgcolor=\"#F0F0F0\"";
	else 
		$bg = "bgcolor=\"#E8E8E8\"";
	
	echo "<tr $bg><td style=\"font-size:10px;\">$nummer</td> <td style=\"font-size:10px;\">$datum</td> <td align=\"left\">$heim - $gast</td> <td align=\"center\">$homeScore : $guestScore</td> <td align=\"center\"><a href=\"./splb.php?spielnr=$nummer\"> hier </a> </td> </tr>";
	}
?>
</table>


</body>
</html>
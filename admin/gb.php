<?php

include("../modules/database.php");


if(isset($_GET["disable"]))
{
	$EntryId = $_GET["entry"];
	mysql_query("update `io_Gbook` set deleted = ((deleted-1)*-1) WHERE entryId = $EntryId");

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Das Gästebuch</title>
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
</style></head>

<body>
<table width="1100" align="center">
	<tr>
    <th>Datum</th> <th>Verfasser</th> <th>Email</th>  <th>IP</th> <th>Betreff</th>  <th>Nachricht</th> <th>Versteckt</th>
    </tr>
    <?php
	
	$SQL = "select EntryID, date, user, email, ip, subject, text, deleted  from io_Gbook order by date desc";
	$result = mysql_query($SQL);
	
	while($row = mysql_fetch_row($result)) {
		$id = $row[0];
		$date = date("d.m.y H:i", $row[1]);
		$user = utf8_encode($row[2]);
		$email = utf8_encode($row[3]);
		$ip = $row[4];
		$subj = utf8_encode($row[5]);
		$text = utf8_encode($row[6]);
		$text = substr($text, 0, 60) . "...";
		
		if($row[7] == 1) $urltxt = "ja";
		else $urltxt = "nein";
		$url = "<a href=\"./gb.php?disable=yes&entry=$id\"> $urltxt </a>";
	
	echo"<tr>\n";
    echo "<td>$date</td> <td>$user</td> <td>$email</td>  <td>$ip</td> <td>$subj</td>  <td>$text</td> <td>$url</td>\n";
	echo"<tr>\n";
	
	}
	
	?>
    
</table>
</body>
</html>
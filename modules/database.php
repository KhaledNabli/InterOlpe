<?php
/*
$host = "rdbms.strato.de";
$db = "DB668090";
$user = "U668090";
$password = "01452645";
*/

$host = "localhost";
$db = "DB668090";
$user = "root";
$password = "";



$connection = mysql_connect($host, $user, $password) or die ("connection failed");
mysql_select_db($db, $connection);
?>
<?php
include('../modules/database.php');

$doc = new DOMDocument('1.0');

$occ = $doc->createElement('game');
//$doc = 
$doc->appendChild($occ);


$queryLastGame = mysql_query("SELECT * FROM `io_Spielplan` WHERE `InterGame` = 1  AND `homeScore` IS NOT NULL ORDER BY `spieltag` DESC LIMIT 1");
$queryNextGame = mysql_query("SELECT * FROM `io_Spielplan` WHERE `InterGame` = 1  AND `homeScore` IS NULL ORDER BY `spieltag` ASC LIMIT 1");

while($row = mysql_fetch_assoc($queryLastGame)) {
	foreach ($row as $fieldname => $fieldvalue) {
		$child = $doc->createElement($fieldname);
		$child = $occ->appendChild($child);
		$value = $doc->createTextNode($fieldvalue);
		$value = $child->appendChild($value);
	}
}

while($row = mysql_fetch_assoc($queryNextGame)) {
	foreach ($row as $fieldname => $fieldvalue) {
		$child = $doc->createElement($fieldname);
		$child = $occ->appendChild($child);
		$value = $doc->createTextNode($fieldvalue);
		$value = $child->appendChild($value);
	}
}

echo $doc->saveXML();


?>
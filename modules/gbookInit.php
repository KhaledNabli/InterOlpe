<?php


function parseBBCode2HTML( $bb )
{
    $bb = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $bb);
    $bb = preg_replace('/\[i\](.*?)\[\/i\]/', '<i>$1</i>', $bb);
    $bb = preg_replace('/\[color=([[:alnum:]]{6}?).*\](.*?)\[\/color\]/', '<font color="$1">$2</font>', $bb);
    $bb = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="$1">$2</a>', $bb);
	$bb = preg_replace('/\[img:([^ ]+).*\](.*)\[\/img:([^ ]+).*\]/', '<img src="$2" width="100%"></img>', $bb);
	
    $bb = preg_replace('/\n/', "<br>\n", $bb);

    return $bb;

}

$AddEntry = $_POST["gbookSubmit"];

if($AddEntry == "Senden") {
	
	$EntryName = $_POST["gbook_Username"];
	$EntryMail = $_POST["gbook_Email"];
	$EntrySubject = $_POST["gbook_Subject"];
	$EntryText = $_POST["gbook_Content"];
	$EntryIP = $_SERVER['REMOTE_ADDR'];
	$EntryDate = time();
	
	// Cleaning
	$EntryName = utf8_decode($EntryName);
	$EntryMail = utf8_decode($EntryMail);
	$EntrySubject = utf8_decode($EntrySubject);
	$EntryText = utf8_decode($EntryText);
	$EntryName = htmlspecialchars($EntryName);
	$EntryMail = htmlspecialchars($EntryMail);
	$EntrySubject = htmlspecialchars($EntrySubject);
	$EntryText = htmlspecialchars($EntryText);
	
	$Spam = false; 	
	$SpamTime = 60*15; // 15 Minuten 
	$SQL_Query = "SELECT * FROM io_Gbook WHERE `date` > ". (time() - $SpamTime). " AND `ip` = \"". $EntryIP . "\"";
	$gbook_Spamquery = mysql_query($SQL_Query);
	while(mysql_fetch_array($gbook_Spamquery)) {
		$Spam = true; 	
	}
	
	if(!$Spam) {
	$SQL_Query = "INSERT INTO  `io_Gbook` (  `EntryID` ,  `date` ,  `user` ,  `email` ,  `subject` ,  `text` ,  `ip` ,  `session` ,  `deleted` ,  `cookies` ) 
				VALUES ('',  '$EntryDate',  '$EntryName',  '$EntryMail',  '$EntrySubject',  '$EntryText',  '$EntryIP',  '',  '0',  '')";
				
	mysql_query($SQL_Query);
	}
	
	
	header('Location: .?cat=gbook');
	
}

?>
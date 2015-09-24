<?

$statFile = fopen("stats.txt", "r+");
$statsVisits = intval(fgets($statFile,64));
$statsViews = intval(fgets($statFile,64));

if($_COOKIE["LastVisit"] == "") {
	setcookie("LastVisit", time(), time()+60*60*3);
	$statsVisits++;
}

$statsViews++;

rewind($statFile);
fputs($statFile, $statsVisits . "\n");
fputs($statFile, $statsViews);
fclose($statFile);





?>
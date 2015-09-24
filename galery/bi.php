<?

$imagePath = "albums"; //  path where you have the preview image tree (the large images in photofolio)  
$imgIndexFilename = "imgindex.xml";

print "<head><title>Photofolio Build Index ||<title></head>"; 
print "<body>"; 
print "<font face='arial, helvetica' size='medium'><B>Creating imgindex.xml from from the directory structure of your site. . .  please wait<B></font><br>"; 
print "<HR width='400' height='1' align='left'>"; 
print("<table  width='400' border='0' cellspacing='0' cellpadding='2'>");

$xmlString = "<albums>\n";
$xmlString .= parseTree($imagePath);
$xmlString .= "</albums>\n";
//print 'the xml string is: ' . $xmlString;
//print $xmlString;

// Open the file and erase the contents if any
$fp = fopen("$imgIndexFilename", "w");

// Write the data to the file
fwrite($fp, $xmlString);

// Close the file
fclose($fp);

print "<p></p><font face='arial, helvetica' size='medium'><strong>DONE!</strong></font>";

//////////////////////////  START FUNCTIONS

function parseTree($tempFolderPath) {
	$dir=opendir("$tempFolderPath");
	while(false !== ($album=readdir($dir))){     
		if($album!="." && $album!="..") {
			$thisImagePath = $tempFolderPath."/".$album;		
			//print $thisImagePath . " is here<br>";
			$innerdir=opendir("$thisImagePath");
			while(false !== ($innerfile=readdir($innerdir))){
				//print "$innerfile : " . is_file($innerfile) . '<br>';
				$isAlbum = 0;
				if (is_file($thisImagePath.'/'.$innerfile)) {  
				 $isAlbum = 1;
				  break ;
				}
			}
			if ($isAlbum == 1){
				$xmlString .= parseSet($tempFolderPath);
				break ;
			} else if (is_dir($thisImagePath)) {
				print $thisImagePath . ' is a set <BR/>';	
				$xmlString .= "<set name=\"$album\">\n";
				$xmlString .= parseSet($thisImagePath);
				$xmlString .= "</set>\n";
			}
		}
	}
	return $xmlString;
}


function parseSet($tempFolderPath) {
	$albums = array();
	$dir=opendir("$tempFolderPath");
	
	while(false !== ($album=readdir($dir))){     
		if($album!="." && $album!="..") {
			$thisAlbumPath = $tempFolderPath."/".$album;		
			$innerdir=opendir("$thisAlbumPath");
			print $thisAlbumPath . " is getting processed<br>";
			$albums[$album] = parseAlbum($thisAlbumPath, $album);
		}
	}
	
	uksort($albums, "strnatcasecmp");
	//ksort($albums, SORT_STRING);
	
	foreach ($albums as $key => $value) {
		$xmlString .= "<album name=\"$key\">\n";
		foreach ($value as $value2) {
			$xmlString .= " <image name=\"" . $value2["name"] . "\">\n";
			$xmlString .= "	 <comment>" . $value2["comment"] . "</comment>\n";
			$xmlString .= "	 <tURL>" . $value2["tURL"]. "</tURL>\n";
			$xmlString .= "	 <lURL>" . $value2["lURL"]. "</lURL>\n";
			$xmlString .= " </image>\n";
		}
		$xmlString .= "</album>\n";
	}
	
	return $xmlString;
}

function parseAlbum($thisAlbumPath, $album) {	
	$innerdir=opendir("$thisAlbumPath");
	$commentName = 'comments';
	unset($albumImages);
	$albumImages = array();
	$image = array();
	
	while(false !== ($innerfile=readdir($innerdir))){
		$thisExt = substr("{$innerfile}", -3);
		if (strtolower($thisExt) == 'jpg'){
			$image["name"] = substr("{$innerfile}", 0, -4);
			$image["tURL"] = $album . "/" . $innerfile;
			$image["lURL"] = $album . "/" . $innerfile;

			if(extension_loaded('exif')) {  // the EXIF is there, then get the comment
				$exif = exif_read_data($thisAlbumPath. "/". $innerfile, 0, true);
				/*foreach ($exif as $key => $section) {
				  foreach ($section as $name => $val) {
				   echo "$key.$name: $val<br />\n";
				  }
				}*/
				extract($exif);
				$image["comment"]  = $COMMENT[0];
				
				unset($exif);
				unset($COMMENT);
			}
			$albumImages[$image["name"]] = $image; // ADD THIS IMAGE TO THE ALBUMIMAGES ARRAY
		}
		
	}

	//array_multisort($albumImages, SORT_ASC);
	//sort($albums);
	uksort($albumImages, "strnatcasecmp");
	return $albumImages;
}

?> 
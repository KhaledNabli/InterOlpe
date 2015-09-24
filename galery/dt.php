<?

$imagePath = "albums"; //  path where you have the preview image tree (the large images in photofolio)  i.e. "seefile/images"
$thumbnailPath = "thumbnails"; //  path where you want the thumbnail tree  i.e. "../seefile home directory/thumbs"


//print "<head><title>Build Thumbnail Script<title></head>"; 
//print "<body>"; 
print "<font face='arial, helvetica' size='medium'><B>Creating thumbnails from original images. . .<B></font><br>"; 
print "<HR width='400' height='1' align='left'>"; 
//Get GD imaging library info
$tgdInfo    = getGDversion(); 
if ($tgdInfo == 0){ 
	print "Note: The GD imaging library was not found on this Server. Thumbnails will not be created. Please contact your web server administrator.<br><br>";
}

if ($tgdInfo < 2){
	print "Note: The GD imaging library is version ".$tgdInfo." on this server. Thumbnails will be reduced quality. Please contact your web server administrator to upgrade GD version to 2.0.1 or later.<br><br>";
}


print("<table  width='400' border='0' cellspacing='0' cellpadding='2'>");
//loop thru images

if (is_dir("$thumbnailPath") == 0) {
	mkdir("$thumbnailPath", 0777);
	print("<TR><TD align='left' colspan='2'><font face='arial, helvetica' size='small'><b>$thumbnailPath created</b> </font><br>");
}

parseFolder($imagePath, $thumbnailPath);

print "<TR><TD align='right' colspan='2'><font face='arial, helvetica' size='medium'><strong>Processing Complete.</strong></font></TD>";
print("</table>");
//print "</body>"; 

function parseFolder($tempFolderPath, $tempThumbnailPath) {
	$dir=opendir("$tempFolderPath");
	while(false !== ($album=readdir($dir))){     //print $imagePath.'/'.$album . " - " . is_dir($imagePath."/".$album). '<br>';  //print $album . ' <BR/>';
		if($album!="." && $album!="..") {
			$thisImagePath = $tempFolderPath."/".$album;		
			$thisThumbnailPath = $tempThumbnailPath."/".$album;
			//print $thisAlbumPath . " is here";
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
				//print $thisImagePath . " is getting processed";
				createThumbsFromFolder($thisImagePath, $thisThumbnailPath);
			} else if (is_dir($thisImagePath)) {
				//print $thisImagePath . ' is a set <BR/>';	
				mkdir("$thisThumbnailPath", 0777);
				parseFolder($thisImagePath, $thisThumbnailPath);
			}
		}
	}
}





function createThumbsFromFolder($thisAlbumPath, $thisThumbnailAlbumPath) {	
	if (is_dir("$thisThumbnailAlbumPath") == 0) {
		mkdir("$thisThumbnailAlbumPath", 0777);
		print("<TR><TD align='left' colspan='2'><font face='arial, helvetica' size='small'><b>$thisThumbnailAlbumPath created</b> </font><br>");
	}
	
	print $thisThumbnailAlbumPath;		
	$innerdir=opendir("$thisAlbumPath");
	while(false !== ($innerfile=readdir($innerdir))){
		$thisExt = substr("{$innerfile}", -3);
		if (strtolower($thisExt) == 'jpg' && file_exists($thisThumbnailAlbumPath."/".$innerfile) == 1 ){
			print "<TR><TD width='300'><font face='arial, helvetica' size='small'>$thisThumbnailAlbumPath/$innerfile</TD><TD>";
			//print $innerfile . " - " . $album;
			$thisImagePath = $thisAlbumPath."/".$innerfile;
			$thisThumbnailPath = $thisThumbnailAlbumPath."/".$innerfile;
			if (unlink("$thisThumbnailPath")) { 
               print 'Thumbnail '.$file.'/thumbs/'.$thumbfile.' deleted.<BR>'; 
            } 
			print "</font></TD></TR>";
		}
	}
}


				

/**
* Create a squared thumbnail from an existing image.
* 
* @param	string		$file		Location and name where the file is stored .
* @return	boolean
* @access	public
* @author	Christian Machmeier
*/

function getGDversion() {
   static $gd_version_number = null;
   if ($gd_version_number === null) {
       // Use output buffering to get results from phpinfo()
       // without disturbing the page we're in.  Output
       // buffering is "stackable" so we don't even have to
       // worry about previous or encompassing buffering.
       ob_start();
       phpinfo(8);
       $module_info = ob_get_contents();
       ob_end_clean();
       if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i",
               $module_info,$matches)) {
           $gd_version_number = $matches[1];
       } else {
           $gd_version_number = 0;
       }
   }
   return $gd_version_number;
} 
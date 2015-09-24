<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="460"><div style="width : 460px; height : 580px; overflow : auto; ">
    <!-- News Begin -->
<?php
		
    $SQL_Query = "SELECT topic_id, topic_title, topic_poster, topic_time, topic_first_post_id, topic_first_poster_name FROM io_Board_topics WHERE forum_id = 2 ORDER BY topic_time DESC LIMIT 0,10";
	$topics_query = mysql_query($SQL_Query);
	echo mysql_error();
while($topics = mysql_fetch_array($topics_query)) {
	$topID = $topics[0];
	$topTitle = $topics[1];
	$topPoster = $topics[2];
	$topTime = $topics[3];
	$topFirstPost = $topics[4];
	$topPosterName = $topics[5];

	// Hauptartikel
	$SQL_Query = "SELECT post_time, post_text FROM io_Board_posts WHERE post_id = ". $topFirstPost ." ORDER By post_time DESC";
	$posts_query = mysql_query($SQL_Query);
	
	$post = mysql_fetch_array($posts_query);
	$postTime = $post[0];
	$postText = $post[1];
	
	// Kommentare
	$SQL_Query = "SELECT post_time, post_text FROM io_Board_posts WHERE topic_id = ". $topID ." AND post_id != ". $topFirstPost ." ORDER By post_time ASC";
	$comment_query = mysql_query($SQL_Query);
	
	$commentCount = mysql_num_rows($comment_query);
	
	// Text Cleaning / Formatting
	$topTitle = utf8_encode($topTitle);
	$topPosterName = utf8_encode($topPosterName);
	$postText = utf8_encode($postText);
	//$postText = str_replace("\n", "<br>\n", $postText);
	$postText = str_replace("{SMILIES_PATH}", "../../brd/images/smilies", $postText);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"430\">\n";
	echo "<tr><td colspan=\"3\" class=\"newsHeader\"> $topTitle </td></tr>\n";
	echo "<tr><td colspan=\"3\" class=\"newsText\">". parseBBCode2HTML($postText) ."<br><br> </td></tr>\n";
	echo "<tr><td width=\"135\" class=\"newsFooter\">". date("d.M.Y",$postTime) ."</td><td width=\"135\" class=\"newsFooter\"> von $topPosterName </td><td width=\"150\" class=\"newsFooter\"> $commentCount Kommentare </td></tr>\n";
	echo "</table>\n<br><br><br><br>";

}

?>
    <!-- News End -->
      </div></td>
    <td width="320" align="center">
    <img src="images/side_element_long.png" alt="FC Inter Olpe Last Match" height="180" width="300"  /><br /><br />
    <img src="images/blitztabelle_txt.png" alt="FC Inter Olpe Tabelle" height="40" width="150" align="left" />
    <?php 
    //<iframe src="http://www.facebook.com/plugins/likebox.php?id=105939672794136&amp;width=300&amp;connections=20&amp;stream=false&amp;header=false&amp;height=410" scrolling="no" frameborder="0" style="border:none; width:300px; height:385px; background:#E5E5E5; overflow:hidden" allowTransparency="false"></iframe>
	
	$SQLResult = mysql_query("SELECT position, teamName, points FROM `io_Tabelle` WHERE spieltagid = 0 order by position asc");
	
	echo "<br><br><table width=\"300\" >\n";
	echo "<tr style=\"font-weight:bold; background:#200;\">\n";
	echo "<td width=\"50\" align=\"center\">Platz</td>\n";	
	echo "<td>Mannschaft</td>\n";
	echo "<td width=\"50\" align=\"center\">Punkte</td>\n";
	echo "</tr>\n";
	while($blitzTabelle = mysql_fetch_row($SQLResult)) {
		$platz = $blitzTabelle[0];
		$team = utf8_encode($blitzTabelle[1]);
			if($team == "FC Inter Olpe") $style = "style=\"background:#2F0000; font-size:11px; font-weight:bold;\" ";
			elseif ($team == "SpVg. Olpe IV") continue;
			else $style = "style=\"font-size:10px;\"";
		$punkte = $blitzTabelle[2];
		echo "<tr >\n";
		echo "<td width=\"50\" align=\"center\" $style>$platz</td>\n";	
		echo "<td $style>$team</td>\n";
		echo "<td width=\"50\" align=\"center\" $style>$punkte</td>\n";
		echo "</tr>\n";
		
	}

	echo "</table>\n<br><br>";
	?>

<p class="statisticInfo">Besucher: <?php echo $statsVisits; ?><br />Aufrufe: <?php echo $statsViews; ?></p></td>
  </tr>
</table>

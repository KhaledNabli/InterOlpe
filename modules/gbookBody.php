<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="440"><div style="width : 430px; height : 580px; overflow : auto; ">
        <p class="gbookHead"> Inter G&auml;stebuch </p>
        <br>
        <br>
        <?php
	
$SQL_Query = "SELECT * FROM io_Gbook WHERE deleted = 0 ORDER by date DESC";
$gbook_query = mysql_query($SQL_Query);

$EntryNr = mysql_num_rows($gbook_query);

while($topics = mysql_fetch_array($gbook_query)) {
	$EntryID = $topics[0];
	$EntryDate = $topics[1];
	$EntryUser = $topics[2];
	$EntryEmail = $topics[3];
	$EntrySubject = $topics[4];
	$EntryText = $topics[5];
	$EntryIP = $topics[6];

	
	// Text Cleaning / Formatting
	$EntryText = utf8_encode($EntryText);
	$EntryText = nl2br($EntryText);
	$EntryUser = utf8_encode($EntryUser);
	$EntrySubject = utf8_encode($EntrySubject);
	
	echo "<table width=\"400\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
	echo "<tr><td width=\"30\" class=\"gbookHeader\"> #$EntryNr </td><td colspan=\"2\" class=\"gbookHeader\"> $EntrySubject </td></tr>\n";
	echo "<tr><td width=\"30\"></td><td colspan=\"2\"  class=\"gbookText\">". $EntryText ."<br><br> </td></tr>\n";
	echo "<tr><td width=\"30\"></td><td width=\"170\" class=\"gbookFooter\">". date("d.M.Y H:i",$EntryDate) ."</td><td width=\"200\" class=\"gbookFooter\"> von <a class=\"gbookFooter\" href=\"mailto:".$EntryEmail."\" > $EntryUser </a></td></tr>\n";
	echo "</table>\n<br><br><br><br>";
	
	$EntryNr--;

}
?>
      </div></td>
    <td width="340">
    
    <?php
	$Spam = false; 	
	$EntryIP = $_SERVER['REMOTE_ADDR'];
	$SpamTime = 60*15; // 15 Minuten 
	$SQL_Query = "SELECT * FROM io_Gbook WHERE `date` > ". (time() - $SpamTime). " AND `ip` = \"". $EntryIP . "\"";
	$gbook_Spamquery = mysql_query($SQL_Query);
	while(mysql_fetch_array($gbook_Spamquery)) {
		$Spam = true; 	
	}
	
	if($Spam) {
		echo "<p style=\"text-align:center\"><br> <br> <br> <br> Vielen Dank f&uuml;r Ihren Eintrag! </p> <br><br><br><br><br><br><br><br><br><br><br><br>";
	}
	 else { 
	 ?>
     
     <p style="font-size:14px; font-weight:bold;">In's G&auml;stebuch eintragen </p>
      <form name="gBook" method="post" action="?cat=gbook">
        <table border="0" cellspacing="0" cellpadding="0" width="310" align="center">
          <tr>
            <td width="100">Name</td>
            <td><span id="sprytextfield1">
              <input name="gbook_Username" type="text" class="bodyInputElement" id="gbook_Username" maxlength="16">
              <span class="textfieldRequiredMsg">*</span></span></td>
          </tr>
          <tr>
            <td>E-Mail</td>
            <td><span id="sprytextfield2">
              <input name="gbook_Email" type="text" class="bodyInputElement" id="gbook_Email" maxlength="32">
              <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
          </tr>
          <tr>
            <td>Betreff</td>
            <td><span id="gbookSubjectValidator">
              <input name="gbook_Subject" type="text" class="bodyInputElement" id="gbook_Subject" maxlength="20">
              <span class="textfieldRequiredMsg">*</span></span></td>
          </tr>
          <tr>
            <td colspan="2"><span id="gbookContentValidator">
              <textarea name="gbook_Content" id="gbook_Content" cols="45" rows="10" class="bodyInputElement"></textarea>
              <span class="textareaRequiredMsg">*</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" name="gbookSubmit" id="button" value="Senden"  class="bodyInputElement"></td>
          </tr>
        </table>
      </form>
      <?php } ?>
      <br>
      <?php 
      //<p class="copyrightInfo">HTML-Code/JavaScript wird aus Sicherheitsgr&uuml;nden nicht ber&uuml;cksichtigt.</p>
      //<p class="copyrightInfo">Bitte beachten Sie das wir nicht f&uuml;r die Eintr&auml;ge unserer Besucher haftbar gemacht werden k&ouml;nnen. Wir bitten daher alle Eintr&auml;ge, die aus Ihrer Sicht unpassend erscheinen, zu melden. Wir werden diese umgehend pr&uuml;fen und ggf. reagieren. Danke !</p>
	  ?>
      <iframe src="http://www.facebook.com/plugins/likebox.php?id=105939672794136&amp;width=340&amp;connections=10&amp;stream=false&amp;header=true&amp;height=285" scrolling="no" frameborder="0" style="border:none; width:330px; height:260px; background:#E5E5E5; overflow:hidden"></iframe>
    </td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email");
var sprytextfield3 = new Spry.Widget.ValidationTextField("gbookSubjectValidator");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("gbookContentValidator");
//-->
</script>

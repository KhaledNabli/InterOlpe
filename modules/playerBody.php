
<table width="780"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="625" border="0" cellpadding="0" cellspacing="0" style="height:300px;">
        <tr>
          <td colspan="6" width="625"  style="height:20px;"></td>
        </tr>
        <tr>
          <td rowspan="4" width="15" style="height:300px;"></td>
          <td rowspan="4"><img src="<?php echo $PlayerPic;?>" width="220" height="300" alt="" /></td>
          <td rowspan="4"><img src="images/SpielerInfo_MiddleSpacer.png" width="19" height="300" alt="" /></td>
          <td colspan="3" width="371" style="height:81px;" ><h1><?PHP echo $PlayerName; ?></h1></td>
        </tr>
        <tr>
          <td rowspan="2" style="height:129px;"><img src="images/SpielerInfo_TrikotLeft.png" width="53" height="129" alt="" /></td>
          <td style="height:34px;"><img src="images/SpielerInfo_TrikotRightTop.png" width="55" height="34" alt="" /></td>
          <td width="263" style="height:129px; vertical-align:middle;" rowspan="2">
          <table border="0" cellpadding="0" cellspacing="1">
          <tr> <td style="font-size: 11px;"> <strong>Geburtsdatum:</strong> <?php echo $PlayerBDate; ?> </td> </tr>
          <tr> <td style="font-size: 11px;"> </td> </tr>
          <tr> <td style="font-size: 11px;"> <strong>Größe: </strong><?php echo $PlayerSize; ?> </td> </tr>
          <tr> <td style="font-size: 11px;"> <strong>Position: </strong><?php echo $PlayerPositionTxt; ?> </td> </tr>
          <tr> <td style="font-size: 11px;"> <strong>Saisonspiele: </strong><?php echo $PlayerPlays ;//." ($PlayerTime min)"; ?> </td> </tr>
          <tr> <td style="font-size: 11px;"> <strong>Saisontore: </strong><?php echo $PlayerGoals; ?> </td> </tr>
          <tr> <td style="font-size: 11px;"> <strong>Karten: </strong><?php echo $PlayerYellow ."<img src=\"images/yellowCardSmall.png\" width=\"12\" height=\"12\" alt=\"Yellow Cards\" /> ". $PlayerRed ."<img src=\"images/redCardSmall.png\" width=\"12\" height=\"12\" alt=\"Red Cards\" />"; ?> </td> </tr>
          <tr> <td style="font-size: 11px;"> <strong>Zugelassen am: </strong><?php echo $PlayerEntryDate; ?> </td> </tr>
          <tr> <td style="font-size: 11px;"> &nbsp;</td> </tr>
          </table>
        </td>
        </tr>
        <tr>
          <td width="55" style="background:url(images/SpielerInfo_TrikotNumber.png); height:95px; font-size:14px; font-weight:bold; vertical-align:top;"><?php  echo $PlayerNumberTxt; ?></td>
        </tr>
        <tr>
          <td colspan="3" width="371" height="90" style="vertical-align:middle; height:90;"><?php echo $PlayerComment; ?></td>
        </tr>
      </table>
      <img src="images/statistik_txt.png" width="128" height="51" />
      <div style="overflow:auto; height:175px; width:600px;" >
      <table border="0" cellspacing="0" cellpadding="1" width="500" align="center">
        <tr bgcolor="#220000">
          <td width="80" class="tableHeader">Datum</td>
          <td class="tableHeader">Spiel</td>
          <td width="40" class="tableHeader"><img src="images/einwechselung.png" height="20" alt="Spielzeit"  title="Einwechslung"  /></td>
          <td width="40" class="tableHeader"><img src="images/auswechselung.png" height="20" alt="Spielzeit"  title="Auswechslung"  /></td>
          <td width="35" class="tableHeader"><img src="images/clock.png" height="20" alt="Spielzeit"  title="Spielzeit"  /></td>
          <td width="35" class="tableHeader"><img src="images/yellowCard.png" height="20" alt="Gelbe Karten"  title="Gelbe Karten"  /></td>
          <td width="35" class="tableHeader"><img src="images/redCard.png" height="20" alt="Rote Karten"  title="Rote Karten" /></td>
          <td width="40" class="tableHeader"><img src="images/goalSmall.png" height="20" alt="Goals" title="Tore" /></td>
        </tr>
        
        <?php 
        
        $SQL_Query = "SELECT a.spielId, a.einsatzDauer, a.einsatzStart, a.einsatzEnde, a.yellows, a.reds, a.goals, b.heim, b.gast, b.timestamp FROM `io_Spielereinsatz` a, `io_Spielplan` b WHERE a.spielId = b.nummer AND a.spielerId = '$PlayerID' ORDER BY b.timestamp DESC";
        
        $SQL_Result = mysql_query($SQL_Query);
        while($row = mysql_fetch_row($SQL_Result)) {
        	$spiel = $row[0];
        	$plyT = $row[1];
        	$plyS = $row[2];
        	$plyE = $row[3];
        	$yel = $row[4];
        	$red = $row[5];
        	$gol = $row[6];
        	
        	
        	
        	$zeitstempel = $row[9];
        	$heim = utf8_encode($row[7]);
        	$gast = utf8_encode($row[8]);
        	
        	$spielDatum = date("d.m.Y", $zeitstempel);
        	/*
        	if($event == 2)
        		$eventText = "Einwechselung";
        	if($event == 3)
        		$eventText = "Auswechselung";
        	if($event == 4)
        		$eventText = "Gelbe-Karte";
        	if($event == 5)
        		$eventText = "Rote-Karte";
        	if($event == 6)
        		$eventText = "Gelb-Rote Karte";       		
        	if($event == 7)
        		$eventText = "Tor erzielt";
        	if($event == 8)
        		$eventText = "EigenTor verusacht";
        	*/
        	if($heim == "FC Inter Olpe")
        		$spielText = "gg. ". $gast;
        	else
        		$spielText = "gg. ". $heim;
        	

        	
        	
        	
        	echo "        
        	<tr>
          	<td class=\"tableRow\">$spielDatum</td>
          	<td style=\"font-size: 11px;\">$spielText</td>
          	<td class=\"tableRow\">$plyS'</td>
          	<td class=\"tableRow\">$plyE'</td>
          	<td class=\"tableRow\">$plyT'</td>
          	<td class=\"tableRow\">$yel</td>
          	<td class=\"tableRow\">$red</td>
          	<td class=\"tableRow\">$gol</td>
        	</tr>";
        }
        
        
        
        ?>
        
        <tr> <td> </td> <td colspan="3" class="tableFootL">Gesamt</td> <td class="tableFoot"> <?php echo $PlayerTime."'";; ?> </td> <td class="tableFoot"> <?php echo $PlayerYellow; ?></td>  <td class="tableFoot"><?php echo $PlayerRed; ?>  </td> <td class="tableFoot"> <?php echo $PlayerGoals; ?></td> </tr>
      </table> </div>
</td>
    <td><p><img src="./images/trainer_txt.png" width="128" height="51" alt="FC Inter Olpe Trainer" /><br />
        <?php echo $AllTrainerMenu; ?> <br />
        <br />
        <img src="./images/spieler_txt.png" width="128" height="51" alt="FC Inter Olpe Spieler" /><br />
        <?php echo $AllPlayerMenu; ?> <br />
        <br />
      </p></td>
  </tr>
</table>

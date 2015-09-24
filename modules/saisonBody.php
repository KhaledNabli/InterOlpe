<table
	style="width: 780; height: 580; text-align: center; vertical-align: middle;">
	<tr>
		<td width="650"><img src="images/begegnungen_txt.png"
			alt="FC Inter Olpe Begegnungen" height="40" width="150" align="left" />
		<br />
		<br />
		<br />
		<table width="90%" border="0" cellspacing="0" cellpadding="2"
			align="center">
			<tr style="background: #200;">
				<th width="30" scope="col">#</th>
				<th width="40" scope="col"></th>
				<th colspan="2" scope="col" style="font-size: 14px;">Begegnung</th>
				<th scope="col" style="font-size: 14px;">Anstoss</th>
				<th scope="col" style="font-size: 14px;">Ergebnis</th>
			</tr>

			<?php

			/*

			*/
			if ( PHP_OS == "WIN32" || PHP_OS == "WINNT" ) {
				setlocale( "LC_TIME", "German_Germany" ); // Windows
			} else {
				setlocale( "LC_TIME", "de_DE" ); // Linux
			}
			
			
			// generate Output
			$SQL_Query = "SELECT timestamp, nummer, heim, gast, InterGame, homeScore, guestScore FROM `io_Spielplan` WHERE spieltag = $SpielTag ORDER BY `timestamp` ASC";
			$SQL_Result = mysql_query($SQL_Query);
			echo mysql_error();
			$lastDate = "";
			$num = 0;
			while($SpielPlanEntity = mysql_fetch_row($SQL_Result)) {

				$num = ($num+1) % 2;
				if($num == 0) $bg = "bgcolor=\"#390000\"";
				else $bg = "";

				$datum = strftime ("%A, %d. %B", $SpielPlanEntity[0]);

				if($datum != $lastDate) {
					echo "
				<tr style=\"background: #220000;\">
				<td></td>
				<td align=\"left\" colspan=\"7\" style=\"font-size:12px;\">$datum</th>
				</tr>";
					$lastDate = $datum;
				}

				$time = date("H:i", $SpielPlanEntity[0]);
				$nummer = $SpielPlanEntity[1];
				$heim = utf8_encode($SpielPlanEntity[2]);
				$gast = utf8_encode($SpielPlanEntity[3]);
				$isInter = $SpielPlanEntity[4];
				$homeScore = $SpielPlanEntity[5];
				$guestScore = $SpielPlanEntity[6];

				if($isInter == 1) { $bg = "bgcolor=\"#5B0000\""; $num = ($num+1) % 2; }
				if($homeScore > $guestScore)
				$heim = "<strong>$heim</strong>";
				else if ($homeScore < $guestScore)
				$gast = "<strong>$gast</strong>";


				echo "<tr $bg ><td style=\"font-size:10px;\">$nummer</td> <td> </td> <td align=\"left\" style=\"font-size:11px;\">$heim</td><td align=\"left\" style=\"font-size:11px;\">$gast</td> <td style=\"font-size:11px;\">$time</td> <td style=\"font-size:11px;\">$homeScore : $guestScore</td></tr>";

			}
			?>
		</table>
		<br />
		<img src="images/tabelle_txt.png" alt="FC Inter Olpe Tabelle"
			height="40" width="150" align="left" /><br />
		<br />
		<br />
		<table width="90%" border="0" cellspacing="0" cellpadding="1"
			align="center">
			<tr style="background: #200;">
				<th scope="col">Platz</th>
				<th scope="col" align="left">Mannschaft</th>
				<th scope="col" width="25">S</th>
				<th scope="col" width="20">g</th>
				<th scope="col" width="20">u</th>
				<th scope="col" width="20">v</th>
				<th scope="col">Torverh&auml;tlnis</th>
				<th scope="col">Punkte</th>
			</tr>

			<?php
			$SQL_Result = mysql_query("SELECT position, teamName, plays, won, lost, draw, goals, cgouls, points, positionLast  FROM `io_Tabelle` where spieltagid = $SpielTag order by position asc");
			$num = 0;
			while($datensatz  = mysql_fetch_row($SQL_Result)) {
				$pos = $datensatz[0];
				$team = utf8_encode($datensatz[1]);
				$plays = $datensatz[2];
				$won = $datensatz[3];
				$lost = $datensatz[4];
				$draw = $datensatz[5];
				$g = $datensatz[6];
				$cg = $datensatz[7];
				$points = $datensatz[8];
				$lastPos = $datensatz[9];

				$num = ($num+1) % 2;
				if($num == 0) $bg = "bgcolor=\"#390000\"";
				else $bg = "";

				if($team == "FC Inter Olpe") { $bg = "bgcolor=\"#5B0000\""; $num = ($num+1) % 2; }
				//else $bg = "";

				echo "<tr $bg><td>$pos</td> <td align=\"left\">$team</td> <td>$plays</td> <td>$won</td><td>$draw</td><td>$lost</td> <td>$g : $cg</td><td>$points</td> </tr>";

			}

			?>
		</table>
		</td>

		<td><br />
		<br />
		<br />
		<br />
		<?php
		for($i = 1; $i < 27; $i++) {
			if($SpielTag != $i)
			echo "<a href=\"./?cat=saison&spieltag=$i\">$i. Spieltag</a><br>\n";
			else
			echo "$i. Spieltag<br>\n";
		}

		?></td>
	</tr>
</table>

<?php 

$category = $_GET["cat"];
include("./modules/database.php");
include("./modules/statistics.php");



switch($category) {
	case "nachrichten":
		$pageInitPart = "./modules/newsInit.php";
		$CategoryTitle ="&raquo; Nachrichten";
		$pageHeadPart = "./modules/newsHead.php";
		$pageBodyPart = "./modules/newsBody.php";
		break;
	case "saison":
		$pageInitPart = "./modules/saisonInit.php";
		$CategoryTitle ="&raquo; Saison";
		$pageHeadPart = "./modules/saisonHead.php";
		$pageBodyPart = "./modules/saisonBody.php";
		break;	
// 	case "mannschaft":
// 		$pageInitPart = "";
// 		$CategoryTitle ="&raquo; Mannschaft";
// 		$pageHeadPart = "";
// 		$pageBodyPart = "./modules/teamBody.php";
// 		break;
	case "spieler":
		$pageInitPart = "./modules/playerInit.php";
		$CategoryTitle ="&raquo; Spieler";
		$pageHeadPart = "./modules/playerHead.php";
		$pageBodyPart = "./modules/playerBody.php";
		break;
// 	case "organisation":
// 		$pageInitPart = "./modules/orgaInit.php";
// 		$CategoryTitle ="&raquo; Organisation";
// 		$pageHeadPart = "";
// 		$pageBodyPart = "./modules/orgaBody.php";
// 		break;
	case "galerie":
		$pageInitPart = "";
		$CategoryTitle ="&raquo; Galerie";
		$pageHeadPart = "";
		$pageBodyPart = "./modules/galeryBody.php";
		break;
	case "gbook":
		$pageInitPart = "./modules/gbookInit.php";
		$CategoryTitle ="&raquo; Gästebuch";
		$pageHeadPart = "./modules/gbookHead.php";
		$pageBodyPart = "./modules/gbookBody.php";
		break;
	case "impressum":
		$pageInitPart = "";
		$CategoryTitle ="&raquo; Impressum";
		$pageHeadPart = "./modules/impressHead.php";
		$pageBodyPart = "./modules/impressBody.php";
		break;
	default:
		$pageInitPart = "./modules/loaderHead.php";
		$CategoryTitle ="&raquo; Willkommen";
		$pageHeadPart = "";
		$pageBodyPart = "";
		break;
}
?>
<?php 
	@include($pageInitPart);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>FC Inter Olpe <?php echo $CategoryTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="page-type" content="Sport Organisation">
<meta name="Expires" content="never">
<meta name="audience" content="Alle">
<meta name="page-topic" content="Fussball Club Inter Olpe">
<meta name="Keywords" content="FC Inter, FC Inter Olpe, FC Inter-Olpe, Fussball, Sauerland, Inter, Integration, Sport, Olpe, Wenden, Gerlingen, Jugend, Kreisliga">
<meta name="Description" content="<?php echo $CategoryTitle."'s Seite auf der"?> offiziellen Internet Präsentation des Fussball Clubs FC Inter Olpe">
<meta name="copyright" content="Khaled Nabli">
<meta name="publisher" content="Oktay Gücük">
<meta name="author" content="Khaled Nabli">
<meta name="msnbot" content="all">
<meta name="revisit-after" content="20 days">
<meta name="robots" content="all">
<link href="basic.css" rel="stylesheet" type="text/css">
<script src="index.js" type="text/javascript"></script>
<?php 
@include($pageHeadPart);
?>
</head>
<body>
<!-- Module - menuBar -->
<?php 
include("./modules/menuBar.php");
?>
<!-- menuBar - End -->
<table width="1040" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5"><img src="images/layout_redisigned_01.png" width="1040" height="21" alt="FC Inter Olpe - Integration"></td>
  </tr>
  <tr>
    <td rowspan="4"><img src="images/layout_redisigned_02.png" width="20" height="829" alt="FC Inter Olpe - Fussball"></td>
    <td colspan="3" width="1000" height="69" style="vertical-align:middle; background:url(images/top_bar.png)"><form action="http://forum.inter-olpe.de/ucp.php?mode=login" method="post" target="_blank" id="login">
        <table width="1000" border="0" cellpadding="0" cellspacing="0" id="head_section">
          <tr>
            <td width="650">&nbsp;</td>
            <td width="100" class="headTextBlocks">Benutzername</td>
            <td width="250"><input name="username" type="text" id="username" size="15" maxlength="12" class="headInputElement"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="headTextBlocks">Passwort</td>
            <td><input name="password" type="password" id="password" size="15" maxlength="12" class="headInputElement">
              <input type="submit" name="head_login" id="head_login" value="Login" class="headInputElement"></td>
          </tr>
        </table>
      </form></td>
    <td rowspan="4"><img src="images/layout_redisigned_04.png" width="20" height="829" alt="FC Inter Olpe - Sport"></td>
  </tr>
  <tr>
    <td><img src="images/left_bar.png" width="110" height="583" alt="FC Inter Olpe - Gerlingen"></td>
    <td width="781" class="mainSection"><?php
    	@include($pageBodyPart);
	?></td>
    <td><img src="images/right_bar.png" width="109" height="583" alt="FC Inter Olpe - Wenden"></td>
  </tr>
  <tr>
    <td colspan="3"><img src="images/buttom_bar.jpg" alt="Inter Olpe Links" width="1000" height="156" border="0" usemap="#Map"></td>
  </tr>
  <tr>
    <td colspan="3" class="footerBar"><a href="?cat=impressum" class="footerCopyright">www.inter-olpe.de // &copy; copyright 2010 Khaled Nabli // all rights reserved // FC Inter Olpe e.V. 2009</a></td>
  </tr>
</table>

<map name="Map">
  <area shape="circle" coords="249,78,55" href="http://www.dfb.de/" target="_blank" alt="Inter Olpe DFB">
  <area shape="circle" coords="498,76,59" href="http://www.wflv.de/" target="_blank" alt="Inter Olpe WFLV">
  <area shape="circle" coords="747,76,57" href="http://www.flvw.de/" target="_blank" alt="Inter Olpe FLVW">
</map>
</body>
</html>
<html>
<head>
<title>Mural de Recados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<link rel="stylesheet" type="text/css" href="../mural.css">
<?php 
$fd = $_GET['fd'];
$f = $_GET['f'];
$j = $_GET['j'];
$anz = $_GET['anz'];
$b = $_GET['b'];
?>
<script language="JavaScript">
<!--
  function eintragen(farbe) {
    parent.window.opener.document.conf.<?=$fd?>.value = farbe;
    parent.window.close();
  }
//-->
</script>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellspacing="0" cellpadding="5" height="100%" width="100%">
  <tr> 
    <td align="center">
	<?
  include("class.cp.php");
  $breite = 100;
  $abstand = 1;
  $img_type = "JPG";

  if (!isset($f)) $f = "999999";
  if (!isset($j)) $j = 51;
  if (!isset($anz))  $anz = 5;
  if (!isset($b))  $b = "0000FF";


  $cp = new pmc_colorpicker($f, $b, $breite, $anz, $abstand, $j, $img_type, $fd);
  $cp->panel();

?>
</td>
  </tr>
</table>
</body>
</html>
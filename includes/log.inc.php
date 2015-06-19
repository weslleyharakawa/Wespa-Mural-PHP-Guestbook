<?php 
// ------------------------------------------------------------------------- //
// Mural de Recados (Wespa Digital Ltda)                                          //
// ------------------------------------------------------------------------- //
// Wespa Mural de Recados 4.1 (2012)
// Desenvolvido por Weslley A. Harakawa (weslley@wcre8tive.com)
// Todos os direitos reservados
// http://www.wespadigital.com
// info@wespadigital.com
// Código de uso livre, favor não remover os créditos nem os banners do Google Adsense.
if ($_SESSION['permission'] == "yes") {
   
    // ########### Admin Menu #############
    include($dir_path . '/includes/admin.menu.inc.php');

    echo $menu;
    echo $tabletop;

    if (!isset($_GET['action'])) {
        $action = '';
    } else {
        $action = $_GET['action'];
    } 


if ($action == "showlog") {

$count = 0;
$page_size = 20;
$pagenumshow = 10;
$StartRow = 0;

$result = cnt_mysql_query("select count(id) from ".$db_prefix."adminlog");  
$RecordCount = mysql_result($result, 0, 0); 

//Set Maximum Page
$MaxPage = $RecordCount % $page_size;
if($RecordCount % $page_size == 0){
    $MaxPage = $RecordCount / $page_size;
}else{
    $MaxPage = ceil($RecordCount / $page_size);
} 

//Set the page no
if(empty($_GET['PageNo'])){
    if($StartRow == 0){
    $PageNo = $StartRow+1;
    }
}else{
    $PageNo = $_GET['PageNo'];
    $StartRow = ($PageNo - 1) * $page_size;
}

//Set the counter start
if($PageNo % $pagenumshow == 0){
    $CounterStart = $PageNo - ($pagenumshow-1);
}else{
    $CounterStart = $PageNo - ($PageNo % $pagenumshow)+1;
}

//Counter End
$CounterEnd = $CounterStart + ($pagenumshow - 1);

if ($MaxPage < 2) {
$pagename = $lang_page;
} else {
$pagename = $lang_pages;
}

if ($RecordCount < 2) {
$recordsname = $lang_record;
} else {
$recordsname = $lang_records;
}

echo "\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
echo "<td class=\"text\" height=\"20\"><b>$lang_adminlogdetail</b></td>";
echo "<td class=\"text\" align=\"right\"><a href=\"admin.php?action=clearlog\">$lang_dellog</a></td>\n";
echo "</tr>\n</table>";
echo "<br />";
echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" align=\"right\"><b>#</b></td>\n";
echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\"><b>$lang_ip</b></td>\n";
echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\"><b>$lang_host</b></td>\n";
echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\"><b>$lang_machine</b></td>\n";
echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\"><b>$lang_browser</b></td>\n";
echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\"><b>$lang_date</b></td>\n";
echo "</tr>\n"; 

$query = "SELECT id,ip,host,machine,FROM_UNIXTIME(datetime) FROM ".$db_prefix."adminlog ORDER BY datetime DESC LIMIT $StartRow, $page_size";
$result = cnt_mysql_query($query);

while (list($id, $ip, $host, $machine, $datetime) = mysql_fetch_row($result)) { 

$count++;
			  
	if ($count % 2 == 0) {
	$rowbgcolor = $bgcolor2;
	} else {
	$rowbgcolor = $bgcolor1;
	}

  // Browser ermitteln
  $browser = $machine;
  $browser_type = "unbekannt";
  if (ereg("Mozilla/3.0",$browser))
    $browser_type = "Netscape 3.0";
  if (ereg("Mozilla/3.1",$browser))
    $browser_type = "Netscape 3.1";
  if (ereg("Mozilla/4.0",$browser))
    $browser_type = "Netscape 4.0";
  if (ereg("Mozilla/4.5",$browser))
    $browser_type = "Netscape 4.5";
  if (ereg("Mozilla/4.6",$browser))
    $browser_type = "Netscape 4.6";
  if (ereg("Mozilla/4.7",$browser))
    $browser_type = "Netscape 4.7";
  if (ereg("Mozilla/5.0",$browser))
    $browser_type = "Netscape 6";
  if (ereg("Netscape/7",$browser))
    $browser_type = "Netscape 7";
  if (ereg("Safari",$browser))
    $browser_type = "Safari";
 if (ereg("Opera",$browser))
    $browser_type = "Opera";
 if (ereg("compatible; MSIE",$browser))
    $browser_type = "Internet Explorer " . substr($browser,30,3);

  // Betriebssystem ermitteln
  $system = "unbekannt";
  if (ereg("Windows NT",$browser) || ereg("WinNT",$browser))
    $system = "Windows NT";
  if (ereg("Windows NT 5.0",$browser))
    $system = "Windows 2000";
  if (ereg("Windows NT 5.1",$browser))
    $system = "Windows XP";
  if (ereg("Windows 98",$browser) || ereg("Win98",$browser))
    $system = "Windows 98";
  if (ereg("Windows 95",$browser) || ereg("Win95",$browser))
    $system = "Windows 95";
  if (ereg("Win16",$browser))
    $system = "Windows 3.x";
  if (ereg("Win 9x 4.90",$browser))
    $system = "Windows ME";
  if (ereg("Unix",$browser) || ereg("hp-ux",$browser))
    $system = "X11";
  if (ereg("Linux",$browser))
    $system = "Linux";
  if (ereg("Mac",$browser))
    $system = "MAC";
				
echo "<tr>\n";
echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"right\">$id</td>\n";
echo "<td class=\"text\" bgcolor=\"$rowbgcolor\"><a href=\"http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=$ip\" target=\"blank\">$ip</a></td>\n";
echo "<td class=\"text\" bgcolor=\"$rowbgcolor\">$host</td>\n";
echo "<td class=\"text\" bgcolor=\"$rowbgcolor\">$system</td>\n";
echo "<td class=\"text\" bgcolor=\"$rowbgcolor\">$browser_type</td>\n";
echo "<td class=\"text\" bgcolor=\"$rowbgcolor\">$datetime</td>\n";
echo "</tr>\n"; 

}
mysql_free_result($result);
echo "</table>";

echo "<p align=\"center\" class=\"text\">".pageing()."</p>\n";
}

 	echo $tablebottom;
    echo $blankline;
    echo $tabletop;
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n<tr>\n<td width=\"50%\" class=\"text\"><a href=\"admin.php\">$lang_overview</a></td>\n";

    echo "</tr>\n</table>\n";	
	echo $tablebottom;
	
echo "<br />".$copyright; //removing the copyright is a violation of the licence agreement!
echo "<p>&nbsp;</p>";
echo "</td>\n</tr>\n</table>\n"; 
} else {
echo "$lang_noaccess";
}
?>

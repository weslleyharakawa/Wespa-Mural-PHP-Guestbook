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
require ('../includes/mysql.inc.php');
require ($dir_path . '/includes/global.php');
require ($dir_path . '/includes/functions.admin.php');
require($dir_path . '/languages/'.$lang.'_lang.inc.php');

$gbname = str_replace("\"", "&quot;", stripslashes($gbname));
include($dir_path.'/admin/header.php');

session_start();
if (isset($_SESSION['permission']) == "yes") {

	$time_start = getmicrotime();
    include($dir_path.'/includes/admin.inc.php');

	$time_end = getmicrotime();
	$totaltime = $time_end - $time_start;
	// time format (how many digits you want to show)
	$digits = 5;
	$trimmedtime = number_format($totaltime, $digits);
	$abfragen = cnt_mysql_query();

if ($show_query == 1) {
    if ($gzip_level == 0) {
        $gzip = "";
    } else {
        $gzip = "(GZIP $gzip_level)";
    } 
	if ($admindebug == 1) {
    echo "<tr><td></td><td class=\"micro\" align=\"center\" valign=\"top\">$lang_pagegen " . $trimmedtime . " $lang_secs $lang_with $abfragen $lang_query $gzip</td></tr></table><p>&nbsp;</p>";
	}  
} 
   
} else {
    echo "<br /><br /><p align=\"center\" class=\"error\">$lang_noaccess</p>";
	echo "$copyright";
} 
include($dir_path . '/admin/footer.php');
ob_end_flush();
?>
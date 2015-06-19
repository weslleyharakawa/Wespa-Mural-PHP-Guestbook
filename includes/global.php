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
// report all errors except E_NOTICE
error_reporting(E_ALL ^ E_NOTICE);
// error_reporting(E_ALL); //just for Debug purposes
// used for timing purpose
set_magic_quotes_runtime(0);
ini_set('session.use_trans_id', 0);

$version = "4.1";

function dbconnect()
{
    global $dbconnection, $dbhost, $dbusername, $dbpassword, $dbname;
    $dbconnection = mysql_connect($dbhost, $dbusername, $dbpassword)
    or die("Can't connect to the database server. MySQL said:<br />" . mysql_error());
    $dbconnectionbase = mysql_select_db("$dbname")
    or die("Can't connect to the database $dbname. MySQL said:<br />" . mysql_error());
    return(($dbconnection && $dbconnectionbase));
}

// Retrieve DB stored configuration
dbconnect();
$abfrage = cnt_mysql_query("SELECT name,value FROM ".$db_prefix."conf")
or die("Database error. MySQL said:<br />" . mysql_error());;
while ($row = mysql_fetch_array($abfrage)) {
$$row['name'] = $row['value'];
} 

function cnt_mysql_query($query=FALSE) { 
static $query_count = 0; 
if (!$query) 
return $query_count; 
$query_count ++; 
return mysql_query($query); 
} 

// start output buffering
if ($gzip_level != 0) {
    ini_set('zlib.output_compression', 0);
    $level = $gzip_level;
    ini_set('zlib.output_compression_level', $level);
    ob_start('ob_gzhandler');
} else {
    ob_start();
} 

function getmicrotime() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
} 

function errorend() {
    echo "</body>\n</html>";
    die;
} 

// ########### tabela #############
$tabletop = "<table cellspacing=\"0\" cellpadding=\"1\" width=\"$tablewidth\" border=\"0\" bgcolor=\"$bordercolor\" align=\"center\">\n<tr>\n<td>\n<table cellspacing=\"0\" cellpadding=\"15\" width=\"100%\" border=\"0\" bgcolor=\"$tablebgcolor\" align=\"center\">\n<tr>\n<td class=\"text\">\n";
$tablebottom = "</td>\n</tr>\n</table>\n</td>\n</tr>\n</table>\n";
$blankline = "<img src=\"$img_relpath/spacer.gif\" width=\"10\" height=\"8\" border=\"0\" alt=\"\" /><br />";

$copyright = "<!-- Copyright Information -->\n<center><span class=\"copyright\">Wespa Mural de Recados 4.1 &copy; 2012, <a href=\"http://www.wespadigital.com\" target=\"_blank\">Desenvolvido por <b>Wespa Digital Ltda</b></a></span><br /></center>";

$powered = "Mural de Recados";
?>
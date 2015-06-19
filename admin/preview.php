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
include($dir_path . '/admin/header.php');

session_start();
if (isset($_SESSION['permission']) == "yes") {

$file = $_GET['file'];

$filename = $dir_path."/templates/$file";
$handle= fopen($filename,'r');
$previewfile = fread($handle,filesize($filename));

$test = str_replace("{rowbgcolor}", "$bgcolor1", $previewfile);
$test = str_replace("{bgcolor1}", "$bgcolor1", $test);
$test = str_replace("{bgcolor2}", "$bgcolor2", $test);
$test = str_replace("{tablebgcolor}", "$tablebgcolor", $test);
$test = str_replace("{bordercolor}", "$bordercolor", $test);
$test = str_replace("{tablewidth}", "$tablewidth", $test);
$test = str_replace("{bgtablehead}", "$bgtablehead", $test);
$test = str_replace("{pagebgcolor}", "$pagebgcolor", $test);

echo $test;

} else {
 echo "<br /><br /><p align=\"center\" class=\"error\">$lang_noaccess</p>";
 echo "$copyright";
}
include($dir_path . '/admin/footer.php');
ob_end_flush();
?>
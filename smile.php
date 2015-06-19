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
require ('includes/mysql.inc.php');
require ($dir_path .'/includes/global.php');
require ($dir_path .'/includes/functions.gb.php');

$time_start = getmicrotime();

require($dir_path .'/languages/'.$lang.'_lang.inc.php');
include($dir_path .'/includes/class.template.inc');

//assign template variables
$gbname = str_replace("\"", "&quot;", stripslashes($gbname));

$count = 0;
$smcount = 0;

//obtem emoticons do dB
$smfile = "\n<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\" width=\"100%\" align=\"center\">\n";

$query = "SELECT filename,alttag,code FROM ".$db_prefix."smilies ORDER BY sort ASC";
$smileresult = cnt_mysql_query($query);
while (list($smfilename,$smalttag,$smcode) = mysql_fetch_row($smileresult)) {
	
if ($count % 2 == 0) {
$rowbgcolor = $bgcolor2;
} else {
$rowbgcolor = $bgcolor1;
}
	
if ($smcount % 2 == 0) {
if ($smcount!=0) {
$smfile .= "</tr>\n";
}
$smfile .= "<tr bgcolor=\"$rowbgcolor\">\n";
$count++;
}

if ($smfilename!="") {
$srcSmile = @getimagesize("$sm_rootpath/$smfilename");
$smfile .= "<td><a href=\"javascript:opener.smilie('$smcode')\"><img src=\"$sm_relpath/$smfilename\" $srcSmile[3] alt=\"$smalttag\" border=\"0\" /></a></td>\n<td class=\"text\">$smcode</td>\n";
} 

$smcount++;
}

if (mysql_num_rows($smileresult) == 0) {
$smfile .= "<td class=\"error\" colspan=\"4\" bgcolor=\"$bgcolor1\">$lang_error_nosmilies</td>";
}

$smilies = $smfile;
$smilies .= "</tr></table>";

//chama o template dos emoticons
$tpl = new template;
$tpl->load_file('smile', $dir_path."/templates/".$tpl_smilies);
$output = $tpl->pprint('smile', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','rowbgcolor','smilies','lang_windowclose','lang_smiliestext'));
echo $output;
ob_end_flush();
?>

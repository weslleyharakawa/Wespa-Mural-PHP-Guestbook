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

//call help template
$tpl = new template;
$tpl->load_file('help', $dir_path."/templates/".$tpl_help);
$output = $tpl->pprint('help', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','rowbgcolor','lang_windowclose','lang_helptext'));
echo $output;
ob_end_flush();
?>

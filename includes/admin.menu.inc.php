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
$menu = "<table cellspacing=\"0\" cellpadding=\"10\" width=\"96%\" border=\"0\" align=\"center\">\n";
$menu .= "<tr>\n<td width=\"150\" valign=\"top\" class=\"text\">";
$menu .= "<img src=\"$img_relpath/adminlogo.gif\" width=\"113\" height=\"32\" alt=\"Mural de Recados\" vspace=\"3\" />";
$menu .= "$tabletop";
$menu .= "<b>$lang_admincenter</b><br /><br />";
$menu .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
$menu .= "<tr><td width=\"14\" valign=\"top\"><img src=\"$img_relpath/arrow.gif\" alt=\"\" width=\"8\" height=\"14\" /></td><td class=\"text\"><a href=\"admin.php\">$lang_overview</a></td></tr>";
$menu .= "<tr><td colspan=\"2\"><img src=\"$img_relpath/spacer.gif\" width=\"1\" alt=\"\" height=\"8\" /></td></tr>";
$menu .= "<tr><td valign=\"top\"><img src=\"$img_relpath/arrow.gif\" width=\"8\" alt=\"\" height=\"14\" /></td><td class=\"text\"><a href=\"admin.php?action=entries\">$lang_records</a></td></tr>";
$menu .= "<tr><td valign=\"top\"><img src=\"$img_relpath/arrow.gif\" width=\"8\" alt=\"\" height=\"14\" /></td><td class=\"text\"><a href=\"admin.php?action=avatars\">$lang_avatars</a></td></tr>";
$menu .= "<tr><td valign=\"top\"><img src=\"$img_relpath/arrow.gif\" width=\"8\" alt=\"\" height=\"14\" /></td><td class=\"text\"><a href=\"admin.php?action=smilies\">$lang_smilies</a></td></tr>";
$menu .= "<tr><td valign=\"top\"><img src=\"$img_relpath/arrow.gif\" width=\"8\" alt=\"\" height=\"14\" /></td><td class=\"text\"><a href=\"admin.php?action=templates\">$lang_templates</a></td></tr>";
$menu .= "<tr><td colspan=\"2\"><img src=\"$img_relpath/spacer.gif\" width=\"1\" alt=\"\" height=\"8\" /></td></tr>";
$menu .= "<tr><td valign=\"top\"><img src=\"$img_relpath/arrow.gif\" width=\"8\" alt=\"\" height=\"14\" /></td><td class=\"text\"><a href=\"config.php\">$lang_settings</a></td></tr>";
$menu .= "<tr><td valign=\"top\"></td></tr>";
$menu .= "<tr><td colspan=\"2\"><img src=\"$img_relpath/spacer.gif\" width=\"1\" height=\"8\" alt=\"\" /></td></tr>";
$menu .= "<tr><td valign=\"top\"><img src=\"$img_relpath/arrow.gif\" width=\"8\" height=\"14\" alt=\"\" /></td><td class=\"text\"><a href=\"$url/index.php\" target=\"_blank\">$lang_gotogb</a></td></tr>";
$menu .= "</table>";
$menu .= "$tablebottom</td><td valign=\"top\"><img src=\"$img_relpath/spacer.gif\" width=\"1\" alt=\"\" height=\"38\" />";
?>

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

if (substr($_SERVER['PHP_SELF'], -9) != "index.php") {
   header('Location:' . $url . '/admin/index.php');
}

require ($dir_path . '/includes/global.php');
require ($dir_path . '/includes/functions.admin.php');
require($dir_path . '/languages/'.$lang.'_lang.inc.php');

$gbname = str_replace("\"", "&quot;", stripslashes($gbname));



// ########### tabela #############
$tabletop = "<table cellspacing=\"0\" cellpadding=\"1\" border=\"0\" bgcolor=\"$bordercolor\" align=\"center\">\n<tr>\n<td>\n<table cellspacing=\"0\" cellpadding=\"15\" width=\"100%\" border=\"0\" bgcolor=\"$tablebgcolor\" align=\"center\">\n<tr>\n<td class=\"text\">\n";
$tablebottom = "</td>\n</tr>\n</table>\n</td>\n</tr>\n</table>\n";
$blankline = "<img src=\"$img_relpath/spacer.gif\" width=\"10\" height=\"8\" border=\"0\" alt=\"\" /><br />";
 
include($dir_path . '/admin/header.php');

if (!isset($HTTP_POST_VARS['action'])) {
    $action = '';
    $username = '';
    $password = '';
} else {
    $action = $HTTP_POST_VARS['action'];
    $username = $HTTP_POST_VARS["username"];
    $password = $HTTP_POST_VARS["password"];
} 

if ($action == "login" AND ($username != "" or $password != "")) {
    if ($username == "$admin_user" AND $password == "$admin_pass") {
        $permission = "yes";

        session_start();
        $_SESSION['permission'] = "yes";
        $_SESSION['username'] = "$admin_user";
        // faz o memso que o login
        $RemoteHost = $_SERVER['REMOTE_ADDR'];
        if ((!$RemoteHost) || preg_match("!^\d+\.\d+\.\d+\.\d+$!", $RemoteHost, $foo)) {
            if (preg_match("!^(\d+)\.(\d+)\.(\d+)\.(\d+)$!", $_SERVER['REMOTE_ADDR'], $foo)) {
                $RemoteHost = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            } 
        } 

        $ip = $_SERVER['REMOTE_ADDR'];
        $machine = $_SERVER['HTTP_USER_AGENT'];
        $datetime = time();

        $query = "INSERT INTO ".$db_prefix."adminlog (id,ip,host,machine,datetime) VALUES ('NULL','$ip','$RemoteHost','$machine','$datetime')";
        $result = mysql_query($query);

        header ('Location: admin.php?' . SID);
    } else {
        echo "<br />";
        echo "<p align=\"center\" class=\"error\">$lang_error_noaccess. $lang_error_tryagain\n<p>";
    } 
} 

if ($admindisable == 1) {
    $pwd = "$admin_pass";
    $user = "$admin_user";
} else {
    $pwd = "";
    $user = "";
} 
// show login form

$title = str_replace("\"", "&quot;", stripslashes($title));
echo "<p>&nbsp;</p>";
echo "<p>&nbsp;</p>";
echo "<p>&nbsp;</p>";
echo $tabletop;

if ($logo != "") {
        $size_logo = getimagesize("$img_rootpath/$logo");
        $logo = "<a href=\"../index.php\"><img src=\"$img_relpath/$logo\" $size_logo[3] alt=\"$gbname\" border=\"0\" /></a>";
    } else {
        $logo = "<span class=\"headline\">$title</span>";
    }
	 
echo $logo;
echo "<br /><br />";
echo "<form name=\"form1\" method=\"post\" action=\"index.php\">\n";
echo "<input type=\"hidden\" name=\"action\" value=\"login\" />\n";
echo "<table border=\"0\" align=\"center\">\n";
echo "<tr>\n";
echo "<td class=\"text\" align=\"right\">$lang_username:</td>\n<td><input type=\"text\" name=\"username\" size=\"20\" class=\"form\" value=\"$user\" style=\"width:200px\" /></td>\n</tr>\n";
echo "<tr>\n<td class=\"text\" align=\"right\">$lang_password:</td>\n<td><input type=\"password\" name=\"password\" size=\"20\" class=\"form\" value=\"$pwd\" style=\"width:200px\" /></td>\n</tr>\n";
echo "<tr>\n<td>&nbsp;</td>\n<td><input type=\"submit\" value=\"$lang_adminlogin\" style=\"width:180px\" /></td>\n</tr>\n";
echo "</table>\n";
echo "</form>\n";
echo $tablebottom;
echo "<br />";
echo $copyright;
if ($admindisable == 1) { // pode ser ativado no arquivo functions.admin.php
    echo "<p class=\"error\" align=\"center\">Admin functions disabled for demo</p>";
} 

include($dir_path . '/admin/footer.php');
ob_end_flush();

?>
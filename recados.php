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
if ($logo!="") {
$size_logo = @getimagesize("$img_rootpath/$logo");
$logo = "<a href=\"index.php\"><img src=\"$img_relpath/$logo\" $size_logo[3] alt=\"$gbname\" border=\"0\" /></a>";
} else {
$logo = $gbname;
} 

//you can change these values - but no more please
$avcolumn = 3;  // Número de colunas de Avatares
$smcolumn = 12; // Númerod e colunas de Emoticons

//não modifique ou remova isto
$count = 0;
$avcount = 0;
$smcount = 0;
$flooder = "";
$homeok = "";
$checkword = 1;
$errortext = "";
$fl = 0;

$helplink = "<a href=\"javascript:MM_openBrWindow('ajuda.php','help','scrollbars=yes,resizable=yes,width=350,height=400')\">$lang_help</a>";

//call header template
$tpl = new template;
$header = $tpl->pget_file($dir_path."/templates/".$tpl_header, array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','hits','stats','pagenums','lang_viewgb','lang_signgb'));
echo $header;

//chama o título do template
$view = 1;
$sign = 0;
$pageing = 0;
$tpl = new template;
$tpl->load_file('top', $dir_path."/templates/".$tpl_top);
$tpl->parse_if('top', 'view');
$tpl->parse_if('top', 'pageing');
$tpl->parse_if('top', 'sign');
$top = $tpl->pprint('top', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','hits','stats','pagenums','lang_viewgb','helplink','lang_signgb'));
echo $top;

if (!$action) {

if (!isset($_GET['more']) or isset($_GET['more'])=="") {
$more = 0;
} else {
$more = $_GET['more'];
}

//get smilies from db
$smfile = "\n<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";

$countsmilies = mysql_num_rows(cnt_mysql_query("SELECT id FROM ".$db_prefix."smilies"));
$query = "SELECT filename,alttag,code FROM ".$db_prefix."smilies ORDER by sort ASC LIMIT 0, $smcolumn";
$smileyfiles = cnt_mysql_query($query);
while (list($smfilename,$smalttag,$code) = mysql_fetch_row($smileyfiles)) {
		
if ($smcount % $smcolumn == 0) {
if ($smcount!=0) {
$smfile .= "</tr>\n";
}
$smfile .= "<tr>\n";
}

if (file_exists("$sm_rootpath/$smfilename") and $smfilename!="") {
	$srcSmile = @getimagesize("$sm_rootpath/$smfilename");
	$smfile .= "<td>";
	$smfile .= "<a href=\"javascript:smilie('$code')\"><img src=\"$sm_relpath/$smfilename\" 		$srcSmile[3] alt=\"$smalttag\" border=\"0\" /></a>";
	$smfile .= "</td>\n";
} elseif (!file_exists("$sm_rootpath/$smfilename") or $smfilename=="") {
    $srcError = @getimagesize("$sm_rootpath/error.gif");
	$smfile .= "<td>";
	$smfile .= "<img src=\"$sm_relpath/error.gif\" $srcError[3] alt=\"$lang_error\" border=\"0\" />";
	$smfile .= "</td>\n";
	}

$smcount++;

if ($countsmilies>$smcolumn) {
$smlink = "<a href=\"javascript:MM_openBrWindow('smile.php','smilies','scrollbars=yes,resizable=yes,width=260,height=300')\">$lang_more</a>";
} else {
$smlink = "";
}
}

if (mysql_num_rows($smileyfiles)==0) {
	$smfile .= "<td class=\"error\" colspan=\"$smcolumn\"></td>";
}

//get avatars from db
$avfile = "\n<table border=\"0\" cellpadding=\"5\" cellspacing=\"1\">\n";
$avfile .= "<tr>\n<td colspan=\"$avcolumn\"></td>\n</tr>\n";
$query = "SELECT id,filename,alttag FROM ".$db_prefix."avatars ORDER by sort ASC";
$avatarfiles = cnt_mysql_query($query);
while (list($id,$filename,$alttag) = mysql_fetch_row($avatarfiles)) {
		
if ($avcount % $avcolumn == 0) {
if ($avcount!=0) {
$avfile .= "</tr>\n";
}
$avfile .= "<tr>\n";
}

if (file_exists("$av_rootpath/$filename") and $filename!="") {
	$srcAvatar = @getimagesize("$av_rootpath/$filename");
	$avfile .= "<td bgcolor=\"$bgcolor2\">";
	$avfile .= "<input type=\"radio\" name=\"avatar\" value=\"$id\" />";
	$avfile .= "<img src=\"$av_relpath/$filename\" $srcAvatar[3] alt=\"$alttag\" border=\"0\" />";
	$avfile .= "</td>\n";
} elseif (!file_exists("$av_rootpath/$filename") or $filename=="") {
    $srcError = @getimagesize("$av_rootpath/error_avatar.gif");
	$avfile .= "<td bgcolor=\"$bgcolor2\">";
	$avfile .= "<input type=\"radio\" name=\"avatar\" value=\"0\" />";
	$avfile .= "<img src=\"$av_relpath/error_avatar.gif\" $srcError[3] alt=\"$lang_error\" border=\"0\" />";
	$avfile .= "</td>\n"; 
}

$avcount++;
}

$smilies = $smfile;
$smilies .= "</tr>\n</table>";

$avafile = $avfile;
$avafile .= "</tr>\n</table>";

if ($show_avatars!=1) {
$noavatars = 0; //dont show
} else {
$noavatars = 1; //show
}

if ($avcount==0){
$noavatars = 0; //if no avatars available in db, dont show in form
}

if ($required_name==1) {
$req_name = "<span class=\"star\">*</span>";
} else {
$req_name = "";
}

if ($required_email==1) {
$req_mail = "<span class=\"star\">*</span>";
} else {
$req_mail = "";
}

if ($required_hp==1) {
$req_hp = "<span class=\"star\">*</span>";
} else {
$req_hp = "";
}

if ($required_avatar==1) {
$req_ava = "<span class=\"star\">*</span>";
} else {
$req_ava = "";
}

if ($required_comment==1) {
$req_com = "<span class=\"star\">*</span>";
} else {
$req_com = "";
}

if ($required_country==1) {
$req_land = "<span class=\"star\">*</span>";
} else {
$req_land = "";
}

//chama o formulário do template
$tpl = new template;
$tpl->load_file('form', $dir_path."/templates/".$tpl_form);
$tpl->parse_if('form', 'noavatars');
$form = $tpl->pprint('form', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','lang_email','lang_homepage','lang_comment','lang_country','lang_submit','lang_name','lang_avatarselect','lang_charsleft','avafile','smilies','smlink','avlink','req_mail','req_name','req_hp','req_land','req_com','req_ava','lang_reqfields','comment_length'));
echo $form;
	}

if ($action=="doentry") {

//envia variáveis
$name = addslashes($HTTP_POST_VARS['name']);
$avatar = @$HTTP_POST_VARS['avatar'];
$email = addslashes($HTTP_POST_VARS['email']);
$homepage = @addslashes($HTTP_POST_VARS['homepage']);
$country = @addslashes($HTTP_POST_VARS['country']);
$comment = addslashes($HTTP_POST_VARS['comment']);
$datetime = time();
$ip = $_SERVER['REMOTE_ADDR'];

//do floocheck
$query = "SELECT ip,datetime FROM ".$db_prefix."book WHERE ip='$ip' ORDER BY id DESC LIMIT 1";
$flood = cnt_mysql_query($query);
list($lastip,$lastdatetime) = mysql_fetch_row($flood);

if ($floodcheck==1) {
      if ($ip==$lastip AND time()-$lastdatetime<=$floodchecktime) {
	  $flooder = "TRUE";
	  $difference = $floodchecktime-(time()-$lastdatetime);
      }
    }

$hp = str_replace("http://","",$homepage);

//check if url exists
if ($homepage!="") {
$up = @fsockopen("$hp", 80, $errno, $errstr);
if(!$up) {   
$homeok = "FALSE";
} 
}
	
//check for correct email
if ($email!="") {
if (!ereg("^([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])*$", $email)) {
        $email = "FALSE";
    } 
}

if ($flooder=="TRUE") {
$errortext .= "<span class=\"error\">$lang_error_flood1 $floodchecktime $lang_error_flood2 $difference $lang_error_flood3</span><br /><br />";
$fl = 1;
}

if ($required_name==1 AND $name=="") {
$errortext .= "<br /><span class=\"error\">$lang_error_name</span>";
$fl = 1;
} elseif ($required_name==0 and $name=="") {
$name = "$lang_anonym";
}

if (($required_email==1 and $email=="") or $email=="FALSE") {
$errortext .= "<br /><span class=\"error\">$lang_error_email</span>";
$fl = 1;
}

if (($required_hp==1 and $homepage=="") or $homeok=="FALSE") {
$errortext .= "<br /><span class=\"error\">$lang_error_homepage</span>";
$fl = 1;
}

if ($required_country==1 AND $country=="") {
$errortext .= "<br /><span class=\"error\">$lang_error_country</span>";
$fl = 1;
}

if ($required_comment==1 AND $comment=="") {
$errortext .= "<br /><span class=\"error\">$lang_error_comment</span>";
$fl = 1;
} elseif ($required_comment==0 and $comment=="") {
$comment = "$lang_nocomment";
}

if ($required_avatar==1 AND $avatar=="") {
$errortext .= "<br /><span class=\"error\">$lang_error_avatar</span>";
$fl = 1;
} elseif ($required_avatar==0 and $avatar=="") {
$avatar = 0;
}

if ($fl==1) {
echo "<span class=\"headline\">$lang_error</span><br />";
echo "$errortext";
echo "<span class=\"text\"><br /><br /><a href=\"javascript:history.go(-1)\">$lang_backtoform</a></span>";
} else {


//parse urls
$comment=parseurl($comment);

//badwords
$name=badtext($name);
$country=badtext($country);
$comment=badtext($comment);

if ($hp!="") {
$hp = "http://".$hp;
}

if ($moderated==1) {
$online = 0;
} else {
$online = 1;
}

	//enter into db
	$sql = "INSERT INTO ".$db_prefix."book (id,name,avatar,email,homepage,country,comments,datetime,ip,online) VALUES (NULL,'$name','$avatar','$email','$hp','$country','$comment','$datetime','$ip','$online')";
	$result = cnt_mysql_query($sql) or
	die("<span class=\"error\">$lang_error_addentry<br />".mysql_error()."</span>"); 
	
	//send email to webmaster
	if ($emailonnewentry==1) {
	$date = strftime("%y-%m-%d %H:%M:%I",$datetime);
	
		if ($moderated!=1) {
		$subject = "$lang_subject";
		} else {
		$subject = "$lang_subject_mod";
		}
		
		$notice = "$lang_hello $admin_user,\n";		
		$notice .= "$lang_notice\n";
		$notice .= "$name $lang_wrote $lang_at $date:\n";
		$notice .= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";				
		$notice .= "$comment\n\n";
		if ($email!="") {
			$notice .= "$lang_email: mailto:$email\n";
		}
		if ($homepage!="") {
			$notice .= "$lang_homepage: $hp\n";
		}
		if ($country!="") {
			$notice .= "$lang_country: $country\n";
		}
		$notice .= "$lang_ip: $ip\n";
		$notice .= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\n";
		
		if ($moderated!=1) {
		$notice .= "$lang_mail_editlink";	
		} else {
		$notice .= "$lang_mail_editmodlink";
		}
		
		$notice .= "$url/admin/index.php\n\n";
		$notice .= "$lang_mail_linktogb";
		$notice .= "$url/index.php\n\n";
		skmail($subject, $notice);
	}
	if ($moderated!=1) {
	echo "<span class=\"text\">$lang_thanks</span>";
	} else {
	echo "<span class=\"text\">$lang_thanks_mod</span>";
	}
  }
  
}

	//queries and gzip
	$time_end = getmicrotime();
	$totaltime = $time_end - $time_start;
	$digits = 5;
	$trimmedtime = number_format($totaltime, $digits);
	$queries = cnt_mysql_query();

	if ($show_query == 1) {
    	if ($gzip_level == 0) {
        	$gzip = "";
    	} else {
        	$gzip = "(GZIP $gzip_level)";
    	} 
		$showquery = 1;
		$time = $trimmedtime;
	} else {
	    $showquery = 0;
		$time = "";
	}

//call footer template
$tpl = new template;
$tpl->load_file('foot', $dir_path."/templates/".$tpl_footer);
$tpl->parse_if('foot', 'pageing');
$tpl->parse_if('foot', 'showquery');
$footer = $tpl->pprint('foot', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','lang_signgb','copyright','lang_pagegen','lang_secs','lang_with','queries','lang_query','gzip','time'));
echo $footer;

ob_end_flush();
?>

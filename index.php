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
include ($dir_path .'/includes/functions.gb.php');

$time_start = getmicrotime();

require($dir_path .'/languages/'.$lang.'_lang.inc.php');
include($dir_path .'/includes/class.template.inc');

//assign template variables
$gbname = str_replace("\"", "&quot;", stripslashes($gbname));

if ($logo!= "") {
$size_logo = @getimagesize("$img_rootpath/$logo");
$logo = "<a href=\"index.php\"><img src=\"$img_relpath/$logo\" $size_logo[3] alt=\"$gbname\" border=\"0\" /></a>";
} else {
$logo = $gbname;
} 

$count = 0;
$avatar = "";
$StartRow = 0;
$i = 0;

$result = cnt_mysql_query("select count(id) from ".$db_prefix."book where online=1");  
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

//count unique visits
if (!isset($HTTP_COOKIE_VARS["user_ip"])) {
$count_ip = "";
} else {
$count_ip = $HTTP_COOKIE_VARS["user_ip"];
}

if(!$count_ip) { 
setcookie("user_ip", $_SERVER['REMOTE_ADDR'], time()+600); //set cookie with lifetime of 10 min 
$newhits = $gbhits+1; 
$update = "UPDATE ".$db_prefix."conf SET value='$newhits' WHERE name='gbhits'";
$result = cnt_mysql_query($update);
} elseif ($count_ip != $_SERVER['REMOTE_ADDR']){ 
$newhits = $gbhits+1; 
$update = "UPDATE ".$db_prefix."conf SET value='$newhits' WHERE name='gbhits'";
$result = cnt_mysql_query($update);
} 

$stats = "$RecordCount $recordsname $lang_on $MaxPage $pagename";
$hits = "$lang_with $gbhits $lang_hits";

$pagenums = pageing();

//call header template
$tpl = new template;
$tpl->load_file('header', $dir_path."/templates/".$tpl_header);
$tpl->parse_if('header', 'sign');
$tpl->parse_if('header', 'view');
$tpl->parse_if('header', 'pageing');
$header = $tpl->pprint('header', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','hits','stats','pagenums','lang_viewgb','lang_signgb'));
echo $header;

//call title template
$sign = 1;
$view = 0;
$pageing = 1;
$tpl = new template;
$tpl->load_file('top', $dir_path."/templates/".$tpl_top);
$tpl->parse_if('top', 'sign');
$tpl->parse_if('top', 'view');
$tpl->parse_if('top', 'pageing');
$top = $tpl->pprint('top', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','lang_signgb','lang_viewgb','pagenums','stats','hits'));
echo $top;

//get smilies and put in cache
$query = "SELECT id,filename,alttag,code FROM ".$db_prefix."smilies";
$data = cnt_mysql_query($query);
$sm_cache = array();
while ($row = mysql_fetch_array($data)){		
$sm_cache[$row['id']] = $row;	
}
mysql_free_result($data);


//get guestbook entries from db
$query = "SELECT b.id,b.name,b.email,b.homepage,b.country,b.comments,b.answer,FROM_UNIXTIME(b.datetime),b.ip,b.online,a.filename,a.alttag 
FROM ".$db_prefix."book as b
LEFT JOIN ".$db_prefix."avatars as a
ON b.avatar = a.id
WHERE b.online like '1'
ORDER BY $sort_after $sort_order LIMIT $StartRow, $page_size";
$entries = cnt_mysql_query($query);
while (list($id,$guestname,$email,$homepage,$country,$comment,$answer,$entrydate,$ipnumber,$online,$filename,$alttag) = mysql_fetch_row($entries)) {

	$count++;	
	
	//uncomment if you want German Date style	
	//$new_dt = strtotime("$entrydate");
    //$entrydate = date("d.m.Y H:i:s", $new_dt);
	
	if ($sort_order == "DESC") {
	$entryno = ($RecordCount-$StartRow) - $i;
	} else {
	$entryno = ($StartRow+1) + $i;
	}

	if ($show_avatars==1) {
	if ($filename!="") {
		$srcAvatar = @getimagesize("$av_rootpath/$filename");
		$filename = "<img src=\"$av_relpath/$filename\" $srcAvatar[3] border=\"0\" alt=\"$alttag\" vspace=\"3\" />";
		$filename .= "<br />\n";
	} 
	} else {
	$filename = "";
	}
	
	if ($answer!="") {
		$comment = $comment."\n\n[b]$lang_answer:[/b]\n".$answer;
	}
	
	if ($show_email==1) {
	if ($email!="") {
		$email = "<a href=\"mailto:$email\">$lang_email</a>";
		$email .= "<br />";
	}
	} else {
		$email = "";
	}
 	
	if ($show_hp==1) {
	if ($homepage!="") {
		$homepage = "<a href=\"$homepage\" target=\"_blank\">$lang_homepage</a>";
	}
	} else {
		$homepage = "";
	}
	
	if ($show_ip==1) {
		$srcIp = @getimagesize("$img_rootpath/$ip.gif");
		$ip = "<a href=\"http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=$ipnumber\" target=\"blank\"><img src=\"$img_relpath/ip.gif\" $srcIp[3] alt=\"$ipnumber\" border=\"0\" align=\"middle\" /></a>";
	} else {
		$ip = "";
	}
			  
	if ($count % 2 == 0) {
	$rowbgcolor = $bgcolor2;
	} else {
	$rowbgcolor = $bgcolor1;
	}
	
	$guesttext=str_replace("&lt;","&amp;lt;",$comment);
    $guesttext=str_replace("&gt;","&amp;gt;",$guesttext);
    $guesttext=str_replace("<","&lt;",$guesttext);
    $guesttext=str_replace(">","&gt;",$guesttext);
	$guesttext = bbcode($guesttext); //allow bbcodes
	$guesttext = nl2br($guesttext); //put in brs
	
	$guestname=str_replace("&lt;","&amp;lt;",$guestname);
    $guestname=str_replace("&gt;","&amp;gt;",$guestname);
    $guestname=str_replace("<","&lt;",$guestname);
    $guestname=str_replace(">","&gt;",$guestname);
	
	$country=str_replace("&lt;","&amp;lt;",$country);
    $country=str_replace("&gt;","&amp;gt;",$country);
    $country=str_replace("<","&lt;",$country);
    $country=str_replace(">","&gt;",$country);
	
	//parse smilies
	foreach ($sm_cache as $smilies) {
	if ($smilies[1]!="" and $smilies[3]!="") {
	$srcSmilie = @getimagesize("$sm_rootpath/$smilies[1]");     
	$guesttext = preg_replace("#".quotemeta($smilies[3])."#", "<img src=\"$sm_relpath/$smilies[1]\" alt=\"$smilies[2]\" $srcSmilie[3] border=\"0\" />", $guesttext);
	}
	}
	
	if (!$country) {
	$from = "";
	} else {
	$from = $lang_from;
	}
	
	$entry = array();
    $entry[] = array( 'guestname'	=> stripslashes($guestname),
                      'guesttext'	=> stripslashes($guesttext),
					  'answer'		=> stripslashes($answer),
                      'entrydate'	=> $entrydate,
					  'rowbgcolor'	=> $rowbgcolor,
					  'country'		=> stripslashes($country),
					  'avatar'		=> $filename,
					  'email'		=> stripslashes($email),
					  'ip'			=> $ip,
					  'homepage'	=> stripslashes($homepage),
					  'id' 			=> $id
                    );

//call guestbook template
$tpl = new template;
$tpl->load_file('entries', $dir_path."/templates/".$tpl_entries);
$tpl->parse_loop('entries', 'entry');
$output = $tpl->pprint('entries', array('pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','from','lang_wrote','entryno'));
$i++;
}
mysql_free_result($entries);

//show something when guestbook has no entries
if ($count!=0) {
	echo $output;
	} else {
	echo "<table border=\"0\" cellpadding=\"6\" cellspacing=\"0\" width=\"100%\">\n";
	echo "<tr>\n<td bgcolor=\"$bgcolor1\" class=\"text\">";
	echo "$lang_error_nogbentries";
	echo "</td>\n</tr>\n";
	echo "</table>\n";
	echo "<br /><br />";
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
	$time = $trimmedtime;
	$showquery = 1;
} else {
	$showquery = 0;
	$time = "";
}

//call footer template
$tpl = new template;
$tpl->load_file('foot', $dir_path."/templates/".$tpl_footer);
$tpl->parse_if('foot', 'sign');
$tpl->parse_if('foot', 'view');
$tpl->parse_if('foot', 'pageing');
$tpl->parse_if('foot', 'showquery');
$footer = $tpl->pprint('foot', array('gbname','logo','pagebgcolor','bgcolor1','bgcolor2','bgtablehead','bordercolor','tablebgcolor','tablewidth','webmasteremail','lang_signgb','lang_viewgb','copyright','lang_pagegen','lang_secs','lang_with','queries','lang_query','gzip','time','pagenums','stats','hits'));
echo $footer;

ob_end_flush();
?>

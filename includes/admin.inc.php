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

    // ########### Menu da Área Administrativa #############
    include($dir_path . '/includes/admin.menu.inc.php');

    echo $menu;
    echo $tabletop;

    if (!isset($_REQUEST['action'])) {
        $action = '';
    } else {
        $action = $_REQUEST['action'];
    }
	
	if (!isset($_REQUEST['PageNo'])) {
	$page = 1;
	} else {
	$page = $_REQUEST['PageNo'];
	}
	
	if (!isset($_REQUEST['id'])) {
	$id = 1;
	} else {
	$id = $_REQUEST['id'];
	}
	
	############# Paginando ################
	
	$count = 0;
	$StartRow= 0;

	if ($action == "entries" or $action=="quicksearch") {
		$page_size = 16;
		$pagenumshow = 10;
		$result = cnt_mysql_query("select count(id) from ".$db_prefix."book");  
		$RecordCount = mysql_result($result, 0, 0); 
	} elseif ($action == "avatars") {
		$page_size = 32;
		$pagenumshow = 10;
		$result = cnt_mysql_query("select count(id) from ".$db_prefix."avatars");  
		$RecordCount = mysql_result($result, 0, 0); 
	} elseif ($action == "smilies") {
		$page_size = 42;
		$pagenumshow = 10;
		$result = cnt_mysql_query("select count(id) from ".$db_prefix."smilies");  
		$RecordCount = mysql_result($result, 0, 0); 
	} else {
		$page_size = 1;
		$pagenumshow = 1;
		$RecordCount = 1;
	}

	//Configura o máximo da página
	$MaxPage = $RecordCount % $page_size;
	if ($RecordCount % $page_size == 0) {
   		$MaxPage = $RecordCount / $page_size;
	} else {
   		$MaxPage = ceil($RecordCount / $page_size);
	} 

	//Configura página como proibida
	if(empty($_GET['PageNo'])){
   		if ($StartRow == 0) {
   			$PageNo = $StartRow+1;
   		}
	} else {
		$PageNo = $_GET['PageNo'];
   		$StartRow = ($PageNo - 1) * $page_size;
	}

	//Configura o contador
	if($PageNo % $pagenumshow == 0){
    	$CounterStart = $PageNo - ($pagenumshow-1);
	} else {
    	$CounterStart = $PageNo - ($PageNo % $pagenumshow)+1;
	}

	//Fim do contador
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
 
	
	// ################# exibe entradas ###############
	if($action == "entries") {
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
	echo "<td><b>$lang_records</b></td>";
	echo "<td align=\"right\">".pageing()."</td>";
	echo "</tr>\n</table>";
	echo "<br />";
	echo "<form name=\"form\" action=\"admin.php?action=delentry\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"qc\" value=\"0\" />\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" align=\"right\" width=\"1%\">&nbsp;<b>ID</b>&nbsp;</td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\">&nbsp;<b>$lang_date</b></td>\n";	
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"96%\"><b>$lang_name</b></td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\" nowrap=\"nowrap\"><b>$lang_email</b></td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\" nowrap=\"nowrap\"><b>&nbsp;$lang_ip</b></td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\"><b>$lang_status</b></td>\n";	
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" align=\"center\"><input name=\"allbox\" type=\"checkbox\" onclick=\"CheckAll();\" title=\"$lang_checkall\" /></td>\n";
	

	echo "</tr>\n"; 
	$query = "SELECT id, online, name, comments, email, ip, FROM_UNIXTIME(datetime) FROM ".$db_prefix."book ORDER BY $sort_after $sort_order LIMIT $StartRow, $page_size";
	$result = cnt_mysql_query($query);

	while (list($id, $status, $name, $comments, $email, $ip, $datetime) = mysql_fetch_row($result)) { 
		
		$count++;
			  
		if ($count % 2 == 0) {
		$rowbgcolor = $bgcolor2;
		} else {
		$rowbgcolor = $bgcolor1;
		}
		
		$trcomments = str_replace("\"","'",htmlspecialchars(stripslashes($comments)));
		
		$trcomments=str_replace("&lt;","&amp;lt;",trcomments);
   		$trcomments=str_replace("&gt;","&amp;gt;",trcomments);
    	$trcomments=str_replace("<","&lt;",trcomments);
    	$trcomments=str_replace(">","&gt;",trcomments);
		
		$comments = stripslashes($comments);
		$name = stripslashes($name);
		$email = stripslashes(trim($email));
		
		$name=str_replace("&lt;","&amp;lt;",$name);
   		$name=str_replace("&gt;","&amp;gt;",$name);
    	$name=str_replace("<","&lt;",$name);
    	$name=str_replace(">","&gt;",$name);
		
		if ($email=="") {
		$mail = "&#8212;";
		} else {
		$srcImg = @getimagesize("$img_rootpath/email.gif");
		$mail = "<a href=\"mailto:$email\"><img src=\"$img_relpath/email.gif\" alt=\"$email\" $srcImg[3] border=\"0\" /></a>";
		}
		
		if ($status == "1") {
		$srcImg = @getimagesize("$img_rootpath/online.gif");
		$status = "<a href=\"admin.php?action=switchoff&amp;id=$id&amp;PageNo=$page\"><img src=\"$img_relpath/online.gif\" alt=\"$lang_isonline\" border=\"0\" $srcImg[3] /></a>";
		} else {
		$srcImg = @getimagesize("$img_rootpath/offline.gif");
		$status = "<a href=\"admin.php?action=switchon&amp;id=$id&amp;PageNo=$page\"><img src=\"$img_relpath/offline.gif\" alt=\"$lang_isoffline\" border=\"0\" $srcImg[3] /></a>";
		}
		
		echo "<tr title=\"$trcomments\">\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"right\">&nbsp;$id&nbsp;</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" nowrap=\"nowrap\">&nbsp;$datetime&nbsp;</td>\n";
		
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\"><a href=\"admin.php?action=entrydetail&amp;id=$id\">$name</a></td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\">$mail</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\">&nbsp;<a href=\"http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=$ip\" target=\"_blank\">$ip</a>&nbsp;</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\">$status</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\"><input type=\"checkbox\" name=\"entry[]\" title=\"$lang_delete\" value=\"$id\" /></td>\n";	
		echo "</tr>\n";
		}
	if (mysql_num_rows($result) == "") {
	echo "<tr>\n<td colspan=\"7\" bgcolor=\"$bgcolor1\" class=\"error\">";
	echo "$lang_error_noentries";
	echo "</td>\n</tr>";
	}

    echo "</table>";
    echo "<br /><div align=\"center\"><input type=\"submit\" value=\"$lang_delentries\" /></div>\n";
	echo "</form>";
    echo "<p align=\"center\" class=\"text\">".pageing()."</p>";
	mysql_free_result($result);	
	}
		
	// ################# busca rápida #################
	if ($action == "quicksearch") {
	
	$searchword = $_REQUEST['qc'];
	
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
	echo "<td><b>$lang_quicksearch</b></td>";
	echo "<td align=\"right\">".pageing()."</td>";
	echo "</tr>\n</table>";
	echo "<br />";
	echo "<form name=\"form\" action=\"admin.php?action=delentry\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"qc\" value=\"0\" />\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" align=\"right\" width=\"1%\">&nbsp;<b>ID</b>&nbsp;</td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\">&nbsp;<b>$lang_date</b></td>\n";	
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"96%\"><b>$lang_name</b></td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\" nowrap=\"nowrap\"><b>$lang_email</b></td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\" nowrap=\"nowrap\"><b>&nbsp;$lang_ip</b></td>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" width=\"1%\"><b>$lang_status</b></td>\n";	
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" align=\"center\"><input name=\"allbox\" type=\"checkbox\" onclick=\"CheckAll();\" title=\"$lang_checkall\" /></td>\n";
	echo "</tr>\n";
    
	$query = "SELECT id, online, name, comments, email, ip, FROM_UNIXTIME(datetime) FROM ".$db_prefix."book WHERE (name LIKE '%$searchword%' or comments LIKE '%$searchword%' or email LIKE '%$searchword%' or ip LIKE '%$searchword%') ORDER BY id DESC LIMIT $StartRow, $page_size";
	$result = cnt_mysql_query($query);
	
	while (list($id, $status, $name, $comments, $email, $ip, $datetime) = mysql_fetch_row($result)) { 
		
		$count++;
			  
		if ($count % 2 == 0) {
		$rowbgcolor = $bgcolor2;
		} else {
		$rowbgcolor = $bgcolor1;
		}
		
		$comments = stripslashes(htmlspecialchars($comments));
		$name = stripslashes(trim($name));
		$email = stripslashes(trim($email));
		
		if ($email=="") {
		$mail = "&#8212;";
		} else {
		$srcImg = @getimagesize("$img_rootpath/$filename");
		$mail = "<a href=\"mailto:$email\"><img src=\"$img_relpath/email.gif\" alt=\"$email\" $srcImg[3] border=\"0\" /></a>";
		}
		
		if ($status == "1") {
		$srcImg = @getimagesize("$img_rootpath/online.gif");
		$status = "<a href=\"admin.php?action=switchoff&amp;qc=$searchword&amp;id=$id&amp;PageNo=$page\"><img src=\"$img_relpath/online.gif\" alt=\"$lang_isonline\" border=\"0\" $srcImg[3] /></a>";
		} else {
		$srcImg = @getimagesize("$img_rootpath/offline.gif");
		$status = "<a href=\"admin.php?action=switchon&amp;&amp;qc=$searchword&amp;id=$id&amp;PageNo=$page\" /><img src=\"$img_relpath/offline.gif\" alt=\"$lang_isoffline\" border=\"0\" $srcImg[3] /></a>";
		}
		
		echo "<tr title=\"$comments\">\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"right\">&nbsp;$id&nbsp;</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" nowrap=\"nowrap\">&nbsp;$datetime&nbsp;</td>\n";
		
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\"><a href=\"admin.php?action=entrydetail&amp;id=$id\">$name</a></td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\">$mail</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\">&nbsp;<a href=\"http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=$ip\" target=\"_blank\">$ip</a>&nbsp;</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\">$status</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\"><input type=\"checkbox\" name=\"entry[]\" title=\"$lang_delete\" value=\"$id\" /></td>\n";	
		echo "</tr>\n";
		}
	if (mysql_num_rows($result) == "") {
	echo "<tr>\n<td colspan=\"7\" bgcolor=\"$bgcolor1\" class=\"error\">";
	echo "$lang_error_nomatch";
	echo "</td>\n</tr>";
	}
				
    echo "</table>";
    echo "<br /><div align=\"center\"><input type=\"submit\" value=\"$lang_delentries\" /></div>\n";
	echo "</form>";
    echo "<p align=\"center\" class=\"text\">".pageing()."</p>";
	mysql_free_result($result);	
	}

	// ################# exclui entradas ###############
	if($action == "delentry") {
	
	if (!isset($HTTP_POST_VARS['entry']) or $HTTP_POST_VARS['entry']=="") {
	echo "<span class=\"error\"><b>$lang_error</b></span><br />";
	echo "$lang_error_noentry_selected";
	echo "<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>";
	echo "</td>\n</tr>\n</table>\n";
	echo $tablebottom;
	errorend();
	} else {
	$entry = $HTTP_POST_VARS['entry'];
	}
	
	echo "<b>$lang_records $lang_delete</b>";
	echo "<br /><br />";
	
    $searchword = $HTTP_POST_VARS['qc'];;
	if ($searchword == "0") {
    	$entryids = "";
        if (!empty($entry)) {
        	foreach ($entry as $val) {
            	$entryids .= (($entryids != "") ? ", " : "") . $val;
            } 
        } 
    } else {
    	$entryids = $entry;
    } 
	
	$query = "SELECT id FROM ".$db_prefix."book WHERE id IN ($entryids)";
    $result = cnt_mysql_query($query) or 
	die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_delentry<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
	 
	while ($row = mysql_fetch_array($result)) {
       
	   if ($admindisable != 1) {
       $querydel = "DELETE FROM ".$db_prefix."book WHERE id=".$row['id'];
       $resultdel = cnt_mysql_query($querydel) or 
	   die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_delentry $row[id]<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
	   echo "-> $lang_record $row[id] $lang_deleted<br />";
	   } 
	 }
	   
	  mysql_free_result($result);	  
	  header("Location: admin.php?action=entries&PageNo=".$page);
	}
	
	// ################# exibe detalhes ###############
	if($action == "entrydetail") {
	
	echo "<b>$lang_entry $lang_details</b>";
	echo "<br /><br />";	
	echo "<form name=\"form1\" method=\"post\" action=\"admin.php?action=updateentry\">\n";
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
    echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\">\n";

    $query = "SELECT b.id,b.name,b.avatar,b.email,b.homepage,b.country,b.comments,b.answer,FROM_UNIXTIME(b.datetime),b.ip,b.online,a.filename,a.alttag 
	FROM ".$db_prefix."book as b
	LEFT JOIN ".$db_prefix."avatars as a
	ON b.avatar=a.id
	WHERE b.id=$id
	GROUP BY b.id";
    $result = cnt_mysql_query($query);

    while (list($id,$from,$avatar,$email,$homepage,$country,$comments,$answer,$datetime,$ip,$online,$filename,$alttag) = mysql_fetch_row($result)) {
    
	$from = str_replace("\"", "&quot;", stripslashes($from));
    $comments = str_replace("\"", "&quot;", stripslashes($comments));
	$homepage = str_replace("\"", "", stripslashes($homepage));
	$email = str_replace("\"", "", stripslashes($email));
	$answer = str_replace("\"", "&quot;", stripslashes($answer));
	$country = str_replace("\"", "&quot;", stripslashes($country));
	$datetime = str_replace("\"", "", stripslashes($datetime));
	$ip = str_replace("\"", "", stripslashes($ip));
	$avatar = str_replace("\"", "", stripslashes($avatar));
	$alttag = str_replace("\"", "", stripslashes($alttag));
	
	if ($avatar!=0) {
	$srcAvatar = @getimagesize("$av_rootpath/$filename");
	$avatarimg = "<img src=\"$av_relpath/$filename\" $srcAvatar[3] border=\"0\" alt=\"$alttag\" />";
	} else {
	$avatarimg = "";
	}

    	echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_name:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"from\" value=\"$from\" size=\"54\" /></td>\n";
		echo "<td rowspan=\"10\">&nbsp;&nbsp;</td>";
		echo "<td rowspan=\"10\" valign=\"top\">$avatarimg</td>";
        echo "</tr>\n";
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_date:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"datetime\" value=\"$datetime\" size=\"54\" /></td>\n";
        echo "</tr>\n";
            
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" class=\"text\"><b>$lang_comment:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><textarea name=\"comments\" cols=\"40\" rows=\"7\"  style=\"wrap:virtual\">$comments</textarea></td>\n";
        echo "</tr>\n";
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" class=\"text\"><b>$lang_answer:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><textarea name=\"answer\" cols=\"40\" rows=\"6\"  style=\"wrap:virtual\">$answer</textarea></td>\n";
        echo "</tr>\n";
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_country:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"country\" value=\"$country\" size=\"54\" /></td>\n";
        echo "</tr>\n";
			
		if ($email!="") {
			$mail = "<a href=\"mailto:$email\">$lang_email</a>";
		} else {
			$mail = "$lang_email";
		}
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$mail:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"email\" value=\"$email\" size=\"54\" /></td>\n";
        echo "</tr>\n";
			
		if ($homepage!="") {
			$hp = "<a href=\"$homepage\" target=\"_blank\">$lang_homepage</a>";
		} else {
			$hp = "$lang_homepage";
		}
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$hp:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"homepage\" value=\"$homepage\" size=\"54\" /></td>\n";
        echo "</tr>\n";
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b><a href=\"http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=$ip\" target=\"_blank\">$lang_ip</a>:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"ip\" value=\"$ip\" size=\"54\" /></td>\n";
        echo "</tr>\n";
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_avatar ID:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"avatar\" value=\"$avatar\" size=\"54\" /></td>\n";
        echo "</tr>\n";
			
		if ($online==1) {
			$onlinemark = " checked=\"checked\"";
			$offlinemark = "";
		} else {
			$onlinemark = "";
			$offlinemark = "checked=\"checked\"";
		}
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_status:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><input name=\"status\" type=\"radio\" value=\"1\"$onlinemark />$lang_isonline&nbsp;&nbsp;<input name=\"status\" type=\"radio\" value=\"0\"$offlinemark />$lang_isoffline</td>";
         echo "</tr>\n";
			
         echo "<tr>\n";
         echo "<td bgcolor=\"$bgcolor1\" class=\"text\">&nbsp;</td>\n";
         echo "<td bgcolor=\"$bgcolor1\"><input type=\"submit\" value=\"$lang_record $lang_edit\" /></td>";
         echo "</tr>\n";
    } 
        mysql_free_result($result);

        echo "</table>\n";
        echo "</form>";
	}
	
	// ################# atualiza entradas ###############
	if($action == "updateentry") {
	
	$id = $HTTP_POST_VARS['id'];
	$from = addslashes($HTTP_POST_VARS['from']);
	$avatar = addslashes($HTTP_POST_VARS['avatar']);
	$email = addslashes($HTTP_POST_VARS['email']);
	$homepage = addslashes($HTTP_POST_VARS['homepage']);
	$country = addslashes($HTTP_POST_VARS['country']);
	$comments = addslashes($HTTP_POST_VARS['comments']);
	$answer = addslashes($HTTP_POST_VARS['answer']);
	$ip = addslashes($HTTP_POST_VARS['ip']);
	$status = $HTTP_POST_VARS['status'];
	$datetime = $HTTP_POST_VARS['datetime'];
	
	if ($from=="" or $comments=="" or $ip=="") {	
	echo "<b>$lang_error</b><br />";
	echo "<span class=\"error\">$lang_error_editentry</span><br /><br />";
	echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
	echo "</td>\n</tr>\n</table>\n";
	echo $tablebottom;
	errorend();
	}
	
	if ($datetime=="") {
		$datetime=time();
	} else {
		$datetime = date('U', strtotime($datetime));
	}
	
	if ($admindisable != 1) {
	$query = "UPDATE ".$db_prefix."book SET name='$from',avatar='$avatar',email='$email',homepage='$homepage',country='$country',comments='$comments',answer='$answer',datetime='$datetime',ip='$ip',online='$status' WHERE id=$id";
	
	$result = cnt_mysql_query($query) or 
	die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_doupdate<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>"); 
	mysql_free_result($result);	
	}
	
	header("Location: admin.php?action=entries&PageNo=".$page);
	}
	
	// ################# compartilha online ###############
	if($action == "switchon") {
	
	if ($admindisable != 1) {
		$query = "UPDATE ".$db_prefix."book SET online=1 WHERE id=$id";
		$result = cnt_mysql_query($query);
		mysql_free_result($result);
	}
	
	if (isset($_GET['qc'])) {
	$qc = $_GET['qc'];
	header("Location: admin.php?action=quicksearch&qc=".$qc."&PageNo=".$page);	
	} elseif (isset($_GET['mod'])) {
	header("Location: admin.php");
	} else {
	header("Location: admin.php?action=entries&PageNo=".$page);
	}
	}
	
	// ################# compartilha offline ###############
	if($action == "switchoff") {
	
	if ($admindisable != 1) {
		$query = "UPDATE ".$db_prefix."book SET online=0 WHERE id=$id";
		$result = cnt_mysql_query($query);
		mysql_free_result($result);
	}
	
	if (!isset($_GET['qc'])) {
	header("Location: admin.php?action=entries&PageNo=".$page);
	} else {
	$qc = $_GET['qc'];
	header("Location: admin.php?action=quicksearch&qc=".$qc."&PageNo=".$page);
	}
	}
	
	// ################# exibe avatars ###############
	if($action == "avatars") {
	$avcount = 0;
	$avfile = "";
	$avcolumn = 4;
	
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
	echo "<td><b>$lang_avatars</b></td>";
	echo "<td align=\"right\"><a href=\"admin.php?action=uploadavatar\">$lang_uploadavatar</a></td>";
	echo "</tr>\n</table>";
	echo "<br />";

	echo "<table border=\"0\" cellpadding=\"6\" cellspacing=\"1\" width=\"100%\">\n";	
	$query = "SELECT id,filename,alttag,sort FROM ".$db_prefix."avatars ORDER BY sort ASC LIMIT $StartRow, $page_size";
    $result = cnt_mysql_query($query);

    while (list($id,$filename,$alttag,$sort) = mysql_fetch_row($result)) {
	
	$filename = str_replace("\"", "", stripslashes($filename));
	$filename = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $filename); 
	$alttag = str_replace("\"", "", stripslashes($alttag));
	$sort = str_replace("\"", "", stripslashes($sort));
	
	if (!file_exists("$av_rootpath/$filename") or $filename=="") {
		$filename = "error_avatar.gif";
	}
		
	if ($avcount % $avcolumn == 0) {
		if ($avcount!=0) {
			$avfile .= "</tr>\n";
		}
	$avfile .= "<tr>\n";
		}

	if ($id!="") {
		$srcAvatar = @getimagesize("$av_rootpath/$filename");
		$avfile .= "<td bgcolor=\"$bgcolor1\">";
		$avfile .= "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">\n";
		$avfile .= "<tr>\n<td width=\"50%\" align=\"center\">";
		$avfile .= "<img src=\"$av_relpath/$filename\" $srcAvatar[3] alt=\"$filename\n$alttag\" border=\"0\" /></td>";
		$avfile .= "<td>&nbsp;</td>";
		$avfile .= "<td class=\"text\" width=\"50%\"><b>ID: $id</b><br /><a href=\"admin.php?action=editavatar&amp;id=$id&amp;PageNo=$page\">$lang_edit2</a><br /><a href=\"admin.php?action=delavatar&amp;id=$id&amp;file=$filename&amp;PageNo=$page\">$lang_delete</a></td>\n";
		$avfile .= "</tr>\n</table>\n";
		$avfile .= "</td>\n";
	}

	$avcount++;
	}
	
	if (mysql_num_rows($result) == 0) {
		$avfile .= "<td class=\"error\" colspan=\"$avcolumn\" bgcolor=\"$bgcolor1\">$lang_error_noavatars</td>";
	}
		echo $avfile;
		echo "</tr>\n</table>\n";
		echo "<p align=\"center\" class=\"text\">".pageing()."</p>";
		mysql_free_result($result);
	}
	
	// ################# sobe avatars ###############
	if($action == "uploadavatar") {
	echo "<b>$lang_uploadavatar</b>";
	echo "<br /><br />";
	
    $result = cnt_mysql_query("SELECT MAX(sort)+1 FROM ".$db_prefix."avatars");
	list($sortid) = mysql_fetch_row($result);
	
	echo "<form name=\"form1\" method=\"post\" action=\"admin.php?action=newav\" enctype=\"multipart/form-data\">\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
    echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\">\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\" nowrap=\"nowrap\"><b>$lang_avname:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" nowrap=\"nowrap\"><input type=\"text\" name=\"avname\" value=\"$lang_newavatar\" size=\"45\" /></td>\n";
	echo "<td rowspan=\"4\">&nbsp;&nbsp;</td>";
	echo "<td rowspan=\"4\" valign=\"top\">$lang_filetypes_allowed</td>";
    echo "</tr>\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\" nowrap=\"nowrap\"><b>$lang_sort:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" nowrap=\"nowrap\"><input type=\"text\" name=\"avsort\" size=\"45\" value=\"$sortid\" /></td>\n";
    echo "</tr>\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\" nowrap=\"nowrap\"><b>$lang_avfile:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\" nowrap=\"nowrap\"><input type=\"file\" name=\"avfile\" /></td>\n";
    echo "</tr>\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\">&nbsp;</td>\n";
    echo "<td bgcolor=\"$bgcolor1\"><input type=\"submit\" value=\"$lang_avupload\" /></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
	mysql_free_result($result);
	}
	
	// ################### faz possível subir avatars ###################
	if ($action=="newav") {
	
	 $picname = $_FILES['avfile']['name'];
	 $picname = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $picname); 
	 $pictyp = $_FILES['avfile']['type'];
	 $picsize = $_FILES['avfile']['size'];
	 $pictemp = $_FILES['avfile']['tmp_name'];
	 $avname = addslashes($HTTP_POST_VARS['avname']);
	 $avsort = addslashes($HTTP_POST_VARS['avsort']);
	 
	  if ($picname == "") {
	 	echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_nopic</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
	 }
	 
	 checkfile ($av_rootpath."/$picname"); 
	 $extension = "\.gif$|\.jpg$|\.png$";
	 checkextension ($extension,$av_rootpath."/$picname");	
	
	 if ($admindisable != 1) {
     	copy ($pictemp, "$av_rootpath/" . $picname) 
	 	or die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_doavupload<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
	  
	  	$sql = "INSERT INTO ".$db_prefix."avatars (id,filename,alttag,sort) VALUES (NULL,'$picname','$avname','$avsort')";
	 	$result = cnt_mysql_query($sql) or
	 	die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_doavupload<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>"); 
		mysql_free_result($result);
	 	} 
	 	header("Location: admin.php?action=avatars&PageNo=".$page); 	    		  
	}
	
	################# exclui avatar ###############
	if($action == "delavatar") {
	
	$file=$_GET['file'];
	
	if ($admindisable != 1) {
		$query = "DELETE FROM ".$db_prefix."avatars WHERE id=$id";
    	$result = cnt_mysql_query($query) or 
		die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_delavatar<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
	
	//update gb entries where avatar was used
		$query = "UPDATE ".$db_prefix."book SET avatar='0' WHERE avatar=$id";
    	$result = cnt_mysql_query($query) or 
		die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_delavatargb<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
			
	     if (file_exists("$av_rootpath/$file")) {
         	unlink("$av_rootpath/$file");
         } 
		 mysql_free_result($result);
	}
	
	header("Location: admin.php?action=avatars&PageNo=".$page);
	}
	
	// ################# exibe detalhes de avatar ###############
	if ($action == "editavatar") {
	echo "<b>$lang_avatar $lang_details</b>";
	echo "<br /><br />";
	
	echo "<form name=\"form1\" method=\"post\" action=\"admin.php?action=updateavatar\">\n";
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
    echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\">\n";

    $query = "SELECT id,filename,alttag,sort FROM ".$db_prefix."avatars WHERE id=$id";
    $result = cnt_mysql_query($query);

    while (list($id,$filename,$alttag,$sort) = mysql_fetch_row($result)) {
    
	$filename = str_replace("\"", "", stripslashes($filename));
	$filename = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $filename);
	$alttag = str_replace("\"", "", stripslashes($alttag));
	$sort = str_replace("\"", "", stripslashes($sort));
	
	if ($id!="") {
	$srcAvatar = @getimagesize("$av_rootpath/$filename");
	$avatarimg = "<img src=\"$av_relpath/$filename\" $srcAvatar[3] alt=\"$alttag\" border=\"0\" />";
	} else {
	$avatarimg = "";
	}
	
	if (!file_exists("$av_rootpath/$filename") or $filename=="") {
		$srcError = @getimagesize("$av_rootpath/error_avatar.gif");
		$avatarimg = "<img src=\"$av_relpath/error_avatar.gif\" $srcError[3] alt=\"$lang_error\" border=\"0\" />";
	} 

    	echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_filename:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"avfile\" value=\"$filename\" size=\"54\" /></td>\n";
		echo "<td rowspan=\"10\">&nbsp;&nbsp;</td>";
		echo "<td rowspan=\"10\" valign=\"top\">$avatarimg</td>";
        echo "</tr>\n";
		
		echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_avname:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"avname\" value=\"$alttag\" size=\"54\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_sort:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"avsort\" value=\"$sort\" size=\"54\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
    	echo "<td bgcolor=\"$bgcolor1\" class=\"text\">&nbsp;</td>\n";
    	echo "<td bgcolor=\"$bgcolor1\"><input type=\"submit\" value=\"$lang_avatar $lang_edit\" /></td>\n";
    	echo "</tr>\n";
		
	}
	echo "</table>";
	echo "</form>";
	mysql_free_result($result);
	}
	
	// ################# torna possível subir avatar ###############
	if($action == "updateavatar") {
	
	$avname = addslashes($HTTP_POST_VARS['avname']);
	$avsort = addslashes($HTTP_POST_VARS['avsort']);
	$avfile = addslashes($HTTP_POST_VARS['avfile']);
	$avfile = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $avfile); 
	
	 if ($avfile == "") {
	 	echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_nofilename</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
	 }
	
	if ($admindisable != 1) {
	$query = "UPDATE ".$db_prefix."avatars SET filename='$avfile',alttag='$avname',sort='$avsort' WHERE id=$id";
	$result = cnt_mysql_query($query) or
	die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_avatarupdate<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
	mysql_free_result($result);
	}
	
	header("Location: admin.php?action=avatars&PageNo=".$page);
	}
	
	################# exibe smilies ###############
	if($action == "smilies") {
	
	$smcount = 0;
	$smfile = "";
	$smcolumn = 6;
	
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
	echo "<td class=\"text\"><b>$lang_smilies</b></td>";
	echo "<td align=\"right\"><a href=\"admin.php?action=uploadsmiley\">$lang_uploadsmiley</a></td>";
	echo "</tr>\n</table>";
	echo "<br />";

	echo "<table border=\"0\" cellpadding=\"6\" cellspacing=\"1\" width=\"100%\">\n";	
	$query = "SELECT id,filename,alttag,sort FROM ".$db_prefix."smilies ORDER BY sort ASC LIMIT $StartRow, $page_size";
    $result = cnt_mysql_query($query);

    while (list($id,$filename,$alttag,$sort) = mysql_fetch_row($result)) {
	
	$filename = str_replace("\"", "", stripslashes($filename));
	$filename = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $filename); 
	$alttag = str_replace("\"", "", stripslashes($alttag));
	$sort = str_replace("\"", "", stripslashes($sort));
	
	if (!file_exists("$sm_rootpath/$filename") or $filename=="") {
		$filename = "error.gif";
	}
		
	if ($smcount % $smcolumn == 0) {
		if ($smcount!=0) {
			$smfile .= "</tr>\n";
		}
			$smfile .= "<tr>\n";
		}

	if ($id!="") {
		$srcSmilie = @getimagesize("$sm_rootpath/$filename");
		$smfile .= "<td bgcolor=\"$bgcolor1\">";
		$smfile .= "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">\n";
		$smfile .= "<tr>\n<td width=\"50%\" align=\"center\">";
		$smfile .= "<img src=\"$sm_relpath/$filename\" $srcSmilie[3] alt=\"$filename\n$alttag\" border=\"0\" /></td>";
		$smfile .= "<td>&nbsp;</td>";
		$smfile .= "<td class=\"text\" width=\"50%\"><b>ID: $id</b><br /><a href=\"admin.php?action=editsmiley&amp;id=$id&amp;PageNo=$page\">$lang_edit2</a><br /><a href=\"admin.php?action=delsmiley&amp;id=$id&amp;file=$filename&amp;PageNo=$page\">$lang_delete</a></td>\n";
		$smfile .= "</tr>\n</table>\n";
		$smfile .= "</td>\n";
	}

	$smcount++;
	}
	
	if (mysql_num_rows($result) == 0) {
		$smfile .= "<td class=\"error\" colspan=\"$smcolumn\" bgcolor=\"$bgcolor1\">$lang_error_nosmilies</td>";
	}
		echo $smfile;
		echo "</tr>\n</table>\n";
		
		echo "<p align=\"center\" class=\"text\">".pageing()."</p>";
		mysql_free_result($result);
	}
	
	// ################# envia smiley ###############
	if($action == "uploadsmiley") {
	echo "<b>$lang_uploadsmiley</b>";
	echo "<br /><br />";
	
    $result = cnt_mysql_query("SELECT MAX(sort)+1 FROM ".$db_prefix."smilies");
	list($sortid) = mysql_fetch_row($result);
	
	echo "<form name=\"form1\" method=\"post\" action=\"admin.php?action=newsm\" enctype=\"multipart/form-data\">\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
    echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\">\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\" nowrap=\"nowrap\"><b>$lang_smname:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" nowrap=\"nowrap\"><input type=\"text\" name=\"smname\" size=\"45\" value=\"$lang_newsmiley\" /></td>\n";
	echo "<td rowspan=\"4\">&nbsp;&nbsp;</td>";
	echo "<td rowspan=\"4\" valign=\"top\">$lang_filetypes_allowed</td>";
    echo "</tr>\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\" nowrap=\"nowrap\"><b>$lang_smcode:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" nowrap=\"nowrap\"><input type=\"text\" name=\"smcode\" size=\"45\" /></td>\n";
    echo "</tr>\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\" nowrap=\"nowrap\"><b>$lang_sort:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" nowrap=\"nowrap\"><input type=\"text\" name=\"smsort\" size=\"45\" value=\"$sortid\" /></td>\n";
    echo "</tr>\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\" nowrap=\"nowrap\"><b>$lang_smfile:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\"  nowrap=\"nowrap\"><input type=\"file\" name=\"smfile\" /></td>\n";
    echo "</tr>\n";
	
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\">&nbsp;</td>\n";
    echo "<td bgcolor=\"$bgcolor1\"><input type=\"submit\" value=\"$lang_smupload\" /></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
	mysql_free_result($result);
	
	}
	
	// ################### torna possível subir smiley ###################
	if ($action=="newsm") {
	
	 $picname = $_FILES['smfile']['name'];
	 $picname = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $picname); 
	 $pictyp = $_FILES['smfile']['type'];
	 $picsize = $_FILES['smfile']['size'];
	 $pictemp = $_FILES['smfile']['tmp_name'];
	 $smname = addslashes($HTTP_POST_VARS['smname']);
	 $smsort = addslashes($HTTP_POST_VARS['smsort']);
	 $smcode = addslashes($HTTP_POST_VARS['smcode']);
	 
	 if ($picname == "") {
	 	echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_nopic</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
	 }
	 
	 if ($smcode == "") {
	 	echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_nosmcode</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
	 }
	 
	 checkfile ($sm_rootpath."/$picname");	 
	 $extension = "\.gif$|\.jpg$|\.png$";
	 checkextension ($extension,$sm_rootpath."/$picname");
	 
	 if ($admindisable != 1) {	
     copy ($pictemp, "$sm_rootpath/" . $picname) 
	 or die ("<span class=\"error\"><b>$lang_error</b></span><br /><br />$lang_error_dosmupload<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
	 
	 $sql = "INSERT INTO ".$db_prefix."smilies (id,filename,alttag,sort,code) VALUES (NULL,'$picname','$smname','$smsort','$smcode')";
	 $result = cnt_mysql_query($sql) or
	 die ("<span class=\"error\"><b>$lang_error</b></span><br /><br />$lang_error_dosmupload<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>"); 
	 mysql_free_result($result);
	 }	 
	 
	 header("Location: admin.php?action=smilies&PageNo=".$page);   		  
	}
	
	// ################# exibe detalhes de smiley ###############
	if ($action == "editsmiley") {
	echo "<b>$lang_smiley $lang_details</b>";
	echo "<br /><br />";
	
	echo "<form name=\"form1\" method=\"post\" action=\"admin.php?action=updatesmiley\">\n";
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
    echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\">\n";

    $query = "SELECT id,filename,alttag,sort,code FROM ".$db_prefix."smilies WHERE id=$id";
    $result = cnt_mysql_query($query);

    while (list($id,$filename,$alttag,$sort,$code) = mysql_fetch_row($result)) {
    
	$filename = str_replace("\"", "", stripslashes($filename));
	$filename = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $filename);
	$alttag = str_replace("\"", "", stripslashes($alttag));
	$sort = str_replace("\"", "", stripslashes($sort));
	$code = str_replace("\"", "", stripslashes($code));
	
	
	if ($id!="") {
		$srcSmiley = @getimagesize("$sm_rootpath/$filename");
		$smileyimg = "<img src=\"$sm_relpath/$filename\" $srcSmiley[3] alt=\"$alttag\" border=\"0\" />";
	} else {
		$smileyimg = "";
	}
	
	if (!file_exists("$sm_rootpath/$filename") or $filename=="") {
		$srcError = @getimagesize("$sm_rootpath/error.gif");
		$smileyimg = "<img src=\"$sm_relpath/error.gif\" $srcError[3] alt=\"$lang_error\" border=\"0\" />";
	} 
	
    	echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_filename:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"smfile\" value=\"$filename\" size=\"54\" /></td>\n";
		echo "<td rowspan=\"10\">&nbsp;&nbsp;</td>";
		echo "<td rowspan=\"10\" valign=\"top\">$smileyimg</td>";
        echo "</tr>\n";
		
		echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_smname:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"smname\" value=\"$alttag\" size=\"54\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_smcode:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"smcode\" value=\"$code\" size=\"54\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
		echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_sort:</b></td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"smsort\" value=\"$sort\" size=\"54\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
    	echo "<td bgcolor=\"$bgcolor1\" class=\"text\">&nbsp;</td>\n";
    	echo "<td bgcolor=\"$bgcolor1\"><input type=\"submit\" value=\"$lang_smiley $lang_edit\" /></td>\n";
    	echo "</tr>\n";
		
	}
	echo "</table>";
	echo "</form>";
	mysql_free_result($result);
	}
	
	// ################# torna possível subir smilies ###############
	if($action == "updatesmiley") {
	
	$smname = addslashes($HTTP_POST_VARS['smname']);
	$smsort = addslashes($HTTP_POST_VARS['smsort']);
	$smfile = addslashes($HTTP_POST_VARS['smfile']);
	$smfile = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $smfile); 
	$smcode = addslashes($HTTP_POST_VARS['smcode']);
	
	if ($smfile == "") {
	 	echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_nofilename</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
	 }
	 
	 if ($smcode == "") {
	 	echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_nosmcode</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
	 }
	
	if ($admindisable != 1) {
	$query = "UPDATE ".$db_prefix."smilies SET filename='$smfile',alttag='$smname',sort='$smsort',code='$smcode' WHERE id=$id";
	$result = cnt_mysql_query($query) or
	die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_smileyupdate<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
	mysql_free_result($result);
	}
	
	header("Location: admin.php?action=smilies&PageNo=".$page);
	}
	
	// ################# exclui smiley ###############
	if($action == "delsmiley") {
		$file = $_GET['file'];
	
	if ($admindisable != 1) {
		$query = "DELETE FROM ".$db_prefix."smilies WHERE id=$id";
    	$result = cnt_mysql_query($query) or 
		die ("<span class=\"error\"><b>$lang_error</b></span><br />$lang_error_delsmiley<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
		
		 if (file_exists("$sm_rootpath/$file")) {
         	unlink("$sm_rootpath/$file");
         } 
		 mysql_free_result($result);		 
	}
	
	header("Location: admin.php?action=smilies&PageNo=".$page);
	}
	
	// ################# exibe templates ###############
	if($action == "templates") {
	$num = 0;

	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
	echo "<td><b>$lang_templates</b></td>";
	echo "<td align=\"right\"><a href=\"admin.php?action=newtemp\">$lang_makenewtemp</a></td>\n";
	echo "</tr>\n</table>";
	echo "<br />";
	
	echo "$lang_template_intro<br />";
	
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n";
	echo "<tr>\n";
	echo "<td bgcolor=\"$bgtablehead\" width=\"1%\" align=\"right\" class=\"tablehl\">&nbsp;#&nbsp;</td>";
	echo "<td bgcolor=\"$bgtablehead\" class=\"tablehl\">$lang_templatename</td>";
	echo "<td bgcolor=\"$bgtablehead\" width=\"1%\" class=\"tablehl\" colspan=\"4\" align=\"center\">&nbsp;$lang_action</td>\n";
	echo "</tr>\n";

	//Define an array;
	$exts = array("\.html$");
	$dir = opendir($dir_path."/templates/");
	$files = readdir($dir);
	while (false !== ($files = readdir($dir))) {	
		foreach ($exts as $value) {
		 if ($files != "." && $files != "..") {
		 
		 $num++;
		 
			echo "<tr>\n";
			echo "<td bgcolor=\"$bgcolor1\" width=\"1%\" align=\"right\" class=\"text\">&nbsp;$num&nbsp;</td>";
			echo "<td bgcolor=\"$bgcolor1\" class=\"text\" width=\"94%\">$files</td>";
			echo "<td bgcolor=\"$bgcolor1\" width=\"1%\" class=\"text\">&nbsp;<a href=\"preview.php?file=$files\" target=\"_blank\">$lang_preview</a>&nbsp;</td>";
			echo "<td bgcolor=\"$bgcolor1\" width=\"1%\" class=\"text\">&nbsp;<a href=\"admin.php?action=edittemp&amp;file=$files\">$lang_edit2</a>&nbsp;</td>";
			echo "<td bgcolor=\"$bgcolor1\" width=\"1%\" class=\"text\">&nbsp;<a href=\"admin.php?action=copytemp&amp;file=$files\">$lang_copy</a>&nbsp;</td>";
			echo "<td bgcolor=\"$bgcolor1\" width=\"1%\" class=\"text\">&nbsp;<a href=\"admin.php?action=deltemp&amp;file=$files\">$lang_delete</a>&nbsp;</td>\n";
			echo "</tr>\n";
			
		break;
		} 	
	}
}	
		closedir($dir);
		
		if (!$num) {
		echo "<tr><td colspan=\"6\" bgcolor=\"$bgcolor1\" class=\"error\">$lang_error_notemplates</td></tr>";
		}
		
		echo "</table>\n";
		echo "<br />\n";
		echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
		echo "<td>$num $lang_templatesfound</td>";
		echo "<td align=\"right\"><a href=\"admin.php?action=recovertemp\">$lang_recover_templates</a></td>\n";
		echo "</tr>\n</table>";
	}
	
	// ################ recupera template origital ###############
	if ($action == "recovertemp") {
	echo "<b>$lang_recover_templates</b>";
	echo "<br /><br />";
	echo "$lang_recover_temptext<br /><br />";
	
	echo "<div align=\"center\">\n";
    echo "<form action=\"admin.php?action=dorecover\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
    echo "<input type=\"submit\" name=\"delstatus\" value=\"$lang_recover\" />";
    echo "</form>\n";
    echo "</div>";
	}
	
	if ($action == "dorecover") {	
	$backupdir = $dir_path."/backups/";
	$templatedir = $dir_path."/templates/";
	
	if (!file_exists($dir_path."/backups/")) {
	echo "<b>$lang_error</b><br />";
	echo "<span class=\"error\">$lang_error_nobackups</span><br /><br />";
	echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
	echo "</td>\n</tr>\n</table>\n";
	echo $tablebottom;
	errorend();
	}
	
	if ($admindisable != 1) {
		rec_copy ($backupdir, $templatedir);
	}
		  
	header("Location: admin.php?action=templates&PageNo=".$page);
	}
	
	// ############# edita template ###############
	if ($action == "edittemp") {
	$file=$_GET['file'];
	
	// abre template
        if (!file_exists($dir_path."/templates/$file")) {
            echo "<span class=\"error\">$lang_cantread $file</span>";
        } else {
            $handle = fopen ($dir_path."/templates/$file", "r");
            $tempinfo = fread ($handle, filesize ($dir_path."/templates/$file"));
            fclose ($handle);
        } 
        $rechte = fileperms($dir_path."/templates/$file");
        if ($rechte == "33206" || $rechte == "16822") {
            $permy = "$lang_permissions ok";
        } else {
            $permy = "<span class=\"error\">$lang_not666</span>";
        } 
	
	echo "<form name=\"form1\" method=\"post\" action=\"admin.php?action=updatetemp\">\n";
	echo "<input type=\"hidden\" name=\"oldfilename\" value=\"$file\" />";
	
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
	echo "<td><b>$lang_template $lang_edit</b></td>";
	echo "<td align=\"right\">Wrap Text <input type=\"checkbox\" onclick=\"javascript:set_wordwrap(this.checked);\" accesskey=\"w\" checked=\"checked\" /></td>\n";
	echo "</tr>\n</table>";
	echo "<br />";
	
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n";
	echo "<tr>\n";
	echo "<td bgcolor=\"$bgtablehead\" class=\"tablehl\">&nbsp;$file - $permy</td>";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td bgcolor=\"$bgcolor1\" align=\"center\">";
	echo "<textarea name=\"template\" id=\"template\" wrap=\"virtual\" cols=\"50\" rows=\"15\" style=\"width:95%\">".htmlspecialchars($tempinfo)."</textarea>";
	echo "</td>";
	echo "</tr>\n";
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\">&nbsp;&nbsp;&nbsp;<b>$lang_filename:</b>&nbsp;<input type=\"text\" name=\"newfilename\" size=\"44\" value=\"$file\" /></td>\n";
    echo "</tr>\n";
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" align=\"center\"><input type=\"submit\" value=\"$lang_template $lang_edit\" /></td>\n";
    echo "</tr>\n";
	echo "</table>\n";
	echo "</form>";
	}
	
	// ############# atualiza template ###############
	if ($action == "updatetemp") {
	
	$oldfilename = $HTTP_POST_VARS['oldfilename'];
	$newfilename = $HTTP_POST_VARS['newfilename'];
	$template = stripslashes($HTTP_POST_VARS['template']);
		
	if ($oldfilename!=$newfilename) {
		$newfilename = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $newfilename); 
		checkfile ($dir_path."/templates/$newfilename");
		$extension = "\.html$";
		checkextension ($extension,$dir_path."/templates/$newfilename");
		if ($admindisable != 1) {	
		rename($dir_path."/templates/$oldfilename", $dir_path."/templates/$newfilename");
		}
	}
	
	if ($admindisable != 1) {
    	$handle = fopen($dir_path."/templates/$newfilename", 'w');
		fwrite($handle, $template);
    	fclose($handle);
	}
	
	header("Location: admin.php?action=templates&PageNo=".$page);
	}
	
	// ############# exclui template ###############
	if ($action == "deltemp") {
	
	$file=$_GET['file'];
	 
	 echo "$lang_confirmdel_template";
     echo "<div align=\"center\">\n";
     echo "<form action=\"admin.php?action=dodeltemp\" method=\"post\">\n";
     echo "<input type=\"hidden\" name=\"filetemp\" value=\"$file\" />\n";
	 echo "<input type=\"hidden\" name=\"PageNo\" value=\"$page\" />\n";
     echo "<input type=\"submit\" name=\"delstatus\" value=\"&nbsp;$lang_yes&nbsp;\" />&nbsp;&nbsp;";
     echo "<input type=\"button\" value=\"&nbsp;$lang_no&nbsp;\" onclick=\"history.go(-1)\" />";
     echo "</form>\n";
     echo "</div>";
	 }
	 
	 
	 if ($action == "dodeltemp") {
		 
	 	if ($admindisable != 1) {
	 		$file=$HTTP_POST_VARS['filetemp'];	
	 			if (file_exists($dir_path."/templates/$file")) {
        		unlink($dir_path."/templates/$file");
        }
	 } 
	 header("Location: admin.php?action=templates&PageNo=".$page);
	 }
	
	// ############# copia template ###############
	if ($action == "copytemp") {
	
	$file=$_GET['file'];	
	
	if ($admindisable != 1) {
		file_copy($dir_path."/templates/$file", "$dir_path/templates/", "copy_$file", 1, 1);
		touch ($dir_path."/templates/copy_$file");
		chmod ($dir_path."/templates/copy_$file", 0666); 
	}
	 
	header("Location: admin.php?action=templates&PageNo=".$page);
	}
	
	// ############# cria novo template ###############
	if ($action == "newtemp") {
	
	echo "<b>$lang_makenewtemp</b>";
	echo "<br /><br />";
		
	echo "<form name=\"form1\" method=\"post\" action=\"admin.php?action=writetemp\">\n";
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n";
	echo "<tr>\n";
	echo "<td bgcolor=\"$bgcolor1\" class=\"text\"><b>$lang_filename:</b></td>\n";
    echo "<td bgcolor=\"$bgcolor1\"><input type=\"text\" name=\"file\" size=\"54\" value=\"$lang_newtemplate\" /></td>\n";
    echo "</tr>\n";
		
	echo "<tr>\n";
    echo "<td bgcolor=\"$bgcolor1\" class=\"text\">&nbsp;</td>\n";
    echo "<td bgcolor=\"$bgcolor1\"><input type=\"submit\" value=\"$lang_createfile\" /></td>\n";
    echo "</tr>\n";
	
	echo "</table>";
	echo "</form>";
	}
	
	// ############# escreve novo arquivo ##################
	if ($action == "writetemp") {
	
	$filename = $HTTP_POST_VARS['file']; 
	
	//limpa nome de arquivo
	$filename = ereg_replace("[^A-Za-z0-9\.\_\-]", "", $filename); 
	
	//check if file already exists
	if (file_exists($dir_path."/templates/$filename")) {
		echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_fileexists</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
	}
	
	$testExt = "\.html$";
		if (!eregi($testExt, $filename)) {
		echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_badext</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo "</td>\n</tr>\n</table>\n";
		echo $tablebottom;
		errorend();
		}
	
	if ($admindisable != 1) {
		$fp = fopen($dir_path."/templates/$filename","w") 
		or die ("Error Opening File");
		fputs($fp,$content);
		touch ($dir_path."/templates/$filename"); 
		chmod ($dir_path."/templates/$filename", 0666);  
		fclose($fp);
	}
	
	header("Location: admin.php?action=templates&PageNo=".$page);
	}
    
    // ############# exibe estatísticas ###################
    if ($action == "") {
        $no = 1;
        $phpversion = phpversion();
        $mysqlversion = cnt_mysql_query("SELECT VERSION() AS version");
        $info = mysql_fetch_row($mysqlversion);
        $mysqlhost = mysql_get_host_info();
        $php_errormsg = ""; 
        // verifica versão do gd
        $not_ok = "<span class=\"error\">$lang_no</span>";
        $ok = "<span class=\"ok\">OK</span>";
               
        // checa se o arquivo enviado está correto
        if (ini_get('file_uploads')) {
            $fu = $ok . ', ' . $lang_enabled;
        } else {
            $fu = $not_ok . ', ' . $lang_disabled;
        } 
        // checa tamanho máximo do arquivo antes do upload
        $maxup = ini_get('upload_max_filesize');
        
        $query = "SELECT ip,host,machine,FROM_UNIXTIME(datetime) FROM ".$db_prefix."adminlog ORDER BY id DESC LIMIT 1,1";
        $rows = cnt_mysql_query($query);
        list($ip, $host, $machine, $datetime_log) = mysql_fetch_row($rows);
        mysql_free_result($rows);
        ?>
        <span class="text"><b><?php echo $lang_welcome; ?> <?php echo $admin_user; ?>!</b></span><br />
        <br />
        <table border="0" cellpadding="3" cellspacing="1" width="100%">
          <tr> 
          <td bgcolor="<?php echo $bgtablehead ?>" colspan="2" class="tablehl">
		  <table border="0" width="100%" cellpadding="0" cellspacing="0">
		  <tr>
          <td nowrap="nowrap" class="tablehl"><?php echo "$lang_adminlog: $datetime_log" ?></td>
          <td align="right" class="tablehl"><a href="admin.php?action=clearlog" title="<?php echo $lang_dellogok ?>"><span class="tablehl"><?php echo "$lang_dellog" ?></span></a>&nbsp;|&nbsp;<a href="log.php?action=showlog"><span class="tablehl"><?php echo "$lang_details" ?></span></a>&nbsp;</td>
            </tr>
		</table>
	</td>
  </tr>
   <tr> 
    <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%" valign="top"><?php echo "$lang_ip" ?>: <a href="http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=<?php echo "$ip" ?>" target="blank"><?php echo "$ip" ?></a><br />
     <?php echo "$lang_host: $host" ?></td>
    <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%" valign="top"><?php echo "$lang_machine: $machine" ?></td>
  </tr>
</table>
<br />
<?php
if ($moderated==1) {
	
	$sort = "b.".$sort_after;
	
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
	echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" colspan=\"6\">$lang_newentries_mod</td>\n";	
	echo "</tr>\n"; 
	
	$datetime_last = date('U', strtotime($datetime_log));
	
	$query = "SELECT b.id, b.online, b.name, b.comments, b.email, b.ip, FROM_UNIXTIME(b.datetime),FROM_UNIXTIME(a.datetime) 
	FROM ".$db_prefix."book as b
	LEFT JOIN ".$db_prefix."adminlog as a
	ON a.datetime > b.datetime
	WHERE b.online = 0
	AND b.datetime > $datetime_last
	GROUP by b.id
	ORDER BY $sort $sort_order";
	$result = cnt_mysql_query($query);

	while (list($id, $status, $name, $comments, $email, $ip, $datetime) = mysql_fetch_row($result)) { 
		
		$count++;
			  
		if ($count % 2 == 0) {
		$rowbgcolor = $bgcolor2;
		} else {
		$rowbgcolor = $bgcolor1;
		}
		
		$comments = stripslashes(htmlspecialchars($comments));
		$name = stripslashes(trim($name));
		$email = stripslashes(trim($email));
		
		if ($email=="") {
		$mail = "&#8212;";
		} else {
		$srcImg = @getimagesize("$img_rootpath/email.gif");
		$mail = "<a href=\"mailto:$email\"><img src=\"$img_relpath/email.gif\" alt=\"$email\" $srcImg[3] border=\"0\" /></a>";
		}
		
		$srcImg = @getimagesize("$img_rootpath/offline.gif");
		$status = "<a href=\"admin.php?action=switchon&amp;mod&amp;id=$id&amp;PageNo=$page\"><img src=\"$img_relpath/offline.gif\" alt=\"$lang_isoffline\" border=\"0\" $srcImg[3] /></a>";
		
		echo "<tr title=\"$comments\">\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"right\" width=\"1%\">&nbsp;$id&nbsp;</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" nowrap=\"nowrap\" width=\"1%\">&nbsp;$datetime&nbsp;</td>\n";
		
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" width=\"95%\"><a href=\"admin.php?action=entrydetail&amp;id=$id\">$name</a></td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\" width=\"1%\">&nbsp;&nbsp;$mail&nbsp;&nbsp;</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\">&nbsp;<a href=\"http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=$ip\" target=\"_blank\" width=\"1%\">$ip</a>&nbsp;</td>\n";
		echo "<td class=\"text\" bgcolor=\"$rowbgcolor\" align=\"center\" width=\"1%\">&nbsp;&nbsp;&nbsp;$status&nbsp;&nbsp;&nbsp;</td>\n";	
		echo "</tr>\n";
		} 
		
		if (mysql_num_rows($result)=="") {
			echo "<tr>\n<td colspan=\"6\" class=\"text\" bgcolor=\"$bgcolor1\">$lang_noentry_tomoderate</td>\n</tr>";
		}
	
    echo "</table>\n<br />";
	mysql_free_result($result);	
}
	
?>
<form name="form1" method="post" action="admin.php?action=quicksearch">
  <table border="0" cellpadding="3" cellspacing="1" width="100%">
    <tr> 
      <td class="tablehl" bgcolor="<?php echo $bgtablehead ?>" colspan="2"><?php echo "$lang_quicksearch:" ?></td>
    </tr>
    <tr> 
      <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%"> 
        <?php echo "$lang_searchin:" ?><br /> </td>
      <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%"> 
        <input type="text" name="qc" /> <input type="submit" name="submit" value="<?php echo "$lang_find" ?>" /> 
      </td>
    </tr>
  </table> 
</form>
<br />
<?php 
        // tamanho do BD
        $query = cnt_mysql_query("SHOW TABLE STATUS like '".$db_prefix."%'");
        if ($query) {
            $size = 0;
            while ($tables = mysql_fetch_array($query)) {
                $size = $size + $tables['Data_length'] + $tables['Index_length'];
            } 
        } 

        if ($size >= "1073741824") {
            $finalsize = sprintf ("%01.5f", $size / "1073741824") . " GB ";
        } elseif ($size >= "1048576") {
            $finalsize = sprintf ("%01.3f", $size / "1048576") . " MB ";
        } elseif ($size >= "1024") {
            $finalsize = sprintf ("%01.5f", $size / "1024") . " KB ";
        } else {
            $finalsize = $size . " B ";
        } 
		
		$totalsmilies = mysql_num_rows(cnt_mysql_query("SELECT id FROM ".$db_prefix."smilies"));
        $totalavatars = mysql_num_rows(cnt_mysql_query("SELECT id FROM ".$db_prefix."avatars"));
		$totalentries = mysql_num_rows(cnt_mysql_query("SELECT id FROM ".$db_prefix."book"));
		$hits = cnt_mysql_query("SELECT value FROM ".$db_prefix."conf WHERE name='gbhits'");
		list($totalhits) = mysql_fetch_row($hits);
        ?>
<table border="0" cellpadding="3" cellspacing="1" width="100%">
  <tr> 
    <td class="tablehl" bgcolor="<?php echo $bgtablehead ?>" colspan="2"><?php echo "$lang_galstats:" ?></td>
  </tr>
  <tr> 
    <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%" valign="top">	 
     <?php echo "$lang_numentries: $totalentries" ?><br /> 
	 <?php echo "$lang_numhits: $totalhits" ?>
    </td>
    <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%" valign="top">
      <?php echo "$lang_numavatars: $totalavatars" ?><br /> 
	  <?php echo "$lang_numsmilies: $totalsmilies" ?>
    </td>
  </tr>
</table>
<br />
<table border="0" cellpadding="3" cellspacing="1" width="100%">
  <tr> 
    <td class="tablehl" bgcolor="<?php echo $bgtablehead ?>"><?php echo $lang_mysqlinfo; ?></td>
	<td class="tablehl" bgcolor="<?php echo $bgtablehead ?>"><?php echo $lang_phpinfo; ?></td>
  </tr>
  <tr> 
    <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%" valign="top"> 
      <?php echo "$lang_mysqlver: $info[0]" ?><br />
      <?php echo "$lang_mysqlhost: $mysqlhost" ?><br />
	  <?php echo "$lang_dbsize: $finalsize" ?>
     </td>
    <td class="text" bgcolor="<?php echo $bgcolor1 ?>" width="50%" valign="top"> 
      <?php echo "$lang_phpver: $phpversion" ?> <br />
	  <?php echo "$lang_phpupload: $fu" ?><br />  
      <?php echo "$lang_maxupload: $maxup" ?></td>
  </tr>
</table>

<?php
echo $tablebottom;
echo $blankline;
echo $tabletop;
?>

<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="33%" class="text" nowrap="nowrap"></td>
    <td width="33%" class="text" nowrap="nowrap">
    <b>Gostou deste script? faça uma doação!</b>
    <br>Obrigado por usar o script WESPA Mural de Recados. 
    <br>Este script é de distribuição gratuita, pede-se apenas que você não remova os créditos 
    <br>do autor (Wespa Digital Ltda) do rodapé das páginas. Se deseja contribuir financeiramente para que 
    <br>possamos estar melhorando este projeto, faça uma doação de qualquer valor por meio do PagSeguro 
    <br>ou PayPal, clicando nos botões à seguir:<br><br>
    
    
  <center>
  <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/donation.html" method="post">
<input type="hidden" name="receiverEmail" value="info@wespadigital.com" />
<input type="hidden" name="currency" value="BRL" />
<input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/doacoes/184x42-doar-azul-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
  </center>

  <br>
  <center>
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="5DR23G4QH3E8W">
<input type="image" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - A maneira mais fácil e segura de efetuar pagamentos online!">
<img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
</form>

  </center><br><br>
  
  Pode notificar sua doação escrevendo para <a href="mailto:info@wespadigital.com">info@wespadigital.com</a> e passará a receber
    <br> novidades sobre novas versões deste script em seu e-mail. 
      </td>
  </tr>
</table>
      <?php
    } 
    
	// ############# Limpa Log de Administrador #############
    if ($action == "clearlog") {
        // obtem último id

        $query = "SELECT id from ".$db_prefix."adminlog ORDER BY id DESC";
        $result = cnt_mysql_query($query);
        $logid = mysql_fetch_row($result);
        $logid2 = $logid[0]-1;

        if ($admindisable != 1) {
            $delsql = "DELETE FROM ".$db_prefix."adminlog WHERE id<$logid2";
            $result = cnt_mysql_query($delsql) or die("<span class=\"error\"><b>$lang_error</b></span><br /><br />$lang_error_dellog<br /><b>$lang_mysqlsays:</b> ".mysql_error()."<br /><br /><a href=\"javascript:history.go(-1)\">$lang_return</a>\n</td>\n</tr>\n</table>".$tablebottom."</body></html>");
			mysql_free_result($result);
        } 	
        header("Location: log.php?action=showlog&PageNo=".$page);
    } 



    // #####################################################
    echo $tablebottom;
	
	if ($action!="") {
    echo $blankline;
    echo $tabletop;
	  
	if ($action=="editsmiley" or $action=="delsmiley" or $action=="uploadsmiley") {
		echo "<a href=\"admin.php?action=smilies\">$lang_overview $lang_smilies</a>";
	} elseif ($action=="editavatar" or $action=="delavatar" or $action=="uploadavatar") {
		echo "<a href=\"admin.php?action=avatars\">$lang_overview $lang_avatars</a>";
	} elseif ($action=="entrydetail" or $action=="delentry") {
		echo "<a href=\"admin.php?action=entries&PageNo=$page\">$lang_overview $lang_records</a>";
	} elseif ($action=="edittemp" or $action=="deltemp" or $action=="recovertemp") {
		echo "<a href=\"admin.php?action=templates\">$lang_overview $lang_templates</a>";
	} else {
        echo "<a href=\"admin.php\">$lang_overview</a>";     
	}
	
    echo $tablebottom;
	}
	
    echo "<br />".$copyright; //remover os direitos de autor é infração penalizada por lei!
    if ($admindebug == 1) {
	echo "</td></tr>";
	} else {
	echo "</td></tr></table>";
	echo "<p>&nbsp;</p>";
	}
    
} else {
  echo "$lang_noaccess";
} 
?>

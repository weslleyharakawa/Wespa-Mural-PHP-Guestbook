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
 
    // ########### Menu da Administração #############
    include($dir_path . '/includes/admin.menu.inc.php');

    echo $menu;
    echo $tabletop;

    if (!isset($_GET['action'])) {
        $action = '';
    } else {
        $action = $_GET['action'];
    } 
    // atualiza configuração
    if ($action == "update") {
    echo "<span class=\"text\"><b>$lang_confsaved_ok</b><br />";
	
        if ($admindisable != 1) {
            while (list($key, $val) = each($HTTP_POST_VARS)) {
                $query = "UPDATE ".$db_prefix."conf SET value='" . addslashes($val) . "' WHERE name='$key'";
                $result = cnt_mysql_query($query);
                if ($result == false) {
                    $oops = "<span class=\"error\">$lang_error_updateconf<br /><br />" . mysql_errno() . ": " . mysql_error();
                    echo "</span>";
                    die ($oops);
                } 
            }     

            if ($admindisable != 1) {
					
			if (isset($HTTP_POST_VARS['csswrite'])) {
			$csswrite = $HTTP_POST_VARS['csswrite'];
			} else {
			$csswrite = 0;
			}
			if (isset($HTTP_POST_VARS['css'])) {
			$css = $HTTP_POST_VARS['css'];
			}
				
                if ($csswrite == 1) {
                    $filename2 = "$dir_path/mural.css";
                    $handle2 = fopen($filename2, 'w');
                    fwrite($handle2, stripslashes($css));
                    fclose($handle2);
                    echo "$help[csssettings] $lang_writeok<br />";
                } 
            } 
        } 
        echo "<br /><a href=\"admin.php\">$lang_overview</a>&nbsp;|&nbsp;<a href=\"config.php\">$lang_settings</a></span>\n";
    } 

    if ($action == "reset") {
        if ($admindisable != 1) {
            // reseta a configuração original
			$name['lang'] = "en";
			$name['gbname'] = "Mural de Recados";
			$name['logo'] = "logo.gif";
			$name['img_rootpath'] = $dir_path."/images";
			$name['img_relpath'] = $url."/images";
			$name['av_rootpath'] = $dir_path."/images/avatars";
			$name['av_relpath'] = $url."/images/avatars";
			$name['sm_rootpath'] = $dir_path."/images/smilies";		
			$name['sm_relpath'] = $url."/images/smilies";
			
			$name['sort_order'] = "DESC";
			$name['sort_after'] = "datetime";
						
			$name['tpl_header'] = "cabecalho.html";
			$name['tpl_top'] = "top.html"; 
			$name['tpl_entries'] = "recados.html";
			$name['tpl_footer'] = "rodape.html"; 
			$name['tpl_form'] = "form.html"; 
			$name['tpl_smilies'] = "emoticons.html";
			$name['tpl_help'] = "ajuda.html"; 
					
			$name['enablebadword'] = "1"; 
			$name['bad_words'] = "fuck asshole arshole ficken arsch";
			$name['badwords_replacement'] = "*";
			
			$name['pagebgcolor'] = "#EFEFEF";
			$name['title'] = "Administração do Mural de Recados";
			$name['adminpagebgcolor'] = "#EFEFEF";
			$name['admintablebgcolor'] = "#FFFFFF";
			$name['bgcolor1'] = "#DEE6E8";
			$name['bgcolor2'] = "#BCCDD1";
			$name['bgtablehead'] = "#58838B";
			$name['bordercolor'] = "#BCCDD1";
			$name['tablebgcolor'] = "#FFFFFF";
			
			$name['tablewidth'] = "85%";
			$name['webmasteremail'] = "nobody@".$_SERVER['HTTP_HOST'];
			
			$name['gzip_level'] = "0";
			$name['show_query'] = "1";
			$name['page_size'] = "10";			
			$name['pagenumshow'] = "10";
			
			$name['gbhits'] = "0";
			$name['show_email'] = "1";
			$name['show_hp'] = "1";
            $name['show_ip'] = "1";
			$name['show_avatars'] = "1";
			$name['floodcheck'] = "1";
			$name['floodchecktime'] = "30";
			$name['comment_length'] = "800";
			
			$name['required_name'] = "1";
			$name['required_email'] = "1";
			$name['required_hp'] = "0";
			$name['required_country'] = "0";
			$name['required_comment'] = "1";
			$name['required_avatar'] = "0";
			 		
			$name['emailonnewentry'] = "1";
			$name['moderated'] = "0";

            while (list($key, $val) = each($name)) {
                $query = "UPDATE ".$db_prefix."conf SET value='" . addslashes($val) . "' WHERE name='$key'";
                $result = cnt_mysql_query($query);
                if ($result == false) {
                    $oops = "<span class=\"error\">$lang_error_updateconf<br /><br />" . mysql_errno() . ": " . mysql_error();
                    echo "</span>";
                    die ($oops);
                } 
            } 
        } 
        echo "<p class=\"text\"><b>$lang_confrestored_ok</b><br />$lang_accessnotreset</p>";
        echo "<p class=\"text\"><a href=\"admin.php\">$lang_overview</a>&nbsp;|&nbsp;<a href=\"config.php\">$lang_settings</a></p>\n";
    } 
    // menu
    if ($action == "" or $action == "design") {
        // define some variables
        FOR ($i = 0; $i < 70; $i++) {
            $no[$i] = "";
        } 

        echo "<table border=\"0\" width=\"100%\" cellpadding=\"3\" cellspacing=\"1\">\n";
        echo "<tr>\n";
        echo "<td class=\"text\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"config.php\">$help[generalsettings]</a></td>";
		 echo "<td class=\"text\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"config.php#path\">$help[pathsettings]</a></td>";
        echo "<td class=\"text\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"config.php#display\">$help[catsettings]</a></td>";
        echo "<td class=\"text\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"config.php?action=design#color\">$help[coloursettings]</a></td>";
        echo "<td class=\"text\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"config.php?action=design\">$help[stylesettings]</a></td>";
      
        echo "</tr>\n";
        echo "</table><br />";
        echo "<form method=\"post\" action=\"config.php?action=update\" name=\"conf\">\n";
    } 
    // exibe a configuração atual
    // configurações gerais
    if ($action == "") {
        echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n";
        echo "<tr>\n";
        echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" colspan=\"2\">$help[generalsettings]</td>\n";
        echo "</tr>\n";
		
		if ($lang == "de") {
            $no[0] = "selected=\"selected\"";
        } else {
            $no[1] = "selected=\"selected\"";
        } 

        echo "<tr>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\" class=\"text\">$help[lang]</td>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\">
			<select name=\"lang\">
			<option value=\"en\" $no[0]>$lang_portugues</option>
			</select></td>\n";
        echo "</tr>\n";
		
		$gbname = str_replace("\"", "&quot;", stripslashes($gbname));
		$logo = str_replace("\"", "", stripslashes($logo));
		$img_roothpath = str_replace("\"", "", stripslashes($img_rootpath));
		$img_relhpath = str_replace("\"", "", stripslashes($img_relpath));
		$av_roothpath = str_replace("\"", "", stripslashes($av_rootpath));
		$av_relhpath = str_replace("\"", "", stripslashes($av_relpath));
		$sm_roothpath = str_replace("\"", "", stripslashes($sm_rootpath));
		$sm_relhpath = str_replace("\"", "", stripslashes($sm_relpath));
		$tpl_header = str_replace("\"", "", stripslashes($tpl_header));
		$tpl_footer = str_replace("\"", "", stripslashes($tpl_footer));
		$tpl_top = str_replace("\"", "", stripslashes($tpl_top));
		$tpl_entries = str_replace("\"", "", stripslashes($tpl_entries));
		$tpl_form = str_replace("\"", "", stripslashes($tpl_form));
		$tpl_smilies = str_replace("\"", "", stripslashes($tpl_smilies));
		$tpl_help = str_replace("\"", "", stripslashes($tpl_help));
		$title = str_replace("\"", "&quot;", stripslashes($title));
		$webmasteremail = str_replace("\"", "", stripslashes($webmasteremail));
		$admin_user = str_replace("\"", "&quot;", stripslashes($admin_user));
		$admin_pass = str_replace("\"", "&quot;", stripslashes($admin_pass));
		
        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[gbname]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"gbname\" type=\"text\" value=\"$gbname\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
		  echo "<tr>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\" class=\"text\">$help[title]</td>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\">
			<input name=\"title\" type=\"text\" value=\"$title\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[admin_user]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\">
			<input name=\"admin_user\" type=\"text\" value=\"$admin_user\" size=\"40\" maxlength=\"50\" /></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[admin_pass]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\">
			<input name=\"admin_pass\" type=\"password\" value=\"$admin_pass\" size=\"40\" maxlength=\"50\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[webmasteremail]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\">
			<input name=\"webmasteremail\" type=\"text\" value=\"$webmasteremail\" size=\"40\" maxlength=\"50\" /></td>\n";
        echo "</tr>\n";

       

        if ($show_query == "0") {
            $no[2] = "selected=\"selected\"";
        } elseif ($show_query == "1") {
            $no[3] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[show_query]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><select name=\"show_query\">
			<option value=\"0\" $no[2]>$lang_no</option>
			<option value=\"1\" $no[3]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";

        if ($gzip_level == "0") {
            $no[4] = "selected=\"selected\"";
        } elseif ($gzip_level == "1") {
            $no[5] = "selected=\"selected\"";
        } elseif ($gzip_level == "2") {
            $no[6] = "selected=\"selected\"";
        } elseif ($gzip_level == "3") {
            $no[7] = "selected=\"selected\"";
        } elseif ($gzip_level == "4") {
            $no[8] = "selected=\"selected\"";
        } elseif ($gzip_level == "5") {
            $no[9] = "selected=\"selected\"";
        } elseif ($gzip_level == "6") {
            $no[10] = "selected=\"selected\"";
        } elseif ($gzip_level == "7") {
            $no[11] = "selected=\"selected\"";
        } elseif ($gzip_level == "8") {
            $no[12] = "selected=\"selected\"";
        } elseif ($gzip_level == "9") {
            $no[13] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[gzip]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><select name=\"gzip_level\">
			<option value=\"0\" $no[4]>0</option>
			<option value=\"1\" $no[5]>1</option>
			<option value=\"2\" $no[6]>2</option>
			<option value=\"3\" $no[7]>3</option>
			<option value=\"4\" $no[8]>4</option>
			<option value=\"5\" $no[9]>5</option>
			<option value=\"6\" $no[10]>6</option>
			<option value=\"7\" $no[11]>7</option>
			<option value=\"8\" $no[12]>8</option>
			<option value=\"9\" $no[13]>9</option>
			</select></td>\n";
        echo "</tr>\n";

        echo "</table><br />"; 
		
       // ######################### Rotas e Templates ##########################
        echo "<a name=\"path\"></a>";
        echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n";
        echo "<tr>\n";
        echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" colspan=\"2\">$help[pathsettings]</td>\n";
        echo "</tr>\n";
		
		 echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[logo]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"logo\" type=\"text\" value=\"$logo\" size=\"40\" /></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[img_rootpath]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"img_rootpath\" type=\"text\" value=\"$img_rootpath\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[img_relpath]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"img_relpath\" type=\"text\" value=\"$img_relpath\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[av_rootpath]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"av_rootpath\" type=\"text\" value=\"$av_rootpath\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[av_relpath]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"av_relpath\" type=\"text\" value=\"$av_relpath\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[sm_rootpath]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"sm_rootpath\" type=\"text\" value=\"$sm_rootpath\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[sm_relpath]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"sm_relpath\" type=\"text\" value=\"$sm_relpath\" size=\"40\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[tpl_header]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"tpl_header\" type=\"text\" value=\"$tpl_header\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[tpl_top]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"tpl_top\" type=\"text\" value=\"$tpl_top\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[tpl_entries]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"tpl_entries\" type=\"text\" value=\"$tpl_entries\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[tpl_form]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"tpl_form\" type=\"text\" value=\"$tpl_form\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[tpl_smilies]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"tpl_smilies\" type=\"text\" value=\"$tpl_smilies\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[tpl_help]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"tpl_help\" type=\"text\" value=\"$tpl_help\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[tpl_footer]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"tpl_footer\" type=\"text\" value=\"$tpl_footer\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";

        echo "</table>\n";
		echo "<br />";
    	
        // ######################## exibe configurações ########################
        echo "<a name=\"display\"></a>";
        echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
        echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" colspan=\"2\">$help[catsettings]</td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[tablewidth]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"tablewidth\" type=\"text\" value=\"$tablewidth\" size=\"40\" maxlength=\"4\" /></td>\n";
        echo "</tr>\n";
		
		if ($enablebadword == "0") {
            $no[18] = "selected=\"selected\"";
        } elseif ($enablebadword == "1") {
            $no[19] = "selected=\"selected\"";
        } else {
        } 
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[enablebadword]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><select name=\"enablebadword\">
			<option value=\"0\" $no[18]>$lang_no</option>
			<option value=\"1\" $no[19]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[bad_words]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"bad_words\" type=\"text\" value=\"$bad_words\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
			
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[badwords_replacement]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"badwords_replacement\" type=\"text\" value=\"$badwords_replacement\" size=\"40\" maxlength=\"250\" /></td>\n";
        echo "</tr>\n";
		
        echo "<tr>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\" class=\"text\">$help[page_size]</td>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\"><input name=\"page_size\" type=\"text\" value=\"$page_size\" size=\"40\" maxlength=\"4\" onblur=\"MM_validateForm('page_size','','RisNum');return document.MM_returnValue\" /></td>\n";
        echo "</tr>\n";

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[pagenumshow]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"pagenumshow\" type=\"text\" value=\"$pagenumshow\" size=\"40\" maxlength=\"4\" onblur=\"MM_validateForm('pagenumshow','','RisNum');return document.MM_returnValue\" /></td>\n";
        echo "</tr>\n";
		
		if ($sort_after == "datetime") {
            $no[30] = "selected=\"selected\"";
        } elseif ($sort_after == "id") {
            $no[31] = "selected=\"selected\"";
        } elseif ($sort_after == "name") {
            $no[32] = "selected=\"selected\"";
        } elseif ($sort_after == "country") {
            $no[33] = "selected=\"selected\"";
        } elseif ($sort_after == "email") {
            $no[34] = "selected=\"selected\"";
        } elseif ($sort_after == "homepage") {
            $no[35] = "selected=\"selected\"";
        } elseif ($sort_after == "ip") {
            $no[36] = "selected=\"selected\"";
        } else {
        } 

        if ($sort_order == "ASC") {
            $no[37] = "selected=\"selected\"";
        } elseif ($sort_order == "DESC") {
            $no[38] = "selected=\"selected\"";
        } else {
        } 
		
        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[sort_after]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\">
			<select name=\"sort_after\">      
			<option value=\"datetime\" $no[30]>$lang_date</option>
			<option value=\"id\" $no[31]>ID</option>
			<option value=\"name\" $no[32]>$lang_name</option>
			<option value=\"country\" $no[33]>$lang_country</option>
            <option value=\"email\" $no[34]>$lang_email</option>
			<option value=\"homepage\" $no[35]>$lang_homepage</option>
			<option value=\"ip\" $no[36]>$lang_ip</option>
			</select>
			<select name=\"sort_order\">
            <option value=\"ASC\" $no[37]>$lang_ascending</option>
			<option value=\"DESC\" $no[38]>$lang_descending</option>
			</select></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[gbhits]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"gbhits\" type=\"text\" value=\"$gbhits\" size=\"40\" maxlength=\"10\" onblur=\"MM_validateForm('gbhits','','RisNum');return document.MM_returnValue\" /></td>\n";
        echo "</tr>\n";
		
		if ($required_name == "1") {
            $no[40] = "checked=\"checked\"";
        } else {
		    $no[41] = "checked=\"checked\"";
		}
		
		
		if ($required_email == "1") {
            $no[42] = "checked=\"checked\"";
        } else {
            $no[43] = "checked=\"checked\""; 
		}
		
		if ($required_hp == "1") {
            $no[44] = "checked=\"checked\"";
        } else {
		    $no[45] = "checked=\"checked\"";
		}
		
		if ($required_country == "1") {
            $no[46] = "checked=\"checked\"";
        } else {
		    $no[47] = "checked=\"checked\"";
		}
		
		if ($required_comment == "1") {
            $no[48] = "checked=\"checked\"";
        } else {
		    $no[49] = "checked=\"checked\"";
		}
		
		if ($required_avatar == "1") {
            $no[50] = "checked=\"checked\"";
        } else {
			$no[51] = "checked=\"checked\"";
		}
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\" valign=\"top\">$lang_name $help[required_fields]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">
		<input type=\"radio\" name=\"required_name\" $no[40] value=\"1\" />$lang_yes&nbsp;
		<input type=\"radio\" name=\"required_name\" $no[41] value=\"0\" />$lang_no<br />
		</td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\" valign=\"top\">$lang_email $help[required_fields]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">
		<input type=\"radio\" name=\"required_email\" $no[42] value=\"1\" />$lang_yes&nbsp;
		<input type=\"radio\" name=\"required_email\" $no[43] value=\"0\" />$lang_no<br />
		</td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\" valign=\"top\">$lang_homepage $help[required_fields]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">
		<input type=\"radio\" name=\"required_hp\" $no[44] value=\"1\" />$lang_yes&nbsp;
		<input type=\"radio\" name=\"required_hp\" $no[45] value=\"0\" />$lang_no<br />
		</td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\" valign=\"top\">$lang_country $help[required_fields]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">
		<input type=\"radio\" name=\"required_country\" $no[46] value=\"1\" />$lang_yes&nbsp;
		<input type=\"radio\" name=\"required_country\" $no[47] value=\"0\" />$lang_no<br />
		</td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\" valign=\"top\">$lang_comment $help[required_fields]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">
		<input type=\"radio\" name=\"required_comment\" $no[48] value=\"1\" />$lang_yes&nbsp;
		<input type=\"radio\" name=\"required_comment\" $no[49] value=\"0\" />$lang_no<br />
		</td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\" valign=\"top\">$lang_avatar $help[required_fields]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">
		<input type=\"radio\" name=\"required_avatar\" $no[50] value=\"1\" />$lang_yes&nbsp;
		<input type=\"radio\" name=\"required_avatar\" $no[51] value=\"0\" />$lang_no<br />
		</td>\n";
        echo "</tr>\n";
		
		
		if ($show_email == "0") {
            $no[22] = "selected=\"selected\"";
        } elseif ($show_email == "1") {
            $no[23] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[show_email]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><select name=\"show_email\">
			<option value=\"0\" $no[22]>$lang_no</option>
			<option value=\"1\" $no[23]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";
		
		if ($show_hp == "0") {
            $no[24] = "selected=\"selected\"";
        } elseif ($show_hp == "1") {
            $no[25] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[show_hp]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><select name=\"show_hp\">
			<option value=\"0\" $no[24]>$lang_no</option>
			<option value=\"1\" $no[25]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";
		
		if ($show_ip == "0") {
            $no[20] = "selected=\"selected\"";
        } elseif ($show_ip == "1") {
            $no[21] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[show_ip]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><select name=\"show_ip\">
			<option value=\"0\" $no[20]>$lang_no</option>
			<option value=\"1\" $no[21]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";
       	
		if ($show_avatars == "0") {
            $no[28] = "selected=\"selected\"";
        } elseif ($show_avatars == "1") {
            $no[29] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[show_avatars]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><select name=\"show_avatars\">
			<option value=\"0\" $no[28]>$lang_no</option>
			<option value=\"1\" $no[29]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";	
		
		
		
		if ($emailonnewentry == "0") {
            $no[16] = "selected=\"selected\"";
        } elseif ($emailonnewentry == "1") {
            $no[17] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[emailonnewentry]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><select name=\"emailonnewentry\">
			<option value=\"0\" $no[16]>$lang_no</option>
			<option value=\"1\" $no[17]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";
		
		if ($moderated == "0") {
            $no[14] = "selected=\"selected\"";
        } elseif ($moderated == "1") {
            $no[15] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[moderated]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><select name=\"moderated\">
			<option value=\"0\" $no[14]>$lang_no</option>
			<option value=\"1\" $no[15]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";
		
		if ($floodcheck == "0") {
            $no[26] = "selected=\"selected\"";
        } elseif ($floodcheck == "1") {
            $no[27] = "selected=\"selected\"";
        } else {
        } 

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[floodcheck]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><select name=\"floodcheck\">
			<option value=\"0\" $no[26]>$lang_no</option>
			<option value=\"1\" $no[27]>$lang_yes</option>
			</select></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[floodchecktime]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\"><input name=\"floodchecktime\" type=\"text\" value=\"$floodchecktime\" size=\"40\" maxlength=\"5\" onblur=\"MM_validateForm('floodchecktime','','RisNum');return document.MM_returnValue\" /></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[comment_length]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\"><input name=\"comment_length\" type=\"text\" value=\"$comment_length\" size=\"40\" maxlength=\"10\" onblur=\"MM_validateForm('comment_length','','RisNum');return document.MM_returnValue\" /></td>\n";
        echo "</tr>\n";

        echo "</table><br />\n"; 
		}
       
	//################### configuração de cores ############################
    if ($action == "design") {
        
		// css settings
        $filename = "$dir_path/mural.css";
        if (!file_exists($filename)) {
            echo "<span class=\"error\">$lang_cantread $filename</span>";
        } else {
            $handle = fopen ($filename, "r");
            $cssinfo = fread ($handle, filesize ($filename));
            fclose ($handle);
        } 
        $rechte = fileperms($filename);
        if ($rechte == "33206" || $rechte == "16822") {
            $permy = "$lang_permissions ok";
        } else {
            $permy = "<span class=\"error\">$lang_not666</span>";
        } 

        echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
        echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" colspan=\"2\">$help[csssettings] - $permy</td>\n";
		echo "</tr>\n";
        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" align=\"center\"><textarea name=\"css\" cols=\"70\" rows=\"10\" style=\"width:95%\">".htmlspecialchars($cssinfo)."</textarea></td>";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" ><input name=\"csswrite\" type=\"checkbox\" value=\"1\" /> <span class=\"text\">$lang_dosave $help[csssettings]</span></td>";
        echo "</tr>\n";
        echo "</table><br />\n";
		
		// ###################### cores ######################
		echo "<a name=\"color\"></a>";
		echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"100%\">\n<tr>\n";
        echo "<td class=\"tablehl\" bgcolor=\"$bgtablehead\" colspan=\"2\">$help[coloursettings]</td>\n";
        echo "</tr>\n";
		echo "<tr>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\" class=\"text\">$help[pagebgcolor]</td>\n";
        echo "<td width=\"50%\" bgcolor=\"$bgcolor1\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"pagebgcolor\" type=\"text\" value=\"$pagebgcolor\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$pagebgcolor\">&nbsp;</td></tr></table>";
        echo "</td><td>&nbsp;</td><td>\n";
        $colour1 = substr($pagebgcolor, 1, 6);
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=pagebgcolor&amp;f=$colour1','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table>";
        echo "</td>\n</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[tablebgcolor]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"tablebgcolor\" type=\"text\" value=\"$tablebgcolor\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$tablebgcolor\">&nbsp;</td></tr></table>";
        echo "</td><td>&nbsp;</td><td>\n";
        $colour2 = substr($tablebgcolor, 1, 6);
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=tablebgcolor&amp;f=$colour2','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table>";
        echo "</td>\n</tr>\n";

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[bgcolor1]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"bgcolor1\" type=\"text\" value=\"$bgcolor1\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$bgcolor1\">&nbsp;</td></tr></table>";
        $colour3 = substr($bgcolor1, 1, 6);
        echo "</td><td>&nbsp;</td><td>\n";
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=bgcolor1&amp;f=$colour3','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table>";
        echo "</td>\n</tr>\n";

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[bgcolor2]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"bgcolor2\" type=\"text\" value=\"$bgcolor2\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$bgcolor2\">&nbsp;</td></tr></table>";
        $colour4 = substr($bgcolor2, 1, 6);
        echo "</td><td>&nbsp;</td><td>\n";
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=bgcolor2&amp;f=$colour4','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table>";
        echo "</td>\n</tr>\n";

        echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[bgtablehead]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"bgtablehead\" type=\"text\" value=\"$bgtablehead\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$bgtablehead\">&nbsp;</td></tr></table>";
        $colour5 = substr($bgtablehead, 1, 6);
        echo "</td><td>&nbsp;</td><td>\n";
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=bgtablehead&amp;f=$colour5','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table></td>\n";
        echo "</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[bordercolor]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"bordercolor\" type=\"text\" value=\"$bordercolor\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$bordercolor\">&nbsp;</td></tr></table>";
        $colour6 = substr($bordercolor, 1, 6);
        echo "</td><td>&nbsp;</td><td>\n";
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=bordercolor&amp;f=$colour6','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table>";
        echo "</td>\n</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor1\" class=\"text\">$help[adminpagebgcolor]</td>\n";
        echo "<td bgcolor=\"$bgcolor1\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"adminpagebgcolor\" type=\"text\" value=\"$adminpagebgcolor\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$adminpagebgcolor\">&nbsp;</td></tr></table>";
        $colour9 = substr($adminpagebgcolor, 1, 6);
        echo "</td><td>&nbsp;</td><td>\n";
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=adminpagebgcolor&amp;f=$colour9','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table>";
        echo "</td>\n</tr>\n";
		
		echo "<tr>\n";
        echo "<td bgcolor=\"$bgcolor2\" class=\"text\">$help[admintablebgcolor]</td>\n";
        echo "<td bgcolor=\"$bgcolor2\" nowrap=\"nowrap\">
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input name=\"admintablebgcolor\" type=\"text\" value=\"$admintablebgcolor\" size=\"30\" /></td><td>&nbsp;&nbsp;</td><td><table border=\"1\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"20\" width=\"30\" bgcolor=\"$admintablebgcolor\">&nbsp;</td></tr></table>";
        $colour10 = substr($admintablebgcolor, 1, 6);
        echo "</td><td>&nbsp;</td><td>\n";
        echo "<a href=\"javascript:MM_openBrWindow('../includes/cp.inc.php?fd=admintablebgcolor&amp;f=$colour10','Auswahl1','width=124,height=264');\"><img src=\"$img_relpath/colour.gif\" border=\"0\" alt=\"colorpicker\" width=\"16\" height=\"16\" /></a></td></tr></table>";
        echo "</td>\n</tr>\n";		
        echo "</table><br />\n"; 
    } 

    if ($action == "" OR $action == "design") {
        echo "<p align=\"center\"><input name=\"submit\" type=\"submit\" value=\"$lang_saveconfig\" /></p>\n";
        echo "</form>\n";
        echo $tablebottom;
        echo $blankline;
        echo $tabletop;
        echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n<tr>\n<td width=\"50%\" class=\"text\"><a href=\"admin.php\">$lang_overview</a></td>\n<td class=\"text\" align=\"right\"><a href=\"config.php?action=reset\">$lang_resetconf</a></td>\n</tr>\n</table>\n";
    } 
    echo $tablebottom;
    echo "<br />".$copyright; //não remova os direitos de copyright!
	echo "</td>\n</tr>\n</table>\n";		
    echo "<p>&nbsp;</p>";
} else {
echo "$lang_noaccess";
}
?>
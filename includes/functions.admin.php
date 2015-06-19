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

// ########### tabela na área administrativa #############
$tabletop = "\n<table cellspacing=\"0\" cellpadding=\"1\" width=\"100%\" border=\"0\">\n<tr>\n<td bgcolor=\"$bordercolor\">\n<table cellspacing=\"0\" cellpadding=\"15\" width=\"100%\" border=\"0\" bgcolor=\"$admintablebgcolor\" align=\"center\">\n<tr>\n<td class=\"text\">\n";
$tablebottom = "</td>\n</tr>\n</table>\n</td>\n</tr>\n</table>\n";
$blankline = "<img src=\"$img_relpath/spacer.gif\" width=\"10\" height=\"8\" border=\"0\" alt=\"\" /><br />";

if (!isset($_GET['action'])) {
        $action = '';
    } else {
        $action = $_GET['action'];
    }
	
// links
if ($action=="showlog") {
$link = "log.php?action=showlog";
} elseif ($action=="entries") {
$link = "admin.php?action=entries";
} elseif ($action=="avatars") {
$link = "admin.php?action=avatars";
} elseif ($action=="smilies") {
$link = "admin.php?action=smilies";
} elseif ($action=="templates") {
$link = "admin.php?action=templates";
} elseif ($action=="quicksearch") {
$qc=$_REQUEST['qc'];
$link = "admin.php?action=quicksearch&amp;qc=$qc";
}

//paginando
function pageing() {
global $CounterEnd,$CounterStart,$page_size,$PageNo,$MaxPage,$RecordCount,$lang,$img_rootpath,$img_relpath,$dir_path,$url,$link;
$pagetext = "";
include($dir_path . '/languages/'.$lang.'_lang.inc.php');

	if($PageNo != 1){
        $PrevStart = $CounterStart - 1;
		if ($PrevStart == 0) {
		$PrevStart=1;
		}
		$srcBack = @getimagesize("$img_rootpath/back.gif");
        $pagetext .= "<a href=\"$link&amp;PageNo=$PrevStart\"><img src=\"$img_relpath/back.gif\" border=\"0\" alt=\"$lang_previouspage\" $srcBack[3] align=\"middle\" /></a> ";
        }
        $c = 0;

        //Imprimir número de páginas
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
               if ($c % $page_size == 0) {
			  if ($c == $PageNo) {
                    $pagetext .= "<b>[$c]</b> ";
					} else {
                    $pagetext .= "<a href=\"$link&amp;PageNo=$c\">$c</a> ";
					}
                } else{
				 if ($c == $PageNo) {
                    $pagetext .= "<b>[$c]</b> "; 
					} else {
                    $pagetext .= "<a href=\"$link&amp;PageNo=$c\">$c</a> ";
					}
                }
            } else { 
			 if ($c == $PageNo) {
                    $pagetext .= "<b>[$c]</b> ";
					} else {
                    $pagetext .= "<a href=\"$link&amp;PageNo=$c\">$c</a> "; 
					}
                    break;           
            }
       }

      if($CounterEnd < $MaxPage){
          $NextPage = $CounterEnd + 1;
		  $srcForward = @getimagesize("$img_rootpath/forward.gif");
          $pagetext .= "<a href=\"$link&amp;PageNo=$NextPage\"><img src=\"$img_relpath/forward.gif\" border=\"0\" alt=\"$lang_nextpage\" $srcForward[3] align=\"middle\" /></a>";
      }
	return $pagetext;
}

function CheckExt($filename, $ext) {
	$passed = FALSE;
	$testExt = "\.".$ext."$";
		if (eregi($testExt, $filename)) {
			$passed = TRUE;
		}
	return $passed;
}

function file_copy($file_origin, $destination_directory, $file_destination, $overwrite, $fatal) {
       
if ($fatal) {
   $error_prefix = 'FATAL: File copy of \'' . $file_origin . '\' to \'' . $destination_directory . $file_destination . '\' failed.';
   $fp = @fopen($file_origin, "r");
       if (!$fp) {
       echo $error_prefix . ' Originating file cannot be read or does not exist.';
       exit();
       }
               
       $dir_check = @is_writeable($destination_directory);
       if (!$dir_check) {
       echo $error_prefix . ' Destination directory is not writeable or does not exist.';
       exit();
       }
               
       $dest_file_exists = file_exists($destination_directory . $file_destination);

         if ($dest_file_exists) { 
           if ($overwrite) {
           $fp = @is_writeable($destination_directory . $file_destination);
               if (!$fp) {
               echo  $error_prefix . ' Destination file is not writeable [OVERWRITE].';
               exit();
               }
               $copy_file = @copy($file_origin, $destination_directory . $file_destination);        
               }                          
       } else {

       $copy_file = @copy($file_origin, $destination_directory . $file_destination);
       }
         } else {
         $copy_file = @copy($file_origin, $destination_directory . $file_destination);
       }
   }
  
function checkfile ($filepath) {
global $tablebottom,$lang,$dir_path;
include($dir_path . '/languages/'.$lang.'_lang.inc.php');
	if (file_exists($filepath)) {
		echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_fileexists</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo $tablebottom;
		echo "</body>";
		echo "</html>";
		die();
	}
	return;
}

function checkextension ($testExt,$filepath) {
global $tablebottom,$lang,$dir_path;
include($dir_path . '/languages/'.$lang.'_lang.inc.php');
		if (!eregi($testExt, $filepath)) {
		echo "<b>$lang_error</b><br />";
		echo "<span class=\"error\">$lang_error_badext</span><br /><br />";
		echo "<a href=\"javascript:history.go(-1)\">$lang_return</a>";
		echo $tablebottom;
		echo "</body>";
		echo "</html>";
		die();
		}
	return;
}

function rec_copy ($from_path, $to_path) {
$this_path = getcwd();
	if(!is_dir($to_path)){
	mkdir($to_path, 0777);
}
	if (is_dir($from_path)) {
		chdir($from_path);
		$handle=opendir('.');
	while (($file = readdir($handle))!==false) {
		if (($file != ".") && ($file != "..")) {
			if (is_dir($file)) {
				chdir($this_path);
			rec_copy ($from_path.$file."/", $to_path.$file."/");
		    chmod($to_path.$file, 0666); 
			chdir($this_path);
			chdir($from_path);
			}
			if (is_file($file)){
		chdir($this_path);
		copy($from_path.$file, $to_path.$file);
		chmod($to_path.$file, 0666); 
		chdir($from_path);
		} 
	}
}
closedir($handle); 
}
}

$admindisable = 0; //habilitar ou desabilitar opções para salvar configurações no admin 1=sim, 0=não
$admindebug = 0; ///habilitar ou desabilitar statísticas para o administrador central 1=sim, 0=não
?>
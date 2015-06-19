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
 
 if (!isset($_GET['action'])) {
    $action = '';
} else {
    $action = $_GET['action'];
} 
			
//paging
function pageing() {
global $CounterEnd,$CounterStart,$page_size,$PageNo,$MaxPage,$RecordCount,$lang,$img_rootpath,$img_relpath,$dir_path,$url;
$pagetext = "";
include($dir_path . '/languages/'.$lang.'_lang.inc.php');

	if($PageNo != 1){
        $PrevStart = $CounterStart - 1;
		if ($PrevStart == 0) {
		$PrevStart=1;
		}
		$srcBack = @getimagesize("$img_rootpath/back.gif");
        $pagetext .= "<a href=\"index.php?PageNo=$PrevStart\"><img src=\"$img_relpath/back.gif\" border=\"0\" alt=\"$lang_previouspage\" $srcBack[3] align=\"middle\" /></a> ";
        }
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
               if ($c % $page_size == 0) {
			  if ($c == $PageNo) {
                    $pagetext .= "<b>[$c]</b> ";
					} else {
                    $pagetext .= "<a href=\"index.php?PageNo=$c\">$c</a> ";
					}
                } else{
				 if ($c == $PageNo) {
                    $pagetext .= "<b>[$c]</b> "; 
					} else {
                    $pagetext .= "<a href=\"index.php?PageNo=$c\">$c</a> ";
					}
                }
            } else { 
			 if ($c == $PageNo) {
                    $pagetext .= "<b>[$c]</b> ";
					} else {
                    $pagetext .= "<a href=\"index.php?PageNo=$c\">$c</a> "; 
					}
                    break;           
            }
       }

      if($CounterEnd < $MaxPage){
          $NextPage = $CounterEnd + 1;
		  $srcForward = @getimagesize("$img_rootpath/forward.gif");
          $pagetext .= "<a href=\"index.php?PageNo=$NextPage\"><img src=\"$img_relpath/forward.gif\" border=\"0\" alt=\"$lang_nextpage\" $srcForward[3] align=\"middle\" /></a>";
      }
	return $pagetext;
}


unset($urlSearchArray);
unset($urlReplaceArray);
unset($emailSearchArray);
unset($emailReplaceArray);
function parseurl($messagetext) { 

  global $urlSearchArray, $urlReplaceArray, $emailSearchArray, $emailReplaceArray;

  if (!isset($urlSearchArray)) {
    $urlSearchArray = array(
      "/([^]_a-z0-9-=\"'\/])((https?|ftp|gopher|news|telnet):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si","/^((https?|ftp|gopher|news|telnet):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si"
    );

    $urlReplaceArray = array(
      "\\1[url]\\2\\4[/url]","[url]\\1\\3[/url]"
    );

    $emailSearchArray = array(
      "/([ \n\r\t])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4}))/si","/^([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4}))/si"
    );

    $emailReplaceArray = array(
      "\\1[email]\\2[/email]","[email]\\0[/email]"
    );
  }

  $text = preg_replace($urlSearchArray, $urlReplaceArray, $messagetext);
  
  if (strpos($text, "@")) {
  $text = preg_replace($emailSearchArray, $emailReplaceArray, $text);
  }

  return $text;

}

############### bbcode ##########################
function bbcode($text) {
  
  $text=eregi_replace("\\[img\\](http://[^\\[]+)\\[/img\\]","<img src=\"\\1\" border=\"0\">",$text);
  $text=eregi_replace("\\[b\\]([^\\[]*)\\[/b\\]","<b>\\1</b>",$text);
  $text=eregi_replace("\\[i\\]([^\\[]*)\\[/i\\]","<i>\\1</i>",$text);
  $text=eregi_replace("\\[u\\]([^\\[]*)\\[/u\\]","<u>\\1</u>",$text);
  $text=eregi_replace("\\[email\\]([^\\[]*)\\[/email\\]","<a href=\"mailto:\\1\">\\1</a>",$text);
  $text=eregi_replace("\\[url\\]www.([^\\[]*)\\[/url\\]","<a href=\"http://www.\\1\" target=\"_blank\">www.\\1</a>",$text);
  $text=eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=\"_blank\">\\1</a>",$text);
  $text=eregi_replace("\\[url=www.([^\\[]+)\\]([^\\[]*)\\[/url\\]","<a href=\"http://www.\\1\" target=\"_blank\">\\2</a>",$text);
  $text=eregi_replace("\\[url=http://([^\\[]+)\\]([^\\[]*)\\[/url\\]","<a href=\"http://\\1\" target=\"_blank\">\\2</a>",$text);  
  $text=eregi_replace("\\[i\\]([^\\[]*)\\[/i\\]","<i>\\1</i>",$text);
  $text=eregi_replace("\\[u\\]([^\\[]*)\\[/u\\]","<u>\\1</u>",$text);
  $text=eregi_replace("\\[b\\]([^\\[]*)\\[/b\\]","<b>\\1</b>",$text);
  return $text;
}

############## caracteres repetidos ##################

function repeatchar($badwords_replacement,$times) {
$retstring="";
  $counter=0;
  while ($counter++<$times) {
    $retstring.=$badwords_replacement;
  }
  return $retstring;
}

############## filtro de palavras censuradas ###################
unset($badword);
function badtext($text) {
  global $enablebadword,$bad_words,$badword,$badwords_replacement;
  if ($enablebadword==1 and $bad_words!="") {
    if (!isset($badword)) {
      $bad_words = preg_quote($bad_words);
      $bad_words = str_replace('/', '\\/', $bad_words);
      $badword=explode(" ",$bad_words);
    } else {
      reset($badword);
    }

    while (list($key,$val)=each($badword)) {
      if ($val!="") {
        if (substr($val,0,2)=="\\{") {
          $val=substr($val,2,-2);

          $text=trim(preg_replace("/([^A-Za-z])".$val."(?=[^A-Za-z])/si","\\1".repeatchar($badwords_replacement,strlen($val))," $text "));
        } else {
          $text=trim(preg_replace("/$val/si",repeatchar($badwords_replacement,strlen($val))," $text "));
        }
      }
    }
  }

  $text = str_replace(chr(173), '_', $text);
  $text = str_replace(chr(160), '_', $text);

  return $text;
}

// ############### função mail #################
function skmail($subject, $notice, $headers='') {
global $webmasteremail,$gbname;
    $webmasteremail = trim($webmasteremail);
	$gbname = stripslashes(trim($gbname));
    $subject = trim($subject);
    $notice = preg_replace("/(\r\n|\r|\n)/s", "\r\n", trim(stripslashes($notice)));
    $headers = "From: \"$gbname\" <$webmasteremail>\r\n" . $headers;
    mail($webmasteremail, $subject, $notice, trim($headers));
}

?>
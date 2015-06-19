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
?>
<!DOCTYPE HTML PUBLIC"-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Instalação do Mural de Recados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="mural.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#EFEFEF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php

if (!isset($HTTP_POST_VARS['action'])) {
    $action = '';
    } else {
    $action = $HTTP_POST_VARS['action'];
    } 
	
if ($action != "install") {
    $root = substr($_SERVER['SCRIPT_FILENAME'], 0, -12);

    ?>
<br><br>
<center>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5657489025436669";
/* Wespa Mural de Recados - 468x60 */
google_ad_slot = "7689038501";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</center><br>
<table border="0" cellpadding="0" cellspacing="1" align="center">
<tr><td bgcolor="#BCCDD1">
<table border="0" cellpadding="15" cellspacing="1">
<tr>
  <td bgcolor="#FFFFFF" class="text">
  <p class="headline"><strong>Olá, seja bem-vindo(a)!</strong></p>
  Você está a ponto de instalar o <b>Wespa Mural de Recados</b> em<br /> 
  seu servidor web. Tenha em conta que, no caso de você usar um prefixo<br />
  de banco de dados diferente do já existente, todas as outras<br />
  tabelas deste script de mural de recados serão excluidas!<br /><br />
  
  <p class="headline"><strong>Antes de você prosseguir...</strong></p>
  Agradecemos sua escolha para o uso do script de Mural de Recados<br />
  da <a href="http://www.wespadigital.com" target="_blank"><b>Wespa Digital Ltda.</b></a> O uso deste software é 100% gratuíto, mas<br />
  se você puder contribuir com uma doação de qualquer valor para<br />
  o projeto, sua contribuição será muito bem-vinda e você colabora<br />
  assim para que este e outros scripts oferecidos por Wespa Digital<br />
  continuem gratuítos para você. Utilize os botões a seguir para<br />
  fazer sua doação, por <a href="http://www.pagseguro.com.br" target="_blank"><b>PagSeguro</b></a> ou por <a href="http://www.paypal.com" target="_blank"><b>PayPal</b></a>.<br /><br />
  
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
  
  
  <span class="headline"><b>Informações sobre sua conta de banco de dados MySQL</b></span>
	<br />
	<br />
    <table border="0" cellpadding="2" cellspacing="1">
	<form action="instalar.php" method="POST">
    <input type="hidden" name="action" value="install" />
      <tr>
        <td class="text" bgcolor="#EFEFEF">Nome do banco de dados:</td>
        <td bgcolor="#EFEFEF"><input type="text" name="dbname" /></td></tr>
<tr>
        <td class="text" bgcolor="#EFEFEF">Servidor do banco de dados:</td>
        <td bgcolor="#EFEFEF"><input type="text" name="dbhost" value="localhost" /></td></tr>
<tr>
        <td class="text" bgcolor="#EFEFEF">Usuário do banco de dados:</td>
        <td bgcolor="#EFEFEF"><input type="text" name="dbusername" /></td></tr>
<tr>
        <td class="text" bgcolor="#EFEFEF">Senha do banco de dados:</td>
        <td bgcolor="#EFEFEF"><input type="password" name="dbpassword" /></td></tr>
<tr>
        <td class="text" bgcolor="#EFEFEF">Prefixo do banco de dados:</td>
        <td bgcolor="#EFEFEF"><input type="text" name="dbprefix" value="mural_" /></td></tr>
<tr>
<td colspan="2"><span class="text">Rota para a pasta do Wespa Mural de Recados:</span><br /><input name="dir_path" type="text" size="50" value="<?php echo $root ?>"><br /><br /><input type="submit" name="submit" value="Instalar"></td></tr>
</form></table>
<?php
   } 
if ($action == "install") {
    echo "<br /><br />";
    $dbname = $HTTP_POST_VARS['dbname'];
    $dbhost = $HTTP_POST_VARS['dbhost'];
    $dbusername = $HTTP_POST_VARS['dbusername'];
    $dbpassword = $HTTP_POST_VARS['dbpassword'];
	$dbprefix = $HTTP_POST_VARS['dbprefix'];
    $unixpath = $HTTP_POST_VARS['dir_path'];
    $adress = "http://" . substr($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 0, -12);
    $config = "<?php
\$dbhost = \"$dbhost\";
\$dbname = \"$dbname\";
\$dbusername = \"$dbusername\";
\$dbpassword = \"$dbpassword\";
\$dir_path = \"$unixpath\";
\$url = \"$adress\";
\$db_prefix = \"$dbprefix\";
?>";

    if ($dbname == "" or $dbhost == "" or $dbusername == "" or $dbpassword == "" or $unixpath == "" or $dbprefix == "") {
        echo "<blockquote class=\"error\"><b>Ocorreu um erro!</b><br />Você não preencheu todos os campos. Por favor, preencha todos os campos corretamente<br /><a href=\"javascript:history.go(-1)\">Tente outra vez</a></blockquote>";
        exit;
    } 

    $connection = @mysql_connect($_POST['dbhost'], $_POST['dbusername'], $_POST['dbpassword'])
    or die("<blockquote class=\"error\"><b>Ocoreu um erro!</b><br />Não foi possível conectar-se ao servidor de banco de dados MySQL! Por favor, verifique o usuário e senha.<br /><a href=\"javascript:history.go(-1)\">Tente outra vez</a></blockquote>");
    $db = @mysql_select_db($_POST['dbname'], $connection)
    or die("<blockquote class=\"error\"><b>Ocoreu um erro!</b><br />Nome do bando de dados éstá incorreto.<br /><a href=\"javascript:history.go(-1)\">Tente outra vez</a></blockquote>");

    $del = "DROP TABLE IF EXISTS `".$dbprefix."book`";
    $del1 = "DROP TABLE IF EXISTS `".$dbprefix."conf`";
    $del2 = "DROP TABLE IF EXISTS `".$dbprefix."smilies`";
    $del3 = "DROP TABLE IF EXISTS `".$dbprefix."adminlog`";
    $del4 = "DROP TABLE IF EXISTS `".$dbprefix."avatars`";

  $sql = "CREATE TABLE ".$dbprefix."book (
  id int(11) unsigned NOT NULL auto_increment,
  name varchar(100) NOT NULL default '',
  avatar int(11) default '0',
  email varchar(100) NOT NULL default '',
  homepage varchar(150) NOT NULL default '',
  country varchar(50) NOT NULL default '',
  comments text NOT NULL,
  answer text NOT NULL,
  datetime int(20) NOT NULL default '0',
  ip varchar(20) NOT NULL default '0',
  online int(1) NOT NULL default '0',
  PRIMARY KEY (id),
  KEY id (id)
  ) TYPE=MyISAM;";

  $sql1 = "CREATE TABLE ".$dbprefix."conf (
  id int(11) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  value varchar(255) NOT NULL default '0',
  PRIMARY KEY (id),
  KEY id (id)
  ) TYPE=MyISAM;";

  $sql2 = "CREATE TABLE ".$dbprefix."adminlog (
  id int(11) NOT NULL auto_increment,
  ip varchar(20) NOT NULL default '',
  host varchar(50) NOT NULL default '',
  machine varchar(255) NOT NULL default '',
  datetime int(10) default NULL,
  PRIMARY KEY  (id),
  KEY id (id)
  ) TYPE=MyISAM;";

  $sql3 = "CREATE TABLE ".$dbprefix."smilies (
  id int(11) unsigned NOT NULL auto_increment,
  filename varchar(100) NOT NULL default '',
  alttag varchar(100) NOT NULL default '',
  sort int(11) NOT NULL default '0',
  code varchar(20) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY id (id)
  ) TYPE=MyISAM;";

  $sql4 = "CREATE TABLE ".$dbprefix."avatars (
  id int(11) unsigned NOT NULL auto_increment,
  filename varchar(100) NOT NULL default '',
  alttag varchar(100) NOT NULL default '',
  sort int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id)
  ) TYPE=MyISAM;";

$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'smile.gif','Sorriso', 1,':)')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'wink.gif','Piscadinha', 2,';)')";
$data[] = "INSERT INTO ".$dbprefix."smilies (
id, filename, alttag, sort, code) VALUES (NULL, 'biggrin.gif','Sorrisão', 3,':D')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'sad.gif', 'Dodói', 4, ':(')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'confused.gif', 'Confuso(a)', 5, ':confuso:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'cry.gif', 'Choro', 6, ':choro:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'eek.gif', 'Soluço', 7, ':eek:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'evil.gif', 'Diabo', 8, ':diabo:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'heart.gif', 'Coração', 9, ':coracao:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'rolleyes.gif', 'Olhinho Virado', 10, ':olhinho:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'cool.gif', 'Legal', 11, ':legal:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'neutral.gif', 'Neutro(a)', 12, ':-/')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'redface.gif', 'Envergonahdo(a)', 13, ':vergonha:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'sick.gif', 'Inesperado', 14, ':opa:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'arrow.gif', 'Seta', 15, ':>:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'exclaim.gif', 'Exclamação', 16, ':!:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'tongue.gif', 'Língua', 17, ':p')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'question.gif', 'Pergunta', 18, ':?:')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'surprised.gif', 'Surpreso(a)', 19, ':O')";
$data[] = "INSERT INTO ".$dbprefix."smilies 
(id, filename, alttag, sort, code) VALUES (NULL, 'smug.gif', 'Queijudo', 20, ':queijudo:');";

$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar1.gif', 'Feliz', 1)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar2.gif', 'Chorão', 2)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar3.gif', 'Quem sabe?', 3)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar4.gif', 'Esta sou eu', 4)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar5.gif', 'SIM!', 5)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar6.gif', 'Chorona', 6)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar7.gif', 'Oh sim?!', 7)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar8.gif', 'Bela', 8)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar9.gif', 'Oh - minha cabeça!', 9)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar10.gif', 'Poder!', 10)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar11.gif', 'Que raiva', 11)";
$av_data[] = "INSERT INTO ".$dbprefix."avatars 
(id, filename, alttag, sort) VALUES (NULL, 'avatar12.gif', 'Eu sou legal', 12);";

    $result1 = @mysql_query($del, $connection) 
	or die("<p align=\"center\" class=\"error\">1. " . mysql_error() . "</p>");
    $result2 = @mysql_query($del1, $connection) 
	or die("<p align=\"center\" class=\"error\">2. " . mysql_error() . "</p>");
    $result3 = @mysql_query($del2, $connection) 
	or die("<p align=\"center\" class=\"error\">3. " . mysql_error() . "</p>");
    $result4 = @mysql_query($del3, $connection) 
	or die("<p align=\"center\" class=\"error\">4. " . mysql_error() . "</p>");
    $result5 = @mysql_query($del4, $connection) 
	or die("<p align=\"center\" class=\"error\">5. " . mysql_error() . "</p>");

    $result6 = @mysql_query($sql, $connection) 
	or die("<p align=\"center\" class=\"error\">0. " . mysql_error() . "</p>");
    $result7 = @mysql_query($sql1, $connection) 
	or die("<p align=\"center\" class=\"error\">1. " . mysql_error() . "</p>");
    $result8 = @mysql_query($sql2, $connection) 
	or die("<p align=\"center\" class=\"error\">2. " . mysql_error() . "</p>");
    $result9 = @mysql_query($sql3, $connection) 
	or die("<p align=\"center\" class=\"error\">3. " . mysql_error() . "</p>");
    $result10 = @mysql_query($sql4, $connection) 
	or die("<p align=\"center\" class=\"error\">4. " . mysql_error() . "</p>");
	
	for ($i=0;$i<sizeof($data);$i++) {
    mysql_query($data[$i], $connection) or die("p align=\"center\" class=\"error\">5. " . mysql_error() . "</p>");
	}
	
	for ($i=0;$i<sizeof($av_data);$i++) {
    mysql_query($av_data[$i], $connection) or die("p align=\"center\" class=\"error\">6. " . mysql_error() . "</p>");
	}
	
    // configuration
	$name['lang'] = "en";
	$name['gbname'] = "Wespa Mural de Recados";
	$name['logo'] = "logo.gif";
	$name['img_rootpath'] = $unixpath."/images";
	$name['img_relpath'] = $adress."/images";
	$name['av_rootpath'] = $unixpath."/images/avatars";
	$name['av_relpath'] = $adress."/images/avatars";
	$name['sm_rootpath'] = $unixpath."/images/smilies";		
	$name['sm_relpath'] = $adress."/images/smilies";
			
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
	$name['bad_words'] = "besta foda foda-se puta buceta caralho merda bosta viado gay safado safada piranha";
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
	$name['webmasteremail'] = "nome@".$_SERVER['HTTP_HOST'];
			
	$name['admin_user'] = "mural";
	$name['admin_pass'] = "mural";
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
        $sql13 = "INSERT INTO ".$dbprefix."conf SET name='" . addslashes($key) . "',value='" . addslashes($val) . "'";
        $result13 = mysql_query($sql13);
        if ($result13 == false) {
            $oops = "<p align=\"center\" class=\"error\">" . mysql_error() . "</p>";
            die ($oops);
        } 
    } 

    if ($connection == false or $result1 == false or $result2 == false or $result3 == false or $result4 == false or $result5 == false or $result6 == false or $result7 == false or $result8 == false or $result9 == false or $result10 == false or $result13 == false or $db == false) {
        exit;
    } else {
        $fp = @fopen("includes/mysql.inc.php", "w") or
        die("<p align=\"center\" class=\"error\">Cannot write to mysql.inc.php. Please check file permissions and make sure file is empty!</p>");
        fwrite($fp, $config); //write data into file
        
        $normurl = substr($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 0, -12); //get url
        mail("info@wespadigital.com", "Instalação: Wespa Mural de Recados 4.1", "Instalado em http://" . $normurl);
        echo "<p align=\"center\" class=\"text\"><font size=\"3\"><b>Wespa Mural de Recados foi instalado com sucesso!</b></font><br /><span class=error>Não se esqueça de excluir este arquivo (instalar.php)!</span><br /><br />Para o seu primeiro acesso, use:<br /><b>Usuário: mural</b><br /><b>Senha: mural</b><br /><br /><a href=\"admin/index.php\">Continuar e ir ao Painel do Administrador</a></p>";
    } 
} 
?>
</td></tr>
</table>
</td></tr>
</table><br>
<center>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5657489025436669";
/* Wespa Mural de Recados - 468x60 */
google_ad_slot = "7689038501";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</center><br>
<br /><center><span class="copyright"> Wespa Mural de Recados 4.1 &copy; 2012 <a href="http://www.wespadigital.com" target="_blank"><b>Wespa Digital</b></a></span><br /></center>
</body>
</html>
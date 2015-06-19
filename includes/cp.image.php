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


$f = $_GET['f'];
$t = $_GET['t'];

  if (!isset($t)) $t = "JPG";
  header ("Content-type: image/".strtolower($t));
  $im = @ImageCreate (10, 10);

  ereg("([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})", $f, $c);

  if ($c[0]) {
    $c[1]= hexdec($c[1]);
    $c[2]= hexdec($c[2]);
    $c[3]= hexdec($c[3]);
  }

  $bg = ImageColorAllocate ($im, $c[1], $c[2], $c[3]);
  if (strtolower($t) == "jpeg" OR strtolower($t) == "jpg") ImageJPEG ($im);
?>
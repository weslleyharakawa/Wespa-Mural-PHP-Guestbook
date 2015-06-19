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
// Wespa Mural de Recados 4.1
// Desenvolvido por Weslley A. Harakawa (weslley@wcre8tive.com)
// Todos os direitos reservados
// http://www.wespadigital.com
// info@wespadigital.com
// Código de uso livre, favor não remover os créditos nem os banners do Google Adsense.

class pmc_colorpicker {
    var $f;
    var $breite;
    var $anzahl;
    var $zellbreite;
    var $zellhoehe;
    var $zellabstand;
    var $j;
    var $b;
    var $img_type;
    var $fd;

    function pmc_colorpicker ($farbe = "FFFFFF", $blau = "00", $breite = 100, $anzahl = 5, $abstand = 1, $jump = 51, $img_type = "JPG", $fd) {
	
        $this->breite = $breite;
        $this->anzahl = $anzahl;
        $this->zellabstand = $abstand;
        $this->f = $farbe;
        $this->zellbreite = floor ($this->breite / $this->anzahl);
        $this->zellhoehe = $this->zellbreite;
        $this->j = $jump;
        $this->b = $blau;
        $this->img_type = $img_type;
        $this->fd = $fd;
    } 

    function panel ()
    {
        $ret = "<table cellspacing='" . $this->zellabstand . "' cellpadding='0' width='100%' border='0'>\n";

        $r = 0;
        $g = 0; 

        for ($i = 0; $i < $this->anzahl; $i++) {
            $ret .= "<tr>"; 

            for ($j = 0; $j < $this->anzahl; $j++) {
                $arr = $this->rgb2dec($this->f); 

                $r_start = ($arr["r"] - round ($this->anzahl / 2) * $this->j < 0) ? 0 : $arr["r"] - round ($this->anzahl / 2) * $this->j ;
                $g_start = ($arr["g"] - round ($this->anzahl / 2) * $this->j < 0) ? 0 : $arr["g"] - round ($this->anzahl / 2) * $this->j ;

                $r = ($r_start + $j * $this->j <= 255) ? $r_start + $j * $this->j : 255;
                $g = ($g_start + $i * $this->j <= 255) ? $g_start + $i * $this->j : 255;

                $ret .= $this->zelle($r, $g, $this->b, 1, $this->f);
            } 
            $ret .= "</tr>\n";
        } 

        $ret .= "</table><img src='../images/spacer.gif' height='4' border='0' alt=''><br><table cellspacing='" . $this->zellabstand . "' cellpadding='0' width='100%' border='0'>\n";

        $ret .= "<tr>";
        for ($k = 0;$k < $this->anzahl; $k++) {
            $b_start = ($this->b - round ($this->anzahl / 2) * $this->j < 0) ? 0 : $this->b - round ($this->anzahl / 2) * $this->j ;
            $b = ($b_start + $k * $this->j <= 255) ? $b_start + $k * $this->j : 255;
            $ret .= $this->zelle(0, 0, $b, 0, $this->f);
        } 
        $ret .= "</tr>";

        $ret .= "</table>";
        if ($this->f) {
            $ret .= $this->auswahl();
        } 
        $ret .= $this->diff();
        $ret .= $this->boxes();

        echo $ret;
    } 

    function auswahl ()
    {
        $ret .= "<img src='../images/spacer.gif' height='4' border='0' alt=''><br><table width='99%' cellpadding='3' cellspacing='0' border='0' align='center'>";
        $ret .= "<form action=\"javascript:eintragen('#".$this->f."')\" method=post><INPUT TYPE='hidden' name='form_farbe' value='#" . $this->f . "'><tr>";
        $ret .= "<td width='33%' bgcolor='e0e0e0'><img src='cp.image.php?f=" . $this->f . "&t=".$this->img_type."' width='16' height='16' border='1' alt='#".$this->f."'></td>";
        $ret .= "<td align='center' class='text' width='33%' bgcolor='e0e0e0'>#" . $this->f . "</td><td align=right width='33%' bgcolor='e0e0e0'><INPUT TYPE='submit' name='ok' value='ok'></td>";
        $ret .= "</tr>";
        $ret .= "<tr><td colspan=3><img src='../images/spacer.gif' height='1' border='0' alt=''></td></tr>";
        $ret .= "</form></table>";
        return $ret;
    } 

    function diff ()
    {
        global $c, $anz;
        global $PHP_SELF;
        $file = basename($PHP_SELF);

        $ret .= "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
        $ret .= "<tr>";
        $ret .= "<td class='text'><b>Difusão: $this->j</b><br>";

        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&anz=$anz&j=1'>1</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&anz=$anz&j=3'>3</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&anz=$anz&j=5'>5</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&anz=$anz&j=10'>10</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&anz=$anz&j=20'>20</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&anz=$anz&j=30'>30</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&anz=$anz&j=50'>50</a> ";

        $ret .= "</td>";
        $ret .= "</tr>";
        $ret .= "</table>";
        return $ret;
    } 

    function boxes ()
    {
        global $c;
        global $PHP_SELF;
        $file = basename($PHP_SELF);

        $ret .= "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
        $ret .= "<tr>";
        $ret .= "<td class='text'><b>Caixas: $this->anzahl</b><br>";

        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&j=$this->j&anz=3'>3</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&j=$this->j&anz=5'>5</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&j=$this->j&anz=7'>7</a> ";
        $ret .= "<a href='$file?fd=" . $this->fd . "&f=" . $this->f . "&b=$this->b&c=$c&j=$this->j&anz=9'>9</a> ";

        $ret .= "</td>";
        $ret .= "<tr>";
        $ret .= "</table>";
        return $ret;
    } 

    function zelle($red, $green, $blue, $c, $c_old)
    {
        global $PHP_SELF;
        $file = basename($PHP_SELF);
        $rc = strtoupper(dechex($red));
        $gc = strtoupper(dechex($green));
        $bc = strtoupper(dechex($blue));

        if ($red < 16) $rc = "0" . $rc;
        if ($green < 16) $gc = "0" . $gc;
        if ($blue < 16) $bc = "0" . $bc;

        $rgb = $rc . $gc . $bc;

        $ret = "\n<td width='$this->zellbreite' height='$this->zellhoehe' bgcolor='#$rgb'><a href='$file?fd=" . $this->fd . "&f=";
        if ($c == 1)
            $ret .= "$rgb";
        else
            $ret .= $c_old;
        $ret .= "&b=$blue&c=$c&j=" . $this->j . "&anz=$this->anzahl";
        $ret .= "'><img src='../images/spacer.gif' width='$this->zellbreite' height='$this->zellhoehe' border='0' alt='#$rgb'></a></td>";
        return $ret;
    } 

    function rgb2dec($rgbstr)
    {
        ereg("([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})", $rgbstr, $c);
        if ($c[0]) {
            $arr["r"] = hexdec($c[1]);
            $arr["g"] = hexdec($c[2]);
            $arr["b"] = hexdec($c[3]);
        } 
        return $arr;
    } 
} 

?>
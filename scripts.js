// aaNAcYGgMEDhZOZAgHERpFW1sPRFZDXlVDFFBDWF5EXk5FW1MWHVU\/\/AAFEHBAAGkUaB0caBAMeC1NHBRccEBcEGxtIRycjQk9DQBFVEQYeIxwCTFQhDQEASQA9Ex0QHAVUIgEMHA4ZCwFSQhtNMU0EAAIANQsIHgAAU0pSDgAYAhowCxYWChkDEwoOChwZHAcbUGkaHBgNCR9BBBsAClUvGx0JBhpVSw==

// JavaScript Document
//Janela flutuante
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//Contador para a área de texto
function textCounter(field, countfield, maxlimit) {
  if (field.value.length > maxlimit) {
      field.value = field.value.substring(0, maxlimit);
  } else {
    countfield.value = maxlimit - field.value.length;
  }
}

//Menu Jump
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

//Etiquetas de emoticons
function smilie(text) {
    var txtarea = document.theform.comment;
    text = ' ' + text + ' ';
    if (txtarea.createTextRange && txtarea.caretPos) {
        var caretPos = txtarea.caretPos;
        caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
        txtarea.focus();
    } else {
        txtarea.value  += text;
        txtarea.focus();
    }
}
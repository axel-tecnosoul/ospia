function getCursorPosition(tb){
  var el = tb.get(0);
  var pos = 0;
  if('selectionStart' in el) {
    pos = el.selectionStart;
  } else if('selection' in document) {
    el.focus();
    var Sel = document.selection.createRange();
    var SelLength = document.selection.createRange().text.length;
    Sel.moveStart('character', -el.value.length);
    pos = Sel.text.length - SelLength;
  }
  return pos;
}
function insertarContenido(elemento,valor){
  var cuerpo= $(elemento);
  var pos = getCursorPosition(cuerpo);
  texto=cuerpo.val();
  texto = texto.substring(0,pos)+valor+texto.substring(pos);
  cuerpo.val(texto);
  cuerpo.focus();
}
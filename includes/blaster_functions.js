function blastFindPosX(obj) {
  var curleft = 0;
  if (obj.offsetParent) {
    while (obj.offsetParent) {
      curleft += obj.offsetLeft
      obj = obj.offsetParent;
    }
  }
  else if (obj.x) { curleft += obj.x; }
  return curleft;
}
function blastFindPosY(obj) {
  var curtop = 0;
  if (obj.offsetParent) {
    while (obj.offsetParent) {
      curtop += obj.offsetTop
      obj = obj.offsetParent;
    }
  }
  else if (obj.y) { curtop += obj.y; }
  return curtop;
}
function computedStyle(obj, attrib) {
  if (document.defaultView && document.defaultView.getComputedStyle && obj) {
    var computedStyle = document.defaultView.getComputedStyle(obj, null);
    return computedStyle.getPropertyValue(attrib);
  } else if (obj && obj.currentStyle) {
    return obj.currentStyle.backgroundColor;
  } else {
    return null;
  }
}
function blastInitScripts() {
  initBlastDiv();
}

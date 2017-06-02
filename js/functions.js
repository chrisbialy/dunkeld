// prevent the default action of a form or link tag with browser support for
// IE8, IE9+ and other browsers
function stopDefaultAction(e) {
	if(e.preventDefault) {
		e.preventDefault();
	} else {
		e.returnValue=false;
	}
}

function createXHR() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	}
	else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
}

// Cross browser compatible event target
function getTargetElement(e) {
	var targetelement=null;
	targetelement=(e.target || e.srcElement || e.toElement)
	return targetelement;
}
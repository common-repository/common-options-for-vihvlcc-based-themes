function ToggleDebugControlVisibility(id, arrowid) {
	el = document.getElementById(id);
	arrow = document.getElementById(arrowid);
	ToggleVisibility(id);
	if(el.style.display == 'none') {
		arrow.innerHTML = "&#8593;";
	} else {
		arrow.innerHTML = "&#8595;";
	}
}

function DebugControlShowInfo(ControlName) {
	el = document.getElementById('DebugControl' + ControlName);
	els = document.getElementsByName('DebugControlInfoItem');
	//alert(els.length);
	for(i=0;i<els.length;i++) {
		//alert(i);
		els[i].style.display = 'none';
		
		}
	el.style.display = "";
}

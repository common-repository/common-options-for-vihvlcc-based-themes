function ToggleVisibility(id) {
	element = document.getElementById(id);
	if(element.style.display=='none') {
		element.style.display=''
		} else {
		element.style.display='none'
		}
	}

function ExchangeVisibility(id1,id2) {
	ToggleVisibility(id1);
	ToggleVisibility(id2);
	}
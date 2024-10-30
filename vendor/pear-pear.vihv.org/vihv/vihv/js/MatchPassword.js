function MatchPassword(element, target_id) {
	tgt = document.getElementById(target_id);
	if(element.value == tgt.value) {
		element.style.background='#0f0';
		} else {
		element.style.background = '#f00';
		}
	}
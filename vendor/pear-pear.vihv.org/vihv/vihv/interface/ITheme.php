<?php

namespace vihv;

interface ITheme {
	/**
	 * get xslt template filename for the control
	 * @return string template filename
	*/
	function getTemplate($controlClassName/*, $ControlId*/);
}
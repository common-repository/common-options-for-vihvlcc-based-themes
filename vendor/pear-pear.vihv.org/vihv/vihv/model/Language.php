<?php

namespace vihv;

class Language {

	public static function getBrowserLanguage() {
		$LangVars = explode(";",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		return explode(",",$LangVars[0]);
	}

}
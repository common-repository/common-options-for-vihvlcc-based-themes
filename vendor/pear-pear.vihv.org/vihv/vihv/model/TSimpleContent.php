<?php
require_once "config/TMysqliConfig.php";
require_once "vihv/db/TSqlKeyValue.php";


class TSimpleContent extends TSqlKeyValue {

	function Save($Key, $Value) {
		return parent::Save($this->AppendLanguage($Key), $Value);
		}
	function Load($Key) {
		return parent::Load($this->AppendLanguage($Key));
		}

	/**
	appends _\<lang short tag> to key if TLanguaege is defined
	*/
	function AppendLanguage($Key) {
		$Res = $Key;
		$Lang = new TLanguage();
		$Res = $Key."_".$Lang->GetLang();
		return $Res;
		}


	}
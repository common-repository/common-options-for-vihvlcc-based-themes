<?php

namespace vihv;

require_once "vihv/interface/IConfigManager.php";
require_once "vihv/interface/IModelConfig.php";

class ConfigManager implements IConfigManager {
	static private $Instance = NULL;

	var $Theme;
	var $ModelConfig;

	private function __construct() {
		
		}

	static function getInstance() {
		if(self::$Instance == NULL) {
			self::$Instance = new ConfigManager();
			}
		return self::$Instance;
		}

	static function SetTheme(ITheme $Theme) {
		$Manager = self::getInstance();
		$Manager->Theme = $Theme;
		}

	static function SetModelConfig(IModelConfig $Config) {
		$Manager = self::getInstance();
		$Manager->ModelConfig = $Config;
		}

	static function GetModel($InterfaceName,/*IControl*/ $Control = null, &$ModelFileName = null) {
		
		$Manager = self::getInstance();
//		var_dump($Manager);
		if(empty($Manager->ModelConfig)) {
			throw new Exception("Model config not set. Interface: ".$InterfaceName." Control: ".$Control." ModelFilename:".$ModelFileName);
		}
		$res = $Manager->ModelConfig->GetModel($InterfaceName, $Control, $ModelFileName);
//		var_dump($FileName);
		return $res;
		}

	static function getTemplate($ControlClassName) {
		$Manager = self::getInstance();
		if($Manager->Theme instanceof ITheme) {
			return $Manager->Theme->GetTemplate($ControlClassName);
		}
		throw new EThemeNotSet('Use \vihv\ConfigManager::setTheme');
	}
}

class EThemeNotSet extends Exception {}
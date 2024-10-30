<?php
namespace vihv;
/**
purpose is to make design templates (xslt) independent
each control registred in control manager to get configuration parametres from it (xslt filename)

this is Singlethon
*/
interface IConfigManager {
	//function Register($Control);
	
	/**
	 * 
	 * @param string $ControlClassName
	 * @return string control template filename
	 */
	static function GetTemplate($ControlClassName);
	
	/**
	 * 
	 * @param \vihv\IModelConfig $Config
	 */
	static function SetModelConfig(IModelConfig $Config);
	
	/**
	 * 
	 * @param string $InterfaceName model interface name
	 * @param \vihv\IControl $Control
	 * @return Object model
	 */
	static function GetModel($InterfaceName, /*IControl*/ $Control);
	}
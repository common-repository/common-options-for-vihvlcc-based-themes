<?php

namespace vihv;

require_once "vihv/interface/ITheme.php";

/**
theme data stored in xml file

Example of file
\<theme>
	\<HellowordControl>design/Helloword.xsl\</HellowordControl>
	\<SampleControl>design/Sample.xsl\</SampleControl>
\</theme>

this is simple list of configuration files for each control
*/
class XmlTheme implements ITheme {

	var $Filename;

	function __construct($Filename) {
		$this->Filename  = $Filename;
		}

	function GetTemplate($ControlClassName) {
		$file = file_get_contents($this->Filename, true);
		if($file === false) {
			throw new EXmlThemeTemplateNotFound('Theme configuration not found or corrupt (located in '.$this->Filename.')');
		}
		$Xml = new \SimpleXmlElement($file);
		if($Xml == false) {
			throw new EXmlThemeTemplateNotFound('Theme configuration not found or corrupt (located in config/Theme.xml by default)');
		}
		$Templates = $Xml->xpath("//".$ControlClassName);
		if($Templates == false) {
			throw new EXmlThemeTemplateNotFound('Template for '.$ControlClassName.' not found. Check '.$this->Filename);
		}
//		if($ControlClassName == 'TUniBesicMenuControl') {
//		foreach($Templates as $template) {
//			$match = (string)($template->attributes()->match);
//			var_dump($match);
//		}
//		}
		return (string)$Templates[0];
		}
	}
	
class EXmlThemeTemplateNotFound extends Exception {}
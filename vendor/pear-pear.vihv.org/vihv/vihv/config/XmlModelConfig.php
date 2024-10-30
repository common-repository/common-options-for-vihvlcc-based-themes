<?php
namespace vihv;

require_once "vihv/interface/IModelConfig.php";

class XmlModelConfig implements IModelConfig {
	var $Filename;

	function __construct($Filename) {
		$this->Filename  = $Filename;
		}

	function GetModel($InterfaceName,/*IControl*/ $Control = null, $ModelFileName = null) {
		$ModelClassName = '';
		$Xml = new \SimpleXmlElement(file_get_contents($this->Filename, true));
		//echo $Xml->asXml();
                $className = str_replace("\\","-",get_class($Control));
		if(!empty($Control)) {
			$ModelClassName = $Xml->xpath("//".$className."/".$InterfaceName."/@class");
			$ModelClassName = (string)reset($ModelClassName);
			$temp = $Xml->xpath("//".$className."/".$InterfaceName."/@file");
			$ModelFileName = (string)reset($temp);

			$ConfigClassName = $Xml->xpath("//".$className."/".$InterfaceName."/Config/@class");
			$ConfigClassName = (string)reset($ConfigClassName);
			$ConfigFileName = $Xml->xpath("//".$className."/".$InterfaceName."/Config/@file");
		}
		if($ModelClassName == '') {
			$ModelClassName = $Xml->xpath("//".$InterfaceName."/@class");
			$ModelClassName = (string)reset($ModelClassName);
			//echo "-=".$ModelClassName."=-";
			$ModelFileNames = $Xml->xpath("//".$InterfaceName."/@file");
			$ModelFileName = (string)reset($ModelFileNames);
			$ConfigClassName = $Xml->xpath("//".$InterfaceName."/Config/@class");
			$ConfigClassName = (string)reset($ConfigClassName);
			$ConfigFileName = $Xml->xpath("//".$InterfaceName."/Config/@file");
			} 
//File::searchIncludePath($ModelClassName);
		try {
			File::searchIncludePath($ModelFileName);
		} catch(EFileNotFoundException $e) {
			throw new EModelFileNotFound("File '".$ModelFileName."' not found, check config/model.xml");
		}
		require_once $ModelFileName;
		/*if( (include_once (string)$ModelFileName[0]) != 'OK' ) {
			throw new EModelNotFoundException('class '.get_class($Control).' asked for interface '.$InterfaceName.', but it is not found in '.$this->Filename." filename is ".(string)$ModelFileName[0]);
			}*/
		if((string)reset($ConfigFileName) != '') {
//			$FileName = $ConfigFileName[0];
//			echo "-=";
//			var_dump($FileName);
//			echo "=-";
			require_once reset($ConfigFileName);
			return new $ModelClassName(new $ConfigClassName());
			}
			
		return new $ModelClassName();
		}
	}
	
class EModelFileNotFound extends Exception {}
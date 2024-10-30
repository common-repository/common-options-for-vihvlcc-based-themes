<?php

namespace vihv;

class Xml {

	const WRAP_COUNT = 74;

	public static function MakeForest($Data) {
		$res = '';
		if(is_array($Data)) {
			foreach($Data as $key=>$value) {
				$temp = $key;
				if(is_int($key)) {
					$temp = "item";
					}
				$res .= self::MakeTree($value, $temp);
				}
			} else {
			$res = (string)$Data;
			}
		return $res;
		}

	public static function MakeTree($Data, $Tag, $Attributes = "") {
		$res = self::MakeForest($Data);
		return "<".$Tag.$Attributes.">".$res."</".$Tag.">";
		}

	public static function ToArray($Xml,$keyItem = "item") {
		return self::FromSimpleXml(new \SimpleXMLElement($Xml),$keyItem);
		}
	/**
	 * @return string surrounded with CDATA
	 */
	public static function cdata($string) {
		return "<![CDATA[".str_replace("<![CDATA[","",str_replace("]]>","",$string))."]]>"; 
	}

	public static function FromSimpleXml($XmlObject, $keyItem = "item") {
		
		if(count($XmlObject) == 0) {
			return (string)$XmlObject;
			}
		$res = array();
		foreach($XmlObject->children() as $child) {
			
			if($child->getName() == $keyItem) {
				$res[] = self::FromSimpleXml($child);
				} else {
				if(!isset($res[$child->getName()])) {
					$res[$child->getName()] = self::FromSimpleXml($child,$keyItem);
					} else {
					if(is_string($res[$child->getName()])) {
						$temp = $res[$child->getName()];
						$res[$child->getName()] = array();
						$res[$child->getName()][] = $temp;
						}
					$res[$child->getName()][] = self::FromSimpleXml($child,$keyItem);
					}
				}
			};
		return $res;
		}
		
	public static function FormatSimpleXml($xml) {
		$lt = "<span class='highline'>&#60;";
		$gt = "&#62;</span>";
		$children = $xml->children();
		$text = $xml->__toString();
		$attrs = $xml->attributes();
		$attrStr = '';
		foreach($attrs as $key=>$value) {
			$attrStr .= " ".$key."='".$value."'";
		}
		$html = '';
		if(count($children) > 0 ) {
			$html .= $lt.$xml->getName().$attrStr.$gt;
			$html .= "<dir>";
			foreach($children as $child) {
				$html .= self::FormatSimpleXml($child);
			}
			$html .= "</dir>";
			$html .= $lt."/".$xml->getName().$gt."<br/>";
		} elseif($text == '') {
			$html .= $lt.$xml->getName().$attrStr."/".$gt."<br/>";
		} else {
			$html .= $lt.$xml->getName()."".$attrStr.$gt;
			$html .= htmlspecialchars($text);
			$html .= $lt."/".$xml->getName().$gt."<br/>";
		}
		return $html;
	}
	/**
	 * Format and Highline Xml 
	 * @param $String XML as string
	 * @return HTML representing formatted XML
	 */	
	public static function FormatXml($String) {
		$xml = new \SimpleXMLElement($String);
		return self::FormatSimpleXml($xml);
		}
	}
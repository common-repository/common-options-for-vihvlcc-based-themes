<?php
namespace vihv;

class Where {
	var $Conditions;

	function __construct() {
		$this->Conditions = array();
		}

	function CreateWhere() {
		/**
		recursive funtion which create WHERE clause string from $Conditions array
		*/
		$res = "";
		foreach($this->Conditions as $key=>$cur) {
			$temp = $cur['value'];
			if(is_object($cur['value'])) {
				$temp = $cur['value']->CreateWhere();
				}
			if($key !=0 ){
				$res .= " ".$cur["operator"];
				}
			$res .= " ( ".$temp." ) ";
			}
		return $res;
		}

	function Append($Value, $Operator="AND") {
		$this->Conditions[] = array("operator" => $Operator, 
					"value" => $Value);
		}

	function __toString() {
		if(count($this->Conditions) == 0) { return ""; }
		$res = " WHERE ".$this->CreateWhere();
		return $res;
		}
	}


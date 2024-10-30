<?php

namespace vihv;

class OrderBy {

	var $Conditions;

	function __construct() {
		$this->Clear();
		}

	function Clear() {
		$this->Conditions = array();
		}

	function Append($Value, $Operator = "ASC") {
		$this->Conditions[] = array("value" => $Value, 
					"operator" => $Operator);
		}

	function CreateOrderBy() {
		$res = "";
		foreach($this->Conditions as $key=>$value) {
			if($key != 0) {
				$res .= ", ";
				}
			$res .= $value['value']." ".$value['operator'];
			}
		return $res;
		}

	function __toString() {
		if(count($this->Conditions) == 0) {
			return "";
			}
		return " ORDER BY ".$this->CreateOrderBy();
		}
	}


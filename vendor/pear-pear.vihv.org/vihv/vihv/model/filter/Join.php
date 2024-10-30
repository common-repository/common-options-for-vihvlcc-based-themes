<?php

namespace vihv;

class Join {
	var $Conditions;

	function __construct() {
		$this->Conditions = array();
		}

	function Append($Condition, $Operator = "LEFT JOIN") {
		$this->Conditions[] = array("operator" => $Operator, "value" => $Condition);
		}
	
	function GetJoin() {
		$res = "";
		foreach($this->Conditions as $key=>$cur) {
			$res .= " 
				".$cur['operator']." 
				relations ON ( ".$cur['value']." ) 
				";
			}
		return $res;
		}

	function __toString() {
		return $this->GetJoin();
		}

	}

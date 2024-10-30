<?php
namespace vihv;

require_once "vihv/model/filter/Where.php";
require_once "vihv/model/filter/OrderBy.php";
require_once "vihv/model/filter/Join.php";

interface IDocFilter {
	function __toString();
	}

class DocFilter implements IDocFilter {
	var $Where;
	var $OrderBy;
	var $Join;
	var $Limit;

	function __construct() {
		$this->Where = new Where();
		$this->OrderBy = new OrderBy();
		$this->Join = new Join();
		}

	function __toString() {
		return $this->Join.$this->Where.$this->OrderBy->__toString().$this->GetLimit();
		}

	function GetLimit() {
		if(!empty($this->Limit)) {
			return " LIMIT ".$this->Limit;
			}
		return "";
		}

	}

class DefaultDocFilter extends DocFilter {
	}

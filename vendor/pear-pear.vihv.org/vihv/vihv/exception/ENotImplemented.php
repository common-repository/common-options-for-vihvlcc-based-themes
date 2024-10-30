<?php

namespace vihv;

require_once 'Exception.php';

class ENotImplemented extends Exception {
	public function __construct($message = null, $code = null, $previous = null) {
		$message = 'Not implemented '.$message." in ".$this->getFile()." at line ".$this->getLine();
		parent::__construct($message, $code, $previous);
	}
}

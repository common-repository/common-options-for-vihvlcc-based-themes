<?php
namespace vihv;

require_once 'vihv/exception/Exception.php';

interface IModelConfig {
	function getModel($InterfaceName, /*IControl*/ $Control = null);
}

class EModelNotFoundException extends Exception {}
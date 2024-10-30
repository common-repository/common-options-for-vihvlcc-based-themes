<?php

namespace vihv;
/**
 * 
 */
class Environment {
	
	public static function requireOnce($classes, $path="", $extension='.php') {
		$backtrace = reset(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,1));
		$caller = $backtrace['file'];
		$callerExploded = explode("/",$caller);
		unset($callerExploded[count($callerExploded)-1]);
		$path = implode("/",$callerExploded)."/".$path;
		
		foreach($classes as $class) {
			require_once($path.$class.$extension);
		}
	}
}

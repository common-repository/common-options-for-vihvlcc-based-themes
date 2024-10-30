<?php

namespace vihv;

/**
 * wrapper for Cms classes, singleton
 * 
 * We need to set up class to wrap in the beginning
 * like TCms::setImplementation('TDrupal');
 * and then call TCms::whatever() will call TDrupal::whatever()
 * so we can switch between CMSs in a second
 */
class Cms {

	private static $implementation;
	
	public static function setImplementation($className) {
		self::$implementation = new $className;
	}
	public static function isDrupal() {
		if(self::$implementation == 'TDrupal') {
			return true;
		}
		return false;
	}
	
	public static function __callStatic($name, $arguments) {
		if(!method_exists(self::$implementation, $name)) {
			throw new Exception('Function '.self::$implementation."::".$name." does not exist");
		}
		$class = self::$implementation;
		$args = implode(",",$arguments);
		if(empty($args)) {
			return $class->$name();
		}
		return $class->$name($args);
	}
}

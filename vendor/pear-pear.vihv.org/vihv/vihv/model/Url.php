<?php

namespace vihv;

class Url {
	
	static function getRequestScheme() {
		if(isset($_SERVER['REQUEST_SCHEME'])) {
			return $_SERVER['REQUEST_SCHEME'];
		}
		if(isset($_SERVER['HTTPS'])) {
			if($_SERVER['HTTPS'] != 'off') {
				return 'https';
			}
		}
		return 'http';
	}
	
	static function getSiteUrl() {
		$port = ":".$_SERVER['SERVER_PORT'];
		if(in_array($port,[':80',':443'])) {
			$port = '';
		}
		return self::getRequestScheme()."://".$_SERVER['SERVER_NAME'].$port.self::getRootPath();
	}
	
	static function getCurrentUrl() {
		return self::getRequestScheme()."://".$_SERVER['SERVER_NAME'].self::getCurrentPath();
	}
	
	public static function getRootPath() {
		return str_replace("/index.php","",$_SERVER['PHP_SELF']);
	} 
	
	
	/**
	 * @return path without domain and search
	 */
	static function getCurrentPath() {
		$temp = explode("?",$_SERVER['REQUEST_URI']);
		return reset($temp);
	}
	
	/**
	 * almost the same as getCurrentPath, but site root excluded
	 * @return path on this site (hady for sites hosted in subfolder)
	 */
	static function getLocalPath() {
		return str_replace(self::getRootPath(),'',self::getCurrentPath());
	}
}

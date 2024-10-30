<?php
namespace vihv;

/**
 * service class for sequrity features
 */
class Security {

	/**
	 * filter input to be safe for using in sql statemetns, used for $_GET and $_POST in EventManager
	 * @arr array raw data
	 * @return array same data, but with all items processed with htmlspecialchars reqursively
	 */
	static function preventInjection($arr) {
		$res = array();
		foreach($arr as $key => $cur ) {
			if(is_array($cur)) {
					$res[$key] = self::preventInjection($cur);
				} else {
					$res[$key] = htmlspecialchars($cur, ENT_QUOTES);
				}
			}
		return $res;
	}

}

<?php
namespace vihv;

class Request {
	static function isAjax() {
			return ( isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				&& $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') || @$_POST['xhttprequest'];
		}
}

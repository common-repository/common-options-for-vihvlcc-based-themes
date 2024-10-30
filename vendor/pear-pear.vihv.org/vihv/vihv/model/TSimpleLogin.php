<?php
require_once "vihv/interface/ILogin.php";
require_once "vihv/event/TAuthorizationManager.php";


/**
simplest login class for only-one-user access
login and password are defined in configuration file
*/
class TSimpleLogin implements ILogin {
	function __construct($LoginConfig) {
		//var_dump($LoginConfig);
		$this->Config = $LoginConfig;
		}

	function Login($Login, $Password) {
		//var_dump($this->Config); exit;
		if($Login == $this->Config->Login &&
			$Password == $this->Config->Password) {
			TAuthorizationManager::SetUniqueID($Login);
			} else {
			TAuthorizationManager::DropUniqueID();
			throw new ELoginException("wrong login or password");
			}
		}

	function Logout() {
		TAuthorizationManager::DropUniqueID();
		}

	}

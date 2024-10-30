<?php
namespace vihv;

require_once "vihv/event/AuthorizationManager.php";

class XmlAcl implements IAcl {

	var $Xml;

	function __construct($Filename) {
		$this->Xml = new \SimpleXmlElement(file_get_contents($Filename, true));
		}

	function UserCanDo($Resource, $Action, $User) {
		$XRequest = "//acl[
			((resource = '".$Resource."')or(resource='any'))
			and((action = '".$Action."')or(action='any'))
			and((user = '".$User."')or(user = 'any'))
			]/type";
		//echo $XRequest."<br/>";
		$Permissions = $this->Xml->xpath($XRequest);
		$Res = false;
		foreach($Permissions as $Permission) {
			if((string)$Permission == "allow") {
				$Res = true;
				}
			}
		foreach($Permissions as $Permission) {
			if((string)$Permission == "deny") {
				$Res = false;
				}
			}
		//var_dump($Permissions);
		//var_dump($Res);
		return $Res;
		}

	function CurrentUserCanDo($Resource, $Action) {
		return $this->UserCanDo($Resource, $Action, $this->GetCurrentUser());
		}

	function GetCurrentUser() {
		return \vihv\AuthorizationManager::GetUniqueId();
		}
	}
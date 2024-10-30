<?php

namespace vihv;

/**
 * this class used in case no ACL needed, NoAcl will always allow any action
 */
class NoAcl implements IAcl{
	
	public function userCanDo($resource, $action, $user) {
		return true;
	}
	
	public function currentUserCanDo($resource, $action) {
		return true;
	}
}



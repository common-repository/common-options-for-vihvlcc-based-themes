<?php

namespace vihv;

require_once 'vihv/control/CMS/Wp/WpBasicMenuControl.php';
require_once 'vihv/model/CMS/Wp/WpMenu.php';

class WpAdvancedMenuControl extends WpBasicMenuControl {
		
	public function OnEnableEvent($Sender) {
		$menu = new WpMenu($this->menuLocation);
                $Sender->Data['menu'] = $menu->getItems();
		}
	
	}

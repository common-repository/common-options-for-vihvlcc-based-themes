<?php

namespace vihv;

class WpBasicMenuControl extends Control {
	
	public $menuLocation;
	
	public function __construct($menuLocation) {
		$this->menuLocation = $menuLocation;
		parent::__construct();
	}
	
	public function getRootTag() {
		return str_replace("\\","-",get_class($this))."_".str_replace("-","_",$this->menuLocation);
	}
	
	public function onParkedEvent($sender) {
		$sender->enable();
	}
		
	public function onEnableEvent($Sender) {
		ob_start();
		wp_nav_menu(array('theme_location'=>$this->menuLocation));
		$Sender->Data['menu'] = \vihv\Xml::cdata(ob_get_clean());
		}
	
	}

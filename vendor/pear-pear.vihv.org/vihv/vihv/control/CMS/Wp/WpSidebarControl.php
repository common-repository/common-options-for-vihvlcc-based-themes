<?php

namespace vihv;

class WpSidebarControl extends Control {

	public function __construct($sidebar, $noCDATA = false, $enabled = true) {
		$this->sidebarSlug = $sidebar;
		$this->noCDATA = $noCDATA;
		$this->enabledByDefault = $enabled;
		parent::__construct();
		}
		
		
	public function getRootTag() {
		return str_replace("\\","-",get_class($this))."_".str_replace("-","_",$this->sidebarSlug);
	}
		
	public function onParkedEvent($sender) {
		if($sender->enabledByDefault) {
			$sender->enable();
			}
		}
		
	public function onEnableEvent($Sender) {
		ob_start();
		dynamic_sidebar($this->sidebarSlug);
		if($this->noCDATA) {
			$Sender->Data['sidebar'] = ob_get_clean();
		} else {
			$Sender->Data['sidebar'] = \vihv\Xml::cdata(ob_get_clean());
		}
		}
	
	}

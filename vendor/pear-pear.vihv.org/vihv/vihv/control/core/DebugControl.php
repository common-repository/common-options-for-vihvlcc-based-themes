<?php

namespace vihv;

require_once "config/DebugControlConfig.php";
require_once 'vihv/control/Control.php';
/**
 * Debug Control can be used for 
 * viewing controls hierarhy
 * viewing possible events
 * viewing permissions
 * 
 * It will appear as hidden frame at the bottom of you sites page, click on it
 * to expand.
 * 
 * Should never been userd on live application. You can disable it in config/TDebugControl.php
 *
 * @author Vigorous Hive
 */
class DebugControl extends Control {
	
	const DEFAULT_TEMPLATE = "vihv/design/control/DebugControl/DebugControl.xsl";
	const DEFAULT_POSITION = '0';
	
	private $TargetControl;
	private static $instance;
	private $config;
	
	public function __construct() {
		parent::__construct();
		self::$instance = $this;
	}
	
	public static function getInstance() {
		return self::$instance;
	}
	
	function onParkedEvent($Sender) {
		$this->config = new DebugControlConfig();
		if($this->config->IsEnabled()) {
			$Sender->Enable();
		}
	}
	
	/**
	 * @param $Control DebugControl will keep an eye on this control and his children
	 */
	function SetTargetControl(IControl $Control) {
		$this->TargetControl = $Control;
		}
	function GetTargetControl() {
		if(!empty($this->TargetControl)) {
			return $this->TargetControl;
			}
		return $this->GetParent();
		}


	/**
	 * @return Tree of controls
	 */
	function GetTree() {
		return $this->GetTreeRecursive($this->GetTargetControl());
		}

		
	private function GetTreeRecursive($Control) {
		$ret['Name'] = $Control->GetResourceId();
		$ret['RootTag'] = $Control->GetRootTag();
		//get_class($Control);
		$ret['Active'] = "false";
		if($Control->IsEnabled()) {
			$ret['Active'] = "true";
			}
		$ret['xml'] = htmlspecialchars(
				Xml::FormatXml($Control->GetXml())		
			);
		$ret['event'] = array_keys($Control->Event);
		if($Control instanceof Container) {
			$res = array();
			foreach ($Control->getChildren() as $Child) {
				$res[] = $this->GetTreeRecursive($Child);
				}
			if(!empty($res)) {
				$ret['Children'] = $res;
				}
			}
		return $ret;
		}
		
	function onBeforeDisplayEvent($Sender) {
		$Sender->Data['tree'] = $Sender->GetTree();
		if(method_exists($this->config, 'getPosition')) {
			$Sender->pushData('position', $this->config->getPosition());
		}
	}
		
	function GetTemplate() {
			try {
				return parent::GetTemlate();
			} catch(Exception $e) {
				return self::DEFAULT_TEMPLATE;
			}
		}
	}


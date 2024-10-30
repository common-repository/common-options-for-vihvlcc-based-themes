<?php

namespace vihv;

class WpFooterControl extends Control {
	
	const DEFAULT_TEMPLATE = "vihv/design/Wp/WpFooterControl.xsl";
	
	public function onParkedEvent($sender) {
		$sender->Enable();
		}
		
	public function onEnableEvent($Sender) {
		ob_start();
		wp_footer();
		$Sender->Data['wpfooter'] = \vihv\Xml::cdata(ob_get_clean());
	}
	
	public function getTemplate() {
			try {
				return parent::GetTemlate();
			} catch(Exception $e) {
				return self::DEFAULT_TEMPLATE;
			}
		}
	
	}

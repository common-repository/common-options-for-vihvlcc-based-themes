<?php
namespace vihv;
require_once "vihv/model/CMS/Wp/WordpressWrapper.php";

class WpHeadControl extends Control {
	const DEFAULT_TEMPLATE = "vihv/design/Wp/WpHeadControl.xsl";

	function onParkedEvent($sender) {
		$sender->Enable();
		}

	function OnEnableEvent($Sender) {
		ob_start();
		wp_head();
		$Sender->Data['wphead'] = \vihv\Xml::cdata(ob_get_clean());
		$Sender->Data['template_url'] = get_bloginfo('template_url');
		$Sender->Data['siteurl'] = WordpressWrapper::getSiteUrl();
		$Sender->Data['title'] = WordpressWrapper::getSiteTitle();
		$Sender->Data['favicon'] = WordpressWrapper::getFavicon();
		if(class_exists('WpThemeColors')) {
			$options = array();
			foreach(WpThemeColors::getColors() as $color) {
				$options[] = $color['name']."=".urlencode(get_theme_mod('vihv_'.$color['name'], $color['default']));
			}		
			$Sender->Data['cssoptions'] = "<![CDATA[".implode('&',$options)."]]>";
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

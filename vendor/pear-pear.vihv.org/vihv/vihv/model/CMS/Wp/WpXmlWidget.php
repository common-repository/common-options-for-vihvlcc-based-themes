<?php

namespace vihv;

abstract class WpXmlWidget extends \WP_Widget {
	abstract protected function getWidgetId();
	abstract protected function getWidgetName();
	abstract protected function createControl($args, $instance);
	
	protected function getRootTag() { 
		return get_class($this);
	}
	
	public function __construct() {
		parent::__construct(
			$this->getWidgetId(), 
			$this->getWidgetName(), 
			array('description' => __($this->getWidgetName(), TEXT_DOMAIN),) 
		);
	}
	
	public function widget($args, $instance) {
		$Control = $this->createControl($args, $instance);
		if ($Control->isEnabled()) {
			/* ugly bugfix 
			 * DOMDocument::saveHTML will encode all UTF8 characters if
			 * meta econding is not set
			 * That means that for part of an HTML containing no header
			 * we should decode it back
			 */
//			echo "widgetControl::".get_class($Control);
			echo html_entity_decode($Control->GetHtml(),ENT_NOQUOTES, 'UTF-8');
		    //echo $Control->GetHtml();
		}
	}
}



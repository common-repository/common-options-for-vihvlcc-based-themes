<?php
namespace vihv;

/**
 * base class for wp widget control (frontend)
 */
class WpWidgetControl extends Control {
	
	
	protected $args;
	protected $instance;

	public function __construct($args, $instance) {
            $this->args = $args;
            $this->instance = $instance;
            parent::__construct();
        }

	public function onParkedEvent($sender) {
		/*
		 * most widgets should enabled if control is created
		 */
		$sender->enable();
	}
}
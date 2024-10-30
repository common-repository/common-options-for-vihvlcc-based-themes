<?php

namespace vihvlccPlugin;

class OptionsPage {
	public function __construct() {
		\add_action('admin_menu', function() {
			\add_menu_page('VihvLCC Options',
				'VihvLCC Options' ,
				'edit_theme_options', 
				'vihvlcc-options',
				[$this,'thePage'],
				\plugin_dir_url('common-options-for-vihvlcc-based-themes').'/common-options-for-vihvlcc-based-themes/img/logo.png');
		});
	}
	
	public function thePage() {
		$eventManager = new \vihv\EventManager();
		$eventManager->setAcl(new \vihv\NoAcl());
		$control = new OptionsControl();
		$control->setTheme(new \vihv\JsonTheme(dirname(__DIR__).'/config/theme.json'));
		$eventManager->park($control);
		$eventManager->doEvents();
		echo $control->getHtml();
	}
}

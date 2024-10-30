<?php

namespace vihvlccPlugin;

class OptionsControl extends \vihv\Control {
	
	const PREFIX = 'vihvlccplugin_';
	
	public function onGetEvent($sender, $input) {
		wp_enqueue_style('vihvlccplugin', plugin_dir_url('common-options-for-vihvlcc-based-themes')."/common-options-for-vihvlcc-based-themes/css/vihvlccplugin.css");
		$this->pushData('labels', [
		    'pageTitle' => __('Common options for VihvLCC based themes', 'vihvlccplugin'),
		    'headerMessage' => __('This options affect only VihvLCC based themes','vihvlccplugin'),
		    'save' => __('Save', 'vihvlccplugin'),
		    'enableDebugger' => __('Enable Debugger', 'vihvlccplugin'),
		    'debuggerPositionTitle' => __('Debugger button position','vihvlccplugin'),
		]);
		$this->pushData('enableDebugger', get_option(self::PREFIX."enableDebugger"));
		$this->pushData('debuggerPosition', get_option(self::PREFIX."debuggerPosition", \vihv\DebugControl::DEFAULT_POSITION));
	}
	
	public function onPostEvent($sender, $input) {
		$input = stripslashes_deep($input);
		update_option(self::PREFIX."enableDebugger", $input['debugger'] == 'on');
		update_option(self::PREFIX."debuggerPosition", (int)$input['debuggerposition']);
	}
}

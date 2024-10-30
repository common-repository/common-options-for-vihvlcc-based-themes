<?php

/**
 * @package VihvLcc 3
 */
/*
Plugin Name: Vigorous Hive Losely Coupled Components v3 as WP Plugin
Description: Required for VihvLCC based themes
Version: 1.0.0
Author: Vigorous Hive
Author URI: http://lcc.vihv.org
License: MIT
Text Domain: vihvlccplugin
*/
ini_set("include_path",__DIR__.PATH_SEPARATOR.__DIR__."/vendor/vihv/vihv".PATH_SEPARATOR.ini_get("include_path"));
require_once 'vihv/autoload.php';

/* autoloader for this plugin */
spl_autoload_register(function($className) {
	$locator = new \vihv\Locator('vihvlccPlugin');
	$locator->requireOnce($className, __DIR__."/inc");
});
new \vihvlccPlugin\OptionsPage();



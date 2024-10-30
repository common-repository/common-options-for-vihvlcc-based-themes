<?php
require_once 'vihv/misc/Locator.php';

spl_autoload_register(function($className) {
	$locator = new \vihv\Locator('vihv');
	$locator->requireOnce($className, __DIR__);
});

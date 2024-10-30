<?php


class DebugControlTest extends PHPUnit_Framework_TestCase{
	public function testCreate() {
		require_once 'vihv/control/core/DebugControl.php';
		$control = new \vihv\DebugControl();
	}
}

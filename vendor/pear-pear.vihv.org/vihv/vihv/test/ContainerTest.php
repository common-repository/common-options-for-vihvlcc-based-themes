<?php


class ContainerTest  extends PHPUnit_Framework_TestCase {
	
	public function testCreate() {
		
		require_once 'vihv/control/Container.php';
		require_once 'vihv/acl/NoAcl.php';
		\vihv\EventManager::setAcl(new \vihv\NoAcl());
		
		$container = new \vihv\Container();
	}
	
	public function testAddChild() {
		require_once 'vihv/control/Container.php';
		require_once 'vihv/acl/NoAcl.php';
		\vihv\EventManager::setAcl(new \vihv\NoAcl());
		
		$control = new \vihv\Control();
		$container = new \vihv\Container();
		$this->assertEquals(0, $container->childrenCount());
		$container->addChild($control);
		$this->assertEquals(1, $container->childrenCount());
		
	}
}

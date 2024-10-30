<?php

class ControlTest extends PHPUnit_Framework_TestCase {
	
	public function testSelf() {
		$this->assertTrue(true);
	}
	
	public function testCreate() {
		require_once 'vihv/control/Control.php';
		require_once 'vihv/acl/NoAcl.php';
		
		\vihv\EventManager::setAcl(new \vihv\NoAcl());
		$control = new \vihv\Control();
	}
	
	public function testOnGet() {
		require_once 'vihv/control/Control.php';
		require_once 'vihv/acl/NoAcl.php';
		
		\vihv\EventManager::setAcl(new \vihv\NoAcl());
		$control = new \vihv\Control();
		
		$control->setEvent('onGet',[$this, 'onGetFor_testOnGet']);
		$this->assertFalse($control->isEnabled());
		$control->onGet(['enableMe'=>0]);
		$this->assertFalse($control->isEnabled());
		$control->onGet(['enableMe'=>1]);
		$this->assertTrue($control->isEnabled());
		$control->onGet(['enableMe'=>0]);
		$this->assertFalse($control->isEnabled());
		$_GET = ['enableMe'=>1];
		\vihv\EventManager::doEvents();
		$this->assertTrue($control->isEnabled());
	}
	
	public function testOnPost() {
		require_once 'vihv/control/Control.php';
		require_once 'vihv/acl/NoAcl.php';
		
		\vihv\EventManager::setAcl(new \vihv\NoAcl());
		$control = new \vihv\Control();
		$control->setEvent('onPost',[$this, 'onGetFor_testOnGet']);
		$_GET = [];
		$_POST = ['enableMe'=>1];
		\vihv\EventManager::doEvents();
		$this->assertTrue($control->isEnabled());
	}
	
	public function onGetFor_testOnGet($sender, $input) {
		if($input['enableMe'] == 1) {
			$sender->enable();
			return;
		}
		$sender->disable();
	}
	
	public function testData() {
		require_once 'vihv/control/Control.php';
		require_once 'vihv/acl/NoAcl.php';
		\vihv\EventManager::setAcl(new \vihv\NoAcl());
		
		$control = new \vihv\Control();
		
		$control->setData(['a'=>1]);
		$this->assertEquals(['a'=>1], $control->getData());
		$this->assertEquals('<vihv-Control><a>1</a></vihv-Control>',$control->getXml());
		$control->pushData('b',2);
		$this->assertEquals(['a'=>1,'b'=>2], $control->getData());
	}
	
	public function testXsltTemplate() {
		require_once 'vihv/control/Control.php';
		require_once 'vihv/acl/NoAcl.php';
		require_once 'vihv/theme/XmlTheme.php';
		\vihv\EventManager::setAcl(new \vihv\NoAcl());
		\vihv\ConfigManager::setTheme(new \vihv\XmlTheme(__DIR__."/xmlThemeFor_ControlTest.xml"));
		
		$control = new \vihv\Control();
		$control->setData(['a'=>1]);
		
		$this->assertEquals('vihv/test/design/vihv-Control.xsl', $control->getTemplate());
		$this->assertEquals('<html>a=1</html>', trim($control->getHtml()));
		$control->setData(['a'=>2]);
		$this->assertEquals('<html>a=2</html>', trim($control->getHtml()));
//		$this->assertTrue(false);
	}
}

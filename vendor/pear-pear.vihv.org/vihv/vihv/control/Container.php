<?php
namespace vihv;

require_once "vihv/control/Control.php";

/**
this control can contain another controls

Events:
OnChildTemplatesLoad
*/
class Container extends Control {

	/**
	 *
	 * @var Array of \vihv\Control
	 */
	private $Children;

	/**
	 * initialize object, add new event - onChildTemplatesLoad, then call parent constructor
	 */
	public function __construct() {
		$this->Children = array();
		$this->setEvent('onChildTemplatesLoad', array($this,'onChildTemplatesLoadEvent'));
		parent::__construct();
		}

	/**
	* add child control to container and park if possible
	* @param \vihv\Control $child 
	*/
	public function addChild(Control $child) {
		$child->setParent($this);
		$this->Children[] = $child;
		try {
			$this->getEventManager()->park($child);
		} catch(EControlEventManagerNotSet $e) {}
	}
	
	/**
	 * insert child control after previously added control, specified by class name
	 * @param string $previousClassName
	 * @param \vihv\Control $child
	 */
	public function insertChildAfter($previousClassName, Control $child) {
		$index = $this->getChildIndex($previousClassName);
		$this->insertChildAfterIndex($index, $child);
	}
	
	/**
	 * inser child control after specified position
	 * @param number $index
	 * @param \vihv\Control $child
	 */
	public function insertChildAfterIndex($index, Control $child) {
		$child->setParent($this);
		array_splice( $this->Children, $index+1, 0, [$child]);
		try {
			$this->getEventManager()->park($child);
		} catch(EControlEventManagerNotSet $e) {}
	}
	
	/**
	 * detect index of child control
	 * @param string $className
	 * @return number 
	 * @throws EContainerChildNotFound
	 */
	public function getChildIndex($className) {
		foreach($this->getChildren() as $key=>$value) {
			if(get_class($value) == $className) {
				return $key;
			}
		}
		throw new EContainerChildNotFound();
	}

	/**
	 * add multiple child controls
	 * @param $children array of Control
	 */	
	public function addChildren($children) {
		foreach($children as $child) {
			$this->addChild($child);
		}
	}
	
	/**
	 * get all child controls for this container
	 * @return Array of \vihv\Control 
	 */
	public function getChildren() {
		return $this->Children;
	}
	
	/**
	 * @param array $children array of IControl
	 */
	public function setChildren($children) {
		$this->Children = $children;
	}
	
	/**
	 * 
	 * @return number count of child controls
	 */
	public function childrenCount() {
		return count($this->Children);
		}
	
	/**
	 * enable child controls for this container (not recursive)
	 */
	public function enableChildren() {
		foreach($this->Children as $child) {
			$child->Enable();
		}
	}


	/**
	root template is loaded, so we add child templates
	*/
	function onRootTemplateLoadEvent($Sender, $DOM) {
		foreach($Sender->Children as $Name=>$Child) {
			if($Child->isEnabled()) {
				$Sender->appendChildTemplate($Child, $DOM);
				$Child->onRootTemplateLoad($DOM);
				}
			}
		
		}

	/**
	 * used by getXml later
	 * @return Array associative array with data of this control and all child controls in it
	 */
	function getData() {
		foreach($this->Children as $Child) {
			if($Child->isEnabled()) {
				$this->Data[$Child->getRootTag()] = $Child->getData();
				}
			}
		return $this->Data;
		}


	/**
	 * as for XSLT template are independent, we should include child templates into template of container
	 * @param \vihv\Control $Child
	 * @param \DOMDocument $DOM 	
	 */
	function appendChildTemplate(IHaveTemplate $Child, \DOMDocument $DOM) {
			/**
			this function add \<xsl:include href="child template filename"/> 
			*/
			$element = $DOM->createElementNS('http://www.w3.org/1999/XSL/Transform','xsl:include');
			$attribute = $DOM->createAttribute("href");
			$value = $DOM->createTextNode(str_replace("\\","/",File::SearchIncludePath($Child->getTemplate())));
			$attribute->appendChild($value);
			$element->appendChild($attribute);
			$DOM->firstChild->appendChild($element);
		}

	/**
	 * to be overriden by child class
	 * default handler for onChildTemplatesLoad event
	 * @param \vihv\Control $Sender object which provide this event handler, in most cases $sender is equal to $this, unless several different controls use the same event handler
	 */
	public function onChildTemplatesLoadEvent(Control $Sender) {}
}

class EContainerChildNotFound extends Exception {}


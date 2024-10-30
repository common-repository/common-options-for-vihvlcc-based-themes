<?php
namespace vihv;

require_once "vihv/interface/IAcl.php";
require_once "vihv/misc/Security.php";
require_once "vihv/exception/Exception.php";

/**
Publisher (in Publisher-Subscriber)
manage events for all controls
! this is not singlethon since version 3.0.0, see also new onParkedEvent (\vihv\Control class)
*/
class EventManager {

	/**
	 * @var Array of \vihv\Control
	 */
	private $listeners;

	public function __construct() {
		$this->listeners = array();
//		var_dump('eventManager::');
		}

	/**
	 * add new listener, do not call directly, use park() or parkMany() instead
	 * @param \vihv\Control $control
	 */
	public function addListener(IControl $control) {
		$this->listeners[] = $control;
		$control->setEventManager($this);
	}
	public function removeListener(IControl $control) {
		$control->dropEventManager();
		$index = array_search($control, $this->listeners);
		unset($this->listeners[$index]);
	}
	/**
	 * 
	 * @return Array of \vihv\Control listeners
	 */
	public function getAllListeners() {
		return $this->listeners;
	}
	
	/**
	 * add control as listener and also all his child controls, then call onParked event
	 * @param \vihv\Control $control
	 */
	public function park(IControl $control) {
		$this->addListener($control);
		if($control instanceof Container) {
			$this->parkMany($control->getChildren());
		}
		$control->onParked();
	}
	public function unpark(IControl $control) {
		$this->removeListener($control);
	}
	/**
	 * park each control from array
	 * @param Array of \vihv\Control $controls
	 */
	public function parkMany($controls) {
		if(empty($controls)) {
			return;
		}
		foreach($controls as $control) {
			$this->park($control);
		}
	}
	/**
	 * set ACL object, ACL object will check if current user is allowed to perform some action with control (see \vihv\Control::__call())
	 * @param \vihv\IAcl $acl
	 */
	public function setAcl(IAcl $acl) {
		$this->acl = $acl;
		}

	/**
	 * @param string $Name class name 
	 * @return \vihv\Control
	 * @throws EListenerNotFound
	 */
	public function getListenerByClassName($Name) {
		foreach($this->listeners as $Listener) {
			if(get_class($Listener) == $Name) {
				return $Listener;
				}
			}
		throw new EListenerNotFound($Name);
		}


	/**
	check permission for current user to do $action on $resource
	*/
	public function checkPermission($Resource, $Action) {
		if($this->acl instanceof IAcl) {
			return $this->acl->currentUserCanDo($Resource, $Action);
		}
		throw new EAclNotSet('Use EventManager::setAcl(..)');
	}

	/**
	 * call common events onPost, onGet, onDefaultPage in case it's post or get request, the onBeforeDisplay 
	 */
	public function doEvents() {
		if(!empty($_POST)) {
			$this->doPost();
			}
		if(empty($_GET) && empty($_POST)) {
			$this->doDefaultPage();
			}
//			echo '=';
		//if(!empty($_GET)) {
			$this->doGet();
		//	}
		$this->doBeforeDisplay();
		}

	/**
	 * call onBeforeDisplay event
	 */
	public function doBeforeDisplay() {
		$this->doEvent('onBeforeDisplay');
		}

	/**
	 * call onDefaultPage event
	 */
	public function doDefaultPage() {
		$this->doEvent('onDefaultPage', Security::PreventInjection($_GET));
		}

	/**
	 * call onGet event
	 */
	public function doGet() {
		$this->doEvent('onGet', Security::PreventInjection($_GET));
		}

	/**
	 * call onPost event
	 */
	public function doPost() {
		$this->doEvent('onPost', Security::PreventInjection($_POST));
		}
		
	/**
	 * call event by name
	 * @param string $Event
	 * @param Array $Input event params
	 */
	public function doEvent($Event, $Input = null) {
		foreach($this->listeners as $cur) {
			if($cur->Provide($Event)) {
				if(!empty($Input)) {
					$cur->$Event($Input);
					} else {
					$cur->$Event();
					}
				}
			}
		}
	}
	
class EAclNotSet extends Exception{}
class EListenerNotFound extends Exception{}
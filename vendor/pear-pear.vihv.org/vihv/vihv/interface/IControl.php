<?php
namespace vihv;

require_once 'vihv/exception/Exception.php';

/**
interface for all vihv controls
*/
interface IControl {
	
	/**
	@return part of html suitable to be embeded into ANY application
	*/
	function getHtml();

	/**
	@return data for displaying serialized as Xml, mostly for future use in xslt template
	*/
	function getXml();

	/**
	check if a control has event handler for specified event
	@return true if provide
	*/
	function provide($Name);

	/**
	Sets Container what own this control
	*/
	function setParent(Container $Container);

	/**
	event handler invoked after constructor
	*/
	function onCreateEvent($sender);

	/**
	this event raised if you pass any data by http get method, this should be access for reading data and displaying in on web page
	vihv.org?a=b&v=i <-- this is get request
	$Input parameter in this case becomes array('a'=>'b', 'v'=>'i');
	*/
	function onGetEvent($Input,$Sender);

	/**
	this is handler for http POST method, should be used for data modification
	*/
	function onPostEvent($Input,$Sender);

	/**
	Example $Sender->SetEvent('OnEnable', array($this, 'OnEnableEvent'));
	@param $Name  name of event, event will be called like $Sender->OnEnable()
	@param $Handler array(object what contains method, method name) where "method" is a fuction what does all real work
	*/
	function setEvent($Name, $Handler);
	}
	
class EControlEventNotFound extends Exception {}
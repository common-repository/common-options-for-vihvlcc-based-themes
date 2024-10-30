<?php

namespace vihv;

/**
interface for Access Control List
you should pass implementation of IAcl to EventManager to take control over user access to all events

by default resource id for control is Class name[Config class name],
you can change this by overriding GetResourceId() methon in your control
*/
interface IAcl {

	/**
	 * @param $resource string resource name, by default equals to control name
	 * @param $action string action name, in most cases - event name (onAdd, onGet etc)
	 * @param $user string user identifier (username or user id)
	 * @return true if $user can do $action on the $resource 
	 */
	public function userCanDo($resource, $action, $user);

	/**
	 * @param $resource string resource name, by default equals to control name
	 * @param $action string action name, in most cases - event name (onAdd, onGet etc)
	 * @return true if current user can do $action on the $resource 
	 */
	public function currentUserCanDo($resource, $action);
}
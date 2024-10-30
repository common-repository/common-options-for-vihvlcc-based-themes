<?php

namespace vihv;

/**
 * this object has a method to get list of similar objects
 * handy for working with databases
 */
interface IListObject {

	/**
	 * @return array of IListObject
	 */
	public function getList();
	
}

<?php

namespace vihv;

interface IKeyValue {
	function save($key, $value);
	function load($key);
	function remove($key);
}
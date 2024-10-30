<?php

namespace vihv;

interface IMysqlConfig {
	function GetHost();
	function GetDbName();
	function GetUser();
	function GetPassword();
	function GetCharset();
	}
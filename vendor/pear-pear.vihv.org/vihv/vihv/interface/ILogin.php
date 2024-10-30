<?php

namespace vihv;

interface ILogin {
	function Login($Login, $Password);
	}

class ELoginException extends Exception {}
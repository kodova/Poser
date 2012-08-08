<?php

namespace Poser\Exception;

use Exception;

class PoserException extends Exception {
	function __construct($message, Exception $e = null) {
		parent::__construct($message, 0, $e);
	}
}

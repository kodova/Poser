<?php

namespace Kodova\Poser\Exception;


class UndefinedPropertyException extends \Exception {
	
	function __construct($property, $class, $e = null) {
		$message = "There is no property $property defined in $class";
		parent::__construct($message, 0, $e);
	}
}

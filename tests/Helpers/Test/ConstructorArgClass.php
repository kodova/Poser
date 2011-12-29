<?php

namespace Helpers\Test;


class ConstructorArgClass {
	
	private $test;
	
	function __construct($test) {
		$this->test = $test;
	}
}

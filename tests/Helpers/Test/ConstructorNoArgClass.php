<?php

namespace Helpers\Test;


class ConstructorNoArgClass {
	private $test;
	
	function __construct() {
		$this->test = "test";
	}
}

<?php

namespace Kodova\Poser\Helpers\Test;

class ConstructorOptionalArgClass {

	private $test = 0;

	public function __construct($test = 0) {
		$this->test = $test;
	}


}

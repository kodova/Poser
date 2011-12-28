<?php

namespace Poser\Invocation;

use Poser\Invocation\Invocation as Invocation;


class InvocationImp implements Invocation {
	
	
	public function __call($name, $args) {
		echo $name;
	}
	
	public static function __callStatic($name, $args) {
		echo $name;
	}
	
}

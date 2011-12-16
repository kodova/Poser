<?php

namespace Poser\Reflection;

use \Reflection as Reflection;
use \ReflectionMethod as ReflectionMethod;


class TypedMethod extends ReflectionMethod {
	
	function __construct($class, $method) {
		parent::__construct($class, $method);
	}
	
	/**
	 * Gets the return type of a given method. This will return
	 * value of supplied in the PHPDoc return value
	 *
	 * @return void
	 */
	public function getReturnType(){
		$doc = $this->getDocComment();
		$count = preg_match('/(@return\s*){1}((\\\?\w*)*)/s', $doc, $matches);
		if($count === 0){
			return null;
		}else{
			return $matches[2];
		}
	}
	
}	

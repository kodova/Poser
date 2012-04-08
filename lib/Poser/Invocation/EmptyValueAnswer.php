<?php

namespace Poser\Invocation;

class EmptyValueAnswer implements Answer {
	
	public function answer(Invocation $invocation){
		$method = $invocation->getMethod();
		$type = ($method == null) ? null : $method->getReturnType();
		
		if($type == null){
			return null;
		}
		
		switch ($type) {
			case 'string':
				return '';
			case 'int':
			case 'number':
			case 'integer':
				return 0;
			case 'float':
			case 'double':
				return .1;
			case 'array':
				return array();
			default:
				return null;
		}
	}

}

<?php

namespace Poser\Reflection;


class TypedParameter extends \ReflectionParameter {
	
	function __construct($class, $method, $parameter) {
		parent::__construct(array($class, $method), $parent);
	}
	
	/**
	 * Gets the type hint for the passed paramenter. If no type hint is 
	 * availiable then will return null
	 *
	 * @return mixed
	 */
	public function getTypeHint() {
		/*
			TODO Need to implement get type hint to return the type for this object
		*/
	}
}

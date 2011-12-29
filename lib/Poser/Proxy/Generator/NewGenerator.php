<?php

namespace Poser\Proxy\Generator;


class NewGenerator extends AbstractGenerator {
	
	function __construct($toMock) {
		parent::__construct($toMock);
	}
	
	public function getClassDeclaration(){
		$dec = new ClassDeclaration($class);
		$dec->setClassName($this->getClassName($this->mockType));
		$dec->setNamespace($this->getNamespace($this->mockType));
		return $dec;
	}
	
 	public function getMethodsToProxy(){
		return array();
	}
	
	/**
	 * Extracts the namespace from a given type without using
	 * reflection. We do not want to load the class defintion.
	 *
	 * @return void
	 */
	private function getNamespace($type){
		$parts = explode('\\', $type);
		unset($parts[sizeof($parts) - 1]); //this will remove the last element from the array aka the class name
		return implode('\\', $parts);
	}
	
	/**
	 * Extracts the class name of a given type without using
	 * reflection. We do not want to load the class defintion.
	 *
	 * @param string $type 
	 * @return void
	 */
	private function getClassName($type) {
		$parts = explode('\\', $type);
		return end($parts);
	}
}

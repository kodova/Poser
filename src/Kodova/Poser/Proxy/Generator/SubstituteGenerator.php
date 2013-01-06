<?php

namespace Kodova\Poser\Proxy\Generator;


use Kodova\Poser\MockOptions;

class SubstituteGenerator extends AbstractGenerator {
	
	/**
	 * @var MockOptions
	 */
	private $mockOptions;
	
	function __construct($toMock, MockOptions $mockOptions) {
		parent::__construct($toMock);
		$this->mockOptions = $mockOptions;
	}
	
	public function getClassDeclaration(){
		$dec = new ClassDeclaration($class);
		$dec->setClassName($this->getClassName($this->mockType));
		$dec->setNamespace($this->getNamespace($this->mockType));
		$dec->setImplements(array('\Kodova\Poser\Proxy\SubstituteProxy'));
		return $dec;
	}
	
 	public function getMethodsToProxy(){
		return array();
	}

	/**
	 * Extracts the namespace from a given type without using
	 * reflection. We do not want to load the class defintion.
	 *
	 * @param $type
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
	
	/**
	 * (non-PHPdoc)
	 * @see Poser\Proxy\Generator.AbstractGenerator::getConstants()
	 * @return array
	 * @return array
	 */
	public function getConstants(){
		return $this->mockOptions->getConstants();
	}
}



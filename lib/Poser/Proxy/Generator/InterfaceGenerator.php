<?php

namespace Poser\Proxy\Generator;

/**
 * This Generator is used for creating mock objects based on
 * a given interfaces. This mock will ensure that all
 * methods specified in the interface and extended interfaces
 * are proxied.
 *
 * @package default
 */
class InterfaceGenerator extends AbstractGenerator {
	
	private $name;

	function __construct($toMock, $name) {
		parent::__construct($toMock);
		$this->name = $name;
		
		//ensure the given mock is an interface
		if (!$this->getToMock()->isInterface()) {
			throw new GeneratorException(sprintf("The interface to mock %s is not a interface", $toMock));
		}
	}

	public function getClassDeclaration(){
		$classDec = new ClassDeclaration();
		$classDec->setClassName($this->name);
		$classDec->setImplements(array($this->getToMock()->getName()));
		return $classDec;
	}
	
	
	public function getMethodsToProxy(){
		return $this->getToMock()->getMethods(\ReflectionMethod::IS_PUBLIC);
	}
	
}

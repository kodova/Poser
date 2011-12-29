<?php

namespace Poser\Proxy\Generator;

/**
 * Creates a generator that can be used to generate classes
 * that extend a given type.
 *
 * @package default
 */
class ExtendedGenerator extends AbstractGenerator {
	
	private $name;
	
	/**
	 * Creates instance of geneartor
	 *
	 * @param string $toMock The type of object that needs to be extended
	 * @param string $name Then name of the of the generated class
	 */
	function __construct($toMock, $name) {
		parent::__construct($toMock);
		$this->name = $name;
		
		//ensure the class is not final
		if ($this->getToMock()->isFinal()) {
			throw new GeneratorException(sprintf('Unable to create proxy for %s because its final', $toMock));
		}
		//ensure toMock can be exteneded
		if ($this->getToMock()->isInterface()) {
			throw new GeneratorException(sprintf('Unable to create proxy for %s because its not instantiable or abstract', $toMock));
		}
		//need a empty contstructor in order to extend
		/*
			TODO Need to create a check for this
		*/
	}
	
	public function getClassDeclaration() {
		$class = new ClassDeclaration();
		$class->setExtends($this->getToMock()->getName());
		$class->setClassName($this->name);
		return $class;
	}
	
	public function getMethodsToProxy() {
		$constructor = $this->getToMock()->getConstructor();
		$methods = $this->getToMock()->getMethods(\ReflectionMethod::IS_PUBLIC);
		return array_diff($methods, array($constructor));
	}
}


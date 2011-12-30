<?php

namespace Poser\Proxy\Generator;

/**
 * Creates a generator that can be used to generate classes
 * that extend a given type.
 *
 * @package default
 */
class ExtendedGenerator extends AbstractGenerator {
	
	/**
	 * Creates instance of geneartor
	 *
	 * @param string $toMock The type of object that needs to be extended
	 * @param string $name Then name of the of the generated class
	 */
	function __construct($toMock) {
		parent::__construct($toMock);
		
		//ensure the class is not final
		if ($this->getToMock()->isFinal()) {
			throw new GeneratorException(sprintf('Unable to create proxy for %s because its final', $toMock));
		}
		//ensure toMock can be exteneded
		if ($this->getToMock()->isInterface()) {
			throw new GeneratorException(sprintf('Unable to create proxy for %s because its not instantiable or abstract', $toMock));
		}
		
		$constructor = $this->getToMock()->getConstructor();
		if ($constructor != null && $constructor->getNumberOfParameters() > 0) {
			throw new GeneratorException('An empty contructor is required to create a proxy for ' . $toMock);
		}
	}
	
	public function getClassDeclaration() {
		$class = new ClassDeclaration();
		$class->setExtends($this->getToMock()->getName());
		$class->setClassName($this->getProxyName($this->getToMock()->getShortName()));
		return $class;
	}
	
	public function getMethodsToProxy() {
		$remove = array();
		$methods = $this->getToMock()->getMethods(\ReflectionMethod::IS_PUBLIC);
		foreach ($methods as $method) {
			if ($method->isConstructor() || $method->isFinal() || $method->isStatic() || $method->getName() == '__call') {
				$remove[] = $method;
			}
		}
		return array_diff($methods, $remove);
	}
}


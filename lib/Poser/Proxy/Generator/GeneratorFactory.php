<?php

namespace Poser\Proxy\Generator;

/**
 * A factory for creating different types for class
 * generators. A new generator per object that needs
 * to be generated.
 *
 * @package default
 */
class GeneratorFactory {
	
	public function getGenerator($toMock, MockOptions $options) {
		if ($options->canMockStatic()) {
			return new NewGenerator($toMock);
		}
		
		$class = new \ReflectionClass($toMock, $options->getName());
		if ($class->isInterface()) {
			return new InterfaceGenerator();
		}
		
		//default
		return new ExtendedGenerator($toMock, $options->getName())
	}
	
}

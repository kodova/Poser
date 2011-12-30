<?php

namespace Poser\Proxy\Generator;

/**
 * A factory for creating different types for class
 * generators. A new generator per object that needs
 * to be generated.
 *
 */
class GeneratorFactory {
	
	public function getGenerator($toMock, \Poser\MockOptions $options) {
		if ($options->canMockStatic()) {
			return new NewGenerator($toMock);
		}
		
		$class = new \ReflectionClass($toMock);
		if ($class->isInterface()) {
			return new InterfaceGenerator($toMock);
		}
		
		//default
		return new ExtendedGenerator($toMock);
	}
	
}

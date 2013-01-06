<?php

namespace Kodova\Poser\Proxy\Generator;

/**
 * A factory for creating different types for class
 * generators. A new generator per object that needs
 * to be generated.
 *
 */
use Kodova\Poser\MockOptions;

class GeneratorFactory {

	/**
	 * Gets a generator that can build the created mock.
	 * @param string $toMock
	 * @param MockOptions $options
	 * @return Generator
	 */
	public function getGenerator($toMock, MockOptions $options) {
		if ($options->canMockStatic()) {
			return new SubstituteGenerator($toMock, $options);
		}
		
		$class = new \ReflectionClass($toMock);
		if ($class->isInterface()) {
			return new InterfaceGenerator($toMock);
		}
		
		//default
		return new ExtendedGenerator($toMock);
	}
	
}

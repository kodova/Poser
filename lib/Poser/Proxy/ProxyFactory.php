<?php

namespace Poser\Proxy;

use \Poser\MockOptions;
use \Poser\Proxy\ObjectCache;
use \Poser\Proxy\Generator\GeneratorFactory;
use \Poser\Proxy\SubstituteProxy;
use \Poser\MockingMonitor;

class ProxyFactory {
	/**
	 * @var ObjectCache
	 */
	private $objectCache;
	
	/**
	 * @var GeneratorFactory
	 */
	private $generatorFactory;
	
	/**
	 * @var MockingMonitor
	 */
	private $mockingMonitor;
	
	
	function __construct(ObjectCache $objectCache, GeneratorFactory $generatorFactory, MockingMonitor $mockingMonitor) {
		$this->objectCache = $objectCache;
		$this->generatorFactory = $generatorFactory;
		$this->mockingMonitor = $mockingMonitor;
	}

	public function createProxy($toMock, MockOptions $options) {
		//set the name in the options if needed
 		$name = $options->getName();
		if ($name == null) {
			$name = $toMock;
			$options->setName($name);
		}
	
		//are they requesting a mock that has alredy been built
		$obj = $this->objectCache->lookupByName($options->getName());
		if($obj != null){
			return $obj;
		}
		
		//are they requesting a mock that uses static that has already been defined
		if ($options->canMockStatic()) {
			$obj = $this->objectCache->lookupByType($toMock);
			if ($obj != null && is_a('SubstituteProxy')) {
				return $obj;
			} elseif ($obj != null && !is_a('SubstituteProxy')) {
				throw new \Poser\Exception\PoserException("Unable to create a mock that can stub static calls for $toMock as it has been previously mocked without static stubbing.");
			} elseif (class_exists($toMock)) {
				throw new \Poser\Exception\PoserException("Unable to create a mock that can stub static calls for $toMock as it has already been loaded someplace else");
			}
		}
		
		//build a new mock since we can't reuse
		$generator = $this->generatorFactory->getGenerator($toMock, $options);
		$mock = $generator->generate();
		$mock->setProxy(new MethodProxy($this->mockingMonitor));
		$this->objectCache->add($name, $mock);
		return $mock;
	}
}



<?php

namespace Poser\Proxy;


use Poser\MockOptions;
use Poser\Invocation\InvocationContainer;
use Poser\Exception\PoserException;
use Poser\MockingMonitor;
use Poser\Proxy\Generator\GeneratorFactory;
use ReflectionClass;

class ProxyFactory {
	
	/**
	 * @var GeneratorFactory
	 */
	private $generatorFactory;
	
	/**
	 * @var MockingMonitor
	 */
	private $mockingMonitor;
	
	/**
	 * @param Generator\GeneratorFactory $generatorFactory
	 * @param \Poser\MockingMonitor $mockingMonitor
	 */
	function __construct(GeneratorFactory $generatorFactory, MockingMonitor $mockingMonitor) {
		$this->generatorFactory = $generatorFactory;
		$this->mockingMonitor = $mockingMonitor;
	}

	/**
	 * Creates a proxy for the give class using the MockOptions. This will call to create a mock, then create
	 * a method proxy and assign the proxy to the given mock.
	 * @param string $toMock class to mock
	 * @param \Poser\MockOptions $options
	 * @return mixed the mocked object
	 * @throws \Poser\Exception\PoserException
	 */
	public function createProxy($toMock, MockOptions $options) {
		//set the name in the options if needed
 		$name = $options->getName();
		if ($name == null) {
			$name = $toMock;
			$options->setName($name);
		}
		
		//are they requesting a mock that uses static that has already been defined
		if ($options->canMockStatic()) {
			if(class_exists($toMock, false)){
				$class = new ReflectionClass($toMock);
				if($class->implementsInterface('\Poser\Proxy\SubstituteProxy')){
					$mock = new $toMock();
				} else {					
					throw new PoserException("Unable to create a mock that can stub static calls for $toMock as it has already been loaded someplace else");				
				}
			}else{
				$mock = $this->createMock($toMock, $options);
			}
		}else{
			$mock = $this->createMock($toMock, $options);	
		}
			
		$invocationContainer = new InvocationContainer($this->mockingMonitor, $options);
		$mock->setProxy(new MethodProxy($mock, $this->mockingMonitor, $invocationContainer, $options));
		return $mock;
	}

	/**
	 * Will generate a mock object without the proxy using the given mock options.
	 * @param string $toMock class to create mock for
	 * @param MockOptions $options options used to create mock
	 * @return mixed
	 */
	public function createMock($toMock, $options){
		$generator = $this->generatorFactory->getGenerator($toMock, $options);
		return $generator->generate();
	}
}



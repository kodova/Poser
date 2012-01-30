<?php

namespace Poser\Proxy;

use Poser\Invocation\InvocationContainer;

use \Poser\MockOptions;
use \Poser\Proxy\Generator\GeneratorFactory;
use \Poser\Proxy\SubstituteProxy;
use \Poser\MockingMonitor;
use \ReflectionClass;

class ProxyFactory {
	
	/**
	 * @var GeneratorFactory
	 */
	private $generatorFactory;
	
	/**
	 * @var MockingMonitor
	 */
	private $mockingMonitor;
	
	
	function __construct(GeneratorFactory $generatorFactory, MockingMonitor $mockingMonitor) {
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
		
		//are they requesting a mock that uses static that has already been defined
		if ($options->canMockStatic()) {
			if(class_exists($toMock)){
				$class = new ReflectionClass($toMock);
				if($class->implementsInterface('\Poser\Proxy\SubstituteProxy')){
					$mock = new $toMock();
				} else {					
					throw new \Poser\Exception\PoserException("Unable to create a mock that can stub static calls for $toMock as it has already been loaded someplace else");				
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
	
	public function createMock($toMock, $options){
		$generator = $this->generatorFactory->getGenerator($toMock, $options);
		return $generator->generate();
	}
}



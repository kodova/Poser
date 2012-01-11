<?php

namespace Poser;

use Poser\Stubbing\Stubbable;

use \Poser\Proxy\ProxyFactory as ProxyFactory;
use \Poser\MockOptions as MockOptions;
use \Poser\MockBuilder as MockBuilder;

class PoserCore {
	
	private $proxyFactory;
	
	/**
	 * @var MockingMonitor
	 */
	private $mockingMonitor; 
	
	function __construct(ProxyFactory $proxyFactory, MockingMonitor $mockingMonitor) {
		$this->proxyFactory = $proxyFactory;
		$this->mockingMonitor = $mockingMonitor;
	}
	
	/**
	 * Creats a mock for a given class
	 *
	 * @param string $toMock the name of the class to mock
	 * @return mixed The mock object
	 */
	public function mock($toMock, MockOptions $options) {
		$mock = $this->proxyFactory->createProxy($toMock, $options);
		return $mock;
	}
	
	/**
	 * Starts a stubbing for a mocked object
	 * 
	 * @param mixed $invoked a result of a invoked method
	 * @return Stubbable
	 */
	public function when($invoked){
		
	}
	
	private function currentStub(){
		$stub = $this->mockingMonitor->currentStubbing();
		if($stub == null){
			$this->mockingMonitor->reset();
			//TODO need to throw an exception when stubbing was not started
		}		
		
		return $stub;
	}
}





<?php

namespace Poser;

use Poser\Verification\VerificationRequest;
use Poser\Exception\PoserException;
use Poser\Verification\VerifiableType;
use Poser\Stubbing\Stubbable;
use Poser\Proxy\ProxyFactory;
use Poser\MockOptions;
use Poser\MockBuilder;
use Hamcrest_Matcher;
use Poser\DefaultReturnValues;

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
		return $this->currentStub();
	}
	
	private function currentStub(){
		$stub = $this->mockingMonitor->currentStubbing();
		if($stub == null){
			$this->mockingMonitor->reset();
			//TODO need to throw an exception when stubbing was not started
		}		
		
		return $stub;
	}
	
	/**
	 * @param Hamcrest_Matcher $matcher
	 * @return DefaultReturnValues;
	 */
	public function reportMatcher(Hamcrest_Matcher $matcher){
		return $this->mockingMonitor->getArgumentMatcherMonitor()->reportMatcher($matcher);
	}
	
	/**
	 * @param mixed $mocks
	 * @return void
	 */
	public function verifyZeroInteractions($mocks){
		$parms = func_get_args();
		foreach($params as $mock){
			$container = $mock->getProxy()->getInvocationContainer();
			if($container->hasInvocations()){
				throw new PoserException("There were invocations on  mock when there should no have been some");
			}	
		}
	}
	
	public function verify($mock, VerifiableType $type){
		if($mock == null){
			throw new PoserException("You can not verify a null object"); 
		}
		
		$this->mockingMonitor->startVerification(new VerificationRequest($mock, $type));
		return $mock;
	}
}





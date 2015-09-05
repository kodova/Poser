<?php

namespace Kodova\Poser;

use Kodova\Poser\Proxy\Generator\GeneratorFactory;
use Kodova\Poser\Reflection\ArgumentMatcherMonitor;
use Kodova\Poser\Verification\VerificationRequest;
use Kodova\Poser\Exception\PoserException;
use Kodova\Poser\Verification\VerifiableType;
use Kodova\Poser\Stubbing\Stubbable;
use Kodova\Poser\Proxy\ProxyFactory;
use Hamcrest\Matcher;

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

    public static function build()
    {
        $generatorFactory = new GeneratorFactory();
        $argumentMonitor = new ArgumentMatcherMonitor();
        $mockMonitor = new MockingMonitor($argumentMonitor);
        $proxyFactory = new ProxyFactory($generatorFactory, $mockMonitor);
        return new PoserCore($proxyFactory, $mockMonitor);
    }

    /**
	 * Creates a mock for a given class
	 *
	 * @param string $toMock the name of the class to mock
	 * @param MockOptions $options
	 * @return mixed
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
	 * @param Matcher $matcher
	 * @return DefaultReturnValues;
	 */
	public function reportMatcher(Matcher $matcher){
		return $this->mockingMonitor->getArgumentMatcherMonitor()->reportMatcher($matcher);
	}

	/**
	 * @param mixed $mocks
	 * @throws Exception\PoserException
	 * @return mixed
	 */
	public function verifyZeroInteractions($mocks){
		$params = func_get_args();
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





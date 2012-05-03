<?php

namespace Poser\Proxy;

use Poser\Stubbing\Stub;
use Poser\Stubbing\OngoingStubbing;
use Poser\MockOptions;
use Poser\Invocation\InvocationContainer;
use Poser\MockingMonitor;
use Poser\Invocation\Invocation;

class MethodProxy {
	
	/**
	 * @var Mixed
	 */
	private $mock;
	
	/**
	 * @var InvocationContainer
	 */
	private $invocationContainer;
	
	/**
	 * @var MockingMonitor
	 */
	private $mockingMonitor;
	
	/**
	 * @var MockOptions;
	 */
	private $options;
	
	function __construct($mock, MockingMonitor $mockingMonitor, InvocationContainer $invocationContainer, MockOptions $options) {
		$this->mock = $mock;
		$this->invocationContainer = $invocationContainer;
		$this->mockingMonitor = $mockingMonitor;
		$this->options = $options;
	}

	/**
	 * @param $method
	 * @param $args
	 * @return mixed
	 */
	public function handle($method, $args) {
		$matchers = $this->mockingMonitor->getArgumentMatcherMonitor()->pullMatchers();
		$stackTrace = debug_backtrace();
		$invocation = new Invocation($this->mock, $method, $args, $matchers, $stackTrace);

		$verifcation = $this->mockingMonitor->currentVerification($this->mock);
		if ($verifcation != null){
			$verifcation->getType()->verify($invocation, $this->invocationContainer);
			return null;
		}

		$this->invocationContainer->reportInvocataion($invocation, $matchers);
		$stub = new Stub($invocation);
		$this->mockingMonitor->reportStubbing(new OngoingStubbing($this->invocationContainer, $stub, $invocation));
		
		$stubbedInvocation = $this->invocationContainer->findAnswerFor($invocation);
		if ($stubbedInvocation == null) {
			return $this->options->getDefaultAnswer()->answer($invocation);
		}else{
			$this->mockingMonitor->reset();
			return $stubbedInvocation->answer($invocation);
		}
	}
	
	public function getMock() {
		return $this->mock;
	}
	
	/**
	 * Returns the InvocationContainer for the give mock object
	 * @return \Poser\Proxy\InvocationContainer
	 */
	public function getInvocationContainer(){
		return $this->invocationContainer;
	}
}


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
	
	public function handle($method, $args) {
		$matchers = $this->mockingMonitor->getArgumentMatcherMonitor()->pullMatchers();
		$invocation = new Invocation($this->mock, $method, $args, $matchers);
		
		
		//verify
		$this->mockingMonitor->validateState();

		//TODO is someone trying to verify soemthing do verify and short circut

		$this->invocationContainer->reportInvocataion($invocation, $matchers);
		$stub = new Stub($invocation);
		$this->mockingMonitor->reportStubbing(new OngoingStubbing($this->invocationContainer, $stub));
		
		$stubbedInvocation = $this->invocationContainer->findAnswerFor($invocation);
		if ($stubbedInvocation == null) {
			return $this->options->getDefaultAnswer()->answer($invocation);
		}else{
			$stubbedInvocation->captureArguments($invocation);
			return $stubbedInvocation->answer(invocation);
		}
	}
	
	public function getMock() {
		return $this->mock;
	}
}


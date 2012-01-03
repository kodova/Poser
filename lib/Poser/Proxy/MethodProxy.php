<?php

namespace Poser\Proxy;

use \Poser\Invocation\InvocationContainer;
use \Poser\Invocation\InvokePetition;
use \Poser\MockingMonitor;

class MethodProxy {
	
	private $mock;
	private $invocationContainer;
	private $mockingMonitor;
	
	function __construct($mock, $mockingMonitor) {
		$this->mock = $mock;
		$this->invocationContainer = new InvocationContainer($mockingMonitor);
		$this->mockingMonitor = $mockingMonitor;
	}
	
	public function handle($method, $args) {
		$matchers = $this->mockingMonitor->getArgumentMatcherMonitor()->pullMatchers();
		$petition = new InvokePetition($this->mock, $method, $args, $matchers);
		return $this->invocationContainer->handle($petition);
	}
	
	public function getMock() {
		return $this->mock;
	}
}


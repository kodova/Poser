<?php

namespace Poser\Invocation;

use \Poser\MockingMonitor;

class InvocationContainer {
	
	private $mockingMonitor = null;
	
	function __construct(MockingMonitor $mockingMonitor) {
		$this->mockingMonitor = $mockingMonitor;
	}
	
	public function handler(Invocation $invocation) {
		
	}
	
	
}

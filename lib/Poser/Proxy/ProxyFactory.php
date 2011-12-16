<?php

namespace Poser\Proxy;

use Poser\MockOptions as MockOptions;

class ProxyFactory {
	

	public function createProxy($toMock, MockOptions $options) {
		
		
		
		$class = $this->getClass($toMock);
		eval($class);
		return new $toMock();
	}
	
	public function getClass($type) {
		return <<<CLASS
			class $type{
				private \$test;
			}
CLASS;
	}
}

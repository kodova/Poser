<?php

namespace Poser;

use \Poser\Proxy\ProxyFactory as ProxyFactory;
use \Poser\MockOptions as MockOptions;
use \Poser\MockBuilder as MockBuilder;

class PoserCore {
	
	private $proxyFactory;
	
	function __construct(ProxyFactory $proxyFactory) {
		$this->proxyFactory = $proxyFactory;
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
}





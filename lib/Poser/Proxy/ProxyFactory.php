<?php

namespace Poser\Proxy;

use Poser\MockOptions as MockOptions;
use Poser\Proxy\ObjectCache as ObjectCache;

class ProxyFactory {
	private $objectCache;
	
	function __construct(ObjectCache $objectCache) {
		$this->objectCache = $objectCache;
	}

	public function createProxy($toMock, MockOptions $options) {
		$mock = $toMock;
	
		//has a mock that has already been generated been requested?
		if($options->getName() != null){
			$obj = $this->objectCache->lookupByName($options->getName());
			if($obj != null){
				return $obj;
			}
		}
		
		//are we playing with static methods?
		if($options->canMockStatic()){
			//has it already been defined?
			$obj = $this->objectCache->lookupByType($toMock);
			if($obj != null){
				return $obj;
			}else{
				return $this->buildNewClass($toMock);
			}
		}
		
		return $this->buildExtendedClass($toMock);
	}
	
	public function getProxyName($type) {
		return $type . 'Proxy_' . uniqid();
	}
}



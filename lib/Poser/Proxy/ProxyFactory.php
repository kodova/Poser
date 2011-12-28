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
	
	public function buildExtendedClass($type) {	
		$name = $this->getProxyName($type);
		$proxy = $this->buildProxyHandler($type);
		$methods = $this->buildPublicMethods($type);
		
		$class =  <<<CLASS
			class $name extends $type {
				$proxy
				$methods
			}
CLASS;
		
		eval($class);
		return new $name();
		
	}
	
	public function buildNewClass($type){
		$name = $type;
		$proxy = $this->buildProxyHandler();
		
		return <<<CLASS
			class $name{
				$proxy
			}
CLASS;
		eval($class);
		return new $name();
	}
	
	public function buildPublicMethods($type) {
		$class = new \ReflectionClass($type);
		foreach($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method){
			$name = $method->getName();
			return <<<METHOD
				public function $name() {
					\$this->__call('$name', func_get_args());
				}
METHOD;
			
		}
	}
	
	public function buildProxyHandler($type) {
		return <<<PROXY
			private \$proxy;

			function __construct() {
				\$this->proxy = new \Poser\Proxy\MethodProxy(new \$type());
			}

			public function __call(\$name, \$args){
				\$this->proxy->handle(\$name, \$args);
			}

			public static function __callStatic(\$name, \$args){
				\$this->proxy->handle(\$name, \$args);
			}
PROXY;
	}
	
	public function getProxyName($type) {
		return $type . 'Proxy_' . uniqid();
	}
}



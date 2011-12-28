<?php

namespace Poser\Invocation {
	
	class InvocationProxy_4efa5b6868328 extends Invocation {
		private $proxy;

		function __construct() {
			$this->proxy = new \Poser\Proxy\MethodProxy(new $type());
		}

		public function __call($name, $args){
			$this->proxy->handle($name, $args);
		}

		public static function __callStatic($name, $args){
			$this->proxy->handle($name, $args);
		}

		
		public function getMock() {
			$this->__call('getMock', func_get_args());
		}
	}
		
}




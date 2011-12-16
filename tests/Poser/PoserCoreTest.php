<?php

use Poser\PoserCore as PoserCore;
use Poser\Proxy\ProxyFactory as ProxyFactory;
use Poser\MockOptions as MockOptions;
use Poser\Reflection\TypedMethod as TypedMethod;

class PoserCoreTest extends PHPUnit_Framework_TestCase {
	
	private $poserCore = null;
	
    public function setUp() {
		$this->poserCore = new PoserCore(new ProxyFactory());
    }

    public function tearDown() {
		$this->poserCore = null;
    }

	public function testMockGetsAMockedObject() {
	    $mock = $this->poserCore->mock('Foo');
		$this->assertInstanceOf('Foo', $mock, 'The mocked object is not a instance of foo');
	}
	
	public function testReflection() {
		$method = new TypedMethod('Poser\Invocation\Invocation', "getMethod");
		echo $method->getReturnType();
	}
}
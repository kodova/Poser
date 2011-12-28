<?php

use Poser\PoserCore as PoserCore;
use Poser\Proxy\ProxyFactory as ProxyFactory;
use Poser\Proxy\ObjectCache as ObjectCache;
use Poser\MockOptions as MockOptions;
use Poser\Reflection\TypedMethod as TypedMethod;

class PoserCoreTest extends PHPUnit_Framework_TestCase {
	
	private $poserCore = null;
	
    public function setUp() {
		$this->poserCore = new PoserCore(new ProxyFactory(new ObjectCache()));
    }

    public function tearDown() {
		$this->poserCore = null;
    }

	public function testMockGetsAMockedObject() {
	    $mock = $this->poserCore->mock('Poser\Invocation\Invocation', new MockOptions());
		$this->assertInstanceOf('Poser\Invocation\Invocation', $mock, 'The mocked object is not a instance of foo');
	}
}
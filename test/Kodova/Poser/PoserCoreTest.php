<?php

use Kodova\Poser\PoserCore as PoserCore;
use Kodova\Poser\Proxy\ProxyFactory as ProxyFactory;
use Kodova\Poser\Proxy\ObjectCache as ObjectCache;
use Kodova\Poser\Proxy\Generator\GeneratorFactory as GeneratorFactory;
use Kodova\Poser\MockOptions as MockOptions;
use Kodova\Poser\Reflection\TypedMethod as TypedMethod;

class PoserCoreTest extends PHPUnit_Framework_TestCase {
	
	private $poserCore = null;
	
    public function setUp() {
		// $this->poserCore = new PoserCore(new ProxyFactory(new ObjectCache(), new GeneratorFactory(), new Mocking));
    }

    public function tearDown() {
		$this->poserCore = null;
    }

	public function testMockGetsAMockedObject() {
	    // $mock = $this->poserCore->mock('Poser\Invocation\Invocation', new MockOptions());
		// $this->assertInstanceOf('Poser\Invocation\Invocation', $mock, 'The mocked object is not a instance of foo');
	}
}
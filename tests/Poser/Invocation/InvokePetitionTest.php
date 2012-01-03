<?php

use	\Poser\Invocation\InvokePetition;
use \Helpers\Test\MethodClass;

class InvokePetitionTest extends PHPUnit_Framework_TestCase 
{
	private $mock = null;
	private $method = null;
	private $args = null;
	private $matchers =  null;
	
    public function setUp() {
		$this->mock = new MethodClass();
		$this->method = 'reqArgsFoo';
		$this->args = array();
		$this->matchers = array();
    }

    public function tearDown() {
		$this->mock = null;
		$this->method = null;
		$this->args = null;
		$this->matchers = null;
    }

	public function testGetMethod() {
		$invoke = new InvokePetition($this->mock, $this->method, $this->args, $this->matchers);
		
		$typeMethod = $invoke->getMethod();
		
		$this->assertEquals($this->method, $typeMethod->getName());
	}
	
	public function testGetMethodWithSubsitiueMock() {
		$this->mock = new \Helpers\Test\SubstituteClass();
		$invoke = new InvokePetition($this->mock, $this->method, $this->args, $this->matchers);
		
		$typeMethod = $invoke->getMethod();
		
		$this->assertNull($typeMethod);
	}
	
	public function testGetMock() {
	    $invoke = new InvokePetition($this->mock, $this->method, $this->args, $this->matchers);
		$this->assertSame($this->mock, $invoke->getMock());
	}
	
	public function testGetArguments() {
		$invoke = new InvokePetition($this->mock, $this->method, $this->args, $this->matchers);
		$this->assertSame($this->args, $invoke->getArguments());
	}
}
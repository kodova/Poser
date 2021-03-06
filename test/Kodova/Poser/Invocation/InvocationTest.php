<?php

use Kodova\Poser\Invocation\Invocation;
use Kodova\Poser\Poser as p;

/**
 * Description of InvocationTest
 *
 * @author pingod
 */
class InvocationTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @var Invocation
	 */
	private $mock;
	
	public function setUp() {
	}
	
	public function tearDown() {
		
	}
	
	public function testMatchesNotSameMock(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array();
		$matchers = new SplDoublyLinkedList;
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		
		$mock2 = p::mock('Kodova\Poser\Helpers\Test\InterfaceClass');
		$invocation2 = new Invocation($mock2, 'foo', array(), new SplDoublyLinkedList(), array());
		
		$result = $invocation->matches($invocation2);
		$this->assertFalse($result);
	}
	
	public function testMatchesNotSameMethod(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array();
		$matchers = new SplDoublyLinkedList;
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		
		$mock2 = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$invocation2 = new Invocation($mock2, 'mixedArgsFoo', array(), new SplDoublyLinkedList(), array());
		
		$result = $invocation->matches($invocation2);
		$this->assertFalse($result);
	}
	
	public function testMatchesNotSameArgSize(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array();
		$matchers = new SplDoublyLinkedList;
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		
		$mock2 = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$invocation2 = new Invocation($mock2, $method, range(1, 3), new SplDoublyLinkedList(), array());
		
		$result = $invocation->matches($invocation2);
		$this->assertFalse($result);
	}

	public function testMatchesWithNullMatchers(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array();
		$matchers = new SplDoublyLinkedList;
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		
		$mock2 = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$invocation2 = new Invocation($mock2, $method, range(1, 3), new SplDoublyLinkedList(), array());
		
		$result = $invocation->matches($invocation2);
		$this->assertFalse($result);
	}
	
	public function testMatchesWithEmptyMatchersZeroArgs(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array();
		$matchers = new SplDoublyLinkedList();
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		$invocation2 = new Invocation($mock, $method, $args, $matchers, array());
		
		$result = $invocation->matches($invocation2);
		$this->assertTrue($result);
	}
	
	public function testMatchesWithEmptyMatchersSameArgs(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array(1, 2);
		$matchers = new SplDoublyLinkedList();
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		$invocation2 = new Invocation($mock, $method, array(1, 2), $matchers, array());
		
		$result = $invocation->matches($invocation2);
		$this->assertTrue($result);
	}
	
	public function testMatchesWithEmptyMatchersDifferentArgs(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array(1, 2);
		$matchers = new SplDoublyLinkedList();
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		$invocation2 = new Invocation($mock, $method, array(3, 4), $matchers, array());
		
		$result = $invocation->matches($invocation2);
		$this->assertFalse($result);
	}
	
	public function testMatchesWithMatchers(){
		$mock = p::mock('Kodova\Poser\Helpers\Test\MethodClass');
		$method = 'privateFoo';
		$args = array(1, 2);
		$matchers = new SplDoublyLinkedList();
		$invocation = new Invocation($mock, $method, $args, $matchers, array());
		$invocation2 = new Invocation($mock, $method, array(3, 4), $matchers, array());
		
		$result = $invocation->matches($invocation2);
		$this->assertFalse($result);
	}
}

?>

<?php


use Kodova\Poser\Invocation\EmptyValueAnswer;
use Kodova\Poser\Invocation\Invocation;
use \Helpers\Test\ReturnTypeClass;

class EmptyValueAnswerTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var EmptyValueAnswer 
	 */
	private $underTest = null;
	
	public function setUp(){
		$this->underTest = new EmptyValueAnswer();
	}	
	
	public function tearDown(){
	}
	
	public function testAnswerWithStringType(){
		$method = 'stringMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertEquals('', $return);
	}
	
	public function testAnswerWithIntType(){
		$method = 'intMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertEquals(0, $return);
	}
	
	public function testAnswerWithNumberType(){
		$method = 'numberMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertEquals(0, $return);
	}
	
	public function testAnswerWithIntegerType(){
		$method = 'integerMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertEquals(0, $return);
	}
	
	public function testAnswerWithFloatType(){
		$method = 'floatMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertEquals(.1, $return);
	}
	
	public function testAnswerWithDoubleType(){
		$method = 'doubleMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertEquals(.1, $return);
	}
	
	public function testAnswerWithArrayType(){
		$method = 'arrayMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertTrue(is_array($return));
		$this->assertEmpty($return);
	}
	
	public function testAnswerWithNullType(){
		$method = 'nullMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertNull($return);
	}
	
	public function testAnswerWithMixedType(){
		$method = 'mixedMethod';
		$invocation = new Invocation(new \Helpers\Test\ReturnTypeClass(), $method, array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertNull($return);
	}
	
	public function testAnswerWithNullMethod(){
		$mock = $this->getMock('Kodova\Poser\Proxy\SubstituteProxy');
		$invocation = new Invocation($mock, 'something', array(), new SplDoublyLinkedList(), array());
		$return = $this->underTest->answer($invocation);
		$this->assertNull($return);
	}
}
<?php

use Kodova\Poser\Verification\Times;
use Kodova\Poser\Invocation\Invocation;
use Helpers\Test\MethodClass;
use Kodova\Poser\MockingMonitor;
use Kodova\Poser\ArgumentMatcherMonitor;
use Kodova\Poser\MockOptions;
use Kodova\Poser\Verification\TimesException;
use Kodova\Poser\Exception\PoserException;

/**
 * Description of TimesTest
 *
 * @author pingod
 */
class TimesTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @var \Poser\Invocation\InvocationContainer 
	 */
	private $invocationContainer = null;
	
	
	/**
	 * @var \Poser\Invocation\Invocation 
	 */
	private $invocation = null;
	
	public function setUp() {
		$mockingMonitor = new MockingMonitor(new ArgumentMatcherMonitor());
		$this->invocationContainer = $this->getMockBuilder('\Kodova\Poser\Invocation\InvocationContainer')
										  ->setConstructorArgs(array($mockingMonitor, new MockOptions()))
										  ->setMethods(array('getInvocations'))
										  ->getMock();
		$this->invocation = new Invocation(new MethodClass(), 'privateFoo', null, new SplDoublyLinkedList, array());
	}

	protected function tearDown() {
		
	}

	
	function testConstructor() {
		new Times(1);
	}
	
	/**
	 * @expectedException Kodova\Poser\Exception\PoserException
	 */
	function testConstrctorLessThanZero(){
		new Times(-1);
	}
	
	
	function testVerifyEqualInvocations(){
		$count = 5;

		$times = new Times($count);
		
		$this->invocationContainer->expects($this->any())
								  ->method('getInvocations')
								  ->will($this->returnValue(range(1, $count)));
		
		$times->verify($this->invocation, $this->invocationContainer);
	}
	
	/**
	 * @expectedException Kodova\Poser\Exception\PoserException
	 */
	function testVerifyLessInvocations(){
		$count = 5;

		$times = new Times($count);
		
		$this->invocationContainer->expects($this->any())
								  ->method('getInvocations')
								  ->will($this->returnValue(range(1, $count - 1)));
		
		$times->verify($this->invocation, $this->invocationContainer);
	}
	
	/**
	 * @expectedException Kodova\Poser\Exception\PoserException
	 */
	function testVerifyMoreInvocations(){
		$count = 5;

		$times = new Times($count);
		
		$this->invocationContainer->expects($this->any())
								  ->method('getInvocations')
								  ->will($this->returnValue(range(1, $count + 1)));
		
		$times->verify($this->invocation, $this->invocationContainer);
	}
	
	/**
	 * @expectedException Kodova\Poser\Exception\PoserException
	 */
	function testVerifyNeverInvoked(){
		$count = 5;

		$times = new Times(0);
		
		$this->invocationContainer->expects($this->any())
								  ->method('getInvocations')
								  ->will($this->returnValue(range(1, $count)));
		
		$times->verify($this->invocation, $this->invocationContainer);
	}
}

?>

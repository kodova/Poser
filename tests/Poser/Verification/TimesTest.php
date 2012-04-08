<?php

use Poser\Verification\Times;
use Poser\Invocation\Invocation;
use Helpers\Test\MethodClass;
use Poser\MockingMonitor;
use Poser\ArgumentMatcherMonitor;
use Poser\MockOptions;

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
		$this->invocationContainer = $this->getMockBuilder('Poser\Invocation\InvocationContainer')
										  ->setConstructorArgs(array($mockingMonitor, new MockOptions()))
										  ->setMethods(array('getInvocations'))
										  ->getMock();
		$this->invocation = new Invocation(new MethodClass(), 'privateFoo', null, new SplDoublyLinkedList);
	}

	protected function tearDown() {
		
	}

	
	function testConstructor() {
		new Times(1);
	}
	
	/**
	 * @expectedException Poser\Exception\PoserException 
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
	 * @expectedException Poser\Exception\PoserException 
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
	 * @expectedException Poser\Exception\PoserException 
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
	 * @expectedException Poser\Exception\PoserException 
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

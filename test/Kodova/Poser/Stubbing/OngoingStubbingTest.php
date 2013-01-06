<?php
namespace Kodova\Poser\Stubbing;

use Kodova\Poser\Stubbing\OngoingStubbing;
use SplDoublyLinkedList;
use Helpers\Test\MethodClass;
use Kodova\Poser\Invocation\Invocation;
use Kodova\Poser\ArgumentMatcherMonitor;
use Kodova\Poser\MockOptions;
use Kodova\Poser\Stubbing\Stub;
use Kodova\Poser\MockingMonitor;
use Kodova\Poser\Invocation\InvocationContainer;

class OngoingStubbingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OngoingStubbing
     */
    protected $object;

	/**
	 * @var InvocationContainer
	 */
	protected $invocationContainer;

	/**
	 * @var Invocation
	 */
	public $invocation;

	/**
	 * @var Stub
	 */
	public $stub;

	protected function setUp() {
	    $mockingMonitor = new MockingMonitor(new ArgumentMatcherMonitor());
	    $this->invocationContainer = $this->getMockBuilder('Poser\Invocation\InvocationContainer')
		                                  ->setConstructorArgs(array($mockingMonitor, new MockOptions))
		                                  ->setMethods(array('addStub'))
		                                  ->getMock();
	    $this->invocation = new Invocation(new MethodClass(), 'privateFoo', null, new SplDoublyLinkedList, array());
	    $this->stub = new Stub($this->invocation);


        $this->object = new OngoingStubbing($this->invocationContainer, $this->stub, $this->invocation);
    }

    protected function tearDown() {
	    $this->object = null;
    }

    public function testThenReturnShouldAddSingleAnswerWhenOnlyOneGiven(){
		$this->invocationContainer->expects($this->once())
								  ->method('addStub');
	    $this->object->thenReturn(1);
    }

	public function testThenReturnShouldAddManyAnswersWhenManyGiven(){
		$this->invocationContainer->expects($this->exactly(2))
			->method('addStub');
		$this->object->thenReturn("foo", "bar");
	}

	/**
	 * @expectedException Poser\Exception\PoserException
	 */
	public function testThenReturnShouldThrowExceptionWhenNothingGiven(){
		$this->object->thenReturn();
	}

    /**
     * @covers Poser\Stubbing\OngoingStubbing::thenAnswer
     */
    public function testThenAnswer(){
	    $answer = new \Poser\Invocation\ReturnAnswer(null);
        $this->invocationContainer->expects($this->any())
	        ->method('thenAnswer')
            ->with($this->equalTo($answer));
	    $this->object->thenAnswer($answer);
    }

    /**
     * @covers Poser\Stubbing\OngoingStubbing::then
     */
    public function testThen() {
        // Remove the following lines when you implement this test.
	    $answer = new \Poser\Invocation\ReturnAnswer(null);
	    $this->invocationContainer->expects($this->any())
		    ->method('then')
		    ->with($this->equalTo($answer));
	    $this->object->then($answer);
    }

    /**
     * @covers Poser\Stubbing\OngoingStubbing::thenThrow
     */
    public function testThenThrow() {
	    $this->invocationContainer->expects($this->any())
		    ->method("thenThrow")
			->with($this->isInstanceOf('Poser\Invocation\ThrowAnswer'));

		$this->object->thenThrow(new \Poser\Exception\PoserException("foo"));
    }
}

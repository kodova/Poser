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
use Kodova\Poser\Exception\PoserException;
use Kodova\Poser\Invocation\ReturnAnswer;

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
	    $this->invocationContainer = $this->getMockBuilder('Kodova\Poser\Invocation\InvocationContainer')
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
	 * @expectedException Kodova\Poser\Exception\PoserException
	 */
	public function testThenReturnShouldThrowExceptionWhenNothingGiven(){
		$this->object->thenReturn();
	}


    public function testThenAnswer(){
	    $answer = new ReturnAnswer(null);
        $this->invocationContainer->expects($this->any())
	        ->method('thenAnswer')
            ->with($this->equalTo($answer));
	    $this->object->thenAnswer($answer);
    }

    public function testThen() {
        // Remove the following lines when you implement this test.
	    $answer = new ReturnAnswer(null);
	    $this->invocationContainer->expects($this->any())
		    ->method('then')
		    ->with($this->equalTo($answer));
	    $this->object->then($answer);
    }

    public function testThenThrow() {
	    $this->invocationContainer->expects($this->any())
		    ->method("thenThrow")
			->with($this->isInstanceOf('\Kodova\Poser\Invocation\ThrowAnswer'));

		$this->object->thenThrow(new PoserException("foo"));
    }
}

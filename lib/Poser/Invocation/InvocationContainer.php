<?php

namespace Poser\Invocation;

use Poser\MockingMonitor;

use Poser\MockOptions;
use \SplDoublyLinkedList;

class InvocationContainer {

	private $invocations = null;
	private $stubs = null;
	private $matchers;

	/**
	 * @var MockingMonitor
	 */
	private $mockingMonitor = null;
	
	/**
	 * @var MockOptions
	 */
	private $mockOptions;
	
	function __construct(MockingMonitor $mockingMonitor, MockOptions $mockOptions) {
		$this->mockingMonitor = $mockingMonitor;
		$this->invocations = new SplDoublyLinkedList();
		$this->stubs = new SplDoublyLinkedList();
		$this->mockOptions = $mockOptions;
	}
	
	public function addConsecutiveAnswer(Answer $answer) {
		$this->addAnswer($answer, true);
	}
	
	public function addAnswer(Answer $answer, $consecutive = false) {
		$invocation = $this->invocations->pop();	//remove the last invocation since it was called to support stubbing
		$this->mockingMonitor->stubbingComplete($invocation);
		
		if ($consecutive) {
			$this->stubs->top()->addAnswer($answer);
		} else {
			$this->add(new Stub($this->mockOptions->getDefaultAnswer(), $invocation));
		}
	}
	
	public function reportInvocataion(Invocation $invocation, $matchers) {
		$this->invocations->push($invocation);
		$this->matchers = $matchers;
	}
	
	public function findAnswerFor(Invocation $invocation) {
		foreach ($this->stubs as $stub) {
			if($stub->matches($invocation)){
				$stub->markStubUsed($invocation);
				$invocation->markStubbed();
				return $stub;
			}
		}
	}
	
	public function hasAnswers() {
		return !$this->stubs->isEmpty();
	}
}

<?php

namespace Poser\Invocation;

use Poser\Stubbing\Stub;
use Poser\Stubbing\Stubbable;
use Poser\MockingMonitor;
use Poser\MockOptions;
use SplDoublyLinkedList;

class InvocationContainer {

	/**
	 * Holds all the invocations of the method to be use for verifying the calls later
	 * @var SplDoublyLinkedList[Invocation]
	 */
	private $invocations = null;
	
	/**
	 * @var Stubbable
	 */
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
	
	public function addStub(Stub $stub){
		$this->stubs->push($stub);
	}
	
	public function reportInvocataion(Invocation $invocation, $matchers) {
		$this->invocations->push($invocation);
		$this->matchers = $matchers;
	}
	
	public function findAnswerFor(Invocation $invocation) {
		foreach ($this->stubs as $stub) {
			if($stub->matches($invocation)){
				$stub->markStubUsed($invocation);
				return $stub;
			}
		}
		return null;
	}
	
	public function hasAnswers() {
		return !$this->stubs->isEmpty();
	}
	
	public function hasInvocations(){
		return ($this->invocations->count() > 0);
	}

	/**
	 * @param Closure|null $matchFunction
	 * @return array|null|\SplDoublyLinkedList
	 */
	public function getInvocations($matchFunction = null){
		if ( ! $matchFunction instanceof \Closure){
			return $this->invocations;
		}

		$matches = array();
		foreach($this->invocations as $invocation){
			if($matchFunction($invocation)){
				$matches[] = $invocation;
			}
		}
		return $matches;
	}
}

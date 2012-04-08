<?php

namespace Poser\Invocation;

use Poser\Stubbing\Stub;

use Poser\MockingMonitor;

use Poser\MockOptions;
use \SplDoublyLinkedList;

class InvocationContainer {

	/**
	 * Holds all the invocations of the method to be use for verifing the calls later
	 * @var SplDoublyLinkedList[Invocation]
	 */
	private $invocations = null;
	
	/**
	 * @var SplDoublyLinkedList
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
				$invocation->markStubbed();
				return $stub;
			}
		}
	}
	
	public function hasAnswers() {
		return !$this->stubs->isEmpty();
	}
	
	public function hasInvocations(){
		return ($this->invocations->count() > 0);
	}
	
	/**
	 * @return array[Invocation]
	 */
	public function getInvocations($func = null){
		if ( $func instanceof \Closure){
			return $this->invocations;
		}
		
		return array_filter($this->invocations, function($invocation){
			return $func($invocation);
		});
	}
}

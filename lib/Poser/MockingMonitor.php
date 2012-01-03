<?php

namespace Poser;

use \Poser\Stubbing\Stubbable as Stubbable;

/**
 * A monitor that oversees all mocking operations. The primary tasks of 
 * the Mocking monitor is to monitor all stubbing and to support the 
 * creation of new stubbed calls
 *
 * @package default
 */
class MockingMonitor {
	
	/**
	 * Current stubbing in progress
	 * @var Stubbable
	 */
	private $ongoingStubbing = null;
	
	/**
	 * A single instance of argument matcher to be used for all monitoring
	 * @var string
	 */
	private $argumentMatcherMonitor = null;
	
	public function __construct(ArgumentMatcherMonitor $argumentMatcherMonitor) {
		$this->argumentMatcherMonitor = $argumentMatcherMonitor;
	}
	
	/**
	 * Starts the current stubbing process
	 *
	 * @return void
	 */
	public function startStubbing() {
		$this->validateState();
	}
	
	/**
	 * Gets the current Stubbable object that 
	 * is in the process of being stubbed
	 *
	 * @return Stubbable
	 */
	public function currentStubbing() {
		$stubbing = $this->ongoingStubbing;
		$this->reset();
		return $stubbing;
	}
	
	/**
	 * Validates the state of the current mocking to ensure
	 * that we can start mocking
	 *
	 * @return void
	 */
	private function validateState() {
		$this->argumentMatcherMonitor->validateState();
	}
	
	public function reset() {
		$this->getArgumentMatcherMonitor()->reset();
		unset($this->ongoingStubbing);
	}
	
	/**
	 * Returns the single instance of the argument matcher
	 * @return void
	 */
	public function getArgumentMatcherMonitor() {
		return $this->getArgumentMatcherMonitor;
	}
}

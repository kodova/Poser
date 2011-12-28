<?php

namespace Poser;

use \Poser\Stubbing\Stubbable as Stubbable;

class MockingMonitor {
	
	/**
	 * Current stubbing in progress
	 * @var Stubbable
	 */
	private $ongoingStubbing = null;
	
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
		unset($this->ongoingStubbing);
		return $stubbing;
	}
	
	private function validateState() {
		/*
			TODO Need to implement
		*/
	}
	
}

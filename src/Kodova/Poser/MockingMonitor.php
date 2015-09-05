<?php

namespace Kodova\Poser;

use Kodova\Poser\Exception\PoserException;
use Kodova\Poser\Reflection\ArgumentMatcherMonitor;
use Kodova\Poser\Verification\VerificationRequest;
use Kodova\Poser\Invocation\Invocation;
use Kodova\Poser\Stubbing\Stubbable;


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
	
	/**
	 * @var VerificationRequest
	 */
	private $verification = null;
	
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
	 * Start the current verification process
	 * @param VerificationRequest $verification
	 */
	public function startVerification(VerificationRequest $verification){
		$this->validateState();
		$this->verification = $verification;
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
	 * Gets the current VerificationRequest that is currently in process
	 * @param $toVerify
	 * @return VerificationRequest
	 */
	public function currentVerification($toVerify) {
		$verification = $this->verification;
		if($verification != null && $verification->getMock()->equals($toVerify)){
			$this->reset();
			return $verification;
		}else{
			return null;
		}
	}

	/**
	 * Validates the state of the current mocking to ensure
	 * that we can start mocking
	 *
	 * @throws Exception\PoserException
	 * @return void
	 */
	public function validateState() {
		if($this->verification != null){
			throw new PoserException("Mocking is in a invalid state there is a verification currently active");
		}
		
		$this->argumentMatcherMonitor->validateState();
		//TODO report that there is unfinished stubbing and verification
	}
	
	public function reset() {
		$this->getArgumentMatcherMonitor()->reset();
		$this->ongoingStubbing = null;
		$this->verification = null;
	}
	
	/**
	 * Returns the single instance of the argument matcher
	 * @return ArgumentMatcherMonitor
	 */
	public function getArgumentMatcherMonitor() {
		return $this->argumentMatcherMonitor;
	}
	
	/**
	 * undocumented function
	 *
	 * @param Invocation $invocation 
	 * @return void
	 */
	public function stubbingComplete(Invocation $invocation) {
		$this->reset();
	}
	
	public function reportStubbing(Stubbable $stubbing){
		$this->ongoingStubbing = $stubbing;
	}
}

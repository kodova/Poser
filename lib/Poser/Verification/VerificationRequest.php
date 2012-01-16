<?php

namespace Poser\Verification;

class VerificationRequest {
	
	/**
	 * @var mixed
	 */
	private $mock;
	/**
	 * @var VerifiableType
	 */
	private $type;
	
	public function __construct($mock, VerifiableType $type){
		$this->mock = $mock;
		$this->type = $type;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @return \Poser\Verification\mixed
	 */
	public function getMock(){
		return $this->mock;
	}
	
	/**
	 * Returns the type of verification to perform
	 * @return VerifiableType
	 */
	public function getType(){
		return $this->type;
	}
	
}
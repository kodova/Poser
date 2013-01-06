<?php

namespace Kodova\Poser\Invocation;

use Kodova\Poser\Invocation\Answer as Answer;

class ReturnAnswer implements Answer{
	
	private $returnValue = null;
	
	public function __construct($returnValue){
		$this->returnValue = $returnValue;
	}
	
	public function answer(Invocation $invocation){
		return $this->returnValue;
	}
	
} 
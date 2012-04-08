<?php

namespace Poser\Invocation;

use Poser\Invocation\Answer;

class ThrowAnswer implements Answer{
	
	/**
	 * @var \Exception
	 */
	private $throwable;
	
	public function __construct(\Exception $throwable){
		$this->throwable = $throwable;
	}
	
	public function answer(Invocation $invocation){
		throw $this->throwable;
	}	
}
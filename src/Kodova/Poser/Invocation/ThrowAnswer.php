<?php

namespace Kodova\Poser\Invocation;

use Kodova\Poser\Invocation\Answer;
use Exception;

class ThrowAnswer implements Answer{
	
	/**
	 * @var \Exception
	 */
	private $throwable;
	
	public function __construct(Exception $throwable){
		$this->throwable = $throwable;
	}
	
	public function answer(Invocation $invocation){
		throw $this->throwable;
	}	
}
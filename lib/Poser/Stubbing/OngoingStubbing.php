<?php

namespace Poser\Stubbing;

use Poser\Invocation\Matchable;

use Poser\Invocation\Answer;

use Poser\Invocation\InvocationContainer;

use Poser\Invocation\ReturnAnswer;

use Poser\Stubbing\Stubbable;


class OngoingStubbing implements Stubbable{
	
	/**
	 * @var InvocationContainer
	 */
	private $invocationContainer;
	/**
     * @var Stub
	 */
	private $stub;
	
	function __construct(InvocationContainer $invocationContainer, Stub $stub) {
		$this->invocationContainer = $invocationContainer;
		$this->stub = $stub;
	}

	public function thenReturn($args){
		if (is_array($args)) {
			foreach($args as $arg){
				$stubbing = $this->thenAnswer(new ReturnAnswer($arg));
			}
			return $stubbing;
		} else {
			return $this->thenAnswer(new ReturnAnswer($args));
		}
	}

	public function thenThrow(Exception $exception){
		return $this->thenAnswer(new ThrowException($exception));
	}

	public function thenAnswer(Answer $answer){
		$this->stub->addAnswer($answer);
		$this->invocationContainer->addStub($this->stub);
	}
	
	public function then(Answer $answer){
		return $this->thenAnswer($answer);
	}
	
	
}

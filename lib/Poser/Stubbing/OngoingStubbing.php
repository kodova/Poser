<?php

namespace Poser\Stubbing;

use Poser\Invocation\Matchable;
use Poser\Invocation\Answer;
use Poser\Invocation\InvocationContainer;
use Poser\Invocation\ReturnAnswer;
use Poser\Invocation\ThrowAnswer;
use Poser\Invocation\Invocation;
use Poser\Stubbing\Stubbable;
use Exception;


class OngoingStubbing implements Stubbable{
	
	/**
	 * @var InvocationContainer
	 */
	private $invocationContainer;
	/**
     * @var Stub
	 */
	private $stub;
	/**
	 * @var Invocation
	 */
	private $invocation;

	/**
	 * @param \Poser\Invocation\InvocationContainer $invocationContainer
	 * @param Stub $stub
	 * @param \Poser\Invocation\Invocation $invocation
	 */
	function __construct(InvocationContainer $invocationContainer, Stub $stub, Invocation $invocation) {
		$this->invocationContainer = $invocationContainer;
		$this->stub = $stub;
		$this->invocation = $invocation;
	}

	/**
	 * @param $args
	 */
	public function thenReturn($args){
		if (is_array($args)) {
			$subbing = null;
			foreach($args as $arg){
				$stubbing = $this->thenAnswer(new ReturnAnswer($arg));
			}
			return $stubbing;
		} else {
			return $this->thenAnswer(new ReturnAnswer($args));
		}
	}

	/**
	 * @param \Poser\Invocation\Answer $answer
	 */
	public function thenAnswer(Answer $answer){
		$this->invocation->markStubbed();
		$this->stub->addAnswer($answer);
		$this->invocationContainer->addStub($this->stub);
	}

	/**
	 * @param \Poser\Invocation\Answer $answer
	 */
	public function then(Answer $answer){
		$this->thenAnswer($answer);
	}


	/**
	 * Sets the exception that will be thrown when the method is invoked.
	 *
	 * @param Exception $exception
	 * @return Stubbable
	 */
	public function thenThrow(Exception $exception) {
		$this->thenAnswer(new ThrowAnswer($exception));
	}
}

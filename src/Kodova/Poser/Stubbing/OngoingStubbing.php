<?php

namespace Kodova\Poser\Stubbing;

use Kodova\Poser\Exception\PoserException;
use Kodova\Poser\Invocation\Answer;
use Kodova\Poser\Invocation\InvocationContainer;
use Kodova\Poser\Invocation\ReturnAnswer;
use Kodova\Poser\Invocation\ThrowAnswer;
use Kodova\Poser\Invocation\Invocation;
use Kodova\Poser\Stubbing\Stubbable;
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
     * @param \Kodova\Poser\Invocation\InvocationContainer $invocationContainer
     * @param Stub $stub
     * @param \Kodova\Poser\Invocation\Invocation $invocation
     */
    function __construct(InvocationContainer $invocationContainer, Stub $stub, Invocation $invocation) {
		$this->invocationContainer = $invocationContainer;
		$this->stub = $stub;
		$this->invocation = $invocation;
	}

	/**
	 * @throws PoserException
	 * @internal param $args
	 * @return null|mixed
	 */
	public function thenReturn(){
		if(func_num_args() == 0){
			throw new PoserException("You must supply one or more value when calling thenReturn");
		}

		if (func_num_args() > 1) {
			foreach(func_get_args() as $arg){
				$this->thenAnswer(new ReturnAnswer($arg));
			}
		} else {
			$this->thenAnswer(new ReturnAnswer(func_get_arg(0)));
		}
	}

    /**
     * @param \Kodova\Poser\Invocation\Answer $answer
     * @return Stubbable|void
     */
    public function thenAnswer(Answer $answer){
		$this->invocation->markStubbed();
		$this->stub->addAnswer($answer);
		$this->invocationContainer->addStub($this->stub);
	}

    /**
     * @param \Kodova\Poser\Invocation\Answer $answer
     * @return Stubbable|void
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

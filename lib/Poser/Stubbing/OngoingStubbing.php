<?php

namespace Poser\Stubbing;

use \Poser\Stubbing\Stubbable as Stubbable;


class OngoingStubbing implements Stubbable {
	
	private $invocationContainer;
	
	function __construct($invocationContainer) {
		$this->invocationContainer = $invocationContainer;
	}

	public function thenReturn($args){
		if (is_array($args)) {
			foreach($args as $arg){
				$stubbing = $this->thenAnswer(new Returns($arg));
			}
			return $stubbing;
		} else {
			return $this->thenAnswer(new Returns($args));
		}
	}

	public function thenThrow(Exception $exception){
		return $this->thenAnswer(new ThrowException($exception));
	}

	public function thenAnswer(Answer $answer){
		$this->invocationContainer->addConsecutiveAnswer($answer);
		return $this;
	}
	
	public function then(Answer $answer){
		return $this->thenAnswer($answer);
	}
}

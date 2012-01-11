<?php

namespace Poser\Stubbing;

use Poser\Invocation\Matchable;

use Poser\Invocation\Invocation;

use \Poser\Invocation\Answer;
use \SplQueue;

class Stub implements Answer {
	/**
	 * @var SplQueue
	 */
	private $answers;
	private $usedAt;
	/**
	 * @var Invocation
	 */
	private $invocation = null;
	
	function __construct(Answer $answer, Invocation $invocation) {
		$this->invocation = $invocation;
		$this->answers = new SplQueue();
		$this->answers->enqueue($answer);
	}
	
	public function answer(Invocation $invocation) {
		$answer = ($this->answers->count() == 1) ? $this->answers->top() : $this->answers->dequeue();
		return $answer->answer();
	}
	
	public function addAnswer(Answer $answer) {
		$this->answers->enqueue($answers);
	}
	
	public function markStubUsed($usedAt) {
		$this->usedAt = $usedAt;
	}
	
	public function wasUsed() {
		return ($this->usedAt != null);
	}
	
	public function matches(Matchable $invocation){
		return $invocation.matches($this->invocation);
	}
}
